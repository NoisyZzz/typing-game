<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Score extends Model
{
    use HasFactory;

   
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Las columnas que pueden ser rellenadas en masa
    protected $fillable = ['user_id', 'wpm', 'time'];
}
