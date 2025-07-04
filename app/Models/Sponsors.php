<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sponsors extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'logo', 'link'];

    // create attribute to clean date formate
    public function getCreatedAtAttribute($value){

        return date('D M Y', strtotime($value));
    }
    // create attribute to clean date formate
    public function getUpdatedAtAttribute($value){

    return date('D M Y', strtotime($value));
    
    }
}
