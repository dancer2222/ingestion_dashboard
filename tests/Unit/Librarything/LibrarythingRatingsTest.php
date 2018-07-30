<?php

namespace Tests\Unit\Librarything;

use Ingestion\LibraryThing\Ratings\Rating;
use Tests\TestCase;

class LibrarythingRatingsTest extends TestCase
{
    /**
     * @param array $ratings
     * @param float $result
     * @dataProvider dataRatingsProvider
     */
    public function testRatingsCalculate(array $ratings, float $result)
    {
        $ratingsCalculator = new Rating();
        $ratingsCalculator->setRatings($ratings);

        $this->assertEquals($ratings, $ratingsCalculator->getRatings());
        $this->assertEquals($result, $ratingsCalculator->calculate());
    }

    /**
     * Data provider
     * @return array
     */
    public function dataRatingsProvider(): array
    {
        return [
            'First' => [
                [
                    '1.0' => 10,
                    '2.0' => 4,
                    '3.5' => 3,
                ],
                1.7,
            ],
            'Second' => [
                [
                    '0.5' => 1,
                    '1.0' => 5,
                    '1.5' => 5,
                    '2.0' => 29,
                    '2.5' => 3,
                    '3.0' => 138,
                    '3.5' => 15,
                    '4.0' => 137,
                    '4.5' => 4,
                    '5.0' => 68,
                ],
                3.6
            ],
            'Third' => [
                [
                    '3.0' => 1,
                    '4.0' => 1,
                ],
                3.5
            ],
        ];
    }
}
