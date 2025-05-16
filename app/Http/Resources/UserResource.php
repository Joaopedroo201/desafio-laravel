<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'    => $this->id,
            'name'  => $this->name,
            'email' => $this->email,
            'cep'   => $this->cep,
            'number'=> $this->number,
            'city'  => $this->city,
            'state' => $this->state,
            'role'  => $this->role,
        ];
    }
}
