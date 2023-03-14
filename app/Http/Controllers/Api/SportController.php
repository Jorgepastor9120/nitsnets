<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SportStoreRequest;
use App\Http\Requests\SportUpdateApiRequest;
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
     *    tags={"Sports"},
     *    summary="Mostrar el listado de de deportes",
     *    @OA\Response(
     *        response=200,
     *        description="OK",
     *        @OA\JsonContent()
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
     * Registrar un deporte.
     * @return \Illuminate\Http\Response
     *
     * @OA\Post(
     *    path="/api/v1/sports",
     *    tags={"Sports"},
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
        $user = auth()->user();

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
     * Actualizar un registro.
     * @return \Illuminate\Http\Response
     *
     * @OA\Put(
     *    path="/api/v1/sports",
     *    tags={"Sports"},
     *    summary="Actualiza un deporte",
     *    @OA\RequestBody(
     *       required=true,
        *    description="Actualiza un deporte",
        *    @OA\JsonContent(
        *       required={"id","name"},
        *       @OA\Property(
        *           property="id", type="integer", format="number", example="2"
        *       ),
        *       @OA\Property(
        *           property="name", type="string", format="text", example="Tenis"
        *       ),
        *    ),
    *    ),
    *    @OA\Response(
    *        response=200,
    *        description="OK"
    *    ),
    *    @OA\Response(
    *        response=404,
    *        description="No se ha podido actualizar el registro."
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

    public function update(SportUpdateApiRequest $request)
    {
        $sport = Sport::findOrFail($request->id);

        $sport->update(
            [
                'name' => $request->name
            ]);

        return $sport;
    }

    /**
     * Elimina un registro.
     * @return \Illuminate\Http\Response
     *
     * @OA\Delete(
     *    path="/api/v1/sports/{id}",
     *    tags={"Sports"},
     *    summary="Elimina un deporte",
     *    @OA\RequestBody(
     *       description="Elimina un deporte"
    *    ),
    *    @OA\Parameter(
    *        name="id", in="path", required=true, description="Id sport",
    *        @OA\schema(type="integer", format="int64")
    *    ),
    *    @OA\Response(
    *        response=200,
    *        description="OK"
    *    ),
    *    @OA\Response(
    *        response=404,
    *        description="No se ha podido eliminar el registro."
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
    public function destroy(int $id)
    {
   
        $sport = Sport::findorFail($id);

        $sport->delete();

        if (!$sport) {
            return response([
                'message' => 'No se encontró el deporte con el ID especificado'
            ], 404);
        }

        return response([
            'message' => 'Deporte eliminado'
        ], 200);

    }
}
