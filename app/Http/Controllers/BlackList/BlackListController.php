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

    public function indexRemove()
    {
        return view('blackList.removeBlackList');
    }

    /**
     * @param Request $request
     * @param Indexation $indexation
     * @return \Illuminate\Http\RedirectResponse
     */
    public function blackList(Request $request, Indexation $indexation)
    {
        $this->validate($request, [
            'id'        => 'required|min:5|string',
            'mediaType' => 'required|string',
            'command'   => 'required|string',
        ]);

        $command = $request->command;

        $oppositeCommand = 'active';
        if ('active' === $command) {
            $oppositeCommand = 'inactive';
        }

        $mediaTypeByIndexation = str_replace('_', '',$request->mediaType);
        $mediaTypeTitleOne = substr($request->mediaType, 0, -1);
        $mediaType = str_replace('_', '',$mediaTypeTitleOne);
        $mediaTypeTitle = ucfirst($mediaType);
        $unHandledIds = [];
        $handledIds = [];
        $ids = explode(',', str_replace(' ', '', $request->id));

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

        return back()->with('message', $msg);
    }
}
