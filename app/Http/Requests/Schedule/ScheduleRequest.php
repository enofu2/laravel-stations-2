<?php

namespace App\Http\Requests\Schedule;

use Illuminate\Foundation\Http\FormRequest;

class ScheduleRequest extends FormRequest
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
            'movie_id' => ['required'],
            'start_time_date' => ['required', 'date_format:Y-m-d', 'before_or_equal:end_time_date'],
            'start_time_time' => ['required', 'date_format:H:i'],
            'end_time_date' => ['required', 'date_format:Y-m-d', 'after_or_equal:start_time_date'],
            'end_time_time' => ['required', 'date_format:H:i'],
        ];
    }

    public function attributes() : array 
    {
        return [
            'movie_id' => '作品ID',
            'start_time_date' => '開始日付',
            'start_time_time' => '開始時間',
            'end_time_date' => '終了日付',
            'end_time_time' => '終了時間',
        ];
    }

    public function messages()
    {
        return [
            'movie_id.required' => '作品IDは必須項目です',
            'start_time_date.required' => '開始日付は必須項目です',
            'start_time_time.required' => '開始時間は必須項目です',
            'end_time_date.required' => '終了日時は必須項目です',
            'end_time_time.required' => '終了時間は必須事項です',
        ];
    }
    
}
