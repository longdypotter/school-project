<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDocumentTypeRequest extends FormRequest
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
        $excepId = $this->route('documenttype') ?? '';
        return [
                'name' => 'required|regex:/^[a-z​ ក-អ A-Z\s​​]+$/|max:50|min:2|unique:document_types,name,'.$excepId,
        ];
    }
}
