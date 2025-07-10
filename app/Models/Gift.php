<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gift extends Model
{
    use HasFactory;
    protected $fillable = ['key', 'label', 'title', 'image', 'detail_image', 'description'];

    public function options()
    {
        return $this->hasMany(GiftOption::class);
    }
}
