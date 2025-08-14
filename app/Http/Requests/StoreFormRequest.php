<?php

namespace App\Http\Requests;

use App\Models\FormFieldType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreFormRequest extends FormRequest
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
            'title' => ['required', 'string'],
            'is_label_enabled' => ['required', 'boolean'],
            'is_active' => ['required', 'boolean'],
            'background_color' => ['required', 'string', 'hex_color'],
            'custom_form_fields' => ['required', 'array', 'min:1'],
            'custom_form_fields.*.label' => ['required', 'string'],
            'custom_form_fields.*.form_field_type_id' => [
                'required',
                'integer',
                Rule::exists((new FormFieldType())->getTable(), 'id'),
            ],
            'custom_form_fields.*.values.*.option' => ['string'],
            'custom_form_fields.*.values.*.label' => ['string'],
        ];
    }
}
