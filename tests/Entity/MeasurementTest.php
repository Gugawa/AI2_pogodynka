<?php

namespace App\Tests\Entity;

use App\Entity\Measurement;
use PHPUnit\Framework\TestCase;

class MeasurementTest extends TestCase
{
    public function dataGetFahrenheit(): array
    {
        return [
            ['100', 212],
            ['50', 122.00],
            ['24.17', 75.51],
            ['12', 53.60],
            ['2.22', 36],
            ['0', 32],
            ['-11.3', 11.66],
            ['-31.83', -25.29],
            ['-77.77', -107.99],
            ['-100', -148],
        ];
    }


    /**
     * @dataProvider dataGetFahrenheit
     */
    public function testGetFahrenheit($celsius, $expectedFahrenheit): void
    {
        $measurement = new Measurement();

        $measurement->setCelsius($celsius);
        $this->assertEquals($expectedFahrenheit, $measurement->getFahrehneit(), "Porządana wartość $expectedFahrenheit Fahrenheit dla $celsius stopni Celsiusza, otrzymano {$measurement->getFahrehneit()}");

//        $measurement->setCelsius('0');
//        $this->assertEquals(32, $measurement->getFahrehneit());
//        $measurement->setCelsius('-100');
//        $this->assertEquals(-148, $measurement->getFahrehneit());
//        $measurement->setCelsius('100');
//        $this->assertEquals(212, $measurement->getFahrehneit());
    }
}
