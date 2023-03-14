<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Booking;
use App\Models\Court;
use App\Models\HourReserve;
use App\Models\Member;
use Illuminate\Http\Request;

/**
 * Summary of BookingController
 */
class BookingController extends Controller
{
    /**
     * Summary of getHours
     * @param int $memberId
     * @param int $courtId
     * @param mixed $date
     * @return \Illuminate\Http\JsonResponse
     */
    public function getHours(int $memberId, int $courtId, mixed $date)
    {
        $newFormatDate = date("Y-m-d", strtotime($date));

        $data = [
            'hours' => HourReserve::whereNotIn('id', function ($query) use ($memberId, $courtId, $newFormatDate)
                                                    {
                                                        $query->select('hour_reserve_id')
                                                            ->from('bookings')
                                                            ->where('court_id', $courtId)
                                                            ->where('date', $newFormatDate)
                                                            ->orWhere(function ($query) use ($memberId, $newFormatDate)
                                                                    {
                                                                        $query->whereNotNull('member_id')
                                                                            ->where('member_id', $memberId)
                                                                            ->where('date', $newFormatDate);
                                                                    })
                                                            ->orWhere(function ($query)
                                                                    {
                                                                        $query->whereIn('member_id', function ($query) {
                                                                                $query->select('id')
                                                                                    ->from('hour_reserves');
                                                                            });
                                                                    });
                                                    })
                                                    ->get(),
            'cantidadReservasSocio' => Booking::where('member_id', $memberId)
                                                ->where('date', $newFormatDate)
                                                ->count(),
        ];

        return  response()->json($data);
    }
    
    public function index()
    {
        return view('bookings.index', [
            'bookings' => Booking::orderBy('id', 'desc')
                                ->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Booking $booking)
    {
        return view('bookings.booking_create', [
            'booking' => $booking,
            'courts' => Court::all(),
            'members' => Member::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function formatDate($requestDate)
    {
        $date = Carbon::createFromFormat('d/m/Y', $requestDate);
        return $date->format('Y-m-d');
    }

    public function formatDateSearch($requestDate)
    {
        $date = Carbon::createFromFormat('d-m-Y', $requestDate);
        return $date->format('Y-m-d');
    }

    public function store(Request $request)
    {
        $createBooking = Booking::create(
            [
                'member_id' => $request->member_id,
                'court_id' => $request->court_id,
                'date' => $this->formatDate($request->date),
                'hour_reserve_id' => $request->hour,
            ]);

        return view('bookings.booking_show', [
                'booking' => $createBooking,
                'btnNewBooking' => true
            ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Booking $booking)
    {
        return view('bookings.booking_show', [
            'booking' => $booking,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Booking $booking)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Booking $booking)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking)
    {
        $booking->delete();

        return view('bookings.index', [
            'bookings' => Booking::orderBy('id', 'desc')
                                ->paginate(10)
        ]);
    }

    public function searchBookings(Request $request)
    {
        return view('bookings.index', [
            'bookings' => Booking::where('date', $this->formatDateSearch($request->date))
                                ->paginate(10)
        ]);
    }
}
