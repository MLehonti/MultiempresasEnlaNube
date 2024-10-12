<x-app-layout>



    @section('content')
    <div class="container">
        <h1>Mis Planes de Cuentas</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Empresa</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($planesDeCuentas as $plan)
                    <tr>
                        <td>{{ $plan->id }}</td>
                        <td>{{ $plan->empresa->nombre }}</td>
                        <td>{{ $plan->fecha }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    </x-app-layout>
