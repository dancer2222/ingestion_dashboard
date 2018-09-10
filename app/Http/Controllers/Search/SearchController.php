<?php

namespace App\Http\Controllers\Search;

use App\Models\Album;
use App\Models\Audiobook;
use App\Models\Book;
use App\Models\Contracts\ContentSmartSearchContract;
use App\Models\Game;
use App\Models\Movie;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{
    /**
     * @var array
     */
    private $modelsMapping = [
        'movies' => Movie::class,
        'audiobooks' => Audiobook::class,
        'books' => Book::class,
        'albums' => Album::class,
        'games' => Game::class,
    ];

    /**
     * @var ContentSmartSearchContract
     */
    private $mediaModel;

    /**
     * @var array
     */
    private $viewData = [];

    /**
     * SearchController constructor.
     * @param Request $request
     * @throws \Exception
     */
    public function __construct(Request $request)
    {
        if (!isset($this->modelsMapping[$request->mediaType])) {
            throw new \Exception("Can't determine media type.");
        }

        $this->mediaModel = new $this->modelsMapping[$request->mediaType];

        if (!$this->mediaModel instanceof ContentSmartSearchContract) {
            throw new \Exception("This media type isn't suitable for this type of search.");
        }

        $this->viewData['mediaType'] = $request->mediaType;
    }

    /**
     * @param string $mediaType
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(string $mediaType, Request $request)
    {
        if ($request->get('needle')) {
            $this->viewData['list'] = $this->mediaModel->smartSearch($request->get('needle'))->paginate(15);
        }

        return view('template_v2.search.index', $this->viewData);
    }

    /**
     * @param string $mediaType
     * @param string $id
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(string $mediaType, string $id, Request $request)
    {
        $viewName = "template_v2.search.{$mediaType}_item";
        $this->viewData['item'] = $this->mediaModel->find($id);

        if (!view()->exists($viewName)) {
            return view('template_v2.search.index', $this->viewData);
        }
//        dd($this->viewData);
        return view($viewName, $this->viewData);
    }
}
