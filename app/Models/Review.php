<?php

namespace App\Models;

use App\Enums\ReviewStatus;
use App\Traits\CommonTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Review extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;
    // Note: NOT using CommonTrait because status column is an enum, not a statuses FK

    protected static $logName = 'Review';

    protected $fillable = [
        'tour_id',
        'user_id',
        'reviewer_name',
        'reviewer_email',
        'rating',
        'review_title',
        'review_body',
        'status',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'status' => ReviewStatus::class,
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
        return $query->where('status', ReviewStatus::Approved);
    }

    public function scopePending($query)
    {
        return $query->where('status', ReviewStatus::Pending);
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
    public function statusBadge(): string
    {
        if (!$this->status) return '<span class="badge bg-secondary">N/A</span>';
        return '<span class="badge ' . $this->status->badgeClass() . '">' . $this->status->label() . '</span>';
    }
}
