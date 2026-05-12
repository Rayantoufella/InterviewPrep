<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuestionRequest;
use App\Models\Question;

class QuestionController extends Controller
{
    public function index()
    {
        $questions = Question::all();

        return view('questions.index', compact('questions'));
    }

    public function create()
    {
        return view('questions.create');
    }

    public function store(QuestionRequest $request)
    {
        Question::create($request->validated());

        return redirect()->route('questions.index');
    }

    public function edit(Question $question)
    {
        return view('questions.edit', compact('question'));
    }

    public function update(QuestionRequest $request, Question $question)
    {
        $question->update($request->validated());

        return redirect()->route('questions.index');
    }

    public function destroy(Question $question)
    {
        $question->delete();

        return redirect()->route('questions.index');
    }
}
