<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Flavor;

class FlavorSeeder extends Seeder
{
    public function run(): void
    {
        $flavors = [
            'Coklat',
            'Strawberry',
            'Vanilla',
            'Durian',
            'Alpukat',
        ];

        foreach ($flavors as $flavor) {
            Flavor::updateOrCreate(
                ['name' => $flavor],
                ['status' => true]
            );
        }
    }
}