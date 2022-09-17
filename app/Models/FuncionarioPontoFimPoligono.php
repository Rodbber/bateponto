<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FuncionarioPontoFimPoligono extends Model
{
    use HasFactory;
    protected $fillable = ['fim_id', 'poligono_id'];

    public function ponto_fim(){
        return $this->belongsTo(FuncionarioPontoFim::class, 'fim_id');
    }

    public function poligono(){
        return $this->belongsTo(BatepontoPoligono::class, 'poligono_id');
    }
}
