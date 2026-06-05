<?php

namespace App\Models;

use App\Traits\CommonTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Author extends Model
{
    use HasFactory, SoftDeletes, CommonTrait, LogsActivity;

    protected static $logName = 'Author';

    protected $fillable = [
        'name',
        'email',
        'bio',
        'profile_image',
        'status',
        'created_by',
        'updated_by',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly([
            'name', 'email', 'status',
        ])->useLogName('Author');
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        return ucfirst($eventName) . " Author";
    }

    public function scopeActiveAuthors($query)
    {
        return $query->whereHas('statusName', function ($q) {
            $q->where('name', config('constants.active_status_name'));
        });
    }

    public function blogs()
    {
        return $this->hasMany(Blog::class, 'author_id');
    }
}
