<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class Usuario extends Authenticatable
{
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
