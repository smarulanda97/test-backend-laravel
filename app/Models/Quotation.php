<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Quotation extends Model
{
    use HasFactory;

    protected $fillable = [
        'age',
        'start_date',
        'user_id',
        'end_date',
        'total',
        'currency_id'
    ];

    /**
     * Returns formatted number
     *
     * @return Attribute
     */
    public function total(): Attribute {
        return Attribute::make(
            get: fn($value) => number_format($value, 2)
        );
    }
}
