<?php

namespace App\Http\Controllers;

use App\Models\Sheet;
use Illuminate\Http\Request;

class SheetController extends Controller
{
    
    public function sheets() {
        $sheetsCollection = Sheet::query()
            ->orderBy('row','asc')
            ->orderBy('column','asc')
            ->get();
        $sheets = [];
        foreach($sheetsCollection as $item){
            $sheets[$item['row']][$item['column']] = $item['id'];
        }
        return view('get.sheet.sheets',compact('sheets'));
    }

    public function sheetsForReservation(Request $request,$movie_id,$schedule_id) {
        $date = $request->date;
        $sheetsCollection = Sheet::query()
            ->orderBy('row','asc')
            ->orderBy('column','asc')
            ->get();
        $sheets = [];
        foreach($sheetsCollection as $item){
            $sheets[$item['row']][$item['column']] = $item['id'];
        }
        return view('get.sheet.sheets',compact('sheets','date','movie_id','schedule_id'));
    }

    public function detail() {

    }
}
