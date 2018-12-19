<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;

class FollowupRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        // return backpack_auth()->check();
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
            'title'=> 'required',
            'type'=> 'required',
            // 'user_id'=> 'required|integer|exists:users,id',
            'description' =>'bail|nullable|max:255',
            // 'files.*'=> 'bail|required|mimes:txt,sql,doc,pdf,docx,zip,pptx,pps,xls,jpeg,png,jpg,gif,svg',
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
            'files.*.mimes'=>'The file must be a file of type: txt, sql, doc, pdf, docx, zip, pptx, pps, xls, jpeg, png, jpg, gif, svg'
        ];
    }
}
