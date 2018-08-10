<?php

namespace Ingestion\LibraryThing\Ratings;


class Rating implements RatingsInterface
{
    private $ratings;

    /**
     * Calculate average rating
     *
     * @return float
     */
    public function calculate(): float
    {
        $countRatings = 0;
        $countsSum = $this->getTotalVotes();

        if (!$countsSum) {
            return 0.0;
        }

        foreach ($this->getRatings() as $rating => $count) {
            $countRatings += $rating * $count;
        }

        return round($countRatings / $countsSum, 1);
    }

    /**
     * @inheritdoc
     */
    public function setRatings(array $ratings): void
    {
        $this->ratings = $ratings;
    }

    /**
     * @inheritdoc
     */
    public function getRatings(): array
    {
        return $this->ratings;
    }

    /**
     * @inheritdoc
     */
    public function getTotalVotes(): int
    {
        return array_sum($this->getRatings());
    }
}
