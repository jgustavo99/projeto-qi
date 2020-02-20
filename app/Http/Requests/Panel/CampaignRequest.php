<?php

namespace App\Http\Requests\Panel;

use Illuminate\Foundation\Http\FormRequest;

class CampaignRequest extends FormRequest
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
        switch($this->method()) {
            case 'POST': {
                return [
                    'title' => 'required|max:200',
                    'amount_goal' => 'required',
                    'close_at' => 'required|date',
                    'image' => 'required|image'
                ];
            }

            case 'PUT':
            case 'PATCH': {
            return [
                'title' => 'required|max:200',
                'amount_goal' => 'required',
                'close_at' => 'required|date',
            ];
            }
        }
    }
}
