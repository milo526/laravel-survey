<?php

namespace MCesar\Survey\Controllers;

use Illuminate\Routing\Controller;
use MCesar\Survey\Facade\Category;

class CategoryController extends Controller
{
    public function index() {
        return view('survey::categories.index', ['selected' => 'categories']);
    }

    public function create() {

    }

    public function store() {

    }

    public function show(int $category) {
        $category = Category::findOrFail($category);

        return view('survey::categories.show', ['selected' => "categories.{$category->title}", 'category' => $category]);
    }

    public function edit(Category $category) {

    }

    public function update(Category $category) {

    }

    public function delete(Category $category) {

    }
}