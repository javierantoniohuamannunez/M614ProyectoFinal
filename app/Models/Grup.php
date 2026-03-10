<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Grup extends Model
{
    protected $fillable = [
        'nom',
        'aula',
        'professor_id',
    ];
    public function professor(): BelongsTo
    {
        return $this->belongsTo(Professor::class);
    }
    public function alumnes()
    {
        return $this->hasMany(Alumne::class);
    }
}