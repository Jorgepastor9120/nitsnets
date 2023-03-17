<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookingStoreRequest;
use App\Http\Requests\BookingUpdateApiRequest;
use App\Models\Booking;
use App\Models\Court;
use App\Models\HourReserve;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Summary of BookingController
 */
class BookingController extends Controller
{
    public function formatDate(string $date)
    {
        return date("Y-m-d", strtotime($date));
    }

    /**
     * Summary of countBookingMembers
     * @param int $memberId
     * @param string $date
     * @return int
     */
    public function countBookingMembers(int $memberId, string $date)
    {
        $countBookings = Booking::where('member_id', $memberId)
                            ->where('date', $this->formatDate($date))
                            ->count();
        
        if ($countBookings >= 3) {
            return false;
        }

        return true;
    }

    /**
     * Summary of countMemberCourtBookings
     * @param int $memberId
     * @param string $date
     * @param int $hourId
     * @return int
     */
    public function countMemberCourtBookings(int $memberId, string $date, int $hourId)
    {
        $countBookings = Booking::where('member_id', $memberId)
                            ->where('date', $this->formatDate($date))
                            ->where('hour_reserve_id', $hourId)
                            ->count();
        
        if ($countBookings >= 1) {
            return false;
        }

        return true;
    }

    /**
     * Summary of courtReserved
     * @param int $courtId
     * @param string $date
     * @param int $hourId
     * @return int
     */
    public function courtReserved(int $courtId, string $date, int $hourId)
    {
        $bookingCourt = Booking::where('court_id', $courtId)
                            ->where('date', $this->formatDate($date))
                            ->where('hour_reserve_id', $hourId)
                            ->count();
        
        if ($bookingCourt > 0) {
            return false;
        }

        return true;
    }

    /**
     * Mostramos el listado de los registros solicitados.
     * @return \Illuminate\Http\Response
     *
     * @OA\Get(
     *    path="/api/v1/bookings",
     *    tags={"Bookings"},
     *    summary="Mostrar el listado de reservas",
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
    public function index(Booking $booking)
    {
        return $booking->paginate(5);
    }

    /**
     * Registrar una pista.
     * @return \Illuminate\Http\Response
     *
     * @OA\Post(
     *    path="/api/v1/bookings",
     *    tags={"Bookings"},
     *    summary="Registra una reserva",
     *    security={{"passport": {}}},
     *    @OA\RequestBody(
     *       required=true,
     *       @OA\JsonContent(
     *           required={"member_id", "court_id", "date", "hour_reserve_id"},
     *           @OA\Property(
     *               property="member_id", type="integer", format="int20", example="4"
     *           ),
     *           @OA\Property(
     *               property="court_id", type="integer", format="int20", example="7"
     *           ),
     *           @OA\Property(
     *               property="date", type="string", format="date", example="2023-10-25"
     *           ),
     *           @OA\Property(
     *               property="hour_reserve_id",
     *               type="integer",
     *               format="int20",
     *               description="Hora del día (formato de 24 horas desde las 08:00 a 22:00)",
     *               example="2",
     *               enum={1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13},
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
    public function store(BookingStoreRequest $request)
    {
        if ($this->countBookingMembers($request->member_id, $request->date)) {
            return response([
                'message' => 'Este socio ya tiene 3 reservas para este día'
            ], 422);
        }

        if ($this->countMemberCourtBookings($request->member_id, $request->date, $request->hour_reserve_id)) {
            return response([
                'message' => 'Este socio ya tiene una reserva a esta hora'
            ], 422);
        }

        if ($this->courtReserved($request->court_id, $request->date, $request->hour_reserve_id)) {
            return response([
                'message' => 'La pista ya está reservada a esta hora'
            ], 422);
        }

        $createBooking = Booking::create(
            [
                'member_id' => $request->member_id,
                'court_id' => $request->court_id,
                'date' => $request->date,
                'hour_reserve_id' => $request->hour_reserve_id,
            ]);

        if (!$createBooking) {
            return response([
                'message' => 'La creación ha fallado'
            ], 404);
        }

        return $createBooking;
    }

    /**
     * Summary of countBookingMembersUpdate
     * @param int $id
     * @param int $memberId
     * @param string $date
     * @return int
     */
    public function countBookingMembersUpdate(int $id, int $memberId, string $date)
    {
        $countBookings = Booking::where('member_id', $memberId)
                            ->whereNotIn('id', [$id])
                            ->where('date', $this->formatDate($date))
                            ->count();
        
        if ($countBookings >= 3) {
            return false;
        }

        return true;
    }

    /**
     * Summary of countMemberCourtBookingsUpdate
     * @param int $id
     * @param int $memberId
     * @param string $date
     * @param int $hourId
     * @return int
     */
    public function countMemberCourtBookingsUpdate(int $id, int $memberId, string $date, int $hourId)
    {
        $countBookings = Booking::where('member_id', $memberId)
                            ->whereNotIn('id', [$id])
                            ->where('date', $this->formatDate($date))
                            ->where('hour_reserve_id', $hourId)
                            ->count();
        
        if ($countBookings >= 1) {
            return false;
        }

        return true;
    }

    /**
     * Summary of courtReservedUpdate
     * @param int $courtId
     * @param string $date
     * @param int $hourId
     * @return int
     */
    public function courtReservedUpdate(int $id, int $courtId, string $date, int $hourId)
    {
        $bookingCourt = Booking::where('court_id', $courtId)
                            ->whereNotIn('id', [$id])
                            ->where('date', $this->formatDate($date))
                            ->where('hour_reserve_id', $hourId)
                            ->count();
        
        if ($bookingCourt > 0) {
            return false;
        }

        return true;
    }

    /**
     * Actualizar un registro.
     * @return \Illuminate\Http\Response
     *
     * @OA\Put(
     *    path="/api/v1/bookings/{id}",
     *    tags={"Bookings"},
     *    summary="Actualiza una reserva",
     *    security={{"passport": {}}},
     *    @OA\RequestBody(
     *        required=true,
     *        description="Actualiza una reserva",
     *        @OA\JsonContent(
     *           required={"member_id", "court_id", "date", "hour_reserve_id"},
     *           @OA\Property(
     *               property="member_id", type="integer", format="int20", example="4"
     *           ),
     *           @OA\Property(
     *               property="court_id", type="integer", format="int20", example="7"
     *           ),
     *           @OA\Property(
     *               property="date", type="string", format="date", example="2023-10-25"
     *           ),
     *           @OA\Property(
     *               property="hour_reserve_id",
     *               type="integer",
     *               format="int20",
     *               description="Hora del día (formato de 24 horas desde las 08:00 a 22:00)",
     *               example="2",
     *               enum={1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13},
     *           ),
     *       ),
     *    ),
     *    @OA\Parameter(
     *        name="id", in="path", required=true, description="Id booking",
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
    public function update(BookingUpdateApiRequest $request, int $id)
    {
        if ($this->countBookingMembersUpdate($id, $request->member_id, $request->date)) {
            return response([
                'message' => 'Este socio ya tiene 3 reservas para este día'
            ], 422);
        }

        if ($this->countMemberCourtBookingsUpdate(
                $id,
                $request->member_id,
                $request->date,
                $request->hour_reserve_id
            )) {
            return response([
                'message' => 'Este socio ya tiene una reserva a esta hora'
            ], 422);
        }

        if ($this->courtReservedUpdate($id, $request->court_id, $request->date, $request->hour_reserve_id)) {
            return response([
                'message' => 'La pista ya está reservada a esta hora'
            ], 422);
        }

        $booking = Booking::findOrFail($id);

        $booking->update(
            [
                'member_id' => $request->member_id,
                'court_id' => $request->court_id,
                'date' => $request->date,
                'hour_reserve_id' => $request->hour_reserve_id,
            ]);

        if (!$request) {
            return response([
                'message' => 'Acción no permitida'
            ], 405);
        }
        
        return $booking;
    }

    /**
     * Elimina un registro.
     * @return \Illuminate\Http\Response
     *
     * @OA\Delete(
     *    path="/api/v1/bookings/{id}",
     *    tags={"Bookings"},
     *    summary="Elimina una reserva",
     *    security={{"passport": {}}},
     *    @OA\RequestBody(
     *       description="Elimina una reserva"
     *    ),
     *    @OA\Parameter(
     *        name="id", in="path", required=true, description="Id booking",
     *        @OA\schema(type="integer", format="int20"),
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
        $booking = Booking::findorFail($id);

        $booking->delete();

        if (!$booking) {
            return response([
                'message' => 'No se encontró la reserva con el ID especificado'
            ], 404);
        }

        return response([
            'message' => 'Reserva eliminada'
        ], 200);
    }

    /**
     * Mostramos el listado de los registros solicitados según una fecha.
     * @return \Illuminate\Http\Response
     *
     * @OA\Get(
     *    path="/api/v1/bookings/{date}",
     *    tags={"Bookings"},
     *    summary="Mostrar el listado de reservas según una fecha",
     *    security={{"passport": {}}},
     *    @OA\Parameter(
     *        name="date", in="path", required=true, description="date",
     *        @OA\schema(type="string", format="date"),
     *        example="2023-10-25",
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
    public function listBookingByDate(string $date)
    {
        return Booking::where('date', $date)->get(5);
    }
}