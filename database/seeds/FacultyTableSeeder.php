<?php

use Illuminate\Database\Seeder;

class FacultyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('faculties')->where('facultyId', '000000003')->update(['link' => 'https://www.mrsu.ru/ru/i_faculty/detail.php?ID=3483']);//Аграрный институт
        DB::table('faculties')->where('facultyId', '000000004')->update(['link' => 'http://www.isi.mrsu.ru/']);//Историко-социологический институт
        DB::table('faculties')->where('facultyId', '000000005')->update(['link' => 'http://phys-chem.mrsu.ru/']);//Институт физики и химии
        DB::table('faculties')->where('facultyId', '000000006')->update(['link' => 'https://www.mrsu.ru/ru/i_faculty/detail.php?ID=2492']);//Институт механики и энергетики
        DB::table('faculties')->where('facultyId', '000000007')->update(['link' => 'https://www.mrsu.ru/ru/i_faculty/detail.php?ID=3493']);//Медицинский институт
        DB::table('faculties')->where('facultyId', '000000008')->update(['link' => 'http://ink.mrsu.ru/']);//Институт национальной культуры
        DB::table('faculties')->where('facultyId', '000000009')->update(['link' => 'http://asf.mrsu.ru/']);//Архитектурно-строительный факультет
        DB::table('faculties')->where('facultyId', '000000010')->update(['link' => 'http://bio.mrsu.ru/ru/']);//Факультет биотехнологии и биологии
        DB::table('faculties')->where('facultyId', '000000011')->update(['link' => 'http://geo.mrsu.ru/']);//Географический факультет
        DB::table('faculties')->where('facultyId', '000000012')->update(['link' => 'http://www.math.mrsu.ru/']);//Факультет математики и информационных технологий
        DB::table('faculties')->where('facultyId', '000000013')->update(['link' => '']);//Светотехнический факультет
        DB::table('faculties')->where('facultyId', '000000014')->update(['link' => 'http://filfak.mrsu.ru']);//Филологический факультет
        DB::table('faculties')->where('facultyId', '000000015')->update(['link' => 'http://www.fld.mrsu.ru/']);//Факультет иностранных языков
        DB::table('faculties')->where('facultyId', '000000016')->update(['link' => 'http://economist.mrsu.ru']);//Экономический факультет
        DB::table('faculties')->where('facultyId', '000000017')->update(['link' => '']);//Факультет электронной техники
        DB::table('faculties')->where('facultyId', '000000018')->update(['link' => 'http://urf.mrsu.ru']);//Юридический факультет
        DB::table('faculties')->where('facultyId', '000000019')->update(['link' => 'http://rim.mrsu.ru']);//Рузаевский институт машиностроения'
        DB::table('faculties')->where('facultyId', '000000020')->update(['link' => 'http://www.kf.mrsu.ru/']);//Ковылкинский филиал
        DB::table('faculties')->where('facultyId', '000000021')->update(['link' => 'http://fdp.mrsu.ru/']);//Факультет довузовской подготовки и среднего профессионального образования
        DB::table('faculties')->where('facultyId', '000000022')->update(['link' => 'https://www.mrsu.ru/ru/ido/']);//Факультет дополнительного образования
        DB::table('faculties')->where('facultyId', '000000023')->update(['link' => 'http://ink.mrsu.ru/']);//Институт национальной культуры (СПО)
        DB::table('faculties')->where('facultyId', '000000024')->update(['link' => 'http://rim.mrsu.ru']);//Рузаевский институт машиностроения (СПО)
        DB::table('faculties')->where('facultyId', '000000025')->update(['link' => 'http://www.kf.mrsu.ru/']);//Ковылкинский филиал (СПО)
        DB::table('faculties')->where('facultyId', '000000026')->update(['link' => '']);//Аспирантура
        DB::table('faculties')->where('facultyId', '000000027')->update(['link' => '']);//Ординатура
        DB::table('faculties')->where('facultyId', '000000166')->update(['link' => 'http://ies.mrsu.ru/']);//Институт электроники и светотехники
        DB::table('faculties')->where('facultyId', '000001189')->update(['link' => '']);//Подготовительный факультет


    }
}
