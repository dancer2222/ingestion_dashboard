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
use Ingestion\Rabbitmq\Indexation;
use Ingestion\Rabbitmq\Manager;

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
     * @param Indexation $indexation
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Indexation $indexation)
    {
        $this->validate($request, [
            'id'        => 'required|min:5|string',
            'mediaType' => 'required|string'
        ]);

        $book = new Book();
        $audiobook = new Audiobook();
        $unHandledIds = [];
        $handledIds = [];
        $ids = explode(',', str_replace(' ', '', $request->id));

        try {
            foreach ($ids as $id) {
                if ('books' == $request->mediaType) {
                    if ($book->getInfoById($id)->isEmpty()) {
                        $unHandledIds[] = $id;

                        continue;
                    }

                    BookBlackList::updateOrCreate([
                        'book_id' => (int)$id
                    ], [
                        'status' => 'active'
                    ]);

                    $book->setStatus($id, 'inactive');
                    $indexation->push('updateSingle', 'books',$id);
                    $handledIds[] = $id;

                    continue;
                }

                if ($audiobook->getInfoById($id)->isEmpty()) {
                    $unHandledIds[] = $id;

                    continue;
                }

                AudioBookBlackList::updateOrCreate([
                    'audio_book_id'=> (int)$id,
                ], [
                    'status' => 'active'
                ]);

                $audiobook->setStatus($id, 'inactive');
                $indexation->push('updateSingle', 'audiobooks',$id);
                $handledIds[] = $id;

                continue;
            }
        } catch (Exception $e) {
            $message = 'An error occurred while storing this id ' . $id . $e->getMessage();
            logger()->critical($message);

            return back()->with('message', $message);
        }

        logger()->info('User - ' .
            Auth::user()->name .
            ' ' .
            Auth::user()->email .
            ' Blacklist added id(s): ' .
            implode(', ', $handledIds));

        $msg = 'This id(s) - ' . implode(', ', $handledIds) . ' added to BlackList';

        if (!empty($unHandledIds)) {
                $msg = $msg . ', not found this id(s) - ' . implode(', ', $unHandledIds);
        }

        return back()->with('message', $msg);
    }

    /**
     * @param Request $request
     * @param Indexation $indexation
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Indexation $indexation)
    {
        $this->validate($request, [
            'id'        => 'required|min:5|string',
            'mediaType' => 'required|string'
        ]);

        $book = new Book();
        $audiobook = new Audiobook();
        $unHandledIds = [];
        $handledIds = [];
        $ids = explode(',', str_replace(' ', '', $request->id));

        try {
            foreach ($ids as $id) {
                if ('books' == $request->mediaType) {
                    if ($book->getInfoById($id)->isEmpty()) {
                        $unHandledIds[] = $id;

                        continue;
                    }

                    BookBlackList::select('audio_book_id', $id)->update(['status' => 'inactive']);
                    $book->setStatus($id, 'active');
                    $indexation->push('updateSingle', 'books',$id);
                    $handledIds[] = $id;

                    continue;
                }

                if ($audiobook->getInfoById($id)->isEmpty()) {
                    $unHandledIds[] = $id;

                    continue;
                }

                AudioBookBlackList::select('audio_book_id', $id)->update(['status' => 'inactive']);
                $audiobook->setStatus($id, 'active');
                $indexation->push('updateSingle', 'audiobooks',$id);
                $handledIds[] = $id;

                continue;
            }
        } catch (Exception $e) {
            $message = 'An error occurred while updating this id ' . $id . $e->getMessage();
            logger()->critical($message);

            return back()->with('message', $message);
        }

        logger()->info('User - ' .
            Auth::user()->name .
            ' ' .
            Auth::user()->email .
            ' removed from Blacklist id(s): ' .
            implode(', ', $handledIds));

        $msg = 'This id(s) - ' . implode(', ', $handledIds) . ' removed from BlackList';

        if (!empty($unHandledIds)) {
            $msg = $msg . ', not found this id(s) - ' . implode(', ', $unHandledIds);
        }

        return back()->with('message', $msg);
    }
}
