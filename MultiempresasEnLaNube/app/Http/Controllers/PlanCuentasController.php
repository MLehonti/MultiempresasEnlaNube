<?php

namespace App\Http\Controllers;

use App\Models\Cuenta;
use App\Models\PlanCuenta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use app\Models\Empresa;
use Illuminate\Support\Facades\Log; // Asegúrate de importar Log


class PlanCuentasController extends Controller
{
    // Mostrar todas las cuentas y permitir al usuario seleccionar para el plan de cuentas
    public function create()
    {
        // $cuentas = Cuenta::all();
        // return view('plan_cuentas.create', compact('cuentas'));

       // Obtener la empresa asociada al usuario logueado
       $empresa = Auth::user()->empresa; // Acceder a la empresa del usuario

       // Obtener todas las cuentas
       $cuentas = Cuenta::all();

       // Pasar la empresa a la vista
       return view('plan_cuentas.create', compact('empresa', 'cuentas'));
    }

    // Guardar el plan de cuentas
    public function store(Request $request)
    {
        $request->validate([
            'empresa_id' => 'required|exists:empresas,id',
            'cuentas_seleccionadas' => 'required|array',
            'cuentas_seleccionadas.*' => 'exists:cuentas,id',
        ]);

        // Depurar las cuentas seleccionadas
        Log::info("Cuentas seleccionadas: ", $request->cuentas_seleccionadas);

        // Crear el plan de cuentas asociado al usuario logueado
        $planCuenta = PlanCuenta::create([
            'empresa_id' => $request->empresa_id,
            'fecha' => now(),
            'user_id' => Auth::id(),
        ]);

        // Guardar las cuentas seleccionadas como detalles del plan de cuentas
        foreach (array_unique($request->cuentas_seleccionadas) as $cuentaId) { // Usar array_unique para evitar duplicados
            $planCuenta->detalles()->create([
                'cuenta_id' => $cuentaId,
            ]);
        }

        return redirect()->route('plan-cuentas.index')->with('success', 'Plan de cuentas creado correctamente.');
    }

    // Mostrar los planes de cuentas del usuario logueado
    public function index()
    {
        $planesDeCuentas = PlanCuenta::where('user_id', Auth::id())->get();
        return view('plan_cuentas.index', compact('planesDeCuentas'));
    }
}

