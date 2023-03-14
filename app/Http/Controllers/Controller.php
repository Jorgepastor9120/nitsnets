<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
    * @OA\Info(
    *             title="API de prueba",
    *             version="1.0",
    *             description="Esta es una primera versión de la API",
    *             contact="jorgepastor9120@gmail.com"
    * )
    *
    * @OA\Server(
    *               url="http://127.0.0.1:8000"
    * ),
    * @OA\Tag(
    *            name="Users",
    *            description="Gestión de los usuarios de la aplicación"
    * )
    * @OA\Tag(
    *            name="Sports",
    *            description="Gestión de los deportes"
    * ),
    * @OA\Tag(
    *            name="Courts",
    *            description="Gestión de las pistas"
    * ),
    * @OA\Tag(
    *            name="Members",
    *            description="Gestión de los socios"
    * ),
    * @OA\Tag(
    *            name="Bookings",
    *            description="Gestión de las reservas de pista"
    * )
*/

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
