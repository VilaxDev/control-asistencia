<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoColaborador extends Model
{
    use HasFactory;
    protected $table = 'tipo_colaborador';
    public $timestamps = false;
}
