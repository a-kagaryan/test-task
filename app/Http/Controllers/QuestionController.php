<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function list()
    {
        return response()->json(array_merge(
            /*Question::LOW_LEVEL =>*/ Question::where('points', 5)->limit(2)->with('choices')->get()->toArray(),
            /*Question::MID_LEVEL =>*/ Question::where('points', 10)->limit(2)->with('choices')->get()->toArray(),
            /*Question::HIGH_LEVEL =>*/ Question::where('points', 20)->limit(1)->with('choices')->get()->toArray()
        ));
    }
}
