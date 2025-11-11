<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssetTransferItem extends Model
{
    protected $fillable = ['asset_transfer_id','asset_id','side'];
    public function asset(){ return $this->belongsTo(Asset::class); }
    public function transfer(){ return $this->belongsTo(AssetTransfer::class, 'asset_transfer_id'); }
}
