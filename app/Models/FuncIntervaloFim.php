<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FuncIntervaloFim extends Model
{
    use HasFactory;
    protected $table = 'func_intervalo_fins';
    protected $fillable = ['empresa_funcionario_id', 'func_intervalo_inicio_id'];

    public function empresa_funcionario(){
        return $this->belongsTo(EmpresaFuncionario::class, 'empresa_funcionario_id');
    }

    public function func_intervalo_inicio(){
        return $this->belongsTo(FuncIntervaloInicio::class, 'func_intervalo_inicio_id');
    }
}
