<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|confirmed|min:6',
            'cep'       => 'required|string|size:8',
            'number'    => 'required|string|max:10',
        ];
    }

    public function messages(): array
    {
        return [
            'required'  => 'O campo :attribute é obrigatório.',
            'email'     => 'Formato de e-mail inválido.',
            'unique'    => 'Este :attribute já está em uso.',
            'confirmed' => 'A confirmação da senha não confere.',
            'min'       => 'O campo :attribute deve ter no mínimo :min caracteres.',
            'size'      => 'O CEP deve conter exatamente :size dígitos.',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}