<?php

namespace App\Models;

use App\Traits\CommonTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Review extends Model
{
    use HasFactory, SoftDeletes, CommonTrait, LogsActivity;
    // Note: NOT using CommonTrait because status column is an enum, not a statuses FK

    protected static $logName = 'Review';

    protected $fillable = [
        'tour_id',
        'user_id',
        'reviewer_name',
        'reviewer_email',
        'client_pic',
        'rating',
        'review_title',
        'review_body',
        'status',
        'created_by',
        'updated_by',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly([
            'reviewer_name', 'rating', 'status',
        ])->useLogName('Review');
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        return ucfirst($eventName) . " Review";
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 1);
    }

    public function scopePending($query)
    {
        return $query->where('status', 0);
    }

    public function tour()
    {
        return $this->belongsTo(Tour::class, 'tour_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Helper: get the badge HTML for status display in views.
     */
    // public function statusBadge(): string
    // {
    //     if (!$this->status) return '<span class="badge bg-secondary">N/A</span>';
    //     return '<span class="badge ' . $this->status->badgeClass() . '">' . $this->status->label() . '</span>';
    // }
}
