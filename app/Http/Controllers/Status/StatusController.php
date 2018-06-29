<?php

namespace App\Http\Controllers\Status;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Ingestion\Rabbitmq\Indexation;

/**
 * Class StatusController
 * @package App\Http\Controllers\Status
 */
class StatusController extends Controller
{
    /**
     * @param Request $request
     * @param Indexation $indexation
     * @return \Illuminate\Http\RedirectResponse
     * @throws \ReflectionException
     */
    public function changeStatus(Request $request, Indexation $indexation)
    {
        $this->validate($request, [
            'id'        => 'required|min:5|string',
            'mediaType' => 'required|string',
            'command'   => 'required|string',
        ]);

        $mediaTypeTitle = ucfirst($request->mediaType);
        $mediaTypeTitle = substr($mediaTypeTitle, 0, -1);

        $className = "App\Models\\" . $mediaTypeTitle;
        $reflectionMethod = new \ReflectionMethod($className,'setStatus');
        $reflectionMethod->invoke(new $className(), $request->id, $request->command);

        $indexation->push('updateSingle', $request->mediaType, $request->id);

        return back()->with('message', 'Status updated');
    }
}
