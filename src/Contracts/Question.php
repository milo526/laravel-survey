<?php

namespace MCesar\Survey\Contracts;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;
use MCesar\Survey\Contracts\Answer as AnswerContract;

interface Question
{
    /**
     * The category in which this question is placed.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category(): BelongsTo;

    /**
     * Get all answers to this given question.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function answers(): HasMany;

    /**
     * Get the answer belonging to the current user.
     *
     * @return AnswerContract;
     */
    public function userAnswer(): AnswerContract;

    /**
     * Only return questions which does/doesn't have an answer from the current user.
     *
     * @param Builder $builder
     * @param bool $answered
     * @return Builder|static
     */
    public function scopeAnswered(Builder $builder, bool $answered): Builder;

    /**
     * Get if the current user has given an answer to this question after its last edit.
     *
     * @return bool
     */
    public function getAnsweredAttribute(): bool;

    /**
     * Get if the current question is required
     *
     * @return bool
     */
    public function getRequiredAttribute(): bool;

    /**
     * Get the possible values for this question.
     *
     * @return []
     */
    public function getValuesAttribute(): array;

    /**
     * Get the default value for this answer.
     *
     * @param string $old
     * @return string
     */
    public function default(string $old): string;

    /**
     * Get if the given answer was a default answer
     *
     * @param $value
     * @return bool
     */
    public function isDefault($value): bool;

}