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
        $sheets = $this->SheetService->getSheetArray();
        return $this->SheetPresenter->sheets($sheets);
    }

    public function sheetsForReservation(
        GetSheetForReservationRequest $request,
        $movie_id,
        $schedule_id)
    {
        if($request->isFailed())
        {
            return $this->SheetPresenter
                ->errorRedirect($request->getErrors());
        }
        $date = $request->query('date');
        $sheets = $this->SheetService->getSheetArray();
        return $this->SheetPresenter->reservation($sheets,$date,$movie_id,$schedule_id);
    }

    public function detail() {

    }
}
