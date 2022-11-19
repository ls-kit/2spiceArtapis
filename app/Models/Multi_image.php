<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Multi_image extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'multi_images';

    public function upload()
    {
        return $this->belongsTo(Upload::class, 'upload_id', 'id');
    }
}
