<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'salesperson_id',
        'date',
        'type',
        'grandtotal'
    ];

    public function salesperson(): BelongsTo
    {
        return $this->belongsTo(Salesperson::class);
    }

    public function details(): HasMany
    {
        return $this->hasMany(TransactionDetail::class);
    }
}
