<?php

namespace MCesar\Survey\Contracts;

use Illuminate\Database\Eloquent\Relations\HasMany;

interface Category
{
    /**
     * Get all questions for this given category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function questions(): HasMany;

    /**
     * Get the percentage of completed questions in this category.
     *
     * @return float|int
     */
    public function getCompletionAttribute(): float;

    /**
     * Get if all questions have been answered in this category.
     *
     * @return bool
     */
    public function getCompletedAttribute(): bool;
}
