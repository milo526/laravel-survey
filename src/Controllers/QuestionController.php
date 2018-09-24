<?php

namespace MCesar\Survey\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Routing\Controller;
use MCesar\Survey\Facade\Category;
use MCesar\Survey\Facade\Question;

class QuestionController extends Controller
{
    public function index(int $category)
    {
        return redirect()->route('survey::categories.show', $category);
    }

    public function create(int $category)
    {
        $category = Category::findOrFail($category);

        return view('survey::questions.create', ['selected' => "categories.{$category->title}", 'category' => $category]);
    }

    public function store(Request $request, int $category)
    {
        $category = Category::findOrFail($category);

        $data = $request->validate([
            'title' => [
                'required',
                'max:255',
                Rule::unique('questions')
                    ->where(function ($query) use ($category) {
                        return $query->where('category_id', $category->id);
                    }),
            ],
            'type' => [
                'required',
                Rule::in(\MCesar\Survey\Facade\Question::types()),
            ],
            'values' => 'required_if:type,radio,checkbox',
            'required' => 'nullable',
        ]);

        $data['options'] = [
            'values' => $data['values'] ?? '',
            'required' => $data['required'] ?? '0',
        ];

        $question = $category->questions()->create($data);

        return redirect()->route('survey::categories.questions.show', [$category, $question])->with('notification', ['type' => 'success', 'message' => 'Question created.']);
    }

    public function show(int $category, int $question)
    {
        $question = Question::findOrFail($question);
        $category = $question->category;

        return view('survey::questions.show', ['selected' => "categories.{$category->title}", 'category' => $category, 'question' => $question]);
    }

    public function edit(int $category, int $question)
    {
        $question = Question::findOrFail($question);
        $category = $question->category;

        return view('survey::questions.edit', ['selected' => "categories.{$category->title}", 'category' => $category, 'question' => $question]);
    }

    public function update(Request $request, int $category, int $question)
    {
        $question = Question::findOrFail($question);

        $data = $request->validate([
            'title' => [
                'required',
                'max:255',
                Rule::unique('questions')
                    ->ignore($question)
                    ->where(function ($query) use ($category) {
                        return $query->where('category_id', $category);
                    }),
            ],
            'type' => [
                'required',
                Rule::in(\MCesar\Survey\Facade\Question::types()),
            ],
            'values' => 'required_if:type,radio,checkbox',
            'required' => 'nullable',
        ]);

        $data['options'] = [
            'values' => $data['values'] ?? '',
            'required' => $data['required'] ?? '0',
        ];

        $question->update($data);

        return redirect()->route('survey::categories.questions.show', [$category, $question])->with('notification', ['type' => 'success', 'message' => 'Question edited.']);
    }

    public function destroy(int $category, int $question)
    {
        $question = Question::findOrFail($question);

        $question->delete();

        return redirect()->route('survey::categories.questions.index', $category)->with('notification', ['type' => 'success', 'message' => 'Question deleted.']);
    }
}
