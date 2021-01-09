<?php

namespace App\Http\Requests\Admin\Scoreboard;

use Illuminate\Foundation\Http\FormRequest;

class StoreAdRequest extends FormRequest
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
            'ad_title' => 'required',
            'game_id' => 'required',
            'ad_path' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ];
    }
}
