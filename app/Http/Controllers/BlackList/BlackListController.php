<?php

namespace App\Http\Controllers\BlackList;

use App\Models\AudiobookBlackList;
use App\Models\BookBlackList;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Ingestion\BlackList\RequestMedia;
use Ingestion\Rabbitmq\Indexation;

/**
 * Class BlackListController
 * @package App\Http\Controllers\BlackList
 */
class BlackListController extends Controller {
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function indexAdd() {
        return view('blackList.addBlackList');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function indexRemove() {
        return view('blackList.removeBlackList');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function indexAddByAuthor() {
        return view('blackList.addBlackListByAuthor');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function indexAddRemoveByAuthor() {
        return view('blackList.removeBlackListByAuthor');
    }

    /**
     * @param Request $request
     * @param Indexation $indexation
     * @return \Illuminate\Http\RedirectResponse
     */
    public function blackList(Request $request, Indexation $indexation) {
        $command = $request->command;
        $oppositeCommand = 'active';
        $authorId = $request->authorId;

        if ('active' === $command) {
            $oppositeCommand = 'inactive';
        }

        $mediaTypeByIndexation = str_replace('_', '', $request->mediaType);
        $mediaTypeTitleOne = substr($request->mediaType, 0, -1);
        $mediaType = str_replace('_', '', $mediaTypeTitleOne);
        $mediaTypeTitle = ucfirst($mediaType);

        if (isset($request->media)) {
            try {
                $requestMedia = new RequestMedia();
                $ids = $requestMedia->getIdsByAuthor(
                        $request->media,
                        $mediaType,
                        $request->action,
                        $authorId,
                        $command,
                        $oppositeCommand
                );
            } catch (Exception $e) {
                $message = 'We have a problem with this author_id ' . $authorId . $e->getMessage();
                logger()->critical($message);

                return back()->with('message', $message);
            }
        } else {
            $ids = explode(',', str_replace(' ', '', $request->id));
        }

        $unHandledIds = [];
        $handledIds = [];

        try {
            foreach ($ids as $id) {
                $className = "App\Models\\" . $mediaTypeTitle;
                $reflectionMethod = new \ReflectionMethod($className, 'getInfoById');

                if ($reflectionMethod->invoke(new $className(), $id, $command)->isEmpty()) {
                    $unHandledIds[] = $id;

                    continue;
                };

                $classNameBlack = "App\Models\\" . $mediaTypeTitle . "BlackList";

                $classNameBlack::updateOrCreate([
                        $mediaTypeTitleOne . '_id' => (int) $id
                ], [
                        'status' => $command
                ]);

                $reflectionMethodSet = new \ReflectionMethod($className, 'setStatus');
                $reflectionMethodSet->invoke(new $className(), $id, $oppositeCommand);

                $indexation->push('updateSingle', $mediaTypeByIndexation, $id);
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
                ' Blacklist updated id(s): ' .
                implode(', ', $handledIds));

        $msg = 'This id(s) - ' . implode(', ', $handledIds) . ' updated in BlackList';

        if (!empty($unHandledIds)) {
            $msg = $msg . ', not found this id(s) - ' . implode(', ', $unHandledIds);
        }

        if (isset($request->media) && $command === 'active') {

            return redirect(route('blackList.indexAddByAuthor'))->with('message', $msg);
        } elseif (isset($request->media) && $command === 'inactive') {

            return redirect(route('blackList.indexRemoveByAuthor'))->with('message', $msg);
        }

        return back()->with('message', $msg);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function blackListByAuthor(Request $request) {
        $id = $request->author_id;
        $command = $request->command;
        $model = $request->model;

        try {
            $requestMedia = new RequestMedia();
            $info = $requestMedia->useBlackListByAuthor($model, $id);
            $authorName = RequestMedia::getAuthorName($model, $id);
        } catch (Exception $exception) {
            $message = 'We have a problem with this author_id ' . $id . $exception->getMessage();
            logger()->critical($message);

            return back()->with('message', $message);
        }


        if ('active' === $command) {

            return view('blackList.addBlackListByAuthorSelect',
                    [
                            'info'       => $info,
                            'mediaType'  => $model . 's',
                            'authorName' => $authorName,
                            'authorId'   => $id
                    ]);
        }

        return view('blackList.removeBlackListByAuthorSelect',
                ['info' => $info, 'mediaType' => $model . 's', 'authorName' => $authorName, 'authorId' => $id]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        return view('blackList.showBlackListInfo');
    }

    /**
     * @param $mediaType
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getInfoFromBlackList($mediaType, Request $request) {
        $bookBlackList = new BookBlackList();
        $audiobookBlackList = new AudiobookBlackList();

        if (!is_null($request->id)) {

            if ('books' === $mediaType) {
                $info = $bookBlackList->getInfoById($request->id);
            } else {
                $info = $audiobookBlackList->getInfoById($request->id);
            }
        } else {

            if ('books' === $mediaType) {
                $info = $bookBlackList->getInfo();
            } else {
                $info = $audiobookBlackList->getInfo();
            }
        }

        if ($info->isEmpty()) {

            return back()->with('message', 'Not found ' . $mediaType . ' in BlackList');
        }

        return view('blackList.showBlackListInfo', ['info' => $info]);
    }
}
