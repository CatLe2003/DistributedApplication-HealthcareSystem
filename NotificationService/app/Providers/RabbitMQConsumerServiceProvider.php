<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Helpers\RabbitMQHelper;

class RabbitMQConsumerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        RabbitMQHelper::consume('appointment.notifications.queue', function ($msg) {
            $data = json_decode($msg->body, true);

            \DB::table('notifications')->insert([
                'recipientId' => $data['patient_id'],
                'type' => 'AppointmentReminder',
                'title' => 'Nhắc lịch hẹn khám bệnh',
                'message' => 'Bạn có cuộc hẹn lúc ' . $data['appointment_time'],
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            echo " [x] Notification saved for patient {$data['patient_id']}\n";
        });
    }
}
