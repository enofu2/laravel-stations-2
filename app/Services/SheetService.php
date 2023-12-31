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
        //日付とスケジュールIDが指定されていたらリレーションを取得
        if(isset($date) && isset($schedule_id))
        {
            $sheetQuery->with(['reservations' => function ($query) use ($schedule_id) {
                $query
                    ->where('schedule_id',$schedule_id);
            }]);
        }
        $sheetsCollection = $sheetQuery->get();

        $sheets = [];
        $isReserved = [];
        //座席一覧を設定
        foreach($sheetsCollection as $item){
            $sheets[$item['row']][$item['column']] = $item['id'];
        }
        //予約状況を設定
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