<?php

namespace Motocle\Email\Database\Seeders;

use Illuminate\Database\Seeder;

class SystemEmailSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(SystemEmailsTableSeeder::class);
    }
}
