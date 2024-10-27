<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Supervisor extends Authenticatable
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'usuario';
    protected $fillable = [
        'nombre',
        'apellidos',
        'email',
        'password',
        'rol'
    ];

    public function getAuthPassword()
    {
        return $this->password;
    }
}
