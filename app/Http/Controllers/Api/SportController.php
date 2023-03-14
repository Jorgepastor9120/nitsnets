<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SportStoreRequest;
use App\Http\Requests\SportUpdateRequest;
use App\Models\Sport;
use Illuminate\Http\Request;

class SportController extends Controller
{

/**
 * Mostramos el listado de los regitros solicitados.
 * @return \Illuminate\Http\Response
 *
 * @OA\Get(
 *    path="/api/v1/sports",
 *    tags={"sports"},
 *    summary="Mostrar el listado de de deportes",
 *    @OA\RequestBody(
 *       required=true,
    *    description="Deporte",
    *    @OA\JsonContent(
    *       required={"name"},
    *       @OA\Property(property="name", type="string", format="text", example="Tenis"),
    *    ),
 *    ),
 *    @OA\Response(
 *        response=200,
 *        description="OK"
 *    ),
 *    @OA\Response(
 *        response=404,
 *        description="No se ha podido cargar el listado."
 *    ),
 *    @OA\Response(
 *        response=503,
 *        description="El servidor no está disponible en este momento"
 *    ),
 *     @OA\Response(
 *         response="default",
 *         description="Ha ocurrido un error."
 *     )
 * )
 */
    public function index(Sport $sport)
    {
        return $sport->get();
    }

/**
 * Mostramos el listado de los regitros solicitados.
 * @return \Illuminate\Http\Response
 *
 * @OA\Post(
 *    path="/api/v1/sports",
 *    tags={"sports"},
 *    summary="Registra un deporte",
 *    @OA\RequestBody(
 *       required=true,
    *    description="Registra un deporte",
    *    @OA\JsonContent(
    *       required={"name"},
    *       @OA\Property(property="name", type="string", format="text", example="Tenis"),
    *    ),
 *    ),
 *    @OA\Response(
 *        response=200,
 *        description="OK"
 *    ),
 *    @OA\Response(
 *        response=404,
 *        description="No se ha podido cargar el listado."
 *    ),
 *    @OA\Response(
 *        response=503,
 *        description="El servidor no está disponible en este momento"
 *    ),
 *     @OA\Response(
 *         response="default",
 *         description="Ha ocurrido un error."
 *     )
 * )
 */
    public function store(SportStoreRequest $request)
    {
        $createSport = Sport::create(
            [
                'name' => $request->name
            ]);

        return $createSport;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SportUpdateRequest $request)
    {
        $sport = Sport::findOrFail($request->id);

        $sport->update(
            [
                'name' => $request->name
            ]);

        return $sport;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        return Sport::destroy($request->id);
    }
}
