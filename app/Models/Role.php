<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Role extends Model
{
    protected $keyType = 'string';
    protected $primaryKey = 'role_id';
    public $incrementing = false;

    protected $fillable = [
        'role_id',
        'title',
        'description',
    ];

    protected static function boot(){
        parent::boot();
        static::creating(function ($query) {
            $query->role_id = (string) Str::uuid();
        });
    }

}
