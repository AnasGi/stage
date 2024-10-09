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
            'name' => 'DAOUD ISSKELA',
            'password' => bcrypt('DAOUD ISSKELA'),
            'role' => 'responsable'
        ],
        [
            'name' => 'HALIMA OUIJANE',
            'password' => bcrypt('HALIMA OUIJANE'),
            'role' => 'responsable'
        ],
        [
            'name' => 'ZINEB ELKHOUDARI',
            'password' => bcrypt('ZINEB ELKHOUDARI'),
            'role' => 'responsable'
        ], 
        [
            'name' => 'FATIMA EZZAHRA AIT AHMED',
            'password' => bcrypt('FATIMA EZZAHRA AIT AHMED'),
            'role' => 'responsable'
        ],
        [
            'name' => 'NAJAT SAOUD',
            'password' => bcrypt('NAJAT SAOUD'),
            'role' => 'responsable'
        ],
        [
            'name' => 'AMINA',
            'password' => bcrypt('AMINA'),
            'role' => 'responsable'
        ],
        [
            'name' => 'BASMA',
            'password' => bcrypt('BASMA'),
            'role' => 'responsable'
        ],
        [
            'name' => 'RACHID NAAIMI',
            'password' => bcrypt('RACHID NAAIMI'),
            'role' => 'responsable'
        ],
        [
            'name' => 'MOHAMED ESSAID',
            'password' => bcrypt('MOHAMED ESSAID'),
            'role' => 'responsable'
        ],
        [
            'name' => 'MED EGHIZ',
            'password' => bcrypt('MED EGHIZ'),
            'role' => 'responsable'
        ],
        [
            'name' => 'KHAMISSA HDIMANE',
            'password' => bcrypt('KHAMISSA HDIMANE'),
            'role' => 'responsable'
        ],
        [
            'name' => 'FATIMA EZZAHRA JAIZI',
            'password' => bcrypt('FATIMA EZZAHRA JAIZI'),
            'role' => 'responsable'
        ],
        [
            'name' => 'Admin',
            'password' => bcrypt('Admin123'),
            'role' => 'Admin'
        ]
    ]);
    

}
}
