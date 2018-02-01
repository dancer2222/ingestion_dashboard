<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Class SearchByController
 * @package App\Http\Controllers
 */
class SearchByController extends Controller
{
    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     * @throws \ReflectionException
     */
    public function index(Request $request)
    {
        $info = $this->switchType($request->type, $request->input, $request->mediaType);

        $result = count($info);
        if ($result == 0) {
            $message = 'Not found ' . $request->type . ' witch  - ' . $request->input;

            return back()->with('message', $message);

        } elseif ($result == 1) {

            return redirect()->route('search',
                ['id' => $info[0]->id, 'type' => $request->type, 'option' => $request->option]);

        } else {

            return view('search.title', ['info' => $info, 'type' => $request->type]);
        }
    }

    /**
     * @param $type
     * @param $input
     * @param $mediaType
     *
     * @return mixed
     * @throws \ReflectionException
     */
    public function switchType($type, $input, $mediaType)
    {
        $mediaTypeTitle = ucfirst($type);
        $mediaType = ucfirst($mediaType);
        $mediaTypeTitle = substr($mediaTypeTitle, 0, -1);
        $className = new \ReflectionMethod("App\Models\\" . $mediaTypeTitle, 'getInfoBy' . $mediaType);

        return $className->invoke(null, $input, lcfirst($mediaTypeTitle));
    }
}
