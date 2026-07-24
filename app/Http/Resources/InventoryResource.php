<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InventoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'                 => $this->id,
            'product_id'         => $this->product_id,
            'product_name'       =>$this->whenLoaded('product.name'),
            'warehouse_id'       => $this->warehouse_id,
            'quantity_available'  => $this->quantity_available,
            'quantity_reserved'   => $this->quantity_reserved,
            'quantity_picked'     => $this->quantity_picked,
            'quantity_packed'     => $this->quantity_packed,
            'quantity_shipped'    => $this->quantity_shipped,
            'quantity_delivered'  => $this->quantity_delivered,
            'total_quantity'      => $this->total_quantity,
            'product'             => $this->whenLoaded('product'),
            'warehouse'           => $this->whenLoaded('warehouse'),
            'updated_at'          => $this->updated_at,
        ];
    }
}
