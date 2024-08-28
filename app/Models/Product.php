<?php

namespace App\Models;

use App\Services\CurrencyService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
    ];

    public function getPriceEgpAttribute()
    {
        return (new CurrencyService)->convert('usd', 'egp', $this->price);
    }

    public function doublePrice(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->price * 2,
        );
    }
}
