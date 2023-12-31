<?php

namespace App\Http\Requests\Reservation;

class UpdateAdminReservationRequest extends ReservationRequest
{
    public function rules()
    {
        $parentRules = parent::rules();
        $parentRules['movie_id'] = ['required'];
        return $parentRules;
    }
}
