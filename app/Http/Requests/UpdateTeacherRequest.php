<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTeacherRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $excepId = $this->route('teacher') ?? '';
        return [
            'name' => 'bail|required|regex:/^[a-z A-Z\s​​ ក-អ]+$/|max:50|min:2',
            'date_of_birth'=>'bail|required|date|before_or_equal:'.date('Y-m-d'),
            'gender'=>'bail|required|in:ស្រី,ប្រុស',
            'house_no'=>'bail|nullable|numeric',
            'street_no'=>'bail|nullable|numeric',
            'address'=>'bail|required',
            'phone'=>'bail|required|numeric|digits_between:9,15|unique:teachers,phone,'.$excepId,
            'email'=>'bail|required|email|min:9|max:255|unique:students,email|unique:teachers,email,'.$excepId,
            'profile'=>'bail|required',
            'curriculum.*'=> 'bail|nullable|mimes:doc,pdf,docx,zip,pptx,pps,xls,jpeg,png,jpg,gif,svg'
        ];
    }
    public function messages()
    {
        return [
            'name.regex'=>'The customer name may only contain letters and space',
            'profile.image' => 'The profile is must be an images.',
            'profile.mimes' => 'The profile must be a file of type: jpeg, png, jpg, gif, svg.',
            'profile.max' => 'Size Maximum 5M',
            'curriculum.*.mimes'=>'The curriculum must be a file of type: doc, pdf, docx, zip, pptx, pps, xls, jpeg, png, jpg, gif, svg'
        ];
    }
}
