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

            if (!class_exists('CreateSurveyTables')) {
                $timestamp = date('Y_m_d_His', time());

                $this->publishes([
                    __DIR__ . '/../database/migrations/create_survey_tables.php.stub' => $this->app->databasePath() . "/migrations/{$timestamp}_create_survey_tables.php",
                ], 'migrations');
            }
        }

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

        $this->app->bind(CategoryContract::class, $config['category']);
        $this->app->bind(QuestionContract::class, $config['question']);
        $this->app->bind(AnswerContract::class, $config['answer']);
    }
}