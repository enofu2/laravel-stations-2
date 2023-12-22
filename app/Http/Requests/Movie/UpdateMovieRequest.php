<?php

namespace App\Http\Requests\Movie;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;

use App\Http\Requests\Movie\MovieRequest;

class UpdateMovieRequest extends MovieRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    //@Override
    public function rules()
    {
        $parentRules = parent::rules();
        $parentRules['title'] = ['required', Rule::unique('movies')->ignore($this->id)];
        return $parentRules;
    }
}
