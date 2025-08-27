# Healthcare Log Service

Centralized logging service for healthcare microservices using RabbitMQ and MongoDB.

## Features

- 🔄 **Asynchronous Logging**: Uses RabbitMQ for reliable message queuing
- 📊 **MongoDB Storage**: Stores logs in MongoDB with indexing for fast queries

## Architecture

```
[Microservice] → [RabbitMQ] → [Log Service] → [MongoDB]

```

## Installation

1. Install dependencies:
```bash
npm install
```

2. Configure environment variables:
```bash
cp .env.example .env
# Edit .env with your configuration
```

3. Start the services:
```bash
# Start MongoDB (if not using Docker)
mongod

# Start RabbitMQ (if not using Docker)
rabbitmq-server

# Start the log service
npm start
```

## Environment Variables

```
PORT=3000
MONGODB_URI=mongodb://localhost:27017/logdb
RABBITMQ_URL=amqp://localhost
NODE_ENV=development
```

## Troubleshooting

### Common Issues

1. **RabbitMQ Connection Failed**
   - Check RabbitMQ is running
   - Verify connection URL
   - Check firewall settings

2. **MongoDB Connection Failed**
   - Check MongoDB is running
   - Verify connection string
   - Check database permissions

