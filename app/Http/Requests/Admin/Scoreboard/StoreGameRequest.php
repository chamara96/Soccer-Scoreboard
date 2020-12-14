<?php

namespace App\Http\Requests\Admin\Scoreboard;

use Illuminate\Foundation\Http\FormRequest;

class StoreGameRequest extends FormRequest
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
        return [
            'game_name' => 'required',
            'date' => 'required',
            'ground' => 'required',
            'game_logo_raw' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            // 'game_name' => 'required',
        ];
    }
}
