<?php

namespace Database\Seeders;

use App\Models\Education;
use Illuminate\Database\Seeder;

class EducationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Education::updateOrCreate(
            ['institution' => 'KCA University'],
            [
                'degree_level' => "Bachelor's",
                'degree' => 'Bsc. Information Security and Forensics',
                'field_of_study' => 'IT',
                'start_year' => 2021,
                'end_year' => 2025,
                'is_current' => false,
                'grade' => 'Second Upper',
                'location' => 'Nairobi, Kenya',
            ]
        );
    }
}
