<?php

namespace App\Http\Requests\Admin\Scoreboard;

use Illuminate\Foundation\Http\FormRequest;

class StoreSongRequest extends FormRequest
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
            'song_name' => 'required',
            'songclip_raw' => 'required|mimes:wav,mpga|max:4096',
        ];
    }
}
