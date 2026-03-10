<?php

namespace Database\Seeders;

use App\Models\Skill;
use App\Models\SkillCategory;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Web Development',
                'icon' => 'ti ti-code',
                'description' => 'Frontend and backend web development',
                'skills' => [
                    ['name' => 'PHP', 'proficiency' => 85, 'icon' => 'ti ti-brand-php'],
                    ['name' => 'Laravel', 'proficiency' => 85, 'icon' => 'ti ti-brand-laravel'],
                    ['name' => 'JavaScript', 'proficiency' => 75, 'icon' => 'ti ti-brand-javascript'],
                    ['name' => 'Bootstrap', 'proficiency' => 85, 'icon' => 'ti ti-brand-bootstrap'],
                    ['name' => 'React.js', 'proficiency' => 65, 'icon' => 'ti ti-brand-react'],
                    ['name' => 'HTML & CSS', 'proficiency' => 90, 'icon' => 'ti ti-brand-html5'],
                    ['name' => 'MySQL', 'proficiency' => 80, 'icon' => 'ti ti-database'],
                ],
            ],
            [
                'name' => 'DevOps & Systems',
                'icon' => 'ti ti-server',
                'description' => 'Infrastructure, networking and systems support',
                'skills' => [
                    ['name' => 'Linux', 'proficiency' => 75, 'icon' => 'ti ti-brand-ubuntu'],
                    ['name' => 'Docker', 'proficiency' => 60, 'icon' => 'ti ti-brand-docker'],
                    ['name' => 'Network Admin', 'proficiency' => 75, 'icon' => 'ti ti-network'],
                    ['name' => 'VoIP', 'proficiency' => 65, 'icon' => 'ti ti-phone-call'],
                ],
            ],
            [
                'name' => 'Data & Automation',
                'icon' => 'ti ti-chart-bar',
                'description' => 'Data processing, scripting and automation',
                'skills' => [
                    ['name' => 'Python', 'proficiency' => 75, 'icon' => 'ti ti-brand-python'],
                    ['name' => 'Pandas', 'proficiency' => 65, 'icon' => 'ti ti-table'],
                    ['name' => 'OCR', 'proficiency' => 70, 'icon' => 'ti ti-scan'],
                ],
            ],
            [
                'name' => 'Mobile',
                'icon' => 'ti ti-device-mobile',
                'description' => 'Android and mobile development',
                'skills' => [
                    ['name' => 'Android Development', 'proficiency' => 65, 'icon' => 'ti ti-brand-android'],
                ],
            ],
        ];

        foreach ($categories as $categoryData) {
            $skills = $categoryData['skills'];
            unset($categoryData['skills']);

            $category = SkillCategory::updateOrCreate(
                ['name' => $categoryData['name']],
                $categoryData
            );

            foreach ($skills as $i => $skill) {
                Skill::updateOrCreate(
                    [
                        'skill_category_id' => $category->id,
                        'name' => $skill['name'],
                    ],
                    array_merge($skill, [
                        'skill_category_id' => $category->id,
                        'sort_order' => $i,
                    ])
                );
            }
        }

    }
}
