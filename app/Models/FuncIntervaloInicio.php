<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FuncIntervaloInicio extends Model
{
    use HasFactory;
    protected $fillable = ['empresa_funcionario_id', 'funcionario_ponto_inicio_id', 'funcionario_pausa_id'];

    public function empresa_funcionario(){
        return $this->belongsTo(EmpresaFuncionario::class, 'empresa_funcionario_id');
    }

    public function funcionario_ponto_inicio(){
        return $this->belongsTo(FuncionarioPontoInicio::class, 'funcionario_ponto_inicio_id');
    }

    public function func_intervalo_fim(){
        return $this->hasOne(FuncIntervaloFim::class, 'func_intervalo_inicio_id');
    }
}
