<?php

namespace App\Http\Controllers\Librarything;

use App\Http\Controllers\Controller;
use App\Models\BookLibrarythingData;
use App\Models\ProductAudioBook;
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
     * Display the specified resource.
     *
     * @param  string  $isbn
     * @return \Illuminate\Http\Response
     */
    public function show($isbn = null)
    {
        try {
            if (!$isbn || $this->isbn->validation->isbn13($isbn)) {
                $isbn10 = $this->isbn->translate->to10($isbn);
                $productsAudiobooks = ProductAudioBook::where('isbn', $isbn)->with('audiobook')->get();
                $bookLibrarythingData = BookLibrarythingData::select('workcode')->whereIsbn_10($isbn10)->first();

                $this->viewData['products'] = $productsAudiobooks;
                $this->viewData['bookLibrarything'] = $bookLibrarythingData;

                if (!$bookLibrarythingData) {
                    throw new \Exception("We haven't yet received this isbn from Librarything - $isbn");
                }

                $ratings = $bookLibrarythingData->ratings()->select('rating', 'count')->get();

                if (!$ratings) {
                    throw new \Exception("We don't have ratings for this isbn: $isbn");
                }

                $this->ratingsCalculator->setRatings($ratings->pluck('count', 'rating')->toArray());
                $this->viewData['rating'] = $this->ratingsCalculator->calculate();
            } else {
                $this->viewErrors[] = "Invalid isbn: $isbn";
            }
        } catch (\Exception $e) {
            $this->viewErrors = $e->getMessage();
        }

        return view('template_v2.misc.library_thing.ratings', $this->viewData)->withErrors($this->viewErrors);
    }
}
