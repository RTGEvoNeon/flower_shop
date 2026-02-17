<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WholesaleOrderRequest extends FormRequest
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
            'product_slug' => ['required', 'string', 'exists:wholesale_products,slug'],
            'quantity' => ['required', 'integer', 'min:1000'],
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_phone' => ['required', 'string', 'max:20'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'product_slug.required' => 'Не указан товар.',
            'product_slug.exists' => 'Выбранный товар не найден.',
            'quantity.required' => 'Укажите количество.',
            'quantity.integer' => 'Количество должно быть целым числом.',
            'quantity.min' => 'Минимальный заказ: 1000 шт.',
            'customer_name.required' => 'Укажите ваше имя.',
            'customer_name.max' => 'Имя не должно превышать 255 символов.',
            'customer_phone.required' => 'Укажите номер телефона.',
            'customer_phone.max' => 'Номер телефона не должен превышать 20 символов.',
            'notes.max' => 'Комментарий не должен превышать 1000 символов.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'product_slug' => 'товар',
            'quantity' => 'количество',
            'customer_name' => 'имя',
            'customer_phone' => 'телефон',
            'notes' => 'комментарий',
        ];
    }
}
