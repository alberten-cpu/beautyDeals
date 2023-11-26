<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EndUser extends Model
{
    use HasFactory;
    /**
     * @var string
     */
    protected $table = 'end_user';
    /**
     * @var string[]
     */
    protected $fillable = [
        'userId',
        'name',
        'suburb',
        'dateOfBirth',
        'userStatus',
    ];

    protected $primaryKey = 'userId';

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'userId', 'userId');
    }

    public function userimages()
    {
        return $this->hasMany(UserImages::class, 'userId', 'userId');
    }
}
