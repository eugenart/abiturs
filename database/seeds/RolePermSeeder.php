<?php

use App\Permission;
use App\Role;
use Illuminate\Database\Seeder;

class RolePermSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $developer = Role::where('slug','developer')->first();
        $admin = Role::where('slug','admin')->first();
        $content = Role::where('slug', 'content')->first();
        $all = Permission::where('slug','all-permissions')->first();
        $content_perm = Permission::where('slug','content')->first();


        $developer->permissions()->attach($all);
        $admin->permissions()->attach($all);
        $content->permissions()->attach($content_perm);
    }
}
