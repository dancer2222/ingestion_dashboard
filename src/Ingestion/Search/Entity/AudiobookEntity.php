<?php

namespace Ingestion\Search\Entity;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Isbn\Isbn;

class AudiobookEntity extends Entity
{
    public function __construct(Model $model)
    {
        parent::__construct($model);

        $this->setScopes(['products']);
    }

    /**
     * @param string $needle
     * @param array $scopes
     * @return Builder
     * @throws \Isbn\Exception
     */
    public function search(string $needle, array $scopes = []): Builder
    {
        $isFound = false;
        $isbnHandler = new Isbn();
        $query = $this->model->newQuery();

        if ($scopes) {
            $query->with($scopes);
        }

        if ($isbnHandler->validation->isbn($needle)) {
            $isbn = $isbnHandler->hyphens->removeHyphens($needle);
            $query->whereHas('products', function ($query) use ($isbn) {
                $query->where('isbn', $isbn);
            });

            $isFound = true;
        }

        if (!$isFound && is_numeric($needle) && ctype_digit($needle)) {
            $query = $query->where('id', $needle)
                ->orWhere('data_origin_id', $needle);

            $isFound = true;
        }

        if (!$isFound) {
            $query->where('title', 'like', "%$needle%");
        }

        $query->select('id', 'title');

        return $query;
    }
}
