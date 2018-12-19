<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;

class UpdateDownloadCenterRequest extends FormRequest
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
        $excepId = $this->route('downloadcenter') ?? '';
        return [
            'name' => 'bail|required|regex:/^[a-z 0-9 A-Z\s]+$/|max:50|min:2',
             'document_type_id' => 'bail|required|integer|exists:document_types,id',
             'public_date'=>'bail|required|date|after_or_equal:'.date('Y-m-d'),
             'class_id'=>'bail|nullable|integer|exists:classes,id',
             'section_id'=>'bail|nullable|integer|exists:sections,id',
             'subject_id'=>'bail|nullable|integer|exists:subjects,id',
             'description'=>'bail|nullable|min:2|max:255',
             'file.*'=> 'bail|nullable|mimes:txt,sql,doc,pdf,docx,zip,pptx,pps,xls,jpeg,png,jpg,gif,svg'.$excepId,
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
            'file.mimes'=>'The file must be a file of type: doc, pdf, docx, zip, pptx, pps, xls, jpeg, png, jpg, gif, svg'
        ];
    }
}
