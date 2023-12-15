<?php
namespace App\Http\Controllers;
use App\Models\Practice;

class PracticeController extends Controller
{
    public function getPractice(){
        $practices = Practice::all();
        return view('getPractice', ['practices' => $practices]);
    }

    /* railway-php04
    public function getPractice() {
        $practice = Practice::all();
        return response()->json($practice);
    }
    */

    /* railway-php03
    public function sample(){
        return view('practice');
    }

    public function sample2(){
        $test = 'practice2';
        return view('practice2', ['testParam' => $test]);
    }

    public function sample3(){
        return view('practice3', ['testParam' => 'test']);
    }
    */
    
}