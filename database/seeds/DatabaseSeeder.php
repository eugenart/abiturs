<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call('FacultyTableSeeder');

        $this->command->info('Ссылки на факультеты выруженны!');

        //$this->call('SubjectTableSeeder');

        //$this->command->info('Таблица предметов загружена данными!');

    }
}
