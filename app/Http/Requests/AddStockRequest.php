<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddStockRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_id'   => ['required', 'integer', 'exists:products,id'],
            'warehouse_id' => ['required', 'integer', 'exists:warehouses,id'],
            'quantity'      => ['required', 'integer', 'min:1'],
            'reason'        => ['nullable', 'string', 'max:500'],
            // idempotency_key @ Header (X-Idempotency-Key)
        ];
    }
}
