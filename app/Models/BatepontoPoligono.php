<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BatepontoPoligono extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['empresa_user_id', 'nome', 'pontos'];
    public function empresa(){
        return $this->belongsTo(EmpresaUsers::class, 'empresa_user_id');
    }
}
