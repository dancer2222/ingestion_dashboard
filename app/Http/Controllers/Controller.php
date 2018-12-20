<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\Software;
use App\Models\Audiobook;
use App\Models\Book;
use App\Models\Movie;
use App\Models\Album;
use App\Models\Game;

/**
 * Class Controller
 * @package App\Http\Controllers
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    const CONTENT_MODELS_MAPPING = [
        'audiobooks' => Audiobook::class,
        'books' => Book::class,
        'movies' => Movie::class,
        'albums' => Album::class,
        'games' => Game::class,
        'software' => Software::class,
    ];
}
