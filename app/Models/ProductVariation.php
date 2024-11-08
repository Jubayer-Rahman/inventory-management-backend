<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariation extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'slug',
        'quantity',
        'price',
        'is_active'
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean'
        ];
    }

    protected function price(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => round($value, 2),
        );
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
