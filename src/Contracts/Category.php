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
}
