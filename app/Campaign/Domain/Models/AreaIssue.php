<?php

namespace App\Campaign\Domain\Models;

use App\Missive\Domain\Models\Contact;
use Illuminate\Database\Eloquent\Relations\Pivot;

class AreaIssue extends Pivot
{
    public static function conjure(Contact $contact, $qty)
    {
        return static::make(['qty' => $qty])->contact()->associate($contact);
    }

    protected function contact()
    {
        return $this->belongsTo(Contact::class);
    }
}
