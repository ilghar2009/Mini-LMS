<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $keyType = 'string';
    protected $primaryKey = 'user_id';
    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'password',
        'is_admin',
    ];

    protected static function boot(){
        parent::boot();
        static::creating(function ($query) {
            $query->user_id = (string) Str::uuid();
        });
    }


    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

//    public function roles(): BelongsToMany
//    {
//        return $this->belongsToMany(Role::class, 'role_user');
//    }

    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'course_user');
    }

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'order');
    }

    public function token(): HasOne
    {
        return $this->hasOne(Token_User::class, 'user_id');
    }

}
