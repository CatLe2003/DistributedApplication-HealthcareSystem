const rabbitmqService = require('./rabbitmq');
const { v4: uuidv4 } = require('uuid');

class LoggerService {
  constructor() {
    this.correlationId = null;
  }

  setCorrelationId(id) {
    this.correlationId = id;
  }

  generateCorrelationId() {
    this.correlationId = uuidv4();
    return this.correlationId;
  }

  async sendLog(level, message, service, metadata = {}) {
    try {
      const logData = {
        timestamp: new Date().toISOString(),
        level: level.toUpperCase(),
        service: service,
        event: metadata.event || 'GeneralEvent',
        userId: metadata.userId || 'anonymous',
        ipAddress: metadata.ipAddress || 'unknown',
        description: message,
        correlationId: this.correlationId || this.generateCorrelationId(),
        metadata: {
          browser: metadata.browser || 'unknown',
          os: metadata.os || 'unknown',
          location: metadata.location || 'unknown',
          details: metadata.details || {}
        },
        environment: process.env.NODE_ENV || 'development'
      };

      const routingKey = `log.${level.toLowerCase()}`;
      await rabbitmqService.publishLog(routingKey, logData);
      
      return logData;
    } catch (error) {
      console.error('❌ Error sending log:', error);
      throw error;
    }
  }
}

module.exports = new LoggerService();
