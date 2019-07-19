<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('users')->delete();
        
        \DB::table('users')->insert(array (
            0 => 
            array (
                'id' => 18,
                'name' => 'teste 2',
                'email' => 'teste2@teste.com',
                'password' => '$2y$10$NqWrg1.PuUg6QTyTdtbzqebv7MaEU.ENpZ.FntK2LaDfTXdib6Hdy',
                'type' => 'user',
                'bio' => NULL,
                'photo' => NULL,
                'email_verified_at' => NULL,
                'remember_token' => NULL,
                'created_at' => '2019-04-27 14:56:37',
                'updated_at' => '2019-04-27 20:53:22',
            ),
            1 => 
            array (
                'id' => 19,
                'name' => 'teste 3',
                'email' => 'teste3@teste.com',
                'password' => '$2y$10$aIiYeXqd5x.rAR3cwpOSSOO7fRJ..qYcglXjS4t00pGZZFukOeMRC',
                'type' => 'user',
                'bio' => NULL,
                'photo' => NULL,
                'email_verified_at' => NULL,
                'remember_token' => NULL,
                'created_at' => '2019-04-29 16:35:41',
                'updated_at' => '2019-04-29 16:35:41',
            ),
            2 => 
            array (
                'id' => 1,
                'name' => 'Máximo Henrique',
                'email' => 'maxmonteiro86@gmail.com',
                'password' => '$2y$10$BwxEGMTRCx.NgMAcvr9kv.MaYKM3L9xtudaZQUjZkugh63BkqCpSu',
                'type' => 'admin',
                'bio' => NULL,
                'photo' => '1562863653.jpeg',
                'email_verified_at' => NULL,
                'remember_token' => 'lUBS2VpjZgH70vvsNe8h7s0SVC8GYuIm1EC3iUOmORKZWevoVsjc0g7ovYpK',
                'created_at' => '2019-04-23 15:15:15',
                'updated_at' => '2019-07-12 16:07:53',
            ),
        ));
        
        
    }
}