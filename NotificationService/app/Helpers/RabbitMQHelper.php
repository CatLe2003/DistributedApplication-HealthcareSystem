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

    public static function consume($queue)
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

            $callback = function ($msg) use ($channel) {
                Log::info(" [x] Received: " . $msg->body);

                $data = json_decode($msg->body, true);

                if ($data) {
                    
                    //Get Doctor and Room names from Employee Service
                    $doctorName = 'N/A';
                    $roomName = 'N/A';
                    if (!empty($data['doctor_id'])) {
                        try {
                            $response = \Illuminate\Support\Facades\Http::get("http://api_gateway/employee/employees/{$data['doctor_id']}");
                            if ($response->successful()) {
                                $doctorData = $response->json();
                                $doctorName = $doctorData['data']['FullName'] ?? 'N/A';
                            }
                        } catch (\Exception $e) {
                            Log::error("Failed to fetch doctor name: " . $e->getMessage());
                        }
                    }

                    if (!empty($data['room_id'])) {
                        try {
                            $response = \Illuminate\Support\Facades\Http::get("http://api_gateway/employee/rooms/{$data['room_id']}");
                            if ($response->successful()) {
                                $roomData = $response->json();
                                $roomName = $roomData['data']['RoomName'] ?? 'N/A';
                            }
                        } catch (\Exception $e) {
                            Log::error("Failed to fetch room name: " . $e->getMessage());
                        }
                    }

                    // Get Patient info from Patient 
                    $patientName = 'N/A';
                    $patientEmail = 'N/A';

                    if (!empty($data['patient_id'])) {
                        try {
                            $response = \Illuminate\Support\Facades\Http::get("http://api_gateway/patient/get-patient/{$data['patient_id']}");
                            if ($response->successful()) {
                                $patientData = $response->json();
                                $patientName = $patientData['data']['full_name'] ?? 'N/A';
                                $patientEmail = $patientData['data']['email'] ?? 'N/A';
                            }
                        } catch (\Exception $e) {
                            Log::error("Failed to fetch patient name: " . $e->getMessage());
                        }
                    }

                    // Send email using Laravel Mail
                    try {
                        \Illuminate\Support\Facades\Mail::send([], [], function ($message) use ($patientEmail, $patientName, $doctorName, $roomName, $data) {
                            $message->to($patientEmail, $patientName)
                                ->subject('Appointment Reminder')
                                ->setBody("Dear {$patientName},<br><br>This is a reminder for your upcoming appointment with Dr. {$doctorName} in room {$roomName}.<br><br>Time: {$data['appointment_time']}<br><br>Thank you,<br>LifeCare Team", 'text/html');
                        });
                        Log::info(" [✓] Email sent to {$patientEmail}");
                    } catch (\Exception $e) {
                        Log::error("Failed to send email: " . $e->getMessage());
                    }

                    // Create notification record in the database
                    $notification = [
                        'recipientId' => "PATIENT" . $data['patient_id'],
                        'type'        => "AppointmentReminder",
                        'title'       => "Appointment Reminder",
                        'message'     => "You have an appointment with Dr. ".$doctorName. " in room " . $roomName,
                        'time'     => "Time: " . $data['appointment_time'],
                        'metadata'    => json_encode($data),
                        'status'      => "Approved",
                        'sentAt'      => $data['notify_time'],
                    ];

                    Notification::create($notification);

                    Log::info(" [✓] Notification created: " . json_encode($notification));
                }

                $channel->basic_ack($msg->delivery_info['delivery_tag']);
            };

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
