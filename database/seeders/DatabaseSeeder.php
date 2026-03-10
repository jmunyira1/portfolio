<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Munyira Joseph',
            'email' => 'munyira@munyira.co.ke',
            'password' => bcrypt('P@55w0rd'),
        ]);

        $this->call([
            ClientSeeder::class,
            EducationSeeder::class,
            ExperienceSeeder::class,
            SettingSeeder::class,
            SocialSeeder::class,
            SkillSeeder::class,
            ProjectSeeder::class,
        ]);
    }
}
