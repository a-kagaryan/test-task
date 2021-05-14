<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionChoice extends Model
{
    use HasFactory;

    protected $hidden = [
        'is_right_answer'
    ];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
