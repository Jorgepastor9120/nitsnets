@csrf
<div class="mb-5">
    <label for="member_id" class="block mb-2 text-sm font-medium text-gray-700 dark:text-white">Socio</label>
    <select id="member_id" name="member_id" class="select2 bg-gray-50 border border-gray-300 text-gray-900 text-sm
    rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700
    dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500
    dark:focus:border-blue-500" required>
        @foreach ($members as $member)
            <option value="{{ $member->id }}" @if ($booking->member_id == $member->id) selected @endif >
                {{ $member->name }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-5">
    <label for="court_id" class="block mb-2 text-sm font-medium text-gray-700 dark:text-white">Pista</label>
    <select id="court_id" name="court_id" class="select2 bg-gray-50 border border-gray-300 text-gray-900 text-sm
    rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700
    dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500
    dark:focus:border-blue-500" required>
        @foreach ($courts as $court)
            <option value="{{ $court->id }}" @if ($booking->court_id == $court->id) selected @endif >
                {{ $court->name }} ({{ $court->sport->name }})
            </option>
        @endforeach
    </select>
</div>

<div class="mb-5">
    <label for="date" class="block mb-2 text-sm font-medium text-gray-700 dark:text-white">Día</label>
    <div class="relative">
    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
        <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20"
        xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd"d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002
        2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
        clip-rule="evenodd"></path></svg>
    </div>
    <input type="text" name="date" id="datepicker"
    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500
    focus:border-blue-500 block w-full pl-10 dark:bg-gray-700 dark:border-gray-600
    dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
    placeholder="Select date" autocomplete="off" required>
    </div>
</div>

<div class="mb-5">
    <label for="hour" class="block mb-2 text-sm font-medium text-gray-700 dark:text-white">Hora</label>
    <select id="hour" name="hour" class="select2 bg-gray-50 border border-gray-300 text-gray-900 text-sm
    rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700
    dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500
    dark:focus:border-blue-500" required>
    <option value="">Selecciona una hora</option>
    </select>
</div>

<div class="flex justify-between items-center mt-4">
    <a href="{{ route('bookings.index') }}" class="py-2.5 px-5 mr-2 mb-2 text-sm font-medium
    text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200
    hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200
    dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600
    dark:hover:text-white dark:hover:bg-gray-700">Volver</a>
    @isset($btnNewBooking)
        <a href="{{ route('bookings.create') }}" class="py-2.5 px-5 mr-2 mb-2
        text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border
        border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200
        dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white
        dark:hover:bg-gray-700">Crear Nuevo</a>
    @endisset
    <input type="submit" value="Guardar" class="text-white bg-blue-700 hover:bg-blue-800
    focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2
    dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
</div>
