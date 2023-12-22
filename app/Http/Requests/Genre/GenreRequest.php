<?php

namespace App\Http\Requests\Genre;

use Illuminate\Foundation\Http\FormRequest;

class GenreRequest extends FormRequest
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
            'name' => ['required','unique:genres'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'ジャンル名は必須項目です',
            'title.unique' => 'ジャンル名が既に登録されています',
        ];
    }
    
}
