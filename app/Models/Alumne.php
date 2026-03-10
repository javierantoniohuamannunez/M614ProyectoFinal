<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Alumne extends Model{
    protected $fillable = [
        'nom',
        'cognoms',
        'dni',
        'email',
        'data_naixament',
        'telefon',
        'grup_id',
    ];
    public function grup(): BelongsTo
    {
        return $this->belongsTo(Grup::class);
    }

    public function moduls(): BelongsToMany
    {
        return $this->belongsToMany(Modul::class, 'alumne_modul')
                    ->withPivot('nota')
                    ->withTimestamps();
    }
}