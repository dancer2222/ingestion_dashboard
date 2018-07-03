<?php

namespace App\Http\Controllers\BlackList;

use App\Models\AudiobookBlackList;
use App\Models\BookBlackList;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Ingestion\Rabbitmq\Indexation;

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

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function indexRemove()
    {
        return view('blackList.removeBlackList');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function indexAddByAuthor()
    {
        return view('blackList.addBlackListByAuthor');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function indexAddRemoveByAuthor()
    {
        return view('blackList.removeBlackListByAuthor');
    }

    /**
     * @param Request $request
     * @param Indexation $indexation
     * @return \Illuminate\Http\RedirectResponse
     * @throws \ReflectionException
     */
    public function blackList(Request $request, Indexation $indexation)
    {
        $command = $request->command;
        $oppositeCommand = 'active';

        if ('active' === $command) {
            $oppositeCommand = 'inactive';
        }

        $sts = $oppositeCommand;
        $mediaTypeByIndexation = str_replace('_', '', $request->mediaType);
        $mediaTypeTitleOne = substr($request->mediaType, 0, -1);
        $mediaType = str_replace('_', '', $mediaTypeTitleOne);
        $mediaTypeTitle = ucfirst($mediaType);

        if (isset($request->media)) {
            $medias = $request->media;
            $ids = [];

            foreach ($medias as $media => &$item) {
                if (isset($item['checked'])) {
                    $ids[] = $item['id'];
                } elseif (!isset($item['checked']) && $request->action === 'add') {
                    $sts = $command;
                } else {
                    $sts = $oppositeCommand;
                }
            }

            if ($mediaType == 'book') {
                $classNameByAuthorName = "App\Models\Author";
            } else {
                $classNameByAuthorName = "App\Models\Author{$mediaType}";
            }

            $reflectionMethodSet = new \ReflectionMethod($classNameByAuthorName, 'setStatus');
            $reflectionMethodSet->invoke(new $classNameByAuthorName(), $request->authorId, $sts);
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
                    $mediaTypeTitleOne . '_id' => (int)$id
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
     * @throws \ReflectionException
     */
    public function blackListByAuthor(Request $request)
    {
        $id = $request->author_id;
        $command = $request->command;

        $modelName = ucfirst(str_replace('_', '', $request->model));
        $className = "App\Models\\" . $modelName . 'author';

        $reflectionMethod = new \ReflectionMethod($className, 'getIdByAuthorId');
        $idAuthor = $reflectionMethod->invoke(new $className(), $id);

        if ($idAuthor->isEmpty()) {
            return back()->with('message', 'This author id: ' . $id . ' not found in database');
        }

        $idAuthor = $idAuthor->toArray();

        if ($request->model == 'book') {
            $classNameByAuthorName = "App\Models\Author";
        } else {
            $classNameByAuthorName = "App\Models\\" . 'Author' . str_replace('_', '', $request->model);
        }

        $authorName = $classNameByAuthorName::find($id)->name;

        $info = [];

        $classNameSecond = "App\Models\\" . $modelName;

        foreach ($idAuthor as $itemInfo) {
            foreach ($itemInfo as $value) {
                if (!$mediaCollection = $classNameSecond::find($value)) {
                    continue;
                }

                $info[] = [
                    'id'    => $mediaCollection->id,
                    'title' => $mediaCollection->title
                ];
            }
        }

        if ('active' === $command) {

            return view('blackList.addBlackListByAuthorSelect',
                [
                    'info'       => $info,
                    'mediaType'  => $request->model . 's',
                    'authorName' => $authorName,
                    'authorId'   => $id
                ]);
        }

        return view('blackList.removeBlackListByAuthorSelect',
            ['info' => $info, 'mediaType' => $request->model . 's', 'authorName' => $authorName, 'authorId' => $id]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('blackList.showBlackListInfo');
    }

    /**
     * @param $mediaType
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getInfoFromBlackList($mediaType, Request $request)
    {
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
