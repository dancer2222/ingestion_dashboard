<?php

namespace App\Providers\Search;

use App\Models\Audiobook;
use App\Models\Book;
use App\Models\Contracts\SearchableModel;
use App\Models\Movie;
use Illuminate\Support\ServiceProvider;

class SearchableModelProvider extends ServiceProvider
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
        'books'      => Book::class,
        'movies'     => Movie::class,
    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $self = $this;

        $this->app->singleton(SearchableModel::class, function ($app) use ($self) {
            $mediaType = $app->request->mediaType;

            if (!isset($self->modelsMapping[$mediaType])) {
                throw new \Exception("Can't determine media type.");
            }

            return new $self->modelsMapping[$mediaType];
        });
    }

    /**
     * @return array
     */
    public function provides()
    {
        return [SearchableModel::class];
    }
}
