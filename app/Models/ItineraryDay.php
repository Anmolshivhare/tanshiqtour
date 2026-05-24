<?php

namespace App\Models;

use App\Traits\CommonTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItineraryDay extends Model
{
    use HasFactory, CommonTrait;

    protected $fillable = [
        'tour_id',
        'day_number',
        'title',
        'description',
        'accommodation',
        'meals_included',
        'activities',
        'created_by',
        'updated_by',
    ];

    public function tour()
    {
        return $this->belongsTo(Tour::class, 'tour_id');
    }
}
