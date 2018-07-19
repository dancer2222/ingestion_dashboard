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
        $contentType = $request->contentType;
        $valueType = $request->valueType;
        $value = $request->value;

        $info = $this->switchType($contentType, $value, $valueType);
        $result = \count($info);

        if ($result === 0) {
            $message = "Not found '$contentType' with  - $value";

            return back()->with('message', $message);
        } elseif ($result === 1) {
            return redirect()->route('search', [
                'value' => $info[0]['id'],
                'valueType' => $valueType,
                'contentType' => $contentType
            ]);
        } else {
            return view('search.title', ['info' => $info->toArray(), 'type' => $contentType]);
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
        if (in_array($mediaType, ['upc', 'dataOriginId', 'isbn', 'id'])) {
            $input = preg_replace("/[^0-9]/", '', $input);
        }

        $mediaTypeTitle = ucfirst($type);
        $mediaType = ucfirst($mediaType);
        $mediaTypeTitle = substr($mediaTypeTitle, 0, -1);

        $className = "App\Models\\" . $mediaTypeTitle;

        $reflectionMethod = new \ReflectionMethod($className, 'getInfoBy' . $mediaType);

        return $reflectionMethod->invoke(new $className(), $input, lcfirst($mediaTypeTitle));
    }
}
