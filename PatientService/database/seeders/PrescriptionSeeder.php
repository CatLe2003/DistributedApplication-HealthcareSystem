<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PrescriptionSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'phone' => '+84903000001',
                'visit_date' => '2025-01-10',
                'notes' => 'BP monitor at home; follow-up in 4 weeks.',
                'status' => 'IN_PROGRESS',
                'date' => '2025-01-10 09:15:00',
            ],
            [
                'phone' => '+84903000002',
                'visit_date' => '2025-01-11',
                'notes' => 'Abortive therapy for migraine; hydration.',
                'status' => 'NEW',
                'date' => '2025-01-11 10:35:00',
            ],
            [
                'phone' => '+84903000005',
                'visit_date' => '2025-01-14',
                'notes' => 'Topicals for eczema.',
                'status' => 'NEW',
                'date' => '2025-01-14 15:10:00',
            ],
            [
                'phone' => '+84903000007',
                'visit_date' => '2025-01-16',
                'notes' => 'Symptomatic relief for rhinitis.',
                'status' => 'NEW',
                'date' => '2025-01-16 11:15:00',
            ],
            [
                'phone' => '+84903000009',
                'visit_date' => '2025-01-18',
                'notes' => 'Eradication therapy if H. pylori positive.',
                'status' => 'NEW',
                'date' => '2025-01-18 16:35:00',
            ],
            [
                'phone' => '+84903000010',
                'visit_date' => '2025-01-19',
                'notes' => 'Thyroid work-up; medication if needed.',
                'status' => 'NEW',
                'date' => '2025-01-19 09:20:00',
            ],
        ];

        foreach ($data as $item) {
            $patient = DB::table('patient')->where('phone_number', $item['phone'])->first();

            if ($patient) {
                $visit = DB::table('medicalvisit')
                    ->where('patient_id', $patient->id)
                    ->whereDate('visit_date', $item['visit_date'])
                    ->first();

                if ($visit) {
                    DB::table('prescription')->insert([
                        'visit_id' => $visit->id,
                        'notes' => $item['notes'],
                        'status' => $item['status'],
                        'date' => $item['date'],
                    ]);
                }
            }
        }
    }
}
