<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
        'meta_title',
        'meta_description',
        'user_id',
    ];

    protected static function boot(){
        parent::boot();
        static::creating(function ($query){
            $query->course_id = (string) Str::uuid();
        });
    }

    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class, 'course_id');
    }

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'order');
    }

}
