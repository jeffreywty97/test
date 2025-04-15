<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    protected array $form_db_mapping = [
        'name'          => 'product_name',
        'category'      => 'category_id',
    ];
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
            'product_name'  => 'required|string|max:255',
            'description'   => 'required',
            'price'         => 'required|numeric|min:0',
            'stock'         => 'required|integer|min:0',
            'enabled'       => 'boolean',
            'category_id'   => 'required|exists:categories,id',
            'user_id'      => 'required|exists:users,id',
        ];
    }

    protected function prepareForValidation():void
    {
        foreach ($this->form_db_mapping as $formField => $dbColumn){
            if($this->has($formField)){
                $this->merge([$dbColumn => $this->input($formField)]);
            }
        }

        $this->merge([
            'user_id' => auth()->id()
        ]);
        
    }
}
