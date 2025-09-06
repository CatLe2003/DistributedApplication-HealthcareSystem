<?php

namespace App\Helpers;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Illuminate\Support\Facades\Log;
use App\Models\Notification;

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

     public static function consume($queue, callable $userCallback = null)
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

            $channel->queue_declare($queue, false, true, false, false);

            Log::info(" [*] Waiting for messages in queue: {$queue}");

            $callback = function ($msg) use ($channel, $userCallback) {
                try {
                    if ($userCallback) {
                        $userCallback($msg);
                    }

                    // $deliveryTag = $msg->get('delivery_tag');
                    // if ($deliveryTag !== null) {
                    //     $channel->basic_ack($deliveryTag);
                    // }
                    $channel->basic_ack($msg->delivery_info['delivery_tag']);
                    
                } catch (\Exception $e) {
                    Log::error("RabbitMQ consumer callback error: " . $e->getMessage());
                }
            };

            $channel->basic_qos(null, 1, null);
            $channel->basic_consume($queue, '', false, false, false, false, $callback);

            while (count($channel->callbacks)) {
                $channel->wait();
            }

            $channel->close();
            $connection->close();
        } catch (\Exception $e) {
            Log::error("RabbitMQ consume error: " . $e->getMessage());
        }
    }
}
