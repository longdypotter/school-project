<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;

class ClassesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $excepId=$this->route('class') ?? '';
        return [
            'name' => 'required|min:2|max:50|unique:classes,name,'.$excepId.'|regex:/^[a-z ក-អ A-Z 0-9:\s # () _-]+$/',
            'sections'=>'bail|nullable|exists:sections,id'
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.regex'=>'Please Insert Character,Number,Space,Underscore and Colon'
        ];
    }
}
