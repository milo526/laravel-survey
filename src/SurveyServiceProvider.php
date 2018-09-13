<?php

namespace MCesar\Survey;

use Illuminate\Support\ServiceProvider;
use MCesar\Survey\Contracts\Answer as AnswerContract;
use MCesar\Survey\Contracts\Category as CategoryContract;
use MCesar\Survey\Contracts\Question as QuestionContract;

class SurveyServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if (isNotLumen()) {
            $this->publishes([
                __DIR__ . '/../config/survey.php' => config_path('survey.php'),
            ], 'config');

            $this->publishes([
                __DIR__.'/../public' => public_path('vendor/survey'),
            ], 'public');

            $this->publishes([
                __DIR__.'/resources/views' => resource_path('views/vendor/survey'),
            ], 'views');

            if (!class_exists('CreateSurveyTables')) {
                $timestamp = date('Y_m_d_His', time());

                $this->publishes([
                    __DIR__ . '/../database/migrations/create_survey_tables.php.stub' => $this->app->databasePath() . "/migrations/{$timestamp}_create_survey_tables.php",
                ], 'migrations');
            }
        }

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadRoutesFrom(__DIR__.'/web.php');
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'survey');

        $this->registerModelBindings();
    }

    public function register()
    {
        if (isNotLumen()) {
            $this->mergeConfigFrom(
                __DIR__.'/../config/survey.php',
                'survey'
            );
        }
    }

    protected function registerModelBindings()
    {
        $config = $this->app->config['survey.models'];

        $this->app->bind('category', $config['category']);
        $this->app->bind('question', $config['question']);
        $this->app->bind('answer', $config['answer']);
    }
}