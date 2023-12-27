<?php

namespace Database\Seeders;

use App\Models\Practice;
use App\Models\Movie;
use App\Models\Reservation;
use App\Models\Schedule;
use Database\Factories\ReservationFactory;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\DB;

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

        $schedulesIDs = DB::table('schedules')->pluck('id');
        $sheetsIDs = DB::table('sheets')->pluck('id');

        $factory = ReservationFactory::new();
        foreach (range(1,100) as $index) {
            $time = CarbonImmutable::create(2023,12,23 + rand(1,14),0,0);

            DB::table('reservations')->insert([
                'date' => $time,
                'schedule_id' => Faker::create()->randomElement($schedulesIDs),
                'sheet_id' => Faker::create()->randomElement($sheetsIDs),
                'email' => Faker::create()->email(),
                'name' => Faker::create()->name(),
                'is_canceled' => rand(1,100) > 5 ? true:false,
            ]);
        }
        
        
        /* railway-php05
        Practice::factory(10)->create();
        */
    }
}
