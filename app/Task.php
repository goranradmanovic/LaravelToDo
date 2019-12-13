<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    //Fillable fields
    protected $fillable = ['description', 'status', 'user_id'];

    public function user()
    {
      return $this->belongsTo(User::class);
    }
}
