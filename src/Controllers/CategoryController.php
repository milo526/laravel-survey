<?php

namespace MCesar\Survey\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Routing\Controller;
use MCesar\Survey\Facade\Category;

class CategoryController extends Controller
{
    public function index()
    {
        return view('survey::categories.index', ['selected' => 'categories']);
    }

    public function create()
    {
        return view('survey::categories.create', ['selected' => 'categories']);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|unique:categories|max:255',
        ]);

        $category = Category::create($data);

        return redirect()->route('survey::categories.show', $category)->with('notification', ['type' => 'success', 'message' => 'Category created.']);
    }

    public function show(int $category)
    {
        $category = Category::findOrFail($category);

        return view('survey::categories.show', ['selected' => "categories.{$category->title}", 'category' => $category]);
    }

    public function edit(int $category)
    {
        $category = Category::findOrFail($category);

        return view('survey::categories.edit', ['selected' => "categories.{$category->title}", 'category' => $category]);
    }

    public function update(Request $request, int $category)
    {
        $category = Category::findOrFail($category);

        $data = $request->validate([
            'title' => [
                'required',
                'max:255',
                Rule::unique('categories')->ignore($category),
            ],
        ]);

        $category->update($data);

        return redirect()->route('survey::categories.show', $category)->with('notification', ['type' => 'success', 'message' => 'Category edited.']);
    }

    public function delete(int $category)
    {
        $category = Category::findOrFail($category);

        $category->delete();

        return redirect()->route('survey::categories.index')->with('notification', ['type' => 'success', 'message' => 'Category deleted.']);
    }
}
