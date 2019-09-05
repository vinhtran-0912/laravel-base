<?php

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();


        Role::create(['name' => 'member']);
        Role::create(['name' => 'admin']);

        $user = (User::class)::Where('email', 'user@sun-asterisk.com')->first();
        $user->assignRole(Role::ADMIN);

        /*
         * @var \App\Models\User $user
         */
        $admin = factory(\App\Models\User::class)->create([
            'name' => 'vim',
            'email' => 'admin@sun-asterisk.com',
            'password' => bcrypt('123123'),
        ]);

        $admin->assignRole('admin');

        $permissions = [
            'get_list_users',
            'create_user',
            'edit_user',
            'delete_user'
            ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        };

        //Assign permissions for admin.
        $admin->givePermissionTo($permissions);
    }
}
