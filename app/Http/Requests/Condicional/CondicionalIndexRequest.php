<?php

namespace App\Http\Requests\Condicional;

use Illuminate\Foundation\Http\FormRequest;

class CondicionalIndexRequest extends FormRequest
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
            'representante_id' => 'nullable|integer|exists:representantes,id',
            'user_name' => 'nullable|string|max:255',
            'data_entrega_inicial' => 'nullable|date',
            'data_entrega_final' => 'nullable|date|after_or_equal:data_entrega_inicial',
            'data_retorno_inicial' => 'nullable|date',
            'data_retorno_final' => 'nullable|date|after_or_equal:data_retorno_inicial',
            'id' => 'nullable|integer|exists:condicionais,id',
            'status' => 'nullable|in:aberta,finalizada,em_cobranca',
        ];
    }

    public function messages(): array
    {
        return [
            'representante_id.integer' => 'O ID do representante deve ser um número inteiro.',
            'representante_id.exists' => 'O representante informado não existe.',
            'user_name.string' => 'O nome do usuário deve ser um texto válido.',
            'user_name.max' => 'O nome do usuário não pode exceder :max caracteres.',
            'status.in' => 'O status deve ser um dos seguintes: aberta, finalizada, em_cobranca.',
            'data_entrega_inicial.date' => 'A data de entrega inicial deve ser uma data válida.',
            'data_entrega_final.date' => 'A data de entrega final deve ser uma data válida.',
            'data_retorno_inicial.date' => 'A data de retorno inicial deve ser uma data válida.',
            'data_retorno_final.date' => 'A data de retorno final deve ser uma data válida.',
            'data_entrega_final.after_or_equal' => 'A data de entrega final deve ser igual ou posterior à data de entrega inicial.',
            'data_retorno_final.after_or_equal' => 'A data de retorno final deve ser igual ou posterior à data de retorno inicial.',
            'id.integer' => 'O ID deve ser um número inteiro.',
            'id.exists' => 'O ID informado não existe.',
        ];
    }
}
