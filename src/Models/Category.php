<?php

namespace MCesar\Survey\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use MCesar\Survey\Contracts\Category as CategoryContract;

class Category extends Model implements CategoryContract
{
    use SoftDeletes;

    public $guarded = ['id'];

    protected $fillable = ['title'];

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

    public function questions(): HasMany
    {
        return $this->hasMany(config('survey.models.question'));
    }
}
