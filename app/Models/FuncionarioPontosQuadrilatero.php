<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FuncionarioPontosQuadrilatero extends Model
{
    use HasFactory;
    protected $fillable = ['empresa_funcionario_id', 'quadrilatero_id'];
    public function empresa_funcionario(){
        return $this->belongsTo(EmpresaFuncionario::class, 'empresa_funcionario_id');
    }
    public function quadrilatero(){
        return $this->belongsTo(BatepontoQuadrilateros::class, 'quadrilatero_id');
    }
}
