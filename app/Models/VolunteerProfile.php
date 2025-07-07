<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VolunteerProfile extends Model
{
    use HasFactory;
    protected $fillable = ['name','nationality','description', 'profile'];

    // create attribute to clean date formate
    public function getCreatedAtAttribute($value){

        return date('D M Y', strtotime($value));
    }
    // create attribute to clean date formate
    public function getUpdatedAtAttribute($value){

    return date('D M Y', strtotime($value));
    
    }
}
