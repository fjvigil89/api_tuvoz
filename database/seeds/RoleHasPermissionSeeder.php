<?php

use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Http\Resources\Resource;

class RoleHasPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $this->createAdminRolePermissions();
        $this->createSpecialistRolePermissions();
        $this->createGuestRolePermissions();
        
    }

    private function createAdminRolePermissions()
    {
        $role = Role::findByName('Admin');
        $role->syncPermissions(Permission::all());
    }

    /**
     * Creates the permissions for the role Specialist
     */
    private function createSpecialistRolePermissions()
    {
        $role = Role::findByName('Specialist');
        $role->syncPermissions(Permission::where('name', Resource::TREATMENT)->first());
    }

    /**
     * Creates the permissions for the role Guest
     */
    private function createGuestRolePermissions()
    {
        $role = Role::findByName('Guest');
        $role->syncPermissions(Permission::where('name', Resource::GUEST)->first());
    }
}
