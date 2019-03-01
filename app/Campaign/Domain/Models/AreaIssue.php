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

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    public function issue()
    {
        return $this->belongsTo(Issue::class);
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }
}
