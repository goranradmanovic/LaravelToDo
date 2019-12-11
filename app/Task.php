<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    //Fillable fields
    protected $fillable = ['description', 'status', 'user_id'];
}
