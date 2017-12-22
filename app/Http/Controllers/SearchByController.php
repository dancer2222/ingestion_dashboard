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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $input = $request->input;
        $type = $request->type;
        $mediaType = $request->mediaType;
        $option = $request->option;

        $info = $this->switchType($type, $input, $mediaType);

        $result = count($info);
        if ($result == 0) {
            $message = 'Not found '.$request->type.' witch  - ' . $input;

            return back()->with('message', $message);

        } elseif ($result == 1) {

            return redirect()->route('search', ['id' => $info[0]->id, 'type' => $type, 'option' => $option]);

        } else {

            return view('search.title', ['info' => $info, 'type' => $type]);
        }
    }

    /**
     * @param $type
     * @param $input
     * @param $mediaType
     *
     * @return mixed
     */
    public function switchType($type, $input, $mediaType)
    {
        $mediaTypeTitle = ucfirst($type);
        $mediaType = ucfirst($mediaType);
        $mediaTypeTitle = substr($mediaTypeTitle,  0,-1);
        $className = new \ReflectionMethod("App\Models\\" . $mediaTypeTitle, 'getInfoBy'.$mediaType);

        return $className->invoke(null, $input, lcfirst($mediaTypeTitle));
    }
}
