<?php

namespace App\Providers\Search;

use App\Models\Audiobook;
use App\Models\Book;
use Illuminate\Support\ServiceProvider;
use Ingestion\Search\Contracts\SearchableEntity;
use Ingestion\Search\Entity\EntityFactory;

class SearchEntityProvider extends ServiceProvider
{
    /**
     * @var bool
     */
    protected $defer = true;

    /**
     * @var array
     */
    private $modelsMapping = [
        'audiobooks' => Audiobook::class,
    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $self = $this;

        $this->app->singleton(SearchableEntity::class, function ($app) use ($self) {
            $mediaType = $app->request->mediaType;

            if (!isset($self->modelsMapping[$mediaType])) {
                throw new \Exception("Can't determine media type.");
            }

            $model = new $self->modelsMapping[$mediaType];

            return EntityFactory::make($mediaType, $model);
        });
    }

    /**
     * @return array
     */
    public function provides()
    {
        return [SearchableEntity::class];
    }
}
