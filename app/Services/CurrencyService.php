<?php

namespace App\Services;

class CurrencyService
{
    const RATES = [
        'usd' => [
            'egp' => 50
        ],
        'egp' => [
            'usd' => 0.02
        ]
    ];

    public function convert(string $from, string $to, float $amount): float
    {
        $rate = self::RATES[$from][$to] ?? 0;

        return $amount * $rate;
    }
}
