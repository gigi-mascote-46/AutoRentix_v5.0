<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Regras de validação que se aplicam ao pedido de atualização do perfil.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // O nome é obrigatório, tem que ser string e no máximo 255 caracteres
            'name' => ['required', 'string', 'max:255'],

            // O email é obrigatório, string, deve estar em minúsculas,
            // deve ser válido, no máximo 255 caracteres,
            // e deve ser único na tabela users, ignorando o email do próprio utilizador (para permitir manter o email atual)
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
        ];
    }
}
