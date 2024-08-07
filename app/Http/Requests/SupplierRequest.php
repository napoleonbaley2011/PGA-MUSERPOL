<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupplierRequest extends FormRequest
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
            'name' => 'required|string|max:255|unique:suppliers,name',
            'nit' => 'required|string|max:50|unique:suppliers,nit',
            'cellphone' => 'required|string|max:20',
            'sales_representative' => 'required|string|max:255',
            'address' => 'required|string',
            'email' => 'required|string|email|max:255',
        ];
    }
}
