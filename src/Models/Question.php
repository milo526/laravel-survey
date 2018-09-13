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

    public function getRequiredAttribute(): bool
    {
        return $this->options["required"];
    }

    public function getValuesAttribute(): ?array
    {

        return $this->options["values"];
    }

    public function default(?string $old): ?string
    {
        if(isset($old)){
            if(is_array($old)){
                return array_keys($old);
            }
            return $old;
        }

        if(array_has($this->options, "default")){
            return $this->options["default"];
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
