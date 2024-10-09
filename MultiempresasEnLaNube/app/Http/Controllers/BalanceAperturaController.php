<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BalanceApertura;
use App\Models\DetalleBalance;
use App\Models\Cuenta;
use App\Models\Empresa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; // Asegúrate de importar Log

class BalanceAperturaController extends Controller
{
    public function create($empresa_id)
    {
        $empresa = Empresa::findOrFail($empresa_id);

        // Verificar que la empresa pertenezca al usuario logueado
        if (Auth::user()->id !== $empresa->user_id) {
            abort(403, 'No tienes permiso para ver esta empresa.');
        }

        $cuentas = Cuenta::all();
        return view('empresa.balance_create', compact('empresa', 'cuentas'));
    }
 


    public function store(Request $request)
    {
        try {
            // Verificar los datos recibidos
            Log::info('Datos recibidos en la solicitud: ' . json_encode($request->all()));

            // Validar la solicitud
            $request->validate([
                'empresa_id' => 'required|exists:empresas,id',
                'detalles' => 'required|array',
                'detalles.*.cuenta_id' => 'required|exists:cuentas,id',
                'detalles.*.debe' => 'nullable|numeric|min:0',
                'detalles.*.haber' => 'nullable|numeric|min:0',
            ]);

            Log::info('Validación de la solicitud exitosa');

            // Crear el balance de apertura
            $balance = BalanceApertura::create([
                'empresa_id' => $request->empresa_id,
                'fecha' => now(),
            ]);

            Log::info('Balance de apertura creado: ' . $balance->id);

            // Verificar que detalles no esté vacío y sea un array
            if (is_array($request->detalles)) {
                foreach ($request->detalles as $detalle) {
                    DetalleBalance::create([
                        'balance_id' => $balance->id,
                        'cuenta_id' => $detalle['cuenta_id'],
                        'debe' => $detalle['debe'] ?? 0,
                        'haber' => $detalle['haber'] ?? 0,
                    ]);
                }
            } else {
                Log::error('Detalles de balance no proporcionados o formato incorrecto.');
                return response()->json(['success' => false, 'message' => 'Detalles de balance no proporcionados o formato incorrecto.'], 400);
            }

            return response()->json(['success' => true, 'message' => 'Balance de apertura creado correctamente']);
        } catch (\Exception $e) {
            Log::error('Error al crear el balance de apertura: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error al crear el balance de apertura: ' . $e->getMessage()], 500);
        }
    }


    public function show($empresa_id)
    {
        // Verifica que la empresa pertenezca al usuario autenticado
        $empresa = Empresa::where('id', $empresa_id)->where('user_id', Auth::user()->id)->firstOrFail();

        // Cargar el balance con los detalles y las cuentas asociadas utilizando with
        $balance = BalanceApertura::where('empresa_id', $empresa->id)
                    ->with(['detalles.cuenta']) // Cargar la relación 'detalles' y 'cuenta' en una sola consulta
                    ->first();

        // Verificar si la relación 'cuenta' está cargada correctamente
        foreach ($balance->detalles as $detalle) {
            if (!$detalle->relationLoaded('cuenta')) {
                Log::error('Relación cuenta no cargada para detalle con id: ' . $detalle->id);
            }
        }

        // Mostrar balance y detalles en la vista para depurar
        return view('empresa.balance_show', compact('empresa', 'balance'));
    }






}
