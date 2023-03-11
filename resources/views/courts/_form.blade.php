@csrf
<label class="block mb-2 text-sm font-medium text-gray-700 dark:text-white">Nombre</label>
<span class='text-red-600'>@error('name') {{ $message }} @enderror</span>
<input type="text" name="name" class="rounded border-gray-200 text-gray-900 w-full mb-4"
value="{{ old('name', $court->name) }}">

<div class="mb-5">
    <label for="sport_id" class="block mb-2 text-sm font-medium text-gray-700 dark:text-white">Deporte</label>
    <select id="sport_id" name="sport_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm
    rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700
    dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500
    dark:focus:border-blue-500" required>
        @foreach ($sports as $sport)
            <option value="{{ $sport->id }}" @if ($court->sport_id == $sport->id) selected @endif >
                {{ $sport->name }}
            </option>
        @endforeach
    </select>
</div>

<div class="flex justify-between items-center mt-4">
    <a href="{{ route('courts.index') }}" class="py-2.5 px-5 mr-2 mb-2 text-sm font-medium
    text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200
    hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200
    dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600
    dark:hover:text-white dark:hover:bg-gray-700">Volver</a>
    @isset($btnNewCourt)
        <a href="{{ route('courts.create') }}" class="py-2.5 px-5 mr-2 mb-2
        text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border
        border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200
        dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white
        dark:hover:bg-gray-700">Crear Nuevo</a>
    @endisset
    <input type="submit" value="Guardar" class="text-white bg-blue-700 hover:bg-blue-800
    focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2
    dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
</div>
