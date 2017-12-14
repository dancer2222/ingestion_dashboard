<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Class SelectController
 * @package App\Http\Controllers
 */
class SelectController extends Controller
{
    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $id = [
            'controller' => 'SearchController@index',
            'variableRequest' => 'id'
        ];
        $title = [
            'controller' => 'SearchByController@index',
            'variableRequest' => 'title'
        ];
        $isbn = [
            'controller' => 'SearchByController@index',
            'variableRequest' => 'isbn'
        ];
        $upc = [
            'controller' => 'SearchByController@index',
            'variableRequest' => 'upc'
        ];

        if ($request->type) {
            $selectedTypes = [];

            switch ($request->type) {
                case 'movies':
                    $selectedTypes = [$id, $title];
                    break;

                case 'books':
                    $selectedTypes = [$id, $title, $isbn];
                    break;

                case 'audiobooks':
                    $selectedTypes = [$id, $title];
                    break;

                case 'albums':
                    $selectedTypes = [$id, $title, $upc];
                    break;

                case 'games':
                    $selectedTypes = [$id];
                    break;
            }
        }

        return view('search.infoById', ['selectedTypes' => $selectedTypes]);
    }
}