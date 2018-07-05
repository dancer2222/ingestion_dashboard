<?php

namespace App\Http\Controllers\BlackList;

use App\Models\AudiobookBlackList;
use App\Models\BookBlackList;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Ingestion\BlackList\BlackListManager;
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
    public function indexManage()
    {
        return view('blackList.manageBlackList');
    }

    /**
     * @param Request $request
     * @param Indexation $indexation
     * @return \Illuminate\Http\RedirectResponse
     */
    public function blackList(Request $request, Indexation $indexation)
    {
        $request->validate([
                'id' => 'required'
        ]);

        try {
            $blackListManager = new BlackListManager($request->id, $request->command, $request->dataType,
                    $request->mediaType);
            $oppositeCommand = 'active';

            if ('active' === $blackListManager->getCommand()) {
                $oppositeCommand = 'inactive';
            }

            if ($request->dataType === 'author') {

                $ids = $blackListManager->getIdsByAuthorSetStatusAuthor(
                        $request->media,
                        $blackListManager->getMediaType(),
                        $blackListManager->getCommand(),
                        $blackListManager->getId(),
                        $blackListManager->getCommand(),
                        $oppositeCommand
                );

            } else {
                $ids = $blackListManager->getIdsById($request->media);
            }
        } catch (Exception $e) {
            $message = 'We have a problem with this author_id ' . $blackListManager->getId() . $e->getMessage();
            logger()->critical($message);

            return back()->with('message', $message);
        }

        try {
            $allIds = $blackListManager->addIdsToBlackList($ids, $oppositeCommand, $indexation);
        } catch (Exception $e) {
            $message = 'An error occurred while updating this id ' . $blackListManager->getId() . $e->getMessage();
            logger()->critical($message);

            return back()->with('message', $message);
        }

        logger()->info('User - ' .
                Auth::user()->name .
                ' ' .
                Auth::user()->email .
                ' Blacklist updated id(s): ' .
                implode(', ', $allIds['handledIds']));

        $msg = 'This id(s) - ' . implode(', ', $allIds['handledIds']) . ' updated in BlackList';

        if (!empty($unHandledIds)) {
            $msg = $msg . ', not found this id(s) - ' . implode(', ', $allIds['unHandledIds']);
        }

        return redirect(route('blackList.manage'))->with('message', $msg);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function blackListSelect(Request $request)
    {
        $request->validate([
                'id' => 'required'
        ]);

        try {
            $blackListManager = new BlackListManager($request->id, $request->command, $request->dataType,
                    $request->mediaType);

            if ('author' == $blackListManager->getDataType()) {
                $info = $blackListManager->getInfoByAuthorId($blackListManager->getModel(), $blackListManager->getId());
                $authorName = BlackListManager::getAuthorName($blackListManager->getMediaType(),
                                $blackListManager->getId()) . ' author';

            } else {
                $authorName = '';
                $info = $blackListManager->getInfoById($blackListManager->getId(), $blackListManager->getModel());
            }
        } catch (Exception $exception) {
            $message = 'We have a problem with this id ' . $blackListManager->getId() . ' ' . $exception->getMessage();
            logger()->critical($message);

            return back()->with('message', $message);
        }
        return view('blackList.manageBlackListSelect', [
                'info'       => $info,
                'mediaType'  => $blackListManager->getMediaType() . 's',
                'authorName' => $authorName,
                'id'         => $blackListManager->getId(),
                'command'    => $blackListManager->getCommand(),
                'dataType'   => $blackListManager->getDataType()
        ]);
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
     * @param Request $request
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
