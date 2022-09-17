<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FuncionarioIntervaloInicioPoligono extends Model
{
    use HasFactory;
    protected $fillable = ['inicio_id', 'poligono_id'];

    public function intervalo_inicio(){
        return $this->belongsTo(FuncionarioPontoFim::class, 'inicio_id');
    }

    public function poligono(){
        return $this->belongsTo(BatepontoPoligono::class, 'poligono_id');
    }
}
