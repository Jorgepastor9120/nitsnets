<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Http\Requests\BookingStoreRequest;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Summary of BookingController
 */
class BookingController extends Controller
{
    /**
     * Summary of countBookingMembers
     * @param int $memberId
     * @param string $date
     * @return int
     */
    public function countBookingMembers(int $memberId, string $date)
    {
        $newFormatDate = date("Y-m-d", strtotime($date));

        $countBookings = Booking::where('member_id', $memberId)
                            ->where('date', $newFormatDate)
                            ->count();
        
        if ($countBookings >= 3) {
            return 0;
        }

        return 1;
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
        $newFormatDate = date("Y-m-d", strtotime($date));

        $countBookings = Booking::where('member_id', $memberId)
                            ->where('date', $newFormatDate)
                            ->where('hour_reserve_id', $hourId)
                            ->count();
        
        if ($countBookings >= 1) {
            return 0;
        }

        return 1;
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
        $newFormatDate = date("Y-m-d", strtotime($date));

        $bookingCourt = Booking::where('court_id', $courtId)
                            ->where('date', $newFormatDate)
                            ->where('hour_reserve_id', $hourId)
                            ->count();
        
        if ($bookingCourt > 0) {
            return 0;
        }

        return 1;
    }

    /**
     * Mostramos el listado de los regitros solicitados.
     * @return \Illuminate\Http\Response
     *
     * @OA\Get(
     *    path="/api/v1/bookings",
     *    tags={"Bookings"},
     *    summary="Mostrar el listado de reservas",
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
        if ($this->countBookingMembers($request->member_id, $request->date) == 0) {
            return response([
                'message' => 'Este socio ya tiene 3 reservas para este día'
            ], 422);
        }

        if ($this->countMemberCourtBookings($request->member_id, $request->date, $request->hour_reserve_id) == 0) {
            return response([
                'message' => 'Este socio ya tiene una reserva a esta hora'
            ], 422);
        }

        if ($this->courtReserved($request->court_id, $request->date, $request->hour_reserve_id) == 0) {
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
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}