<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssetTransfer extends Model
{
    protected $fillable = ['from_user_id','to_user_id','total_from','total_to'];
    public function items(){ return $this->hasMany(AssetTransferItem::class); }
}
