<?php

namespace App\Services;

use App\Models\Sheet;

class SheetService
{
    /**
     * シートの一覧を取得する
     */
    public function getSheetArray() :array
    {
        $sheetsCollection = Sheet::query()
        ->orderBy('row','asc')
        ->orderBy('column','asc')
        ->get();
        $sheets = [];
        foreach($sheetsCollection as $item){
            $sheets[$item['row']][$item['column']] = $item['id'];
        }
        return $sheets;
    }
}