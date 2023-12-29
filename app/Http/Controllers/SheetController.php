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
        //$columns = array_unique($sheets->pluck('column')->toArray());
        //$rows = array_unique($sheets->pluck('row')->toArray());
        //ddd($sheets);
        // $columns = Sheet::query()
        //     ->select('column')->groupBy('column')->orderBy('column','asc')->get();
        // $rows = Sheet::query()
        //     ->select('row')->groupBy('row')->orderBy('row','asc')->get();
        //dd($columns, $rows);
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
        //$columns = array_unique($sheets->pluck('column')->toArray());
        //$rows = array_unique($sheets->pluck('row')->toArray());
        //ddd($sheets);
        // $columns = Sheet::query()
        //     ->select('column')->groupBy('column')->orderBy('column','asc')->get();
        // $rows = Sheet::query()
        //     ->select('row')->groupBy('row')->orderBy('row','asc')->get();
        //dd($columns, $rows);
        return view('get.sheet.sheets',compact('sheets','date','movie_id','schedule_id'));
    }

    public function detail() {

    }
}
