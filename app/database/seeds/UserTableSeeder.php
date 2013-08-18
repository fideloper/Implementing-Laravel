<?php

class UserTableSeeder extends Seeder {

    public function run()
    {
        DB::table('users')->delete();

        User::create(array(
            'email' => 'fideloper@example.com',
            'password' => Hash::make('password')
        ));
    }

}