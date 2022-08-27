<?php

namespace App\Http\Controllers\WebControllers\Funcionario;

use App\Http\Controllers\Controller;
use App\Models\EmpresaFuncionario;
use App\Models\FuncionarioPontoFim;
use App\Models\FuncionarioPontoInicio;
use Illuminate\Http\Request;

class FuncionarioPontoController extends Controller
{
    public function iniciar(Request $request)
    {
        $user = $request->user();
        /* $empresa_id = $request->empresa_id;

        $empresaFuncionario = EmpresaFuncionario::where('empresa_user_id', $empresa_id)->where('funcionario_user_id', $user->id)->first(); */

        $empresaFuncionario = EmpresaFuncionario::where('funcionario_user_id', $user->id)->first();

        try {
            $pontoInicio = FuncionarioPontoInicio::create(['empresa_funcionario_id' => $empresaFuncionario->id]);
            return response('Ponto iniciado!', 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function finalizar(Request $request)
    {
        $user = $request->user();
        /* $empresa_id = $request->empresa_id;

        $empresaFuncionario = EmpresaFuncionario::where('empresa_user_id', $empresa_id)->where('funcionario_user_id', $user->id)->first(); */

        $empresaFuncionario = EmpresaFuncionario::where('funcionario_user_id', $user->id)->first();

        try {
            $pontoInicio = FuncionarioPontoInicio::latest()->where('empresa_funcionario_id', $empresaFuncionario->id)->first();
            $pontoFim = FuncionarioPontoFim::create(['empresa_funcionario_id' => $empresaFuncionario->id, 'funcionario_ponto_inicio_id' => $pontoInicio->id]);
            return response('Ponto finalizado!', 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getStatusPonto(Request $request){
        $user = $request->user();

        $empresaFuncionario = EmpresaFuncionario::where('funcionario_user_id', $user->id)->first();

        try {
            return FuncionarioPontoInicio::with('funcionario_ponto_final', 'funcionario_ponto_pausa')->latest()->where('empresa_funcionario_id', $empresaFuncionario->id)->first();
        } catch (\Throwable $th) {
            throw $th;
        }
    }


}
