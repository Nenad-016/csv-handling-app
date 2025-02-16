<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Artisan::call('migrate');

        $csvFilePath = storage_path('app/imports/product_categories.csv');
        Artisan::call('import:csv', ['file' => $csvFilePath]);
    }
}
