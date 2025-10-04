<?php

namespace App\Http\Requests\Produto;

use Illuminate\Foundation\Http\FormRequest;

class ProdutoRequest extends FormRequest
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
            "descricao" => 'required|string|max:1000',
            "categoria_id" => 'required|exists:categorias_produto,id',
            "preco_custo" => 'required|numeric|decimal:0,2',
            "preco_venda" => 'required|numeric|decimal:0,2',
        ];
    }

    public function messages(): array
    {
        return [
            'descricao.required' => 'A descrição é obrigatória.',
            'descricao.string' => 'A descrição deve ser um texto válido.',
            'descricao.max' => 'A descrição não pode exceder :max caracteres.',

            'categoria_id.required' => 'A categoria é obrigatória.',
            'categoria_id.exists' => 'A categoria selecionada é inválida.',

            'preco_custo.required' => 'O preço de custo é obrigatório.',
            'preco_custo.numeric' => 'O preço de custo deve ser um número.',
            'preco_custo.decimal' => 'O preço de custo deve ter até 2 casas decimais.',

            'preco_venda.required' => 'O preço de venda é obrigatório.',
            'preco_venda.numeric' => 'O preço de venda deve ser um número.',
            'preco_venda.decimal' => 'O preço de venda deve ter até 2 casas decimais.',
        ];
    }
}
