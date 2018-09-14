<?php

namespace Ingestion\Search\Entity;

use Illuminate\Database\Eloquent\Model;
use Ingestion\Search\Contracts\SearchableEntity;

class EntityFactory
{
    /**
     * @var array
     */
    private static $entitiesMapping = [
        'audiobooks' => AudiobookEntity::class,
    ];

    /**
     * @param string $mediaType
     * @param Model $model
     * @return SearchableEntity
     * @throws \Exception
     */
    public static function make(string $mediaType, Model $model): SearchableEntity
    {
        if (!isset(self::$entitiesMapping[$mediaType])) {
            throw new \Exception("Can't determine media type.");
        }

        return new self::$entitiesMapping[$mediaType]($model);
    }
}
