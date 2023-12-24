<?php

namespace Database\Seeders;

use App\Models\Practice;
use App\Models\Movie;
use App\Models\Schedule;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //Movie::factory(15)->create();
        $movies = Movie::factory(50)->hasSchedules(5)->create();
        $this->call(SheetTableSeeder::class);

        /* railway-php05
        Practice::factory(10)->create();
        */
    }
}
