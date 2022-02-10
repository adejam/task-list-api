<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'label',
        'sort_order',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'completed_at',
    ];

    /**
     * Set the user's first name.
     *
     * @param string $value // value of label coming from request
     *
     * @return void
     */
    public function setLabelAttribute(string $value): void
    {
        $this->attributes['label'] = strtolower($value);
    }
}
