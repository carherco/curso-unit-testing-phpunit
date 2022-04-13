<?php

namespace misc;

use App\misc\TimeUtils;
use DateTime;
use PHPUnit\Framework\TestCase;

class TimeUtilsTest extends TestCase
{
    /**
     * @test
     * @dataProvider getTimeOfDayResult
     */
    public function testTimeOfTheDayResult(string $expected, DateTime $time): void
    {
        $myClass = new TimeUtils();
        $result = $myClass->getTimeOfDay($time);

        $this->assertSame($expected, $result);
    }

    public function getTimeOfDayResult(): array
    {
        return [
            'Caso Night' => ['Night', new DateTime('2022-03-07 00:05:18')],
            'Caso Morning' => ['Morning', new DateTime('2022-03-07 10:10:18')],
            'Caso Afternoon' => ['Afternoon', new DateTime('2022-03-07 17:05:18')],
            'Caso Evening' => ['Evening', new DateTime('2022-03-07 21:05:18')],
        ];
    }
}

