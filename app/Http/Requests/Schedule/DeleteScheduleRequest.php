<?php

namespace App\Http\Requests\Schedule;

class DeleteScheduleRequest extends ScheduleRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => ['required'],
        ];
    }

    public function attributes() : array 
    {
        return [
            'id' => 'ID',
        ];
    }

    public function messages()
    {
        return [
            'movie_id.required' => 'IDは必須項目です',
        ];
    }
}
