<?php

namespace Database\Seeders;

use App\Models\MedicalCase;
use Illuminate\Database\Seeder;

class MedicalCaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = ['Planning', 'In Review', 'Approved', 'Completed'];
        $priorities = ['Low', 'Normal', 'High', 'Urgent'];
        $implants = ['Hip Implant', 'Knee Implant', 'Spinal Implant', 'Shoulder Implant'];

        for ($i = 1; $i <= 20; $i++) {
            MedicalCase::updateOrCreate(
                ['case_number' => 'JM-' . str_pad($i, 4, '0', STR_PAD_LEFT)],
                [
                    'patient_reference' => 'PAT-' . str_pad($i, 4, '0', STR_PAD_LEFT),
                    'surgeon_name' => 'Dr. ' . ['Sharma', 'Patel', 'Rao', 'Mehta'][$i % 4],
                    'implant_type' => $implants[($i - 1) % 4],
                    'status' => $statuses[($i - 1) % 4],
                    'priority' => $priorities[($i - 1) % 4],
                    'surgery_date' => now()->addDays($i)->toDateString(),
                ]    
            );
        }
    }
}
