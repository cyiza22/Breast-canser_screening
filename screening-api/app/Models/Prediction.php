<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prediction extends Model
{
    protected $fillable = [
        'user_id',
        'type',     // 'questionnaire' or 'image'
        'result',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}