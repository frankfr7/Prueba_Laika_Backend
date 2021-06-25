<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipo_documento extends Model
{
    protected $table = 'tipo_documento';

    // Relacion de uno a muchos
    public function users(){
        return $this->hasMany('App\Models\User');
    }

    use HasFactory;
}
