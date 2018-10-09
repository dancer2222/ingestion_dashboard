<?php

namespace App\Http\Controllers\API\V1\Content;

use App\Models\Audiobook;
use App\Models\AudiobookBlackList;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Ingestion\Rabbitmq\Indexation;

/**
 * Class AudiobooksController
 * @package App\Http\Controllers\API\V1\Content
 */
class AudiobooksController extends Controller
{
    /**
     * @param Request $request
     * @param Indexation $indexation
     * @return \Illuminate\Http\JsonResponse
     */
    public function setStatus(Request $request, Indexation $indexation)
    {
        $id = $request->id;
        $result = Audiobook::where('id', $id)->update(['status' => $request->status]);
        $indexation->push('updateSingle', 'audiobooks', $id);

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
            $result = AudiobookBlackList::updateOrCreate(
                [
                    'audio_book_id' => $id,
                ],
                [
                    'status' => $status,
                ]
            );

            if ($status === 'active' && $result) {
                Audiobook::where('id', $id)->update(['status' => 'inactive']);
            }

        }

        return response()->json(['result' => $result], 200);
    }
}
