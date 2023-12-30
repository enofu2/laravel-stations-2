<?php

namespace App\Http\Requests\Base;

use Illuminate\Contracts\Support\MessageBag;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Arr;
use PhpParser\Node\Arg;

abstract class BaseFormRequest extends FormRequest
{
    protected $errorDetails = [];
    protected $errors;
    protected $failedStatus = false;

    protected function failedValidation(Validator $validator) : void
    {
        $this->failedStatus = true;
        $this->errorDetails = [
            'data' => [],
            'status' => 'error',
            'summary' => 'Failed validation',
        ];
        $this->errors = $validator->errors()->toArray();
    }

    public function isFailed(){
        return $this->failedStatus;
    }

    public function getErrors() :array{
        return $this->errors;
    }
}