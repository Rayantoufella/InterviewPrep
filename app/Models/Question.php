<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Question extends Model
{
    protected $fillable = [
        'concept_id' ,
        'question' ,
    ];

    protected $casts = [
        'question' => 'array'
    ];

    public function concept(): BelongsTo
    {
        return $this->belongsTo(Concept::class);
    }
}
