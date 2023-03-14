<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
    * @OA\Info(
    *             title="API de prueba NitsNet",
    *             version="1.0",
    *             description="Esta es una primera versión de la API"
    * )
    *
    * @OA\Server(url="http://127.0.0.1:8000")
*/

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
