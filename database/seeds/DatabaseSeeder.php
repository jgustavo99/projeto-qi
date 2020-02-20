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
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $this->call(StatesTableSeeder::class);
        $this->call(CitiesTableSeeder::class);

        \App\Models\Admin::create([
            'email' => 'joaogustavo.b@hotmail.com',
            'password' => Hash::make('123456'),
            'name' => 'Administrador'
        ]);

        //$this->call(UserSeeder::class);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
