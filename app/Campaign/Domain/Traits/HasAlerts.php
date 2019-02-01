<?php

namespace App\Campaign\Domain\Traits;

use App\Campaign\Domain\Models\Alert;
use App\Missive\Domain\Models\Contact;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait HasAlerts
{
    /**
     * A model may have multiple alerts.
     */
    public function alerts(): MorphToMany
    {
        return $this->morphToMany(
            Alert::class,
            'model',
            'model_has_alerts'
        // 'model_id',
        // 'alert_id'
        );
    }

    /**
     * Assign the given alert to the model.
     *
     * @param array|string|App\Alert ...$alerts
     *
     * @return $this
     */
    public function assignAlert(...$alerts)
    {
        $alerts = collect($alerts)
            ->flatten()
            ->map(function ($alert) {
                if (empty($alert)) {
                    return false;
                }

                return $this->getStoredAlert($alert);
            })
            ->filter(function ($alert) {
                return $alert instanceof Alert;
            })
            ->map->id
            ->all();

        $model = $this->getModel();

        if ($model->exists) {
            $this->alerts()->sync($alerts, false);
            $model->load('alerts');
        } else {
            $class = \get_class($model);

            $class::saved(
                function ($model) use ($alerts) {
                    $model->alerts()->sync($alerts, false);
                });
        }

        // $this->forgetCachedPermissions();

        return $this;
    }

    /**
     * Revoke the given alert from the model.
     *
     * @param string|App\Alert $alert
     */
    public function removeAlert($alert)
    {
        $this->alerts()->detach($this->getStoredAlert($alert));

        $this->load('alerts');
    }

    /**
     * Remove all current alert and set the given ones.
     *
     * @param array|App\Alert|string ...$alerts
     *
     * @return $this
     */
    public function syncAlerts(...$alerts)
    {
        $this->alerts()->detach();

        return $this->assignAlert($alerts);
    }

    /**
     * Determine if the model has (one of) the given role(s).
     *
     * @param string|int|array|App\Alert $alert
     *
     * @return bool
     */
    public function hasAlert($alerts): bool
    {
        if (is_string($alerts) && false !== strpos($alerts, '|')) {
            $alerts = $this->convertPipeToArray($alerts);
        }

        if (is_string($alerts)) {
            return $this->alerts()->get()->contains('name', $alerts);
        }

        if (is_int($alerts)) {
            return $this->alerts()->get()->contains('id', $alerts);
        }

        if ($alerts instanceof Alert) {
            return $this->alerts()->get()->contains('id', $alerts->id);
        }

        if (is_array($alerts)) {
            foreach ($alerts as $alert) {
                if ($this->hasAlert($alert)) {
                    return true;
                }
            }

            return false;
        }

        return $alerts->intersect($this->alerts()->get())->isNotEmpty();
    }

    /**
     * Determine if the model has any of the given alert(s).
     *
     * @param string|array|App\Alert|\Illuminate\Support\Collection $alerts
     *
     * @return bool
     */
    public function hasAnyAlert($alerts): bool
    {
        return $this->hasAlert($alerts);
    }

    /**
     * Determine if the model has all of the given role(s).
     *
     * @param string|App\Alert|\Illuminate\Support\Collection $alerts
     *
     * @return bool
     */
    public function hasAllAlerts($alerts): bool
    {
        if (is_string($alerts) && false !== strpos($alerts, '|')) {
            $alerts = $this->convertPipeToArray($alerts);
        }

        if (is_string($alerts)) {
            return $this->alerts()->get()->contains('name', $alerts);
        }

        if ($alerts instanceof Alert) {
            return $this->alerts()->get()->contains('id', $alerts->id);
        }

        $alerts = collect()->make($alerts)->map(function ($alert) {
            return $alert instanceof Alert ? $alert->name : $alert;
        });

        return $alerts->intersect($this->alerts->pluck('name')) == $alerts;
    }

    public function getAlertNames(): Collection
    {
        return $this->alerts->pluck('name');
    }

    protected function getStoredAlert($alert): Alert
    {
        $alertClass = Alert::class;

        if (is_numeric($alert)) {
            return app($alertClass)->find($alert);
        }

        if (is_string($alert)) {
            return app($alertClass)->whereName($alert)->first();
        }

        return $alert;
    }
}