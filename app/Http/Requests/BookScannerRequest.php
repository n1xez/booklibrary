<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class BookScannerRequest
 * @package App\Http\Requests
 */
class BookScannerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'isbn' => 'required|unique|numeric',
            'author_full_name' => 'required|string|min:1|max:255',
            'title' => 'required|string|min:1|max:255',
            'year' => 'required|numeric|min:1970|max:2100',
        ];
    }
}