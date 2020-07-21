<?php

use App\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $developer = new Role();
        $developer->name = 'developer';
        $developer->slug = 'developer';
        $developer->save();

        $manager = new Role();
        $manager->name = 'admin';
        $manager->slug = 'admin';
        $manager->save();

        $developer = new Role();
        $developer->name = 'content';
        $developer->slug = 'content';
        $developer->save();
    }
}
