<?php

namespace App\Http\Controllers\BlackList;

use App\Models\Audiobook;
use App\Models\AudioBookBlackList;
use App\Models\Book;
use App\Models\BookBlackList;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

/**
 * Class BlackListController
 * @package App\Http\Controllers\BlackList
 */
class BlackListController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function indexAdd()
    {
        return view('blackList.addBlackList');
    }

    public function indexRemove()
    {
        return view('blackList.removeBlackList');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'id'        => 'required|min:5|string',
            'mediaType' => 'required|string'
        ]);

        $book = new Book();
        $audiobook = new Audiobook();
        $unHandleIds = '';
        $handleIds = '';
        $ids = explode(',', str_replace(' ', '', $request->id));

        foreach ($ids as $id) {
            if ('book' == $request->mediaType) {
                if ($book->getInfoById($id)->isEmpty()) {
                    $unHandleIds .= $id . '|';

                    continue;
                }

                try {
                    BookBlackList::create([
                        'book_id' => (int)$id,
                        'status'  => 'active'
                    ]);

                    $book->setStatus($id, 'inactive');
                    $handleIds .= $id;
                } catch (Exception $e) {
                    $message = 'An error occurred while storing this id ' . $id . $e->getMessage();
                    logger()->critical($message);
                    return back()->with('message', $message);
                }

                continue;
            }

            if ($audiobook->getInfoById($id)->isEmpty()) {
                $unHandleIds .= $id . '|';

                continue;
            }

            try {
                AudioBookBlackList::create([
                    'audio_book_id' => (int)$id,
                    'status'        => 'active'
                ]);

                $audiobook->setStatus($id, 'inactive');
                $handleIds .= $id;
            } catch (Exception $e) {
                $message = 'An error occurred while storing this id ' . $id . $e->getMessage();
                logger()->critical($message);
                return back()->with('message', $message);
            }

            continue;
        }

        logger()->info('User - ' .
            Auth::user()->name .
            ' ' .
            Auth::user()->email .
            ' Blacklist added id(s): ' .
            $handleIds);

        if ('' !== $unHandleIds) {
            return back()->with('message',
                'This id(s) - ' . $handleIds . ' added to BlackList, not found this id(s) - ' . $unHandleIds);
        }

        return back()->with('message', 'This id(s) - ' . $handleIds . ' added to BlackList');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'id'        => 'required|min:5|string',
            'mediaType' => 'required|string'
        ]);

        $book = new Book();
        $audiobook = new Audiobook();
        $unHandleIds = '';
        $handleIds = '';
        $ids = explode(',', str_replace(' ', '', $request->id));

        foreach ($ids as $id) {
            if ('book' == $request->mediaType) {
                if ($book->getInfoById($id)->isEmpty()) {
                    $unHandleIds .= $id . '|';

                    continue;
                }

                try {
                    BookBlackList::select('audio_book_id', $id)->update(['status' => 'inactive']);
                    $book->setStatus($id, 'active');
                    $handleIds .= $id;
                } catch (Exception $e) {
                    $message = 'An error occurred while updating this id ' . $id . $e->getMessage();
                    logger()->critical($message);
                    return back()->with('message', $message);
                }

                continue;
            }

            if ($audiobook->getInfoById($id)->isEmpty()) {
                $unHandleIds .= $id . '|';

                continue;
            }

            try {
                AudioBookBlackList::select('audio_book_id', $id)->update(['status' => 'inactive']);
                $audiobook->setStatus($id, 'active');
                $handleIds .= $id;
            } catch (Exception $e) {
                $message = 'An error occurred while updating this id ' . $id . $e->getMessage();
                logger()->critical($message);
                return back()->with('message', $message);
            }

            continue;
        }

        logger()->info('User - ' .
            Auth::user()->name .
            ' ' .
            Auth::user()->email .
            ' removed from Blacklist id(s): ' .
            $handleIds);

        if ('' !== $unHandleIds) {
            return back()->with('message',
                'This id(s) - ' . $handleIds . ' removed from BlackList, not found this id(s) - ' . $unHandleIds);
        }

        return back()->with('message', 'This id(s) - ' . $handleIds . ' remove from BlackList');
    }
}
