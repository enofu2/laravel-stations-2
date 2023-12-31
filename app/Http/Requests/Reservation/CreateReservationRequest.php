<?php

namespace App\Http\Requests\Reservation;


class CreateReservationRequest extends ReservationRequest
{

    public function rules()
    {
        $parentRules = parent::rules();
        $parentRules['date'] = ['required', 'date_format:Y-m-d','after_or_equal:'. date('Y-m-d')];
        return $parentRules;
    }

}
