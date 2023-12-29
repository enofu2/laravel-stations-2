<?php

namespace App\Http\Requests\Schedule;

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;

abstract class ScheduleRequest extends FormRequest
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
        /**
         * 使えなさそうなので途中で書くのやめた...
         */
        /*
        Validator::extend('is_minutes_after_attrDate_attrTime', function($attribute, $value, $parameters, $validator) {
            if (is_null($parameters[0]) || is_null($parameters[1]) || is_null($parameters[2]) )
            {   //パラメータが少なくとも3つ指定されていなければfalse
                return false;
            }
            if (!is_numeric($min = filter_var($parameters[0], FILTER_VALIDATE_INT)))
            {   //第一パラメータが整数値として取得できるか
                return false;
            }
            if ($min < 0)
            {   //minutesが負の場合はfalse
                return false;
            }
            if (is_null($date = $this->getValue($parameters[1])))
            {   //指定した属性値を取得できなければfalse
                return false;
            }
            if (is_null($time = $this->getValue($parameters[2])))
            {   //指定した属性値を取得できなければfalse
                return false;
            }
            $dateFrom = new CarbonImmutable($date);
            $dateMy = new CarbonImmutable($value);

            if ($dateMy->gte($dateFrom->addMinutes($min)))
            {
                return true;
            }
            return false;
        });
        */

        $datetime_validate = function($attribute, $value, $fail) {
            // 入力の取得
            $input_data = $this->all();

            switch ($attribute){
                case 'start_time_date':
                    $name = '開始日付';
                    break;
                case 'start_time_time':
                    $name = '開始時間';
                    break;  
                case 'end_time_date':
                    $name = '終了日付';
                    break;
                case 'end_time_time':
                    $name = '終了時間';
                    break;
                default:
                    $name = '何か';
            }

            $startDateTime = date('Y-m-d H:i:s', strtotime($input_data['start_time_date'] .' ' .$input_data['start_time_time'] ));
            $endDateTime = date('Y-m-d H:i:s', strtotime($input_data['end_time_date'] .' ' .$input_data['end_time_time'] ));

            $from = CarbonImmutable::create($startDateTime);
            $to = CarbonImmutable::create($endDateTime);
            if ($to->gt($from->addMinutes(5)) )
            {
                return;
            }
            $fail($name .'の日時の指定が不正です');
        };

        return [
            'movie_id' => ['required'],
            'start_time_date' => ['required', 'date_format:Y-m-d', 'before_or_equal:end_time_date',$datetime_validate],
            'start_time_time' => ['required', 'date_format:H:i',$datetime_validate],
            'end_time_date' => ['required', 'date_format:Y-m-d', 'after_or_equal:start_time_date',$datetime_validate],
            'end_time_time' => ['required', 'date_format:H:i',$datetime_validate],
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
