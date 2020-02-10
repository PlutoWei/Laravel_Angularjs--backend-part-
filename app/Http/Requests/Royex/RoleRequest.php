<?php

namespace App\Http\Requests\Royex;

use Illuminate\Foundation\Http\FormRequest;


class RoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if(isset($this->role_id)){
            return [
                'role_name'  => 'required|unique:royex_role,role_name,'.$this->role_id.',role_id'
            ];
        }
        return [
            'role_name'=>'required|unique:royex_role',
        ];
    }
}
