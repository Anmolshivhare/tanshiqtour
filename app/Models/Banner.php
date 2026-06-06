<?php

namespace App\Models;

use App\Traits\CommonTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Banner extends Model
{
    use HasFactory, SoftDeletes, CommonTrait, LogsActivity;

    protected static $logName = 'Banner';

    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'image',
        'button_text',
        'button_url',
        'sort_order',
        'status',
        'created_by',
        'updated_by',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly([
            'title', 'subtitle', 'sort_order', 'status',
        ])->useLogName('Banner');
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        return ucfirst($eventName) . " Banner";
    }
}
