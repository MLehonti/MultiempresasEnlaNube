{{-- resources/views/empresa/balance_show.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
            {{ __('Balance de Apertura de ') . $empresa->nombre }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="text-xl font-bold mb-4 text-center">Balance de Apertura</h3>

                @if($balance)
                    <!-- Contenedor para centrar la tabla -->
                    <div class="flex justify-center">
                        <!-- Tabla de balance de apertura con ancho completo -->
                        <table class="min-w-full bg-white border w-full">
                            <thead>
                                <tr>
                                    <th class="py-2 px-4 border text-left">Cuenta</th>
                                    <th class="py-2 px-4 border text-left">Debe</th>
                                    <th class="py-2 px-4 border text-left">Haber</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($balance->detalles as $detalle)
                                    <tr>
                                        <td class="py-2 px-4 border text-left">{{ $detalle->cuenta->nombre }}</td>
                                        <td class="py-2 px-4 border text-left">{{ number_format($detalle->debe, 2) }}</td>
                                        <td class="py-2 px-4 border text-left">{{ number_format($detalle->haber, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-center">No hay balance de apertura registrado para esta empresa.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
