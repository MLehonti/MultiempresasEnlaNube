<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    // Obtener todos los usuarios en formato JSON
   // UserController.php
    public function index(Request $request)
    {
        // Obtener todos los usuarios
        $users = User::all();

        // Si la solicitud es AJAX (usada en fetch), devolver el JSON
        if ($request->ajax()) {
            return response()->json($users);
        }

        // Si no es una solicitud AJAX, retornar la vista
        return view('users.index', compact('users'));
    }


    // Obtener un usuario específico en formato JSON
    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user); // Retornar el usuario en formato JSON
    }

    // Actualizar el usuario y retornar la respuesta en JSON
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');

        if ($request->filled('password')) {
            $user->password = bcrypt($request->input('password'));
        }

        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Usuario actualizado correctamente',
            'user' => $user
        ]); // Retornar la respuesta en formato JSON
    }

    // Eliminar el usuario y retornar la respuesta en JSON
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'Usuario eliminado correctamente'
        ]); // Retornar la respuesta en formato JSON
    }
}
