<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course_user extends Model
{
    protected $fillable = [
        'course_id',
        'user_id',
    ];

}
