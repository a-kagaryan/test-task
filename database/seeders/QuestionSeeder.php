<?php

namespace Database\Seeders;

use App\Models\Question;
use Faker\Core\Number;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $points = [5, 10, 20];
        $faker = Factory::create();

        foreach (range(0,50) as $count) {
            DB::table('questions')->insert([
                'body' => $faker->sentence,
                'points' => $points[rand(0, 2)],
            ]);
            $questionId = DB::getPdo()->lastInsertId();

            foreach (range(0, rand(2, 3)) as $choicesCount) {
                DB::table('question_choices')->insert([
                    'question_id' => $questionId,
                    'body' => $faker->sentence,
                    'is_right_answer' => $choicesCount === 1,
                ]);
            }
        }
    }
}
