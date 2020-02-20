<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class EntityRequest extends FormRequest
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
        $user = \App\Models\Entity::find($this->entity)->user;

        return [
            'email' => 'required|unique:users,email,'.$user->id.',id,deleted_at,NULL',
            'password' => 'confirmed',
        ];
    }
}
