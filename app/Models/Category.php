<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'categories';

    // Relation
    public function videos()
    {
      //  return $this->belongsTo(VideoManagement::class, 'id', 'category_id');
        return $this->hasMany(Videos::class, 'category_id', 'id');
    }
}
