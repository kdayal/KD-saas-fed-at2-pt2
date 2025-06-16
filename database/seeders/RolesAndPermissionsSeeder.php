<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;


class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create Permissions
        Permission::create(['name' => 'User-Browse']);
        Permission::create(['name' => 'User-Show']);
        Permission::create(['name' => 'User-Edit']);
        Permission::create(['name' => 'User-Add']);
        Permission::create(['name' => 'User-Delete']);
        Permission::create(['name' => 'User-Trash-Recover (one)']);
        Permission::create(['name' => 'User-Trash-Remove (one)']);
        Permission::create(['name' => 'User-Trash-Empty (all)']);
        Permission::create(['name' => 'User-Trash-Restore (all)']);

        Permission::create(['name' => 'Joke-Browse']);
        Permission::create(['name' => 'Joke-Show']);
        Permission::create(['name' => 'Joke-Edit']);
        Permission::create(['name' => 'Joke-Add']);
        Permission::create(['name' => 'Joke-Delete']);
        Permission::create(['name' => 'Joke-Trash-Recover (one)']);
        Permission::create(['name' => 'Joke -Trash-Remove (one)']);
        Permission::create(['name' => 'Joke -Trash-Empty (all)']);
        Permission::create(['name' => 'Joke -Trash-Restore (all)']);

        Permission::create(['name' => 'Roles & Permissions']);

        // Create Roles and Assign Permissions
        $adminRole = Role::create(['name' => 'Administrator']);
        $adminRole->givePermissionTo(Permission::all());

        $staffRole = Role::create(['name' => 'Staff']);
        $staffRole->givePermissionTo([
            'User-Browse', 'User-Show', 'User-Edit',
            'Joke-Browse', 'Joke-Show', 'Joke-Edit', 'Joke-Delete',  // Adjust as needed for "any client" & their own
            'Joke-Trash-Recover (one)', 'Joke -Trash-Remove (one)'
        ]);

        $clientRole = Role::create(['name' => 'Client']);
        $clientRole->givePermissionTo([
            'User-Show', 'User-Edit', 'User-Delete', // For their own profile
            'Joke-Browse', 'Joke-Show', 'Joke-Edit', 'Joke-Add', 'Joke-Delete',
            'Joke-Trash-Recover (one)', 'Joke -Trash-Remove (one)', // Own jokes
        ]);

        // Optionally, assign roles to initial users (e.g., Admin user)
        // Assuming you have a User with ID 1
        $adminUser = User::find(1); 
        if ($adminUser) {
            $adminUser->assignRole('Administrator');
        }
    }
}
