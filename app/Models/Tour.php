<?php

namespace App\Models;

use App\Traits\CommonTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Tour extends Model
{
    use HasFactory, SoftDeletes, CommonTrait, LogsActivity;

    protected static $logName = 'Tour';

    protected $fillable = [
        'title',
        'slug',
        'location',
        'duration',
        'price_per_person',
        'description',
        'featured_image',
        'destination_id',
        'max_persons',
        'status',
        'created_by',
        'updated_by',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly([
            'title', 'slug', 'price_per_person', 'status',
        ])->useLogName('Tour');
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        return ucfirst($eventName) . " Tour";
    }

    public function scopeActive($query)
    {
        return $query->whereHas('statusName', function ($q) {
            $q->where('name', config('constants.active_status_name'));
        });
    }

    public function destination()
    {
        return $this->belongsTo(Destination::class, 'destination_id');
    }

    public function images()
    {
        return $this->hasMany(TourImage::class, 'tour_id')->orderBy('sort_order');
    }

    public function itineraryDays()
    {
        return $this->hasMany(ItineraryDay::class, 'tour_id')->orderBy('day_number');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'tour_id');
    }

    public function wishlistedBy()
    {
        return $this->hasMany(Wishlist::class, 'tour_id');
    }
}
