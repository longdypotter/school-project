<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSessionRequest extends FormRequest
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
        $excepId = $this->route('session') ?? '';
        return [
             'session' => 'sometimes|required|regex:/^[0-9\-_]+$/|min:7|max:7|unique:sessions,session,'.$excepId,
             //'session' => 'required|numeric|regex:/^[-]+$/|min:7',
             'is_active'=>'bail|required|in:yes,no'
        ];
    }
}
