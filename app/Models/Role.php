<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    use HasFactory;
    public const ADMIN = 1;
    public const USER = 2;
    public const ENDUSER = 3;
    public const ADMINUSER = 4;

    protected $table = 'roles';

    protected $fillable = [
        'role',
        'roleIdentifier',
        'roleLevel',
        'status',
    ];

    public function user(): HasMany
    {
        return $this->hasMany(User::class);

    }

    public static function getRoleId($identifier)
    {
        $role = Role::where('roleIdentifier', $identifier)->firstOrFail();
        return $role->roleId;
    }
}
