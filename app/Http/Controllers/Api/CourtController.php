<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CourtStoreRequest;
use App\Http\Requests\CourtUpdateApiRequest;
use App\Models\Court;
use App\Models\HourReserve;
use Illuminate\Http\Request;

class CourtController extends Controller
{
    /**
     * Mostramos el listado de los regitros solicitados.
     * @return \Illuminate\Http\Response
     *
     * @OA\Get(
     *    path="/api/v1/courts",
     *    tags={"Courts"},
     *    summary="Mostrar el listado de pistas",
     *    security={{"passport": {}}},
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
    public function index(Court $court)
    {
        return $court->paginate(5);
    }

    /**
     * Registrar una pista.
     * @return \Illuminate\Http\Response
     *
     * @OA\Post(
     *    path="/api/v1/courts",
     *    tags={"Courts"},
     *    summary="Registra una pista",
     *    security={{"passport": {}}},
     *    @OA\RequestBody(
     *       required=true,
     *       description="Registra una pista",
     *       @OA\JsonContent(
     *           required={"name", "sport_id"},
     *           @OA\Property(
     *               property="name", type="string", format="text", example="Prueba"
     *           ),
     *           @OA\Property(
     *               property="sport_id", type="integer", format="int20", example="4"
     *           ),
     *       ),
     *    ),
     *    @OA\Response(
     *        response=200,
     *        description="OK"
     *    ),
     *    @OA\Response(
     *        response=201,
     *        description="La pista ha sido creado"
     *    ),
     *    @OA\Response(
     *        response=404,
     *        description="No se ha podido registrar la pista."
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
    public function store(CourtStoreRequest $request)
    {
        $createCourt = Court::create(
            [
                'name' => $request->name,
                'sport_id' => $request->sport_id
            ]);

        if (!$createCourt) {
            return response([
                'message' => 'La creación ha fallado'
            ], 404);
        }

        return $createCourt;
    }

    /**
     * Actualizar un registro.
     * @return \Illuminate\Http\Response
     *
     * @OA\Put(
     *    path="/api/v1/courts/{id}",
     *    tags={"Courts"},
     *    summary="Actualiza una pista",
     *    security={{"passport": {}}},
     *    @OA\RequestBody(
     *        required=true,
     *        description="Actualiza una pista",
     *        @OA\JsonContent(
     *           required={"name", "sport_id"},
     *           @OA\Property(
     *               property="name", type="string", format="text", example="Prueba"
     *           ),
     *           @OA\Property(
     *               property="sport_id", type="integer", format="int20", example="4"
     *           ),
     *       ),
     *    ),
     *    @OA\Parameter(
     *        name="id", in="path", required=true, description="Id court",
     *        @OA\schema(type="integer", format="int20")
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
     *        response=405,
     *        description="No se ha permitido actualizar el registro."
     *    ),
     *    @OA\Response(
     *        response=503,
     *        description="El servidor no está disponible en este momento"
     *    ),
     *    @OA\Response(
     *         response="default",
     *         description="Ha ocurrido un error."
     *    )
     * )
     */
    public function update(CourtUpdateApiRequest $request, int $id)
    {
        $court = Court::findOrFail($id);

        $court->update(
            [
                'name' => $request->name,
                'sport_id' => $request->sport_id
            ]);

        if (!$request) {
            return response([
                'message' => 'Acción no permitida'
            ], 405);
        }
        
        return $court;
    }

    /**
     * Elimina un registro.
     * @return \Illuminate\Http\Response
     *
     * @OA\Delete(
     *    path="/api/v1/courts/{id}",
     *    tags={"Courts"},
     *    summary="Elimina una pista",
     *    security={{"passport": {}}},
     *    @OA\RequestBody(
     *       description="Elimina una pista"
     *    ),
     *    @OA\Parameter(
     *        name="id", in="path", required=true, description="Id court",
     *        @OA\schema(type="integer", format="int20")
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
     *    @OA\Response(
     *        response="default",
     *        description="Ha ocurrido un error."
     *    )
     * )
     */
    public function destroy(int $id)
    {
        $court = Court::findorFail($id);

        $court->delete();

        if (!$court) {
            return response([
                'message' => 'No se encontró la pista con el ID especificado'
            ], 404);
        }

        return response([
            'message' => 'Pista eliminada'
        ], 200);
    }

    /**
     * Mostramos el listado de pistas disponibles según varios parametros.
     * @return \Illuminate\Http\Response
     *
     * @OA\Get(
     *    path="/api/v1/courts/list",
     *    tags={"Courts"},
     *    summary="Mostrar el listado de pistas libres según una fecha, un deporte y un miembro",
     *    security={{"passport": {}}},
     *    @OA\Parameter(
     *        name="date", in="query", required=true, description="date",
     *        @OA\schema(type="string", format="date"),
     *        example="2023-10-25",
     *    ),
     *    @OA\Parameter(
     *        name="sport_id", in="query", required=true, description="sport_id",
     *        @OA\schema(type="integer", format="int20"),
     *        example="3",
     *    ),
     *    @OA\Parameter(
     *        name="member_id", in="query", required=true, description="member_id",
     *        @OA\schema(type="integer", format="int20"),
     *        example="30",
     *    ),
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
    public function listBookingByDateSportMember()
    {
        $date = request()->input('date');
        $sportId = request()->input('sport_id');
        $memberId = request()->input('member_id');

        $courts = Court::where('sport_id', $sportId)->get();

        $curtsArray = [];

        foreach ($courts as $court) {

            $hours = HourReserve::whereNotIn('id', function ($query) use ($memberId, $date, $court)
                                                    {
                                                        $query->select('hour_reserve_id')
                                                            ->from('bookings')
                                                            ->where('court_id', $court->id)
                                                            ->where('date', $date)
                                                            ->orWhere(function ($query) use ($memberId, $date)
                                                                    {
                                                                        $query->whereNotNull('member_id')
                                                                            ->where('member_id', $memberId)
                                                                            ->where('date', $date);
                                                                    })
                                                            ->orWhere(function ($query)
                                                                    {
                                                                        $query->whereIn('member_id', function ($query) {
                                                                                $query->select('id')
                                                                                    ->from('hour_reserves');
                                                                            });
                                                                    });
                                                    })->paginate(5);

            $addCourt = [
                "id" => $court->id,
                "name" => $court->name,
                "sport_id" => $court->sport_id,
                "hour_reserves" => []
            ];

            foreach ($hours as $hour) {

                $addHour = [
                    "id" => $hour->id,
                    "name" => $hour->name
                ];

                $addCourt['hour_reserves'][] = $addHour;

            }

            $curtsArray[] = $addCourt;

        }

        return $curtsArray;
    }
}