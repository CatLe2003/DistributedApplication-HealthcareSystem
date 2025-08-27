const amqp = require('amqplib');
const Log = require('../models/Log');

class RabbitMQService {
  constructor() {
    this.connection = null;
    this.channel = null;
    this.isConnected = false;
    this.exchangeName = 'log_exchange';
    this.queueName = 'log_queue_1';
  }

  async connect() {
    try {
      const rabbitmqUrl = process.env.RABBITMQ_URL || 'amqp://localhost';
      
      // Create connection with credentials
      this.connection = await amqp.connect(rabbitmqUrl);
      console.log('✅ Connected to RabbitMQ successfully');

      // Create channel
      this.channel = await this.connection.createChannel();
      
      // Declare exchange (topic type for flexible routing)
      await this.channel.assertExchange(this.exchangeName, 'fanout', {
        durable: true
      });

      // Declare queue
      await this.channel.assertQueue(this.queueName, {
        durable: true
      });

      this.isConnected = true;

      // Handle connection events
      this.connection.on('error', (err) => {
        console.error('❌ RabbitMQ connection error:', err);
        this.isConnected = false;
      });

      this.connection.on('close', () => {
        console.warn('⚠️ RabbitMQ connection closed');
        this.isConnected = false;
      });

      console.log('📨 RabbitMQ exchange and queue configured');
      
    } catch (error) {
      console.error('❌ Failed to connect to RabbitMQ:', error);
      this.isConnected = false;
      throw error;
    }
  }

  async startConsumer() {
    if (!this.channel) {
      throw new Error('RabbitMQ channel not initialized. Call connect() first.');
    }

    try {
      // Set prefetch to process one message at a time
      await this.channel.prefetch(1);

      console.log('🎧 Starting log consumer...');
      
      await this.channel.consume(this.queueName, async (message) => {
        if (message) {
          try {
            const logData = JSON.parse(message.content.toString());
            
            // Save to MongoDB
            await this.saveLogToDatabase(logData);
            
            // Acknowledge message
            this.channel.ack(message);
            
            console.log(`✅ Processed log: ${logData.service} - ${logData.event}`);
            
          } catch (error) {
            console.error('❌ Error processing log message:', error);
            
            // Reject message and requeue if it's a temporary error
            this.channel.nack(message, false, false);
          }
        }
      });

      console.log('🎧 Log consumer started successfully');
      
    } catch (error) {
      console.error('❌ Failed to start consumer:', error);
      throw error;
    }
  }

  async saveLogToDatabase(logData) {
    try {
      const log = new Log({
        timestamp: logData.timestamp || new Date(),
        level: logData.level,
        event: logData.event,
        service: logData.service || 'unknown',
        environment: logData.environment || process.env.NODE_ENV || 'development',
        ipAddress: logData.ipAddress || 'unknown',
        response: logData.response || {},
        userId: logData.userId || 'anonymous'
      });

      await log.save();
      console.log(`💾 Log saved to database: ${log._id}`);
      
    } catch (error) {
      console.error('❌ Error saving log to database:', error);
      throw error;
    }
  }

  async publishLog(routingKey, logData) {
    if (!this.channel) {
      throw new Error('RabbitMQ channel not initialized. Call connect() first.');
    }

    try {
      const message = Buffer.from(JSON.stringify(logData));
      
      const published = this.channel.publish(
        this.exchangeName,
        routingKey,
        message,
        {
          persistent: true,
          timestamp: Date.now()
        }
      );

      if (published) {
        console.log(`📤 Log published with routing key: ${routingKey}`);
      } else {
        console.warn('⚠️ Failed to publish log message');
      }

      return published;
      
    } catch (error) {
      console.error('❌ Error publishing log:', error);
      throw error;
    }
  }

  async disconnect() {
    try {
      if (this.channel) {
        await this.channel.close();
      }
      if (this.connection) {
        await this.connection.close();
      }
      this.isConnected = false;
      console.log('📴 Disconnected from RabbitMQ');
    } catch (error) {
      console.error('❌ Error disconnecting from RabbitMQ:', error);
    }
  }

  getConnectionStatus() {
    return {
      isConnected: this.isConnected,
      hasChannel: !!this.channel,
      exchangeName: this.exchangeName,
      queueName: this.queueName
    };
  }
}

module.exports = new RabbitMQService();
