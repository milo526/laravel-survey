<?php

namespace MCesar\Survey\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    public $guarded = ['id'];

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
        'completion',
        'completed',
    ];

    /**
     * Get all questions for this given category.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    /**
     * Get the percentage of completed questions in this category.
     * @return float|int
     */
    public function getCompletionAttribute(): float
    {
        $questions = $this->questions->count();
        $answered = $this->questions()->answered()->count();

        return ($answered / $questions) * 100;
    }

    /**
     * Get if all questions have been answered in this category.
     * @return bool
     */
    public function getCompletedAttribute(): bool
    {
        return $this->questions()->answered == $this->questions;
    }
}
