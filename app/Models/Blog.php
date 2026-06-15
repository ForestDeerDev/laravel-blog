<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $table = 'blogs';

    public $timestamps = false;

    protected $fillable = ['user_id', 'title', 'content', 'create_time'];
}
