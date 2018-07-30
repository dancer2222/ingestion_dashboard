<?php

namespace App\Http\Controllers\Librarything;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BookLibrarythingData;
use Ingestion\LibraryThing\Ratings\Rating;
use Isbn\Isbn;

class RatingsController extends Controller
{
    /**
     * @var Isbn
     */
    private $isbn;

    /**
     * @var Rating
     */
    private $ratingsCalculator;

    /**
     * @var array
     */
    private $viewData = [];

    /**
     * @var
     */
    private $viewErrors;

    public function __construct(Isbn $isbn, Rating $ratingsCalculator)
    {
        $this->isbn = $isbn;
        $this->ratingsCalculator = $ratingsCalculator;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('template_v2.misc.library_thing.ratings');
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
     * @param  string  $isbn
     * @return \Illuminate\Http\Response
     */
    public function show(string $isbn)
    {
        try {
            if ($isbn && $this->isbn->validation->isbn13($isbn)) {
//                $audiobook = ProductAudioBook::where('isbn', $isbn)->audiobook();
                $audiobook = 1;
//9780329050436
                $isbn10 = $this->isbn->translate->to10($isbn);
                $bookLibrarythingData = BookLibrarythingData::select('workcode')->whereIsbn_10($isbn10)->first();

                if (!$audiobook || !$bookLibrarythingData) {
                    throw new \Exception("Can't find audiobook with isbn: $isbn");
                }

                $ratings = $bookLibrarythingData->ratings()->select('rating', 'count')->get();

                if (!$ratings) {
                    throw new \Exception("We don't have ratings for this isbn: $isbn");
                }

                $this->ratingsCalculator->setRatings($ratings->pluck('count', 'rating')->toArray());
                $this->viewData['rating'] = $this->ratingsCalculator->calculate();
            }
        } catch (\Exception $e) {
            $this->viewErrors = $e->getMessage();
        }

        return view('template_v2.misc.library_thing.ratings', $this->viewData)->withErrors($this->viewErrors);
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
