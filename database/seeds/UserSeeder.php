<?php

use App\Permission;
use App\Role;
use App\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
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


        $admin1 = User::where('name', 'Kirdyashkina Elina')->first();
        $admin1->roles()->attach($developer);
        $admin1->roles()->attach($admin);
        $admin1->permissions()->attach($all);

        $admin2 = User::where('name', 'Евгений Конаков')->first();
        $admin2->roles()->attach($admin);
        $admin2->permissions()->attach($all);

        $user1 = User::where('name', 'postgrad')->first();
        $user1->roles()->attach($content);
        $user1->permissions()->attach($content_perm);

        $user2 = User::where('name', 'УМС')->first();
        $user2->roles()->attach($content);
        $user2->permissions()->attach($content_perm);
    }
}
