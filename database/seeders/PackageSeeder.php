<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Package;

class PackageSeeder extends Seeder
{
    public function run(): void
    {
        $packages = [
            'Box 5 Liter',
            'Cup 150 ml',
            'Mangkok 200 ml',
        ];

        foreach ($packages as $package) {
            Package::updateOrCreate(
                ['name' => $package],
                ['status' => true]
            );
        }
    }
}