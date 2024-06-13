<?php

namespace App\Http\Controllers;

use App\Models\Test;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class TestController extends Controller
{
    public function create()
    {
        return Inertia::render('Teacher/CreateTest');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'questions' => 'required|array',
            'questions.*.question' => 'required|string|max:255',
            'questions.*.answers' => 'required|array',
            'questions.*.answers.*.answer' => 'required|string|max:255',
            'questions.*.answers.*.is_correct' => 'required|boolean',
        ]);

        $test = Test::create([
            'name' => $request->name,
            'teacher_id' => Auth::id(),
        ]);

        foreach ($request->questions as $questionData) {
            $question = $test->questions()->create([
                'question' => $questionData['question'],
            ]);

            foreach ($questionData['answers'] as $answerData) {
                $question->answers()->create([
                    'answer' => $answerData['answer'],
                    'is_correct' => $answerData['is_correct'],
                ]);
            }
        }

        return redirect()->route('teacher.dashboard')->with('success', 'Test created successfully!');
    }
}
