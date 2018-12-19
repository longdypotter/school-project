<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;

class StudentRequest extends FormRequest
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
       $excepid = $this->route('student') ?? '';
        return [

          'khmer_name' =>             'bail|required|regex:/^[s​​ ក-អ]+$/|max:100|min:3',
          'english_name' =>           'bail|required|regex:/^[a-z A-Z\s​​ ]+$/|max:100|min:3',
          'gender' =>                 'bail|required|in:ស្រី,ប្រុស',
          'ethnicity' =>              'bail|nullable|regex:/^[a-z A-Z\s​​ ក-អ]+$/|max:100|min:2',
          'nationality' =>            'bail|nullable|regex:/^[a-z A-Z\s​​ ក-អ]+$/|max:100|min:2',
          'date_of_birth' =>          'bail|required|date|before_or_equal:'.date('Y-m-d'),
          'place_of_birth' =>         'bail|required|regex:/^[a-z 0-9 A-Z\s​​ ក-អ]+$/|max:100|min:5',
          'status' =>                 'bail|nullable|regex:/^[a-z 0-9 A-Z\s​ ក-អ]+$/|max:255|min:4',
          'occupation' =>             'bail|nullable|regex:/^[a-z 0-9 A-Z\s​​ ក-អ]+$/|max:100|min:4',
          'education' =>              'bail|nullable|regex:/^[a-z 0-9 A-Z\s​​ ក-អ]+$/|max:100|min:3',
          'health' =>                 'bail|nullable|regex:/^[a-z A-Z\s​​ ក-អ]+$/|max:100|min:3',
          'house_no' =>               'bail|nullable|regex:/^[a-z A-Z\s​​ 0-9]+$/',
          'street_no' =>              'bail|nullable|regex:/^[a-z A-Z\s​​ ក-អ 0-9]+$/',
          'address' =>                'bail|required',
          'profile'=>                 'bail|required',
          'father_name' =>            'bail|nullable|regex:/^[a-z A-Z\s​​ ក-អ]+$/|max:100',
          'father_occupation' =>      'bail|nullable|regex:/^[a-z A-Z\s​​ ក-អ]+$/|max:100',
          'mother_name' =>            'bail|nullable|regex:/^[a-z A-Z\s​​ ក-អ]+$/|max:100',
          'mother_occupation' =>      'bail|nullable|regex:/^[a-z A-Z\s​​ ក-អ]+$/|max:100',
          'parent_house_no' =>        'bail|nullable|regex:/^[a-z A-Z\s​​ ក-អ 0-9]+$/|',
          'parent_street_no' =>       'bail|nullable|regex:/^[a-z A-Z\s​​ ក-អ 0-9]+$/|',
          'parent_address' =>         'bail',
          'guardian_name' =>          'bail|nullable|regex:/^[a-z A-Z\s ក-អ]+$/|max:100',
          'guardian_occupation' =>    'bail|nullable|regex:/^[a-z A-Z\s ក-អ]+$/|max:100',
          'guardian_house_no' =>      'bail|nullable|regex:/^[a-z A-Z\s​​ ក-អ 0-9]+$/|',
          'guardian_street_no' =>     'bail|nullable|regex:/^[a-z A-Z\s​​ ក-អ 0-9]+$/|',
          'guardian_address' =>       'bail',
          'guardian_phone' =>         'bail|nullable|numeric|digits_between:9,15',
          'father_phone' =>           'bail|numeric|nullable|digits_between:9,15',
          'mather_phone' =>           'bail|numeric|nullable|digits_between:9,15',
          'phone' =>                  'bail|required|numeric|digits_between:9,15|unique:students,phone,'.$excepid,
          'name' =>                   'bail|required|sometimes|regex:/^[a-z A-Z 0-9\s ក-អ]+$/|max:255|min:3',
          'type' =>                   'required|sometimes',
          'url'=>                     'bail|sometimes|required|mimes:doc,pdf,docx,zip,pptx,pps,xls,jpeg,png,jpg,gif,svg',
          'section_id' =>             'required|sometimes',
          'session_id' =>             'required|sometimes',
          'class_id' =>               'required|sometimes',
        //'is_active' =>              'required|exists:sessions,id',
          'email' =>                  'required|email|unique:teachers,email|unique:students,email,'.$excepid,
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
            'khmer_name.required' =>'The khmer name is required',
            'english_name.required' =>'The english name is required',
            'session_id.required' => 'The session is required',
            'class_id.required' => 'The class is required',
            'section_id.required' => 'The section is required',
        ];
    }
}
