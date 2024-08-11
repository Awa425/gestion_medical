<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePersonnelRequest extends FormRequest
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
            'name' =>['string'],
            'prenom' =>['string'],
            'adresse' =>['string'],
            'telephone' =>['string'],
            'email' =>['string'],
            'datte_naissance' =>['date'],
            'datte_embauche' =>['date'],
            'password' =>['string'],
            'type_personnel_id' =>['integer'],
            'isActive' =>['boolean'],
        ];
    }
}
