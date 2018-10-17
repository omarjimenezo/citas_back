<?php

namespace  App\Http\Responses\User;

use Illuminate\Http\Resources\Json\JsonResource;

class UserDataResponse extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id"    => $this->id,
            "email" => $this->email,
        ];
    }

}