<?php

namespace MCesar\Survey;

use Illuminate\Support\ServiceProvider;

class SurveyServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if (! class_exists('CreateSurveyTables')) {
            $timestamp = date('Y_m_d_His', time());

            $this->publishes([
                __DIR__.'/../database/migrations/create_survey_tables.php.stub' => $this->app->databasePath()."/migrations/{$timestamp}_create_survey_tables.php",
            ], 'migrations');
        }
    }

    public function register()
    {

    }
}