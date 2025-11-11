<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = ['user_id','latitude','longitude','recorded_at'];
    public function user(){ return $this->belongsTo(User::class); }
}
