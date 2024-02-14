<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Wildside\Userstamps\Userstamps;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, Userstamps, HasApiTokens, CascadeSoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'password',
        'PhoneNumber',
        'isActive',
        'isVerified',
        'isMember',
        'roleId',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $primaryKey = 'userId';

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'isMember' => 'boolean',
        'isVerified' => 'boolean',
        'isActive' => 'boolean',
        'email_verified_at' => 'datetime',
    ];

    /**
     * @return HasMany
     */
    public function venues(): HasMany
    {
        return $this->hasMany(Venue::class,'userId', 'userId');
    }

    /**
     * @return HasMany
     */
    public function endUser(): HasMany
    {
        return $this->hasMany(EndUser::class,'userId', 'userId');
    }

    public function images(): HasMany
    {
        return $this->hasMany(UserImages::class,'userId', 'userId');
    }

    /**
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->roleId == Role::getRoleId('admin');
    }

    /**
     * @return bool
     */
    public function isUser(): bool
    {
        return $this->roleId == Role::getRoleId('user');
    }

    /**
     * @return bool
     */
    public function isEndUser(): bool
    {
        return $this->roleId == Role::getRoleId('end_user');
    }

    /**
     * @return bool
     */
    public function isAdminUser(): bool
    {
        return $this->roleId == Role::getRoleId('admin_user');
    }
}
