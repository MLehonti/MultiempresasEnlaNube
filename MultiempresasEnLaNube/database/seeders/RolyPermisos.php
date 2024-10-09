<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolyPermisos extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role1 = Role::create(['name'=>'admin']);
        $role2 = Role::create(['name'=>'cliente']);



        //permisos para el rol adminitrador
        Permission::create(['name'=>'users.index'])->syncRoles($role1);
        Permission::create(['name'=>'users.destroy'])->syncRoles($role1);
        Permission::create(['name'=>'empresas.index'])->syncRoles(($role1));

        //Permission::create(['name'=>'users.edit'])->syncRoles($role1);
        
    



    }
}
