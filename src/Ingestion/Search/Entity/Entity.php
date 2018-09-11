<?php

namespace Ingestion\Search\Entity;

use Illuminate\Database\Eloquent\Model;
use Ingestion\Search\Contracts\SearchableEntity;

abstract class Entity implements SearchableEntity
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * @var array
     */
    protected $scopes = [];

    /**
     * AbstractEntity constructor.
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @return Model
     */
    public function getModel(): Model
    {
        return $this->model;
    }
}
