<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\JsonFile;

class HandleUploadPost extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'jsonFile' => ['nullable', 'mimes:txt', new JsonFile],
            'jsonText' => 'nullable|json'
        ];
    }

    public function messages()
    {
        return [
            'jsonFile.mimes'  => 'Only allowed text files',
            'jsonText.json'  => 'Text should be valid json',
        ];
    }
}
