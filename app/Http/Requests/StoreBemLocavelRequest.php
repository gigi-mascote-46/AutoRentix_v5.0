<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBemLocavelRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
{
    return [
        'marca_id' => 'required|exists:marca,id',
        'modelo' => 'required|string|max:100',
        'registo_unico_publico' => 'required|string|max:20|unique:bens_locaveis,registo_unico_publico',
        'cor' => 'required|string|max:20',
        'numero_passageiros' => 'required|integer|min:1',
        'combustivel' => 'required|in:gasolina,diesel,elétrico,híbrido,outro',
        'numero_portas' => 'required|integer|min:1',
        'transmissao' => 'required|in:manual,automática',
        'ano' => 'required|integer|min:1900|max:' . (date('Y') + 1),
        'manutencao' => 'boolean',
        'preco_diario' => 'required|numeric|min:0',
        'observacao' => 'nullable|string|max:200',
    ];
}

}
