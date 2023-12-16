<?php

namespace App\Http\Requests\Movie;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

use App\Http\Requests\Movie\MovieRequest;

class DeleteMovieRequest extends MovieRequest
{
    //Override
    public function rules()
    {
        return [
            'id' => ['required']
        ];
    }
    //Override
    public function attributes() : array 
    {
        return [
            'id' => 'ID'
        ];
    }
    //Override
    public function messages()
    {
        return [
            'id.required' => 'IDを指定してください'
        ];
    }
}
