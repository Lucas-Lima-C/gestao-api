<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rows = [
            [
                'name' => 'Lucas Lima do Couto',
                'email' => 'lucas.lima.c@outlook.com',
                'photo' => 'user/1/perfil.png',
                'password' => 'password'
            ]
        ];

        foreach ($rows as $row) {
            if(!User::find(1) && !$exists = User::where('email', $row['email'])->first()){
                $exists = User::where('email', $row['email'])->first();
                if ($exists) {
                    $exists->update($row);
                    continue;
                }
                User::create($row);
            }
        }
    }
}
