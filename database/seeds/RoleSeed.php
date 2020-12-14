<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::create(['name' => 'administrator']);
        $role->givePermissionTo(['users_manage', 'dashboard_only']);

        $role = Role::create(['name' => 'controller']);
        $role->givePermissionTo('dashboard_only');
    }
}
