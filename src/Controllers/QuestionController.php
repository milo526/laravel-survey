<?php

namespace MCesar\Survey\Controllers;

use Illuminate\Routing\Controller;
use MCesar\Survey\Contracts\Question;

class QuestionController extends Controller
{
    public function index() {
        return view('survey::questions.index', ['selected' => 'questions']);
    }

    public function create() {

    }

    public function store() {

    }

    public function show(Question $question) {

    }

    public function edit(Question $question) {

    }

    public function update(Question $question) {

    }

    public function delete(Question $question) {

    }
}