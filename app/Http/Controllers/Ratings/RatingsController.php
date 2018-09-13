<?php

namespace App\Http\Controllers\Ratings;

use App\Models\Audiobook;
use App\Models\Book;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Controller;

class RatingsController extends Controller
{
    const MODELS_MAPPING = [
        'audiobooks' => Audiobook::class,
        'books' => Book::class,
    ];

    /**
     * @var Model
     */
    private $model;
    private $contenType;

    /**
     * RatingsController constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $contentType = $this->contenType = request()->content_type;

        if (isset(self::MODELS_MAPPING[$contentType])) {
            $modelName = self::MODELS_MAPPING[$contentType];
            $this->model = new $modelName;
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [];
        $needle = request()->input('needle');

        try {
            if (!$this->model) {
                throw new \Exception("Can't determine the media type.");
            }

            if ($needle) {
                $this->model = $this->model->seek($needle, ['rating'], ['rating']);
                $data['list'] = $this->model->paginate(10);
            }

            return view('template_v2.misc.ratings.ratings', $data);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return view('template_v2.misc.ratings.ratings')->withErrors('An error happened. See logs for more info.');
        }
    }
}
