<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'description', 'category', 'image'];

    public function getCreatedAtAttribute($value){

        return Carbon::parse($value)->format('d M Y');
    }

    public function getUpdatedAtAttribute($value){

    return Carbon::parse($value)->format('d M Y');
    
    }
}

