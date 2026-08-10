<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        Setting::updateOrCreate(
            ['id' => 1],
            [
                'business_name' => 'Ice Cream Firda',
                'logo' => null,
                'address' => '',
                'phone' => '',
                'receipt_footer' => 'Terima kasih telah berbelanja di Ice Cream Firda',
            ]
        );
    }
}