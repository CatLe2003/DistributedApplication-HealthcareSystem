<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Helpers\RabbitMQHelper;
use App\Models\Notification;
use Illuminate\Support\Facades\Log;

class RabbitMQConsumerServiceProvider extends ServiceProvider
{
    public function boot()
    {
            RabbitMQHelper::consume('appointment.notifications.queue', function ($msg) {
                $data = json_decode($msg->body, true);

                if (!$data) {
                    Log::warning(" [!] Received invalid message: " . $msg->body);
                    return;
                }

                $notification = [
                    'recipientId' => $data['patient_id'],
                    'type'        => "AppointmentReminder",
                    'title'       => "Appointment Reminder",
                    'message'     => "You have an appointment in Room " . $data['room_id'],
                    'time'        => "Time: " . $data['appointment_time'],
                    'metadata'    => json_encode($data),
                    'status'      => "Approved",
                    'sentAt'      => $data['notify_time'],
                ];

                Notification::create($notification);

                Log::info(" [✓] Notification created for patient {$data['patient_id']}");
            });
    }
}
