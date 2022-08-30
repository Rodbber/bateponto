<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FuncionarioPausa extends Model
{
    use HasFactory;
    protected $fillable = ['empresa_funcionario_id', 'nome', 'horario', 'tempo'];

    public function empresa_funcionario(){
        return $this->belongsTo(EmpresaFuncionario::class, 'empresa_funcionario_id');
    }
}
