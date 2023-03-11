<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nuevo miembro') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="grid gap-4 mb-6 md:grid-cols-2">
                        <form action="{{ route('members.store') }}" method="POST">

                            @include('members._form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
