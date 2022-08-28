<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FuncionarioPontosPoligono extends Model
{
    use HasFactory;
    protected $fillable = ['empresa_funcionario_id', 'poligono_id'];
    public function empresa_funcionario(){
        return $this->belongsTo(EmpresaFuncionario::class, 'empresa_funcionario_id');
    }
    public function poligono(){
        return $this->belongsTo(BatepontoPoligono::class, 'poligono_id');
    }
}
