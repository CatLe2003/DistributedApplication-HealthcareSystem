<?php

namespace Database\Factories;

use App\Models\Appointment;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class AppointmentFactory extends Factory
{
    protected $model = Appointment::class;

    public function definition(): array
    {
        return [
            'PatientID' => $this->faker->numberBetween(1, 20),
            'DoctorID' => $this->faker->numberBetween(100, 110),
            'TransactionID' => $this->faker->boolean(30) ? $this->faker->numberBetween(5000, 6000) : null,
            'AppointmentDate' => Carbon::now()->addDays($this->faker->numberBetween(1, 30)),
            'TimeSlotID' => $this->faker->numberBetween(1, 5), // giả định = ShiftID
            'Status' => $this->faker->randomElement(['pending', 'confirmed', 'completed', 'cancelled']),
            'DepartmentID' => $this->faker->numberBetween(10, 20),
            'WeekdayID' => $this->faker->numberBetween(1, 7),
            'RoomID' => $this->faker->numberBetween(1, 10),
        ];
    }
}
