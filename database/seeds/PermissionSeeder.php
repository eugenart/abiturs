<?php

use App\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $manageUser = new Permission();
        $manageUser->name = 'all';
        $manageUser->slug = 'all';
        $manageUser->save();

        $createTasks = new Permission();
        $createTasks->name = 'content';
        $createTasks->slug = 'content';
        $createTasks->save();
    }
}
