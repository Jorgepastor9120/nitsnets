<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ver reserva') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @isset($btnNewBooking)
                        <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800
                        dark:text-green-400" role="alert">
                            <span class="font-medium">Reserva creada con éxito</span>
                        </div>
                    @endisset
                    <div class="grid gap-4 mb-6 md:grid-cols-2">
                        <div class="w-full max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800
                        dark:border-gray-700">
                            <div class="flex justify-end px-4 pt-4">
                                <button id="dropdownButton" data-dropdown-toggle="dropdown" class="inline-block
                                text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700
                                focus:ring-4 focus:outline-none focus:ring-gray-200 dark:focus:ring-gray-700
                                rounded-lg text-sm p-1.5" type="button">
                                    <span class="sr-only">Open dropdown</span>
                                    <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg"><path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12
                                    10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z"></path></svg>
                                </button>
                                <!-- Dropdown menu -->
                                <div id="dropdown" class="z-10 hidden text-base list-none bg-white divide-y
                                divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                                    <ul class="py-2" aria-labelledby="dropdownButton">
                                    <li>
                                        <form action="{{ route('bookings.destroy', $booking) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type='submit' class="px-5 py-4">Eliminar</button>
                                        </form>
                                    </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="flex flex-col items-center pb-10">
                                <div class="w-24 h-24 mb-3 rounded-full shadow-lg">
                                    <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15
                                        9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745
                                        3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746
                                        3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013
                                        12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0
                                        013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0
                                        013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z"></path>
                                    </svg>
                                </div>
                                <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white">
                                    {{ $booking->member->name }}
                                </h5>
                                <span class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ $booking->court->name }} ({{ $booking->court->sport->name }})
                                </span>
                                <div class="flex mt-4 space-x-3 md:mt-6">
                                    <span class="bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5
                                    rounded dark:bg-blue-900 dark:text-blue-300">
                                        {{ \Carbon\Carbon::make($booking->date)->format('d/m/Y') }}
                                    </span>
                                    <span class="bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5
                                    rounded dark:bg-blue-900 dark:text-blue-300">
                                        {{ $booking->hourReserve->name }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>