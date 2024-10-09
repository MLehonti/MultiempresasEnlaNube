{{-- resources/views/empresas/index.blade.php --}}
@role('admin')
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Lista de Empresas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <!-- Tabla para mostrar todas las empresas ocupando el 100% de la tarjeta -->
                <table class="w-full bg-white border"> <!-- Cambié min-w-full a w-full para ocupar todo el ancho -->
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border">ID</th>
                            <th class="py-2 px-4 border">Nombre</th>
                            <th class="py-2 px-4 border">Rubro</th>
                            <th class="py-2 px-4 border">Propietario</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($empresas as $empresa)
                            <tr>
                                <td class="border px-4 py-2">{{ $empresa->id }}</td>
                                <td class="border px-4 py-2">{{ $empresa->nombre }}</td>
                                <td class="border px-4 py-2">{{ $empresa->rubro->nombre }}</td>
                                <td class="border px-4 py-2">{{ $empresa->user->name }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
@endrole
