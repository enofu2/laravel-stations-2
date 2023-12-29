<?php
declare(stryct_types=1);
namespace App\Http\Requests\Reservation;

use Illuminate\Contracts\Support\MessageBag;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

abstract class ReservationRequest extends FormRequest
{
    protected $errorDetails = [];
    protected $errors;
    protected $failedStatus = false;

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
            'schedule_id' => ['required'],
            'sheet_id' => ['required'],
            'name' => ['required'],
            'email' => ['required', 'email:strict,dns'],
            'date' => ['required', 'date_format:Y-m-d']
        ];
    }

    public function attributes()
    {
        return [
            'schedule_id' => 'スケジュールID',
            'sheet_id' => 'シートID',
            'name' => '予約者名',
            'email' => '予約者メールアドレス',
            'date' => '上映日',
        ];
    }
    
    protected function failedValidation(Validator $validator) : void
    {
        $this->failedStatus = true;
        $this->errorDetails = [
            'data' => [],
            'status' => 'error',
            'summary' => 'Failed validation',
            'category' => 'Reservation',
        ];
        $this->errors = $validator->errors();
        
    }

    public function isFailed(){
        return $this->failedStatus;
    }

    public function getErrors() :MessageBag{
        return $this->errors;
    }
}
