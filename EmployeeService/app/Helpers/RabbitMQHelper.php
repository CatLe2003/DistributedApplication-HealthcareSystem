<?php

namespace App\Helpers;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitMQHelper
{
    public static function publish($exchange, $data, $type = 'fanout')
    {
       try {
            $connection = new AMQPStreamConnection(
                env('RABBITMQ_HOST'),
                env('RABBITMQ_PORT'),
                env('RABBITMQ_USER'),
                env('RABBITMQ_PASSWORD'),
                env('RABBITMQ_VHOST')
            );
            $channel = $connection->channel();

            $channel->exchange_declare($exchange, $type, false, true, false);

            $msg = new AMQPMessage(json_encode($data), [
                'content_type' => 'application/json',
                'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT
            ]);

            $channel->basic_publish($msg, $exchange);

            $channel->close();
            $connection->close();
        } catch (\Exception $e) {
            \Log::error("RabbitMQ error: " . $e->getMessage());
        }
    }
}
