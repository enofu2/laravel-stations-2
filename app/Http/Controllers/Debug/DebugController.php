<?php

namespace App\Http\Controllers\Debug;

use App\Http\Controllers\Controller;
use App\Models\Sheet;
use Illuminate\Http\Request;

class DebugController extends Controller
{
    public function testRoute(Request $request)
    {
        $record = Sheet::find(1);
        $array = $record->
        return;
    }
}
