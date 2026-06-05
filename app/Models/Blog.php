<?php

namespace App\Models;

use App\Traits\CommonTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Blog extends Model
{
    use HasFactory, SoftDeletes, CommonTrait, LogsActivity;

    protected static $logName = 'Blog';

    protected $fillable = [
        'author_id',
        'category_id',
        'title',
        'slug',
        'excerpt',
        'body',
        'featured_image',
        'tags',
        'is_featured',
        'status',
        'published_at',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'tags' => 'array',
        'is_featured' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly([
            'title', 'slug', 'status',
        ])->useLogName('Blog');
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        return ucfirst($eventName) . " Blog";
    }

    public function scopePublished($query)
    {
        return $query->whereNotNull('published_at')->where('published_at', '<=', now());
    }

    public function author()
    {
        return $this->belongsTo(Author::class, 'author_id');
    }

    public function category()
    {
        return $this->belongsTo(BlogCategory::class, 'category_id');
    }
}
