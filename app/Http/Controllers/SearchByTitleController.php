<?php

namespace App\Http\Controllers;

use App\Models\AudioBook;
use App\Models\Book;
use App\Models\Movie;
use Illuminate\Http\Request;

class SearchByTitleController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $title = $request->title;
        $type = $request->type;
        $info = $this->switchType($type, $title);
        $result = count($info);

        if ($result == 0) {
            $message = 'Not found media witch this title - ' . $title;
            return back()->with('message', $message);
        } elseif ($result == 1) {
            return redirect()->route('search', ['id' => $info[0]->id]);
        } else {

            return view('search.title', ['info' => $info]);
        }
    }

    /**
     * @param $type
     * @param $title
     * @return AudioBook|Book|Movie|\Illuminate\Http\RedirectResponse
     */
    public function switchType($type, $title)
    {
        switch ($type) {
            case 'movies':
                $info = new Movie();
                $info = $info->getInfoByTitle($title);
                break;
            case 'books':
                $info = new Book();
                $info = $info->getInfoByTitle($title);
                break;
            case 'audiobooks':
                $info = new AudioBook();
                $info = $info->getInfoByTitle($title);
                break;
            default:
                $message = 'Select a media type';
                return back()->with('message', $message);
        }

        return $info;
    }
}
