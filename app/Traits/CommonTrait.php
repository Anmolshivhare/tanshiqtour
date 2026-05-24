<?php

namespace App\Traits;

use App\Helpers\DateHelper;
use App\Helpers\UserHelper;
use App\Models\Status;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait CommonTrait
{
    /**
     * function to get the actual value of the status
     *
     * @return mixed
     */
    public function getOriginalStatusAttribute()
    {
        return $this->attributes['status'];
    }

    /**
     * function to format the updated at value
     *
     * @param mixed $value
     * @return mixed
     */
    public function getCreatedAtAttribute($value)
    {
        return DateHelper::formatDateTime($value);
    }

    /**
     * function to formatted the updated-at value
     *
     * @param mixed $value
     * @return mixed
     */
    public function getUpdatedAtAttribute($value)
    {
        return DateHelper::formatDateTime($value);
    }

    /**
     * function to save the logged in user as created-at
     *
     * @return void
     */
    protected static function booted()
    {
        static::creating(function ($model) {
            $userData = UserHelper::getLoggedInUser();
            if (empty($model->created_by) && $userData) {
                $model->created_by = $userData->id;
            }
        });

        static::updating(function ($model) {
            $userData = UserHelper::getLoggedInUser();
            if ($userData) {
                $model->updated_by = $userData->id;
            }
        });
    }

    /**
     * Get the user who last updated this record.
     */
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    /**
     * Get the user who created this record.
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    /**
     * function to define the relationship with the statuses table
     *
     * @return BelongsTo
     */
    public function statusName(): BelongsTo
    {
        return $this->belongsTo(Status::class, 'status');
    }

     /**
     * Scope a query to only include active records.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->whereHas('statusName', function ($query) {
            $query->where('name', config('constants.active_status_name'));
        });
    }
}
