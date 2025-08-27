require('dotenv').config();
var express = require('express');
var path = require('path');
var cookieParser = require('cookie-parser');
var logger = require('morgan');

// Import services
const databaseService = require('./services/database');
const rabbitmqService = require('./services/rabbitmq');
const loggerService = require('./services/logger');

var indexRouter = require('./routes/index');
var usersRouter = require('./routes/users');

var app = express();

// Initialize services
async function initializeServices() {
  try {
    console.log('🚀 Initializing Log System...');
    
    // Connect to MongoDB
    await databaseService.connect();
    
    // Connect to RabbitMQ
    await rabbitmqService.connect();
    
    // Start RabbitMQ consumer
    await rabbitmqService.startConsumer();
    
    console.log('✅ All services initialized successfully');
  } catch (error) {
    console.error('❌ Failed to initialize services:', error);
    process.exit(1);
  }
}

// Initialize services when app starts
initializeServices();

app.use(logger('dev'));
app.use(express.json());
app.use(express.urlencoded({ extended: false }));
app.use(cookieParser());
app.use(express.static(path.join(__dirname, 'public')));

// Middleware to add correlation ID
app.use((req, res, next) => {
  const correlationId = req.headers['x-correlation-id'] || loggerService.generateCorrelationId();
  req.correlationId = correlationId;
  loggerService.setCorrelationId(correlationId);
  res.setHeader('x-correlation-id', correlationId);
  next();
});

// Request logging middleware
app.use(async (req, res, next) => {
  try {
    await loggerService.info(
      `${req.method} ${req.originalUrl}`,
      'log-service',
      {
        method: req.method,
        url: req.originalUrl,
        ip: req.ip,
        userAgent: req.get('User-Agent'),
        headers: req.headers
      }
    );
  } catch (error) {
    console.error('Error logging request:', error);
  }
  next();
});

app.use('/', indexRouter);
app.use('/users', usersRouter);

// Error handling middleware
app.use(async (err, req, res, next) => {
  try {
    await loggerService.error(
      err.message,
      'log-service',
      {
        stack: err.stack,
        url: req.originalUrl,
        method: req.method,
        ip: req.ip
      }
    );
  } catch (logError) {
    console.error('Error logging error:', logError);
  }
  
  res.status(err.status || 500);
  res.json({
    message: err.message,
    error: process.env.NODE_ENV === 'development' ? err : {},
    correlationId: req.correlationId
  });
});

// Graceful shutdown
process.on('SIGINT', async () => {
  console.log('\n🛑 Shutting down gracefully...');
  
  try {
    await rabbitmqService.disconnect();
    await databaseService.disconnect();
    console.log('✅ Graceful shutdown completed');
    process.exit(0);
  } catch (error) {
    console.error('❌ Error during shutdown:', error);
    process.exit(1);
  }
});

process.on('SIGTERM', async () => {
  console.log('\n🛑 Received SIGTERM, shutting down gracefully...');
  
  try {
    await rabbitmqService.disconnect();
    await databaseService.disconnect();
    console.log('✅ Graceful shutdown completed');
    process.exit(0);
  } catch (error) {
    console.error('❌ Error during shutdown:', error);
    process.exit(1);
  }
});

module.exports = app;
