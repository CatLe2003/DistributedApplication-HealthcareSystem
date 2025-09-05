<?php

namespace App\Helpers;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class ScheduledReminder
{
    private $connection;
    private $channel;

    public function __construct()
    {
        $this->connection = new AMQPStreamConnection(
                env('RABBITMQ_HOST'),
                env('RABBITMQ_PORT'),
                env('RABBITMQ_USER'),
                env('RABBITMQ_PASSWORD'),
                env('RABBITMQ_VHOST')
        );

        $this->channel = $this->connection->channel();

        /**
         * Exchange chính cho notification
         */
        $this->channel->exchange_declare(
            'appointment.exchange',
            'direct',
            false,
            true,
            false
        );

        $this->channel->queue_declare(
            'appointment.notifications.queue',
            false,
            true,
            false,
            false
        );

        $this->channel->queue_bind(
            'appointment.notifications.queue',
            'appointment.exchange',
            'appointment.notifications'
        );

        /**
         * Exchange + Queue cho delay
         */
        $this->channel->exchange_declare(
            'appointment.delay.exchange',
            'direct',
            false,
            true,
            false
        );

        $this->channel->queue_declare(
            'appointment.delay.queue',
            false,
            true,
            false,
            false,
            false,
            [
                'x-dead-letter-exchange' => ['S', 'appointment.exchange'],
                'x-dead-letter-routing-key' => ['S', 'appointment.notifications']
            ]
        );

        $this->channel->queue_bind(
            'appointment.delay.queue',
            'appointment.delay.exchange',
            'appointment.delay'
        );
    }

    public function publishDelayedNotification($data, $appointmentTime)
    {
        // Test : Send message after 1 minute
        $delay = 1 * 60 * 1000; // ms

        // $notifyTime = strtotime($appointmentTime) - (24 * 60 * 60); // 24 hours before appointment
        // $delay = ($notifyTime - time()) * 1000;

        if ($delay < 0) {
            $delay = 0;
        }

        $patientId = $data['PatientID'];

        $messageData = [
            'patient_id'       => $patientId,
            'doctor_id'       => $data['DoctorID'],
            'room_id'        => $data['RoomID'],
            'appointment_time' => $appointmentTime,
            'notify_time'      => date('Y-m-d H:i:s', (time() + $delay / 1000))
        ];

        $msg = new AMQPMessage(json_encode($messageData), [
            'delivery_mode' => 2,
            'expiration'    => (string) $delay // TTL ms
        ]);

        // publish vào delay exchange
        $this->channel->basic_publish(
            $msg,
            'appointment.delay.exchange',
            'appointment.delay'
        );

        echo " [x] Scheduled notification for Patient {$patientId}\n";
    }

    public function __destruct()
    {
        $this->channel->close();
        $this->connection->close();
    }
}
