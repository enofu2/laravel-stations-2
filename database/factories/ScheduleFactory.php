<?php

namespace Database\Factories;

use App\Models\Movie;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Factories\Factory;

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

        return [
            'movie_id' => Movie::factory(),
            'start_time' => $time,
            'end_time' => $time->addHours(2),
        ];
    }
}
