<?php

namespace App\Http\Requests\Movie;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

use App\Http\Requests\Movie\MovieRequest;

class CreateMovieRequest extends MovieRequest
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
    //@Override
    public function rules()
    {
        return [
            'title' => ['required', 'unique:movies'],
            'image_url' => ['required', 'url'],
            'published_year' => ['required', 'gte:1900'],
            'description' => ['required'],
            'is_showing' => ['required', 'boolean'],
            //'genre' => ['required']
        ];
    }
}
