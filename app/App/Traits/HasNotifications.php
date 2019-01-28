<?php

namespace App\App\Traits;

use Illuminate\Notifications\Notifiable;

trait HasNotifications
{
	use Notifiable;

	protected $token;
	
    public function routeNotificationForGlobeConnect()
    {
        return $this->extra_attributes['token'];
    }

    public function getTokenAttribute()
    {
        return $this->extra_attributes['token'] ?? null;
    }

    public function setTokenAttribute($value)
    {
        $this->extra_attributes['token'] = $value;

        return $this;
    }
}