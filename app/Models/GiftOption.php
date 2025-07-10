<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GiftOption extends Model
{
    use HasFactory;
    protected $fillable = ['gift_id', 'label', 'price'];

    public function gift() {
        return $this->belongsTo(Gift::class);
    }
}
