<?php

namespace App\Models;

use App\Enums\EnquiryStatus;
use App\Traits\CommonTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Enquiry extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;
    // Note: NOT using CommonTrait because status column is an enum, not a statuses FK

    protected static $logName = 'Enquiry';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'subject',
        'message',
        'tour_id',
        'status',
        'replied_at',
        'replied_by',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'status'     => EnquiryStatus::class,
        'replied_at' => 'datetime',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly([
            'name', 'email', 'status',
        ])->useLogName('Enquiry');
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        return ucfirst($eventName) . " Enquiry";
    }

    public function tour()
    {
        return $this->belongsTo(Tour::class, 'tour_id');
    }

    public function repliedBy()
    {
        return $this->belongsTo(User::class, 'replied_by');
    }

    /**
     * Helper: get badge HTML for status.
     */
    public function statusBadge(): string
    {
        if (!$this->status) return '<span class="badge bg-secondary">N/A</span>';
        return '<span class="badge ' . $this->status->badgeClass() . '">' . $this->status->label() . '</span>';
    }
}
