<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    //
    protected $table = 'tasks';
    protected $fillable = ['title', 'user_id', 'completed', 'created_at'];
}
