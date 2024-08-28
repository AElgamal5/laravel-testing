<?php

namespace Tests\Unit;

use App\Services\CurrencyService;
use PHPUnit\Framework\TestCase;

class CurrencyTest extends TestCase
{

    public function test_currency_converter_from_usd_to_egp(): void
    {
        $egp = (new CurrencyService)->convert('usd', 'egp', 100);
        $this->assertEquals(5000, $egp);
    }

    public function test_currency_converter_from_egp_to_usd(): void
    {
        $usd = (new CurrencyService)->convert('egp', 'usd', 150);

        $this->assertEquals(3, $usd);
    }
}
