<?php

namespace App\Http\Controllers\Authors;

use App\Models\Author;
use App\Models\Authoraudiobook;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthorsController extends Controller
{
    const AUTHOR_MODELS_MAPPING = [
        'audio_book' => Authoraudiobook::class,
        'book' => Author::class,
    ];

    /**
     * @var Model $authorModel
     */
    private $authorModel;

    /**
     * AuthorsController constructor.
     */
    public function __construct()
    {
        $type = request()->get('author_type');

        if (isset(self::AUTHOR_MODELS_MAPPING[$type])) {
            $authorModelClass = self::AUTHOR_MODELS_MAPPING[$type];
            $this->authorModel = new $authorModelClass;
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $needle = request()->get('needle');

        if ($needle && $this->authorModel) {
            if (is_numeric($needle) && ctype_digit($needle)) {
                $authorsQuery = $this->authorModel->where('id', $needle);
            } else {
                $authorsQuery = $this->authorModel->where('name', 'LIKE', "%$needle%");
            }

            $authors = $authorsQuery->with('books')->paginate(10);

            return view('template_v2.misc.authors.index', ['authors' => $authors]);
        }

        return view('template_v2.misc.authors.index');
    }

    /**
     * Display the specified resource.
     *
     * @param string $id
     * @return \Illuminate\Http\Response
     */
    public function show(string $id)
    {
        if (!$this->authorModel) {
            return view('template_v2.misc.authors.index')->withErrors(["Can't determine the author type."]);
        }

        $author = $this->authorModel->where('id', $id)->first();

        $booksQuery = $author->books();

        $status = request()->get('status');

        if ($status) {
            $booksQuery = $booksQuery->where('status', $status);
        }

        $books = $booksQuery->get();

        return view('template_v2.misc.authors.index', ['author' => $author, 'books' => $books]);
    }
}
