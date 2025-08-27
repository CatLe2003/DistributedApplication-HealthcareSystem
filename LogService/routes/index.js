var express = require('express');
var router = express.Router();
const Log = require('../models/Log');
const loggerService = require('../services/logger');
const databaseService = require('../services/database');
const rabbitmqService = require('../services/rabbitmq');

/* GET home page. */
router.get('/', function(req, res, next) {
  res.json({
    message: 'Healthcare Log Service API',
    status: 'running',
    timestamp: new Date().toISOString(),
    correlationId: req.correlationId
  });
});

/* POST - Send log message */
router.post('/logs', async (req, res, next) => {
  try {
    const { level, message, service, metadata } = req.body;
    
    if (!level || !message || !service) {
      return res.status(400).json({
        error: 'Missing required fields: level, message, service',
        correlationId: req.correlationId
      });
    }

    const logData = await loggerService.sendLog(level, message, service, metadata);
    
    res.status(201).json({
      success: true,
      message: 'Log sent successfully',
      data: logData,
      correlationId: req.correlationId
    });
    
  } catch (error) {
    next(error);
  }
});

/* POST - Send audit log */
router.post('/audit', async (req, res, next) => {
  try {
    const { action, service, metadata } = req.body;
    
    if (!action || !service) {
      return res.status(400).json({
        error: 'Missing required fields: action, service',
        correlationId: req.correlationId
      });
    }

    const auditData = await loggerService.audit(action, service, metadata);
    
    res.status(201).json({
      success: true,
      message: 'Audit log sent successfully',
      data: auditData,
      correlationId: req.correlationId
    });
    
  } catch (error) {
    next(error);
  }
});

/* GET - Retrieve logs with filtering */
router.get('/logs', async (req, res, next) => {
  try {
    const {
      level,
      service,
      from,
      to,
      limit = 100,
      page = 1,
      correlationId
    } = req.query;

    // Build filter query
    const filter = {};
    
    if (level) filter.level = level;
    if (service) filter.service = service;
    if (correlationId) filter.correlationId = correlationId;
    
    if (from || to) {
      filter.timestamp = {};
      if (from) filter.timestamp.$gte = new Date(from);
      if (to) filter.timestamp.$lte = new Date(to);
    }

    const skip = (parseInt(page) - 1) * parseInt(limit);
    
    const logs = await Log.find(filter)
      .sort({ timestamp: -1 })
      .limit(parseInt(limit))
      .skip(skip)
      .lean();

    const total = await Log.countDocuments(filter);
    
    res.json({
      success: true,
      data: logs,
      pagination: {
        total,
        page: parseInt(page),
        limit: parseInt(limit),
        pages: Math.ceil(total / parseInt(limit))
      },
      correlationId: req.correlationId
    });
    
  } catch (error) {
    next(error);
  }
});

/* GET - Log statistics */
router.get('/stats', async (req, res, next) => {
  try {
    const { from, to, service } = req.query;
    
    // Build match stage for aggregation
    const matchStage = {};
    
    if (service) matchStage.service = service;
    
    if (from || to) {
      matchStage.timestamp = {};
      if (from) matchStage.timestamp.$gte = new Date(from);
      if (to) matchStage.timestamp.$lte = new Date(to);
    }

    const stats = await Log.aggregate([
      { $match: matchStage },
      {
        $group: {
          _id: {
            level: '$level',
            service: '$service'
          },
          count: { $sum: 1 },
          latestLog: { $max: '$timestamp' }
        }
      },
      {
        $group: {
          _id: '$_id.service',
          levels: {
            $push: {
              level: '$_id.level',
              count: '$count',
              latestLog: '$latestLog'
            }
          },
          totalLogs: { $sum: '$count' }
        }
      },
      { $sort: { totalLogs: -1 } }
    ]);

    res.json({
      success: true,
      data: stats,
      correlationId: req.correlationId
    });
    
  } catch (error) {
    next(error);
  }
});

/* GET - Health check */
router.get('/health', async (req, res, next) => {
  try {
    const dbStatus = databaseService.getConnectionStatus();
    const mqStatus = rabbitmqService.getConnectionStatus();
    
    const health = {
      status: 'healthy',
      timestamp: new Date().toISOString(),
      services: {
        database: dbStatus,
        rabbitmq: mqStatus
      },
      correlationId: req.correlationId
    };

    // Determine overall health
    if (!dbStatus.isConnected || !mqStatus.isConnected) {
      health.status = 'unhealthy';
    }

    const statusCode = health.status === 'healthy' ? 200 : 503;
    res.status(statusCode).json(health);
    
  } catch (error) {
    next(error);
  }
});

module.exports = router;
