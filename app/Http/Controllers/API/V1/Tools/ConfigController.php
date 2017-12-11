<?php

namespace App\Http\Controllers\API\V1\Tools;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ConfigController extends Controller
{
    /**
     *
     */
    public function index()
    {
       //
    }

    /**
     * @param Request $request
     */
    public function store(Request $request)
    {
        file_put_contents(public_path().'/someconfig.php', "<?php \n return " . var_export($request->tools, true) . "; \n");
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }
}
