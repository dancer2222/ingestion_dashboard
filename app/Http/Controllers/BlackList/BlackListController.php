<?php

namespace App\Http\Controllers\BlackList;

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
     */
    public function blackList(Request $request, Indexation $indexation)
    {
        if (isset($request->media)) {
            $medias = $request->media;
            $ids = [];
            foreach ($medias as $media => &$item) {
                if (isset($item['checked'])) {
                    $ids[] = $item['id'];
                }
            }
        } else {
            $ids = explode(',', str_replace(' ', '', $request->id));
        }

        $command = $request->command;
        $oppositeCommand = 'active';
        if ('active' === $command) {
            $oppositeCommand = 'inactive';
        }

        $mediaTypeByIndexation = str_replace('_', '', $request->mediaType);
        $mediaTypeTitleOne = substr($request->mediaType, 0, -1);
        $mediaType = str_replace('_', '', $mediaTypeTitleOne);
        $mediaTypeTitle = ucfirst($mediaType);
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
        $name = $request->author_id;

        $modelName = ucfirst(str_replace('_', '', $request->model));
        $className = "App\Models\\" . $modelName . 'author';
        $reflectionMethod = new \ReflectionMethod($className, 'getIdByAuthorId');
        $idAuthor = $reflectionMethod->invoke(new $className(), $name);

        if ($idAuthor->isEmpty()) {
            return back()->with('message', 'This author id: ' . $name . ' not found in database');
        }

        $idAuthor = $idAuthor->toArray();
        $info = [];

        $classNameSecond = "App\Models\\" . $modelName;
        $reflectionMethod = new \ReflectionMethod($classNameSecond, 'getInfoById');

        foreach ($idAuthor as $itenInfo) {
            foreach ($itenInfo as $value) {
                $info[] = [
                    'id'    => $reflectionMethod->invoke(new $classNameSecond(), $value)[0]->id,
                    'title' => $reflectionMethod->invoke(new $classNameSecond(), $value)[0]->title
                ];
            }
        }

        if ('active' === $request->command) {

            return view('blackList.addBlackListByAuthorSelect',
                ['info' => $info, 'mediaType' => $request->model . 's']);
        }

        return view('blackList.removeBlackListByAuthorSelect', ['info' => $info, 'mediaType' => $request->model . 's']);
    }
}
