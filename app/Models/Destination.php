<?php

namespace App\Models;

use App\Traits\CommonTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Destination extends Model
{
    use HasFactory, SoftDeletes, CommonTrait, LogsActivity;

    protected static $logName = 'Destination';

    protected $fillable = [
        'name',
        'slug',
        'country',
        'state',
        'city',
        'description',
        'short_description',
        'featured_image',
        'banner_image',
        'status',
        'created_by',
        'updated_by',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly([
            'name', 'slug', 'country', 'status',
        ])->useLogName('Destination');
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        return ucfirst($eventName) . " Destination";
    }

    /**
     * Scope to get only active destinations.
     */
    public function scopeActive($query)
    {
        return $query->whereHas('statusName', function ($q) {
            $q->where('name', config('constants.active_status_name'));
        });
    }

    public function tours()
    {
        return $this->hasMany(Tour::class, 'destination_id');
    }
}
