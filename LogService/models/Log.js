const mongoose = require("mongoose");

const logSchema = new mongoose.Schema(
  {
    timestamp: {
      type: Date,
      default: Date.now,
      index: true,
    },
    level: {
      type: String,
      
      enum: ["INFO", "WARN", "ERROR", "DEBUG"],
      index: true,
    },
    service: {
      type: String,
      
      index: true,
    },
    event: {
      type: String,
      index: true,
    },
    ipAddress: {
      type: String,
      index: true,
    },
    environment: {
      type: String,
      default: "development",
    },
    response: {
      type: Object,
      default: {},
    },
    userId: {
      type: String,
      ref: 'User',
      index: true,
    }
  },
  {
    timestamps: true,
  }
);

// Indexes for efficient querying
logSchema.index({ timestamp: -1, level: 1, service: 1 });
logSchema.index({ userId: 1, timestamp: -1 });
logSchema.index({ service: 1, event: 1, timestamp: -1 });
logSchema.index({ level: 1, timestamp: -1 });
logSchema.index({ ipAddress: 1, timestamp: -1 });

module.exports = mongoose.model("Log", logSchema);
