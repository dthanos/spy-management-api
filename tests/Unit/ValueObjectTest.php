<?php

namespace Tests\Unit;

use App\Domain\ValueObjects\Date;
use Tests\TestCase;

class ValueObjectTest extends TestCase
{
    public function test_date()
    {
        $dateString = '2024-01-01';
        $date = new Date($dateString);

        $this->assertEquals($date->toString(), $dateString);
    }

    public function test_invalid_date_throws_exception()
    {
        $this->expectException(\InvalidArgumentException::class);

        new Date('01/01/2024');
    }
}
