<?php

namespace App\Http\Controllers\BlackList;

use App\Http\Requests\ManageBlackList;
use App\Models\AudiobookBlackList;
use App\Models\BookBlackList;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Ingestion\BlackList\BlackListManager;
use Ingestion\Logs\UserActivityLogs;
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
     * @param UserActivityLogs $userActivityLogs
     * @return \Illuminate\Http\RedirectResponse
     */
    public function blackList(Request $request, Indexation $indexation, UserActivityLogs $userActivityLogs)
    {
        $request->validate([
            'id' => 'required'
        ]);

        try {
            $blackListManager = new BlackListManager(
                $request->id,
                $request->command,
                $request->dataType,
                $request->mediaType
            );

            $oppositeCommand = 'active';

            if ('active' === $blackListManager->getCommand()) {
                $oppositeCommand = 'inactive';
            }


            $dataType = $blackListManager->getDataType();

            if ($dataType === 'author') {
                $ids = $blackListManager->getIdsByAuthor(
                    $request->media,
                    $oppositeCommand
                );
            } elseif ($dataType == 'idType') {
                $ids = (array)$blackListManager->getId();
            } else {
                $ids = $blackListManager->getIdsById($request->media);
            }

            $blackListManager->addIdsToBlackList($ids, $oppositeCommand, $indexation);
        } catch (Exception $e) {
            $message = 'We have a problem with this id ' . $blackListManager->getId() . ' ' . $e->getMessage();
            logger()->critical($message);

            return back()->with('message', $message);
        }

        $handledIds = implode(', ', $blackListManager->handledIds);
        $userActivityLogs->updateBlacklistStatus($handledIds, $request->mediaType);

        $msg = 'This id(s) - ' . $handledIds . ' updated in BlackList';

        if (!empty($unHandledIds)) {
            $unHandledIds = implode(', ', $blackListManager->unHandledIds);
            $msg = $msg . ', not found this id(s) - ' . $unHandledIds;
        }

        if ($dataType == 'idType') {
            return back()->with('message', $msg);

        }

        return redirect(route('blackList.manage'))->with('message', $msg);
    }

    /**
     * @param ManageBlackList $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function blackListSelect(ManageBlackList $request)
    {
        try {
            $request->session()->put('command', $request->command);
            $request->session()->put('dataType', $request->dataType);
            $request->session()->put('mediaType', $request->mediaType);

            $blackListManager = new BlackListManager(
                $request->id,
                $request->command,
                $request->dataType,
                $request->mediaType
            );

            $dataType = $blackListManager->getDataType();

            if ('author' == $dataType) {
                $info = $blackListManager->getInfoByAuthorId();
                $authorName = $blackListManager->getAuthorName() . ' author';;
            } else {
                $authorName = '';
                $info = $blackListManager->getInfoById();
            }
        } catch (Exception $exception) {
            $message = 'Not found this id ' . $blackListManager->getId() . ' ' . $exception->getMessage();
            logger()->critical($message);

            return back()->with('message', $message);
        }

        return view('blackList.manageBlackListSelect', [
            'info' => $info,
            'mediaType' => $blackListManager->getMediaTypeFromRequest(),
            'authorName' => $authorName,
            'id' => $blackListManager->getId(),
            'command' => $blackListManager->getCommand(),
            'dataType' => $dataType
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
     * @param BookBlackList $bookBlackList
     * @param AudiobookBlackList $audiobookBlackList
     * @return mixed
     */
    public function getInfoFromBlackList($mediaType, Request $request, BookBlackList $bookBlackList, AudiobookBlackList $audiobookBlackList)
    {
        $paginate = $request->get('limit', 10);

        if (!is_null($request->id)) {
            if ('books' === $mediaType) {
                $info = $bookBlackList->getInfoById($request->id);
            } else {
                $info = $audiobookBlackList->getInfoById($request->id);
            }
        } else {
            if ('books' === $mediaType) {
                $info = $bookBlackList->getInfo($paginate);
            } else {
                $info = $audiobookBlackList->getInfo($paginate);
            }
        }

        if ($info->isEmpty()) {
            return back()->with('message', 'Not found ' . $mediaType . ' in BlackList');
        }

        return view('blackList.showBlackListInfo', ['info' => $info, 'mediaType' => $mediaType]);
    }
}
