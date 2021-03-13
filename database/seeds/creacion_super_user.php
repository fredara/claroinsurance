<?php

use Illuminate\Database\Seeder;

class creacion_super_user extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Carga del User Administrador a la base de datos desde seed
        \DB::table('users')->insert(array(
           'email' => 'fredaravagmail.com',
           'password'  => bcrypt('123456789'),
           'name'  => 'Freddy',
           'last_name'  => 'Ramirez',
           'phone'  => '4129322986',
           'document_id'  => '25913861',
           'fecha_nacimiento'  => '1997-02-22',
           'created_at' => date('Y-m-d H:m:s'),
           'updated_at' => date('Y-m-d H:m:s')
    ));
    }
}
