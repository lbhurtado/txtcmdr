<?php

namespace App\Missive\Domain\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CreateSMSResource extends JsonResource
{
    public function toArray($request)
    {
        return [
               'from' => $this->from,
                 'to' => $this->to,
            'message' => $this->message,
        ];
    }
}
