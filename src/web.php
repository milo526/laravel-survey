<?php

Route::group(['prefix' => 'survey', 'middleware' => ['web'], 'namespace' => 'MCesar\\Survey\\Controllers', 'as' => 'survey::'], function() {
    Route::resource('categories', 'CategoryController');
    Route::resource('categories.questions', 'QuestionController');
});
