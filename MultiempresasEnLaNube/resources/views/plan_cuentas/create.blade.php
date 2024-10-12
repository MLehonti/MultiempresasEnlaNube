<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
            {{ __('Crear Plan de Cuentas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <form action="{{ route('plan-cuentas.store') }}" method="POST">
                    @csrf

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="form-group">
                        <label for="empresa_id">Empresa:</label>
                        <select name="empresa_id" id="empresa_id" class="form-control">
                            <option value="{{ $empresa->id }}">{{ $empresa->nombre }}</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="cuentas">Selecciona las cuentas:</label>
                        <ul>
                            @foreach ($cuentas as $cuenta)
                                <li>
                                    <input type="checkbox" name="cuentas_seleccionadas[]" value="{{ $cuenta->id }}">
                                    {{ $cuenta->nombre }} ({{ $cuenta->tipo }})
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <button type="submit" class="btn btn-primary">Crear Plan de Cuentas</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
