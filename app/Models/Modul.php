<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Modul extends Model
{
    protected $fillable = [
        'nom',
        'hores',
        'professor_id',
    ];
    public function professor(): BelongsTo
    {
        return $this->belongsTo(Professor::class);
    }

    public function alumnes(): BelongsToMany
    {
        return $this->belongsToMany(Alumne::class, 'alumne_modul')
                    ->withPivot('nota')
                    ->withTimestamps();
    }
    public function getHoresFormatejadesAttribute()
    {
        return $this->hores . ' h';
    }
}