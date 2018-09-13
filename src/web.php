<?php

Route::group(['prefix' => 'survey', 'middleware' => ['web'], 'namespace' => 'MCesar\\Survey\\Controllers'], function() {
    Route::resource('categories', 'CategoryController');
    Route::resource('questions', 'QuestionController');
});
