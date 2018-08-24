<?php

namespace App\Http\Controllers\Ratings;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Controller;

class RatingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Model $model
     * @return \Illuminate\Http\Response
     */
    public function index(Model $model)
    {
        $list = $model->has('rating')->with('rating')->paginate(10);

        return view('template_v2.misc.ratings.ratings', ['list' => $list]);
    }

    /**
     * Display the specified resource.
     *
     * @param Model $model
     * @return \Illuminate\Http\Response
     */
    public function show(Model $model)
    {
        return view('template_v2.misc.ratings.ratings', ['entity' => $model]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
