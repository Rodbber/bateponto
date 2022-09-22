<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FuncionarioFuncao extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "funcionario_funcoes";
    protected $fillable = ['empresa_funcionario_id', 'funcao', 'inicio', 'tolerancia', 'fim'];

    public function empresa_funcionario(){
        return $this->belongsTo(EmpresaFuncionario::class, 'empresa_funcionario_id');
    }

}
