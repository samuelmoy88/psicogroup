<?php

namespace Database\Seeders;

use App\Models\SocialMedia;
use Illuminate\Database\Seeder;

class SocialMediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $social_media = [
            [
                'name' => 'Facebook',
            ],
            [
                'name' => 'Instagram',
            ],
            [
                'name' => 'Twitter',
            ],
            [
                'name' => 'Youtube',
            ],
            [
                'name' => 'LinkedIn',
            ],
        ];

        foreach ($social_media as $media) {
            SocialMedia::create($media);
        }
    }
}
