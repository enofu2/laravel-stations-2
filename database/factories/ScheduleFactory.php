<?php

namespace Database\Factories;

use App\Models\Movie;
use Carbon\CarbonImmutable;
use Faker\Factory as FakerFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

class ScheduleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $time = CarbonImmutable::create(2023,12,23,rand(8,21),5*rand(0,11));
        $screenIDs = DB::table('screens')->pluck('id');

        return [
            'movie_id' => Movie::factory(),
            'start_time' => $time,
            'end_time' => $time->addHours(2),
            'screen_id' => FakerFactory::create()->randomElement($screenIDs),
        ];
    }
}
