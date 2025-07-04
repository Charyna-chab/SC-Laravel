<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'description', 'category', 'image'];

    // create attribute to clean date formate
    public function getCreatedAtAttribute($value){

        return date('D M Y', strtotime($value));
    }
    // create attribute to clean date formate
    public function getUpdatedAtAttribute($value){

    return date('D M Y', strtotime($value));
    
    }
}

