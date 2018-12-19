<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;

class SessionRequest extends FormRequest
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
        $excepId = $this->route('session') ?? '';
        return [
            //'session' => 'required|regex:/^[0-9\-]+$/|min:7|max:7|unique:sessions'.$excepId,
            // 'session' => 'required|min:2|max:50|unique:sessions'.$excepId,
            'session' => 'required|min:2|max:50|unique:classes,name,'.$excepId.'|regex:/^[a-z ក-អ A-Z 0-9:\s # _-()]+$/',
            'is_active'=>'bail|required|in:yes,no'
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
            'session.regex'=> 'Insert only number and dash (-)'
        ];
    }
}
