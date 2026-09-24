<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Asset extends Model
{
    use HasFactory;

    public const STATUS_AVAILABLE = 'AVAILABLE';

    public const STATUS_BORROWED = 'BORROWED';

    protected $fillable = ['asset_code', 'name', 'serial_number', 'building_id', 'status'];

    public function building(): BelongsTo
    {
        return $this->belongsTo(Building::class);
    }

    public function borrowings(): BelongsToMany
    {
        return $this->belongsToMany(Borrowing::class, 'borrowing_asset');
    }
}
