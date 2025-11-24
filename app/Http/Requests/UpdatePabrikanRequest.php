<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePabrikanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $pabrikanId = null;
        $routeParam = $this->route('pabrikan');
        if ($routeParam) {
            // route model binding may provide model or id
            $pabrikanId = is_object($routeParam) ? $routeParam->pabrikan_id : $routeParam;
        }

        return [
            'nama_pabrikan' => [
                'required',
                'string',
                'max:255',
                Rule::unique('pabrikans', 'nama_pabrikan')->ignore($pabrikanId, 'pabrikan_id'),
            ],
            'asal_negara' => ['required', 'string', 'max:100'],
            'logo_pabrikan' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ];
    }
}
