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

    /**
     * @param string $id
     * @param array $scopes
     * @return Model
     */
    public function findById(string $id, array $scopes = []): Model
    {
        $query = $this->model->newQuery();
        $this->scopes = array_merge($this->scopes, $scopes);

        if ($this->scopes) {
            $query->with($this->scopes);
        }

        return $query->find($id);
    }

    /**
     * @param array|string $scopes
     */
    protected function setScopes($scopes): void
    {
        if (!\is_array($scopes)) {
            $scopes = [$scopes];
        }

        $this->scopes = array_merge($this->scopes, $scopes);
    }
}
