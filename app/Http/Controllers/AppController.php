<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

class AppController extends Controller
{
    public function check(Request $request)
    {
        $data = $request->input('data');
        $response = [
            'collectedPoints' => 0
        ];

        foreach ($data as $question_id => $answerId) {
            $isRightAnswer = Question::check($question_id, $answerId);

            $response['questions'][$question_id] = [
                'passed' => Question::check($question_id, $answerId),
                'user_answer' => $answerId,
                'right_answer' => Question::getRightAnswer($question_id)
            ];

            $response['collectedPoints'] += $isRightAnswer ? Question::findOrFail($question_id)->points : 0;
        }

        return response()->json($response);
    }
}
