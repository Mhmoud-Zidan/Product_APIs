<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Product extends JsonResource
{

    public function toArray($request)
    {
        //return parent::toArray($request);
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'detail'=>$this->detail,
            'price'=>$this->price,
            'created_at'=>$this->created_at,
            'updated_at'=>$this->updated_at,
        ];
    }
}
