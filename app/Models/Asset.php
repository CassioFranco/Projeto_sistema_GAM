<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    protected $fillable = ['name','valor_contabil','latitude_distribuicao','longitude_distribuicao','current_user_id','status'];
    public function owner(){ return $this->belongsTo(User::class, 'current_user_id'); }
}
