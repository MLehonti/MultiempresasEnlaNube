<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
            {{ __('Mis Planes de Cuentas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Contenedor para la tabla en una tarjeta -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <h3 class="text-xl font-bold mb-4">Vista del Plan de Cuentas</h3>

                <table class="min-w-full bg-white border w-full">
                    <thead>
                        <tr>
                           <!-- // <th class="py-2 px-4 border">ID</th> -->
                            <th class="py-2 px-4 border">Empresa</th>
                            <th class="py-2 px-4 border">Fecha</th>
                            <th class="py-2 px-4 border">Detalles (Cuentas Asociadas)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($planesDeCuentas as $plan)
                            <tr>
                                <!-- <td class="py-2 px-4 border">{{ $plan->id }}</td> -->
                                <td class="py-2 px-4 border">{{ $plan->empresa->nombre }}</td>
                                <td class="py-2 px-4 border">{{ $plan->fecha }}</td>
                                <td class="py-2 px-4 border">
                                    <table class="min-w-full bg-white border w-full">
                                        <thead>
                                            <tr>
                                                <th class="py-2 px-4 border">Código</th>
                                                <th class="py-2 px-4 border">Cuenta</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                // Definir el orden de los tipos de cuentas
                                                $codigoTipoCuenta = [
                                                    'activo_corriente' => 1,
                                                    'activo_no_corriente' => 2,
                                                    'pasivo_corriente' => 3,
                                                    'pasivo_no_corriente' => 4,
                                                    'patrimonio' => 5
                                                ];

                                                // Contadores para autoincrementar los números de subcuentas
                                                $contadores = [
                                                    'activo_corriente' => 1,
                                                    'activo_no_corriente' => 1,
                                                    'pasivo_corriente' => 1,
                                                    'pasivo_no_corriente' => 1,
                                                    'patrimonio' => 1
                                                ];

                                                // Títulos de los tipos de cuentas
                                                $titulosTipos = [
                                                    'activo_corriente' => '1 Activos Corrientes',
                                                    'activo_no_corriente' => '2 Activos No Corrientes',
                                                    'pasivo_corriente' => '3 Pasivos Corrientes',
                                                    'pasivo_no_corriente' => '4 Pasivos No Corrientes',
                                                    'patrimonio' => '5 Patrimonio'
                                                ];

                                                // Ordenar las cuentas por tipo
                                                $detallesOrdenados = $plan->detalles->sortBy(function($detalle) use ($codigoTipoCuenta) {
                                                    return $codigoTipoCuenta[$detalle->cuenta->tipo] ?? 999;
                                                });

                                                $tipoAnterior = null;
                                            @endphp

                                            @foreach ($detallesOrdenados as $detalle)
                                                @php
                                                    $tipoCuenta = $detalle->cuenta->tipo;

                                                    // Si el tipo de cuenta ha cambiado, mostrar el título correspondiente
                                                    if ($tipoCuenta !== $tipoAnterior) {
                                                        echo '<tr><td colspan="2" class="border px-4 py-2 font-bold">' . $titulosTipos[$tipoCuenta] . '</td></tr>';
                                                        $tipoAnterior = $tipoCuenta;
                                                    }

                                                    // Generar el código usando el tipo y su contador
                                                    $codigo = $codigoTipoCuenta[$tipoCuenta] . '.' . $contadores[$tipoCuenta];
                                                    $contadores[$tipoCuenta]++;
                                                @endphp
                                                <tr>
                                                    <td class="py-2 px-4 border">{{ $codigo }}</td>
                                                    <td class="py-2 px-4 border">{{ $detalle->cuenta->nombre }} ({{ $detalle->cuenta->tipo }})</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
