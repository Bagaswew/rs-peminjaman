<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Building extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'name'];

    public function assets(): HasMany
    {
        return $this->hasMany(Asset::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function originBorrowings(): HasMany
    {
        return $this->hasMany(Borrowing::class, 'origin_building_id');
    }

    public function targetBorrowings(): HasMany
    {
        return $this->hasMany(Borrowing::class, 'target_building_id');
    }
}
