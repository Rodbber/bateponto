<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BatepontoQuadrilateros extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['empresa_id', 'nome', 'pontos'];
}
