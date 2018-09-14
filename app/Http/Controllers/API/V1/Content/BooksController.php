<?php

namespace App\Http\Controllers\API\V1\Content;

use App\Models\Book;
use App\Models\BookBlackList;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class BooksController
 * @package App\Http\Controllers\API\V1\Content
 */
class BooksController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function setStatus(Request $request)
    {
        $result = Book::where('id', $request->id)->update(['status' => $request->status]);

        return response()->json(['result' => $result], 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function blacklist(Request $request)
    {
        $result = false;
        $id = $request->get('id');
        $status = $request->get('status');

        if ($id && $status) {
            $result = BookBlackList::updateOrCreate(
                [
                    'book_id' => $id,
                ],
                [
                    'status' => $status,
                ]
            );

            if ($status === 'active' && $result) {
                Book::where('id', $id)->update(['status' => 'inactive']);
            }

        }

        return response()->json(['result' => $result], 200);
    }
}