<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Professor extends Model
{
    protected $fillable = [
        'nom',
        'cognoms',
        'email',
        'foto',
    ];
    public function moduls(): HasMany
    {
        return $this->hasMany(Modul::class);
    }

    public function grup(): HasOne
    {
        return $this->hasOne(Grup::class);
    }
}