<?php

namespace App\Http\Controllers\API\V1\Tools;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class ConfigController
 * @package App\Http\Controllers\API\V1\Tools
 */
class ConfigController extends Controller
{
    /**
     * @param Request $request
     */
    public function store(Request $request)
    {
        file_put_contents(public_path().'/someconfig.php', "<?php \n return " . var_export($request->all(), true) . "; \n");
    }
}
