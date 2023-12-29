<?php

namespace App\Http\Requests\Sheet;

class GetSheetForReservationRequest extends SheetRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function validationData()
    {
        $date = $this->query('date');
        return array_merge($this->all(), compact('date'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'date' => 'required','date_format:Y-m-d',
        ];
    }
}
