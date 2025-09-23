<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Course extends Model
{
    protected $keyType = 'string';
    protected $primaryKey = 'course_id';
    public $incrementing = false;

    protected $fillable = [
        'course_id',
        'title',
        'description',
        'teacher',
    ];

    protected static function boot(){
        parent::boot();
        static::creating(function ($query){
            $query->course_id = (string) Str::uuid();
        });
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'role_user');
    }

    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class, 'course_id');
    }

}
