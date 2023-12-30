<?php
declare(stryct_types=1);
namespace App\Http\Requests\Reservation;

class GetCreateFormForReservationRequest extends ReservationRequest
{

    public function validationData()
    {
        $date = $this->query('date');
        $sheetId = $this->query('sheetId');
        return array_merge($this->all(), compact('date','sheetId'));
    }

    public function rules()
    {
        return [
            'date' => ['required', 'date_format:Y-m-d H:i:s'],
            'sheetId' => ['required','regex:/^[0-9]+$/i'],
        ];
    }

}
