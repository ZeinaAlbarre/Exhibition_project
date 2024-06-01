<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesPremissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole=Role::create(['name'=>'admin']);
        $employeeRole=Role::create(['name'=>'employee']);
        $visitorRole=Role::create(['name'=>'visitor']);
        $companyRole=Role::create(['name'=>'company']);
        $organizerRole=Role::create(['name'=>'organizer']);

        $permissions=[
            'add.employee','delete.employee','add.exhibition','delete.exhibition','accept.exhibition','reject.exhibition','visitor.register','organizer.register',
            'add.organizer','delete.organizer','accept.company','reject.company','delete.account',
        ];

        foreach ($permissions as $permission){
            Permission::findOrCreate($permission,'web');
        }

        //Assign Pemissions to roles
        $adminRole->syncPermissions(['add.employee','delete.employee','accept.company','reject.company']);
        $employeeRole->givePermissionTo(['add.exhibition','accept.company','reject.company','delete.exhibition','accept.exhibition','reject.exhibition','update.exhibition']);
        $organizerRole->givePermissionTo(['add.exhibition','delete.account','update.exhibition']);
        $companyRole->givePermissionTo(['delete.account']);
        $visitorRole->givePermissionTo(['visitor.register','delete.account']);


        $adminUser=User::create([
            'name'=>'Admin User',
            'email'=>'adminuser@gmail.com',
            'phone'=>'0992501682',
            'password'=>bcrypt('admin1234'),
            'password_confirmation'=>bcrypt('password'),
        ]);
        $adminUser->assignRole($adminRole);
        $permissions=$adminRole->permissions()->pluck('name')->toArray();
        $adminUser->givePermissionTo($permissions);

    }
}
