<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sell extends Model
{
    use HasFactory;

    protected $fillable = ['upload_id', 'seller_id','buyer_id', 'price'];

    public function upload()
    {
        return $this->hasOne(Upload::class, 'id', 'upload_id');
    }


}
