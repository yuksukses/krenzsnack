<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([

            [
                'name' => 'Septiyan Dwi Nugroho',
                'email' => 'septiyandwinugroho98@gmail.com',
                'level'=>'admin',
                'password' => '$2y$10$v3r9Q6ABBgz0.vh9NhbhhOuWjVZ6RshGCV35fLgrbrAgzmwCLm79i',
            ],
            [
                'name' => 'Candra Novita',
                'email' => 'cnovita03@gmail.com',
                'level'=>'kasir',
                'password' => '$2y$10$v3r9Q6ABBgz0.vh9NhbhhOuWjVZ6RshGCV35fLgrbrAgzmwCLm79i',
            ],

        ]);
    }
}
