<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;


class Concept extends Model
{
    use HasFactory , softDeletes    ;
    protected $fillable = [
        'domain_id',
        'title',
        'description',
        'difficulty',
        'status',
    ];

    public function domain(): BelongsTo
    {
        return $this->belongsTo(Domain::class);
    }

    public function questions():HasMany
    {
        return $this->HasMany(question::class);
    }


}
