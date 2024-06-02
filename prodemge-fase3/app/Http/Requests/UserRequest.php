<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:50',
            'social_name' => 'required|string|max:50',
            'email' => 'required|string|email|max:100|unique:users',
            'contact' => 'required|max:15',
            'password' => 'required|string|min:8',
            'document' => 'required|string|max:20|unique:peoples',
            'father_name' => 'required|string|max:50',
            'mother_name' => 'required|string|max:50',
        ];
    }
     /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages()
    {
        return [
            'name.required' => 'O campo nome é obrigatório.',
            'name.string' => 'O campo nome deve ser uma string.',
            'name.max' => 'O campo nome não pode ter mais de :max caracteres.',
            'social_name.required' => 'O campo nome social é obrigatório.',
            'social_name.string' => 'O campo nome social deve ser uma string.',
            'social_name.max' => 'O campo nome social não pode ter mais de :max caracteres.',
            'email.required' => 'O campo email é obrigatório.',
            'email.string' => 'O campo email deve ser uma string.',
            'email.email' => 'O email fornecido não é válido.',
            'email.max' => 'O campo email não pode ter mais de :max caracteres.',
            'email.unique' => 'Este email já está em uso.',
            'contact.required' => 'O campo contato é obrigatório.',
            'contact.max' => 'O campo contato não pode ter mais de :max caracteres.',
            'password.required' => 'O campo senha é obrigatório.',
            'password.string' => 'O campo senha deve ser uma string.',
            'password.min' => 'A senha deve ter no mínimo :min caracteres.',
            'document.required' => 'O campo documento é obrigatório.',
            'document.string' => 'O campo documento deve ser uma string.',
            'document.max' => 'O campo documento não pode ter mais de :max caracteres.',
            'document.unique' => 'Este documento já está em uso.',
            'father_name.required' => 'O campo nome do pai é obrigatório.',
            'father_name.string' => 'O campo nome do pai deve ser uma string.',
            'father_name.max' => 'O campo nome do pai não pode ter mais de :max caracteres.',
            'mother_name.required' => 'O campo nome da mãe é obrigatório.',
            'mother_name.string' => 'O campo nome da mãe deve ser uma string.',
            'mother_name.max' => 'O campo nome da mãe não pode ter mais de :max caracteres.',
        ];
    }
}
