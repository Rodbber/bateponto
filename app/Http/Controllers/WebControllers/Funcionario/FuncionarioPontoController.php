<?php

namespace App\Http\Controllers\WebControllers\Funcionario;

use App\Http\Controllers\Controller;
use App\Models\EmpresaFuncionario;
use App\Models\FuncIntervaloFim;
use App\Models\FuncIntervaloInicio;
use App\Models\FuncionarioFuncao;
use App\Models\FuncionarioPausa;
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
            return response(['message' => 'Ponto iniciado.'], 200);
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
            return response(['message' => 'Ponto finalizado.'], 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getStatusPonto(Request $request)
    {
        $user = $request->user();
        $empresaFuncionario = EmpresaFuncionario::where('funcionario_user_id', $user->id)->first();

        try {
            $funcoes = FuncionarioFuncao::where('empresa_funcionario_id', $empresaFuncionario->id)->get();
            $intervalos = FuncionarioPausa::where('empresa_funcionario_id', $empresaFuncionario->id)->get();
            $statusPontos = FuncionarioPontoInicio::with('funcionario_ponto_final', 'func_intervalo_inicio.func_intervalo_fim')->latest()->where('empresa_funcionario_id', $empresaFuncionario->id)->first();
            return [
                'funcoes' => $funcoes,
                'intervalos' => $intervalos,
                'ponto' => $statusPontos,
            ];
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function pausaInicio(Request $request)
    {
        $user = $request->user();
        $empresaFuncionario = EmpresaFuncionario::where('funcionario_user_id', $user->id)->first();

        //return $request->all();

        try {
            $intervaloInicio = FuncIntervaloInicio::create([
                'empresa_funcionario_id' => $empresaFuncionario->id,
                'funcionario_ponto_inicio_id' => $request->funcionario_ponto_inicio_id,
                'funcionario_pausa_id' => $request->funcionario_pausa_id
            ]);
            return response(['message' => 'Intervalo iniciado.', 'intervalo_id' => $intervaloInicio->id], 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function pausaFim(Request $request)
    {
        $user = $request->user();
        $empresaFuncionario = EmpresaFuncionario::where('funcionario_user_id', $user->id)->first();

        try {
            $intervaloFim = FuncIntervaloFim::create([
                'empresa_funcionario_id' => $empresaFuncionario->id,
                'func_intervalo_inicio_id' => $request->func_intervalo_inicio_id
            ]);
            return response(['message' => 'Intervalo finalizado.'], 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
