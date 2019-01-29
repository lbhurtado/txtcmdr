<?php

namespace App\Missive\Domain\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CreateContactFromGlobeRedirectResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'access_token' => $this->access_token,
            'subscriber_number' => $this->subscriber_number,
        ];
    }
}
