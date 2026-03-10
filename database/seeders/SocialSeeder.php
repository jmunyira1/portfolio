<?php

namespace Database\Seeders;

use App\Models\Social;
use Illuminate\Database\Seeder;

class SocialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $socials = [
            [
                'platform' => 'Email',
                'label' => 'Email',
                'value' => 'munyira@munyira.co.ke',
                'url' => 'mailto:munyira@munyira.co.ke',
                'icon' => 'ti ti-mail',
                'is_primary' => true,
            ],
            [
                'platform' => 'Phone',
                'label' => 'Phone',
                'value' => '+254711318428',
                'url' => 'tel:+254711318428',
                'icon' => 'ti ti-phone',
                'is_primary' => true,
            ],
            [
                'platform' => 'GitHub',
                'label' => 'GitHub',
                'value' => 'jmunyira1',
                'url' => 'https://github.com/jmunyira1',
                'icon' => 'ti ti-brand-github',
                'is_primary' => false,
            ],
            [
                'platform' => 'LinkedIn',
                'label' => 'LinkedIn',
                'value' => 'Munyira Joseph',
                'url' => 'https://linkedin.com/in/jmunyira1',
                'icon' => 'ti ti-brand-linkedin',
                'is_primary' => false,
            ],
            [
                'platform' => 'X',
                'label' => 'X (Twitter)',
                'value' => '@jmunyira1',
                'url' => 'https://x.com/jmunyira1',
                'icon' => 'ti ti-brand-x',
                'is_primary' => false,
            ],
            [
                'platform' => 'Instagram',
                'label' => 'Instagram',
                'value' => '@jmunyira1',
                'url' => 'https://www.instagram.com/jmunyira1/',
                'icon' => 'ti ti-brand-instagram',
                'is_primary' => false,
            ],
            [
                'platform' => 'Facebook',
                'label' => 'Facebook',
                'value' => 'Munyira Joseph',
                'url' => 'https://www.facebook.com/profile.php?id=61573678314269',
                'icon' => 'ti ti-brand-facebook',
                'is_primary' => false,
            ],
            [
                'platform' => 'WhatsApp',
                'label' => 'WhatsApp',
                'value' => '+254711318428',
                'url' => 'https://wa.me/254711318428',
                'icon' => 'ti ti-brand-whatsapp',
                'is_primary' => false,
            ],
            [
                'platform' => 'Website',
                'label' => 'Website',
                'value' => 'munyira.co.ke',
                'url' => 'https://munyira.co.ke',
                'icon' => 'ti ti-globe',
                'is_primary' => false,
            ],
        ];

        foreach ($socials as $social) {
            Social::updateOrCreate(
                ['platform' => $social['platform']],
                $social
            );
        }
    }
}
