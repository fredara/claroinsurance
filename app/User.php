<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    // 
    public function ciudad() {
        return $this->hasOne('App\Ciudad','idCiudades','idCiudades');
    }
}
