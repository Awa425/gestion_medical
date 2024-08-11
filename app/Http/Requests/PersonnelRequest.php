<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PersonnelRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'date_naissance' => 'date',
            'adresse' => 'string|max:255',
            'telephone' => 'string|max:15',
            'email' => 'required|email|unique:personnels,email,',
            'type_personnel_id' => 'required|exists:type_personnels,id',
            'date_embauche' => 'date',
            'isActive' => 'boolean',
        ];
    }
}
