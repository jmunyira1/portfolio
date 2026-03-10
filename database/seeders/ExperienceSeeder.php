<?php

namespace Database\Seeders;

use App\Models\Experience;
use Illuminate\Database\Seeder;

class ExperienceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $experiences = [
            [
                'title' => 'Software Developer & IT Support (Industrial Attachment)',
                'start_date' => '2025-08-01',
                'end_date' => '2025-10-31',
                'is_current' => false,
                'responsibilities' => [
                    'Redesigned user portals using React.js, improving navigation and accessibility',
                    'Built real-time data pipeline with Python (Pandas, NumPy) for website updates',
                    'Created OCR automation system processing thousands of PDF documents with multiprocessing',
                    'Provided IT support including VoIP configuration, network troubleshooting, and hardware upgrades',
                ],
            ],
            [
                'title' => 'Storekeeper & Procurement Officer',
                'start_date' => '2024-04-01',
                'end_date' => '2024-06-30',
                'is_current' => false,
                'responsibilities' => [
                    'Managed inventory and procurement for food, stationery, hardware, and laboratory supplies',
                    'Processed daily requisitions and coordinated with suppliers',
                ],
            ],
            [
                'title' => 'IT Support Specialist',
                'start_date' => '2022-05-01',
                'end_date' => '2024-07-31',
                'is_current' => false,
                'responsibilities' => [
                    'Provided technical support for staff and students',
                    'Managed student data across multiple systems (NEMIS, Zeraki) including enrolment, transfers, and removals',
                    'Developed Library Management System using PHP and MySQL',
                ],
            ],
        ];

        foreach ($experiences as $exp) {
            Experience::updateOrCreate(
                [
                    'client_id' => 1,
                    'title' => $exp['title'],
                ],
                array_merge($exp, ['client_id' => 1])
            );
        }
    }

}
