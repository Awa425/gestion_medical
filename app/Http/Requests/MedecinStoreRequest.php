<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MedecinStoreRequest extends FormRequest
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
        return [
            'nom' => ['required', 'string', 'max:255'],
            'prenom' => ['required', 'string', 'max:255'],
            'adresse' => ['required', 'string', 'max:255'],
            'email' => ['unique:apprenants','required', 'email', 'max:255'],
            'password' => ['sometimes', 'max:255',],
            'telephone' => ['required' , 'regex:/^([0-9\s\-\+\(\)]*)$/'],
        ];
    }
}
