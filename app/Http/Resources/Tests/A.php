<?php

namespace App\Http\Resources\Tests;

use Illuminate\Http\Resources\Json\JsonResource;

class AResource extends JsonResource
{
    public function toArray($request)
    {
        return ['id' => $this->id,
'uuid' => $this->uuid,
'username' => $this->username,
'email' => $this->email,
'password' => $this->password,
];
    }
}
