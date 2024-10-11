<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CuentasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Lista de cuentas a insertar
        $cuentas = [
            ['nombre' => 'Caja', 'tipo' => 'activo_corriente'],
            ['nombre' => 'Bancos', 'tipo' => 'activo_corriente'],
            ['nombre' => 'Inventarios', 'tipo' => 'activo_corriente'],
            ['nombre' => 'Terreno', 'tipo' => 'activo_no_corriente'],
            ['nombre' => 'Edificio', 'tipo' => 'activo_no_corriente'],
            ['nombre' => 'Cuentas por pagar a proveedores', 'tipo' => 'pasivo_corriente'],
            ['nombre' => 'Préstamos bancarios a corto plazo', 'tipo' => 'pasivo_corriente'],
            ['nombre' => 'Préstamos bancarios a largo plazo', 'tipo' => 'pasivo_no_corriente'],
            ['nombre' => 'Capital Social', 'tipo' => 'patrimonio'],
        ];

        // Iterar sobre cada cuenta y crearla solo si no existe
        foreach ($cuentas as $cuenta) {
            DB::table('cuentas')->updateOrInsert(
                ['nombre' => $cuenta['nombre']], // Condición para verificar si ya existe
                [
                    'tipo' => $cuenta['tipo'], 
                    'created_at' => Carbon::now(), 
                    'updated_at' => Carbon::now()
                ]
            );
        }
    }
}
