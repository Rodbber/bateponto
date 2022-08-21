<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmpresaFuncionario extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['empresa_user_id', 'funcionario_user_id'];

    public function empresa(){
        return $this->belongsTo(EmpresaUsers::class, 'empresa_user_id');
    }

    public function funcionario(){
        return $this->belongsTo(FuncionarioUser::class, 'funcionario_user_id');
    }
}
