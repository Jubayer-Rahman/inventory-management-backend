<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VariationOption extends Model
{
    use HasFactory;

    protected $fillable = [
        'variation_id',
        'option',
    ];

    protected function option(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => ucwords($value),
        );
    }

    public function variation()
    {
        return $this->belongsTo(Variation::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_variation_option');
    }
}
