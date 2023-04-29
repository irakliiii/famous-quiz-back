<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Answer;
use App\Models\Question;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'test',
            'email' => 'test@test.com',
            'password' => Hash::make('password')
        ]);
        
        $booleanQuestions = Question::factory()->count(10)->create([
            'type' => 'boolean'
        ]);
        $answerQuestions = Question::factory()->count(10)->create([
            'type' => 'answers'
        ]);
        $answerQuestions->each(function($question) {
            $answers = Answer::factory()->count(rand(2,4))->create([
                'question_id' => $question->id
            ]);
            $question->correct_answer = $answers[0]->id;
            $question->update();
        });
    }
}
