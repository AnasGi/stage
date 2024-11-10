<?php

namespace Database\Seeders;

use App\Models\User;
use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class usersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    // Insert multiple records using create
    DB::table('users')->insert([
        [
            'name' => 'DAOUD',
            'password' => bcrypt('DAOUD'),
            'passwordText' => 'DAOUD',
            'role' => 'responsable'
        ],
        [
            'name' => 'ZINEB',
            'password' => bcrypt('ZINEB'),
            'passwordText' => 'ZINEB',
            'role' => 'responsable'
        ], 
        [
            'name' => 'BASMA',
            'password' => bcrypt('BASMA'),
            'passwordText' => 'BASMA',
            'role' => 'responsable'
        ],
        [
            'name' => 'SANAA',
            'password' => bcrypt('SANAA'),
            'passwordText' => 'SANAA',
            'role' => 'responsable'
        ],
        [
            'name' => 'MOURAD',
            'password' => bcrypt('MOURAD'),
            'passwordText' => 'MOURAD',
            'role' => 'responsable'
        ],
        [
            'name' => 'HANAN',
            'password' => bcrypt('HANAN'),
            'passwordText' => 'HANAN',
            'role' => 'responsable'
        ],
        [
            'name' => 'ISMAIL',
            'password' => bcrypt('ISMAIL'),
            'passwordText' => 'ISMAIL',
            'role' => 'responsable'
        ],
        [
            'name' => 'KHAMISSA',
            'password' => bcrypt('KHAMISSA'),
            'passwordText' =>'KHAMISSA',
            'role' => 'responsable'
        ],
        [
            'name' => 'FATIMA EZZAHRA JAIZI',
            'password' => bcrypt('FATIMA EZZAHRA JAIZI'),
            'passwordText' => 'FATIMA EZZAHRA JAIZI',
            'role' => 'responsable'
        ],
        [
            'name' => 'NAJAT',
            'password' => bcrypt('Admin123'),
            'passwordText' => 'Admin123',
            'role' => 'Admin'
        ]
    ]);
    

}
}
