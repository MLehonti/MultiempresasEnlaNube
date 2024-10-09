<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rubro;
use App\Models\Empresa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class EmpresaController extends Controller
{



     // Método para mostrar todas las empresas
     public function index()
     {
         // Obtener todas las empresas del sistema
         $empresas = Empresa::with('rubro', 'user')->get();
 
         // Retornar la vista con las empresas
         return view('empresa.index', compact('empresas'));
     }


    public function create()
    {
        try {
            $user = Auth::user();
            $empresa = Empresa::where('user_id', $user->id)->first();

            if ($empresa) {
                return redirect()->route('empresa.show', ['empresa' => $empresa->id]);
            }

            $rubros = Rubro::all();
            return view('empresa.create', compact('rubros'));
        } catch (\Exception $e) {
            Log::error('Error al obtener los rubros: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al cargar la vista de creación de empresa.');
        }
    }

    public function store(Request $request)
    {
        try {
            $user = Auth::user();
            $empresaExistente = Empresa::where('user_id', $user->id)->first();

            if ($empresaExistente) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ya has creado una empresa.'
                ], 400);
            }

            $request->validate([
                'nombre' => 'required|string|max:255',
                'rubro_id' => 'required|exists:rubros,id',
            ]);

            $empresa = Empresa::create([
                'nombre' => $request->nombre,
                'rubro_id' => $request->rubro_id,
                'user_id' => $user->id,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Empresa creada correctamente.',
                'empresa' => $empresa,
                'redirect' => route('empresa.show', ['empresa' => $empresa->id])
            ]);
        } catch (\Exception $e) {
            Log::error('Error al crear la empresa: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al crear la empresa: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show(Empresa $empresa)
    {
        if (Auth::user()->id !== $empresa->user_id) {
            abort(403, 'No tienes permisos para ver esta empresa.');
        }

        return view('empresa.show', compact('empresa'));
    }

    // Método para eliminar la empresa
    public function destroy(Empresa $empresa)
    {
        try {
            if (Auth::user()->id !== $empresa->user_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'No tienes permisos para eliminar esta empresa.'
                ], 403);
            }

            // Eliminar la empresa y todos los datos relacionados (si aplica)
            $empresa->delete();

            return response()->json([
                'success' => true,
                'message' => 'Empresa eliminada correctamente.'
            ]);
        } catch (\Exception $e) {
            Log::error('Error al eliminar la empresa: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar la empresa: ' . $e->getMessage()
            ], 500);
        }
    }
}

