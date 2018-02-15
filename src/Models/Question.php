<?php

namespace MCesar\Survey\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use MCesar\Survey\Contracts\Answer as AnswerContract;
use MCesar\Survey\Contracts\Question as QuestionContract;

class Question extends Model implements QuestionContract
{
    use SoftDeletes;

    public $guarded = ['id'];

    /**
     * Defines the possible question types.
     */
    const TYPES = ['string', 'radio', 'checkbox'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at', 'updated_at', 'deleted_at',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'answered',
        'required',
        'values',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'options' => 'array',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(config('survey.models.category'));
    }

    public function answers(): HasMany
    {
        return $this->hasMany(config('survey.models.answer'));
    }

    public function userAnswer(): AnswerContract
    {
        return $this->answers->where('user_id', app('auth')->user()->id)->first();
    }

    public function scopeAnswered(Builder $builder, bool $answered = true): Builder
    {

        if($answered){
            return $builder->whereHas('answers', function ($q) {
                $q->where('user_id', app('auth')->user()->id);
            });
        } else {
            return $builder->whereDoesntHave('answers', function ($q) {
                $q->where('user_id', app('auth')->user()->id);
            });
        }
    }

    public function getAnsweredAttribute(): bool
    {
        $answer = $this->answers->where('user', app('auth')->user())->first();
        if ($answer == null || $answer->updated_at < $this->updated_at){
            return false;
        }

        return true;
    }

    public function getRequiredAttribute(): bool
    {
        return $this->options["required"];
    }

    public function getValuesAttribute(): array
    {

        return $this->options["values"];
    }

    public function default(string $old): string
    {
        if(isset($old)){
            if(is_array($old)){
                return array_keys($old);
            }
            return $old;
        }

        $answered = $this->userAnswer();
        if(!is_null($answered)){
            return $answered->answer;
        }
        return null;
    }

    public function isDefault($value): bool
    {
        $defaults = $this->default();

        if(is_array($defaults)){
            return in_array($value, $defaults);
        }
        return $value == $defaults;
    }
}
