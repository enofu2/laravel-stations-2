<?php

namespace Database\Seeders;

use App\Models\Screen;
use Carbon\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SheetTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ## [2024.01.24|Hara Takanobu] 
        # returnの配列からidキーを削除
        $screens = Screen::factory(3)->create();
        $seeds = [
            [ 'column' => 1, 'row' => 'a'],
            [ 'column' => 2, 'row' => 'a'],
            [ 'column' => 3, 'row' => 'a'],
            [ 'column' => 4, 'row' => 'a'],
            [ 'column' => 5, 'row' => 'a'],
            [ 'column' => 1, 'row' => 'b'],
            [ 'column' => 2, 'row' => 'b'],
            [ 'column' => 3, 'row' => 'b'],
            [ 'column' => 4, 'row' => 'b'],
            [ 'column' => 5, 'row' => 'b'],
            [ 'column' => 1, 'row' => 'c'],
            [ 'column' => 2, 'row' => 'c'],
            [ 'column' => 3, 'row' => 'c'],
            [ 'column' => 4, 'row' => 'c'],
            [ 'column' => 5, 'row' => 'c'],
        ];
        foreach ($screens as $screen) {
            foreach ($seeds as $seed) {
                DB::table('sheets')->insert(array_merge($seed,['screen_id' => $screen->id]));
            }
        }

    }
}
