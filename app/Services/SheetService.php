<?php

namespace App\Services;

use App\Http\Presenters\SheetPresenter;
use App\Models\Sheet;
use App\Properties\Sheet\SheetProperties;
use DateTime;

class SheetService
{
    /**
     * シートの一覧を取得する
     */
    public function getSheetArray($date = null,$movie_id = null,$schedule_id = null) :SheetProperties
    {
        $sheetQuery = Sheet::query()
            ->orderBy('row','asc')
            ->orderBy('column','asc');   
        if(isset($date) && isset($schedule_id))
        {
            $sheetQuery->with('reservatinons')
                ->where('reservations.schedule_id',$schedule_id)
                ->where('reservations.date',
                    DateTime::createFromFormat('Y-m-d H:i:s',$date)->format('H:i:s')
                );
        }
        $sheetsCollection = $sheetQuery->get();

        $sheets = [];
        $isReserved = [];
        foreach($sheetsCollection as $item){
            $sheets[$item['row']][$item['column']] = $item['id'];
        }
        if(isset($date) && isset($schedule_id))
        {
            foreach($sheetsCollection as $item){
                $isReserved[$item['row']][$item['column']]
                    = $item->reservations->count() == 0 ? null : true;
            }
        }
        $dto = SheetProperties::create();
        $dto->date = $date;
        $dto->sheets = $sheets;
        $dto->isReserved = $isReserved;
        $dto->movie_id = $movie_id;
        $dto->schedule_id = $schedule_id;
        return $dto;
    }
}