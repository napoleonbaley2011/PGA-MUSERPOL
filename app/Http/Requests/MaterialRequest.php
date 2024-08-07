<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MaterialRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Cambia esto a true si deseas autorizar la solicitud
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'code_material' => 'required|string|max:10|unique:materials,code_material',
            'description' => 'required|string|max:255|unique:materials,description',
            'unit_material' => 'required|string|max:50',
            'state' => 'required|string|max:50',
            'stock' => 'required|integer|min:0',
            'min' => 'required|integer|min:0',
            'barcode' => 'required|string|max:255|unique:materials,barcode',
            'type'=>'required|string|max:25',
            'group_id' => 'required|integer|exists:groups,id',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'group_id.required' => 'El campo grupo es obligatorio.',
            'group_id.integer' => 'El campo grupo debe ser un número entero.',
            'group_id.exists' => 'El grupo seleccionado no existe.',
            'code_material.required' => 'El código del material es obligatorio.',
            'code_material.string' => 'El código del material debe ser una cadena de texto.',
            'code_material.max' => 'El código del material no puede exceder los 10 caracteres.',
            'code_material.unique' => 'El código del material ya está registrado.',
            'description.required' => 'La descripción es obligatoria.',
            'description.string' => 'La descripción debe ser una cadena de texto.',
            'description.max' => 'La descripción no puede exceder los 255 caracteres.',
            'unit_material.required' => 'La unidad del material es obligatoria.',
            'unit_material.string' => 'La unidad del material debe ser una cadena de texto.',
            'unit_material.max' => 'La unidad del material no puede exceder los 50 caracteres.',
            'barcode.required' => 'El código de barras es obligatorio.',
            'barcode.string' => 'El código de barras debe ser una cadena de texto.',
            'barcode.max' => 'El código de barras no puede exceder los 255 caracteres.',
            'barcode.unique' => 'El código de barras ya está registrado.',
            'stock.required' => 'El stock es obligatorio.',
            'stock.integer' => 'El stock debe ser un número entero.',
            'stock.min' => 'El stock no puede ser un número negativo.',
            'state.required' => 'El estado es obligatorio.',
            'state.string' => 'El estado debe ser una cadena de texto.',
            'state.in' => 'El estado debe ser uno de los siguientes valores: INHABILITADO, ALMACEN.',
            'min.required' => 'El stock mínimo es obligatorio.',
            'min.integer' => 'El stock mínimo debe ser un número entero.',
            'min.min' => 'El stock mínimo no puede ser un número negativo.',
            'type.required' => 'El tipo es obligatorio.',
            'type.string' => 'El tipo debe ser una cadena de texto.',
            'type.in' => 'El tipo debe ser ALMACEN.',
        ];
    }
}
