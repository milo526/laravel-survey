<?php

namespace MCesar\Survey\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
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

    /**
     * The category in which this question is placed.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get all answers to this given question.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function answers(): BelongsTo
    {
        return $this->hasMany(Answer::class);
    }

    /**
     * Get the answer belonging to the current user.
     * @return MCesar\Survey\Models\Answer
     */
    public function userAnswer(){
        return $this->answers->where('user_id', app('auth')->user()->id)->first();
    }

    /**
     * Only return questions which does/doesn't have an answer from the current user.
     *
     * @param Builder $builder
     * @param bool $answered
     * @return Builder|static
     */
    public function scopeAnswered(Builder $builder, $answered = true): Builder
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

    /**
     * Get if the current user has given an answer to this question after its last edit.
     *
     * @return bool
     */
    public function getAnsweredAttribute(): bool
    {
        $answer = $this->answers->where('user', app('auth')->user())->first();
        if ($answer == null || $answer->updated_at < $this->updated_at){
            return false;
        }

        return true;
    }

    /**
     * Get if the current question is required
     * @return bool
     */
    public function getRequiredAttribute(): bool
    {
        return $this->options["required"];
    }

    /**
     * Get the possible values for this question.
     *
     * @return []
     */
    public function getValuesAttribute(): array
    {

        return $this->options["values"];
    }

    /**
     * Get the default item that should be used for this question.
     *
     * @return string
     */
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

    /**
     * Get if the given answer was a default answer
     *
     * @param $value
     * @return bool
     */
    public function isDefault($value): bool
    {
        $defaults = $this->default();

        if(is_array($defaults)){
            return in_array($value, $defaults);
        }
        return $value == $defaults;
    }
}
