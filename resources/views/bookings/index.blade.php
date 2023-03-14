<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Reservas') }}
            <a class="text-xs bg-blue-700 text-white rounded px-2 py-1"
            href="{{ route('bookings.create') }}">Nueva reserva</a>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                <form action="{{ route('search-bookings.get') }}" method="get">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21
                            21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input type="search" id="datepickerSearch" name="date" class="block w-full p-4 pl-10 text-sm
                        text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500
                        focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400
                        dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Buscar reservas por día" required>

                        <button type="submit" class="text-white absolute right-2.5 bottom-2.5 bg-blue-700
                        hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg
                        text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Buscar</button>
                    </div>
                </form>

                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 mt-4"
                aria-labelledby="Tabla de miembros">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">Socio</th>
                                <th scope="col" class="px-6 py-3">Pista</th>
                                <th scope="col" class="px-6 py-3">Fecha</th>
                                <th scope="col" class="px-6 py-3">Hora</th>
                                <th scope="col" class="px-6 py-3">#</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($bookings as $booking)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700
                        hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="px-6 py-4">
                                <a href="{{ route('bookings.show', $booking) }}">{{ $booking->member->name }}</a>
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('bookings.show', $booking) }}">{{ $booking->court->name }}</a>
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('bookings.show', $booking) }}">
                                    {{ \Carbon\Carbon::make($booking->date)->format('d/m/Y') }}
                                </a>
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('bookings.show', $booking) }}">{{ $booking->hourReserve->name }}</a>
                            </td>
                            <td class="px-6 py-4">
                            <div>
                                <button id="MenuAccionesBooking" data-dropdown-toggle="AccionesBooking{{$booking->id}}"
                                class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-900
                                bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none dark:text-white
                                focus:ring-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                                type="button">
                                    <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0
                                     110-4 2 2 0 010 4z"></path></svg>
                                </button>
                                <div id="AccionesBooking{{ $booking->id }}" class="z-10 hidden bg-white divide-y
                                divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                                    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200"
                                    aria-labelledby="MenuAccionesBooking">
                                        <li>
                                            <a href="{{ route('bookings.show', $booking) }}"
                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600
                                            dark:hover:text-white">Ver</a>
                                        </li>
                                    </ul>
                                    <div class="py-1">
                                        <form action="{{ route('bookings.destroy', $booking) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type='submit' class="px-5 py-4">Eliminar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $bookings->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
