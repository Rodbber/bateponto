<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FuncionarioPontoInicio extends Model
{
    use HasFactory;
    protected $fillable = ['empresa_funcionario_id'];

    public function empresa_funcionario(){
        return $this->belongsTo(EmpresaFuncionario::class, 'empresa_funcionario_id');
    }

    public function funcionario_ponto_final(){
        return $this->hasOne(FuncionarioPontoFim::class, 'funcionario_ponto_inicio_id');
    }

    public function func_intervalo_inicio(){
        return $this->hasMany(FuncIntervaloInicio::class, 'funcionario_ponto_inicio_id');
    }



    /* public function func_intervalo_fim(){
        return $this->hasOne(FuncIntervaloFim::class, 'funcionario_ponto_inicio_id');
    } */
}
