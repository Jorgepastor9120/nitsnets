<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Miembros') }}
            <a class="text-xs bg-blue-700 text-white rounded px-2 py-1"
            href="{{ route('members.create') }}">Nuevo miembro</a>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400"
                aria-labelledby="Tabla de miembros">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">Nombre</th>
                                <th scope="col" class="px-6 py-3">Email</th>
                                <th scope="col" class="px-6 py-3">Activo desde</th>
                                <th scope="col" class="px-6 py-3">#</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($members as $member)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700
                        hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="px-6 py-4">
                                <a href="{{ route('members.edit', $member) }}">{{ $member->name }}</a>
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('members.edit', $member) }}">{{ $member->email }}</a>
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('members.edit', $member) }}">
                                    {{ optional($member->created_at)->format('d/m/Y') }}
                                </a>
                            </td>
                            <td class="px-6 py-4">
                            
                            <div>
                                <button id="MenuAccionesMember" data-dropdown-toggle="AccionesMember{{ $member->id }}"
                                class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-900
                                bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none dark:text-white
                                focus:ring-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                                type="button">
                                    <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0
                                     110-4 2 2 0 010 4z"></path></svg>
                                </button>
                                <div id="AccionesMember{{ $member->id }}" class="z-10 hidden bg-white divide-y
                                divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                                    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200"
                                    aria-labelledby="MenuAccionesMember">
                                        <li>
                                            <a href="{{ route('members.edit', $member) }}"
                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600
                                            dark:hover:text-white">Ver</a>
                                        </li>
                                    </ul>
                                    <div class="py-1">
                                        <form action="{{ route('members.destroy', $member) }}" method="POST">
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
                    {{ $members->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
