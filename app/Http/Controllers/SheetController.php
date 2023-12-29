<?php

namespace App\Http\Controllers;

use App\Models\Sheet;
use Illuminate\Http\Request;

class SheetController extends Controller
{
    
    public function sheets() {
        //$sheets = Sheet::query()->all();
        $columns = Sheet::query()
            ->select('column')->groupBy('column')->orderBy('column','asc')->get();
        $rows = Sheet::query()
            ->select('row')->groupBy('row')->orderBy('row','asc')->get();
        //dd($columns, $rows);
        return view('get.sheet.sheets',['columns' => $columns, 'rows' => $rows]);
    }

    public function detail() {

    }
}
