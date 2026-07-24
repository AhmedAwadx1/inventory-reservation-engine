<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransferStockRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_id'               => ['required', 'integer', 'exists:products,id'],
            'source_warehouse_id'      => ['required', 'integer', 'exists:warehouses,id'],
            'destination_warehouse_id' => ['required', 'integer', 'exists:warehouses,id', 'different:source_warehouse_id'],
            'quantity'                  => ['required', 'integer', 'min:1'],
            'reason'                    => ['nullable', 'string', 'max:500'],
            // idempotency_key at Header (X-Idempotency-Key)
        ];
    }
}
