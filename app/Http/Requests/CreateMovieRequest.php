<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class CreateMovieRequest extends FormRequest
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
            'title' => ['required', 'unique:movies'],
            'image_url' => ['required', 'url'],
            'published_year' => ['required', 'gte:1900'],
            'description' => ['required'],
            //'is_showing' => ['required', 'boolean'],
            //'genre' => ['required']
        ];
    }

    public function attributes() : array 
    {
        return [
            'title' => '映画タイトル',
            'image_url' => '画像URL',
            'published_year' => '公開年',
            'is_showing' => '公開中かどうか',
            'description' => '概要'
        ];
    }

    public function messages()
    {
        return [
            'title.required' => '映画タイトルは必須項目です',
            'title.unique' => '映画タイトルが既に登録されています',
            'published_year.required' => '公開年は必須項目です',
            'published_year.gte' => '公開年は1900より大きい値を指定してください',
            'description.required' => '概要は必須項目です',
            'is_showing.required' => '公開中かどうかは必須事項です',
            'is_showing.boolean' => '公開中かどうかは真偽値(boolean)で指定してください'
        ];
    }
    
    protected function failedValidation(Validator $validator)
    {
        //dd($validator);
        return parent::failedValidation($validator);
    }
    
}
