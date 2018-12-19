<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;

class AttachmentRequest extends FormRequest
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
        // $excepId = $this->route('attachment') ?? '';
        return [
            // 'name' => 'required|min:5|max:255'
            'title'=> 'required',
            'type'=> 'required',
            'date'=>'bail|required|date|after_or_equal:'.date('Y-m-d'),
            'user_id'=> 'required|integer|exists:users,id',
            'description' =>'bail|nullable|min:2|max:255',
            'files.*'=> 'bail|required|mimes:txt,sql,doc,pdf,docx,zip,pptx,pps,xls,jpeg,png,jpg,gif,svg',
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
