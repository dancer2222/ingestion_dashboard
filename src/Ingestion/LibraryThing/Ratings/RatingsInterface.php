<?php

namespace Ingestion\LibraryThing\Ratings;


interface RatingsInterface
{
    /**
     * Calculate average rating
     *
     * @return float
     */
    public function calculate(): float;

    /**
     * @param array $ratings Ratings example ['2.0' => 10]
     */
    public function setRatings(array $ratings): void;

    /**
     * @return array
     */
    public function getRatings(): array;
}