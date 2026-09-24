<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Borrowing extends Model
{
    use HasFactory;

    public const STATUS_PENDING = 'PENDING';

    public const STATUS_APPROVED = 'APPROVED';

    public const STATUS_REJECTED = 'REJECTED';

    public const STATUS_BORROWED = 'BORROWED';

    public const STATUS_PENDING_RETURN = 'PENDING_RETURN';

    public const STATUS_RETURNED = 'RETURNED';

    protected $fillable = [
        'user_id',
        'origin_building_id',
        'target_building_id',
        'asset_id',
        'item_type',
        'quantity',
        'notes',
        'borrow_date',
        'return_date',
        'status',
    ];

    protected function casts(): array
    {
        return ['borrow_date' => 'date', 'return_date' => 'date'];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function originBuilding(): BelongsTo
    {
        return $this->belongsTo(Building::class, 'origin_building_id');
    }

    public function targetBuilding(): BelongsTo
    {
        return $this->belongsTo(Building::class, 'target_building_id');
    }

    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class, 'asset_id');
    }

    public function assets(): BelongsToMany
    {
        return $this->belongsToMany(Asset::class, 'borrowing_asset');
    }
}
