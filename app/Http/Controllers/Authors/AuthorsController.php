<?php

namespace App\Http\Controllers\Authors;

use App\Models\Author;
use App\Models\Authoraudiobook;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthorsController extends Controller
{
    const AUTHOR_MODEL_MAPPING = [
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
        $type = request()->get('author_type') ?? request('author_type');

        if (isset(self::AUTHOR_MODEL_MAPPING[$type])) {
            $authorModelClass = self::AUTHOR_MODEL_MAPPING[$type];
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
                $authors = $this->authorModel->where('id', $needle);
            } else {
                $authors = $this->authorModel->where('name', 'LIKE', "%$needle%");
            }

            $authors = $authors->has('books')->paginate(10);

            return view('template_v2.misc.authors.index', ['authors' => $authors]);
        }

        return view('template_v2.misc.authors.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param string $id
     * @return \Illuminate\Http\Response
     */
    public function show(string $id, string $authorType)
    {
        if (!$this->authorModel) {
            return view('template_v2.misc.authors.index')->withErrors(["Can't determine the author type."]);
        }

        $author = $this->authorModel->where('id', $id);

        $author = $author->first();
        $books = $author->books;

        return view('template_v2.misc.authors.index', ['author' => $author, 'books' => $books]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
