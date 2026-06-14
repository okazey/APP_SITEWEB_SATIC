<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            DepartementSeeder::class,
            UserSeeder::class,
            QuestionFaqSeeder::class,
            PartenaireSeeder::class,
        ]);
    }
}