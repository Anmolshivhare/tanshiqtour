<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Traits\HasRoles;
use App\Traits\CommonTrait;

class User extends Authenticatable
{
    use HasFactory, SoftDeletes, HasRoles, Notifiable, CommonTrait, LogsActivity;

    protected static $logName = 'User';

    protected static $logAttributes = ['*'];

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_email_verified',
        'phone_no',
        'date_of_birth',
        'address',
        'status',
        'profile_pic',
        'created_by',
        'updated_by'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly([
            'name',
            'email',
            'phone_no',
            'date_of_birth',
            'address',
            'status',
        ])->useLogName('User');
    }

    public function attributeNames()
    {
        return [
            'name' => 'Name',
            'email' => 'Email',
            'phone_no' => 'Phone Number',
            'date_of_birth' => 'Date of birth',
            'status' => 'Status',
            'address' => 'Address',
        ];
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        return ucfirst($eventName) . " User";
    }

    // public function roles()
    // {
    //     return $this->belongsToMany(Role::class);
    // }
}
