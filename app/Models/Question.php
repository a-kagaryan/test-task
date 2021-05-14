<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    const LOW_LEVEL = 'low_level';
    const MID_LEVEL = 'mid_level';
    const HIGH_LEVEL = 'high_level';

    protected $attributes = [
        'time' => 90,
    ];

    public function choices() {
        return $this->hasMany(QuestionChoice::class);
    }

    /**
     * @param int $id
     * @param int $answerId
     * @return bool
     */
    public static function check(int $id, ?int $answerId): bool
    {
        return !empty($answerId) && (bool) QuestionChoice::where([
            'id' => $answerId,
            'is_right_answer' => true,
            'question_id' => $id
        ])->first();
    }

    /**
     * @param int $id
     * @return int
     */
    public static function getRightAnswer(int $id): int
    {
        return QuestionChoice::where(['question_id' => $id, 'is_right_answer' => true])->first()->id;
    }
}
