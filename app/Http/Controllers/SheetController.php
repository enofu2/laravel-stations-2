<?php

namespace App\Http\Controllers;

use App\Http\Presenters\SheetPresenter;
use App\Http\Requests\Sheet\GetSheetForReservationRequest;
use App\Services\SheetService;

class SheetController extends Controller
{
    private  $SheetService;
    private $SheetPresenter;

    public function __construct(
        SheetService $SheetService,
        SheetPresenter $SheetPresenter)
    {
        $this->SheetService = $SheetService;
        $this->SheetPresenter = $SheetPresenter;
    }

    public function sheets() {
        $dto = $this->SheetService->getSheetArray();
        return $this->SheetPresenter->sheets($dto);
    }

    public function sheetsForReservation(
        GetSheetForReservationRequest $request,
        $movie_id,
        $schedule_id)
    {
        if($request->isFailed())
        {
            return $this->SheetPresenter->error($request->getErrors(),400);
        }
        $date = $request->query('date');
        $dto = $this->SheetService->getSheetArray($date,$movie_id,$schedule_id);
        
        return $this->SheetPresenter->reservation($dto);
    }
}
