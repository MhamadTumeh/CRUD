<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Courses extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id','name', 'video' 
    ];

    public function admin()
    {
        return $this->belongsTo('App\Models\Admin');
    }
}
