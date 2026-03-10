<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            'name' => 'Munyira Joseph',
            'tagline' => 'Full Stack Developer, Android Developer, Software Developer, IT Professional',
            'bio' => 'Versatile IT professional with hands-on experience in software development, network administration, and systems support, driven by a commitment to continuous learning and delivering real-world impact.',
            'location' => 'Nairobi, Kenya',
            'contact_email' => 'munyira@munyira.co.ke',
            'resume_path' => '',
            'avatar' => '',
        ];

        foreach ($settings as $key => $value) {
            Setting::set($key, $value);
        }
    }
}
