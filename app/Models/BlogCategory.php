<?php

namespace App\Models;

use App\Traits\CommonTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class BlogCategory extends Model
{
    use HasFactory, SoftDeletes, CommonTrait, LogsActivity;

    protected static $logName = 'BlogCategory';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'status',
        'created_by',
        'updated_by',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly([
            'name', 'slug', 'status',
        ])->useLogName('BlogCategory');
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        return ucfirst($eventName) . " Blog Category";
    }

    public function scopeActive($query)
    {
        return $query->whereHas('statusName', function ($q) {
            $q->where('name', config('constants.active_status_name'));
        });
    }

    public function blogs()
    {
        return $this->hasMany(Blog::class, 'category_id');
    }
}
