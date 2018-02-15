<?php

namespace MCesar\Survey\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use MCesar\Survey\Contracts\Answer as AnswerContract;

class Answer extends Model implements AnswerContract
{
    use SoftDeletes;
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at', 'updated_at', 'deleted_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'answer' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(config('survey.models.user'));
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(config('survey.models.question'));
    }
}
