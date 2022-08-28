<?php

namespace App\Http\Controllers\WebControllers\Empresa;

use App\Http\Controllers\Controller;
use App\Models\EmpresaFuncionario;
use App\Models\FuncionarioFuncao;
use App\Models\FuncionarioPausa;
use App\Models\FuncionarioPontosPoligono;
use App\Models\FuncionarioPontosQuadrilatero;
use App\Models\FuncionarioUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class FuncionarioUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function indexEmpresa()
    {
        $user = Auth::guard('empresa')->user();
        $id = $user->id;
        try {
            return EmpresaFuncionario::withTrashed()->with(['funcionario' => fn ($q) => $q->withTrashed()])->where('empresa_user_id', $id)->get();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $dadosValidadosUser = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email',
        ])->validated();

        $dadosValidadosFuncao = Validator::make($request->all(), [
            'funcao' => 'required|string',
            'inicio' => 'required|date_format:H:i',
            'fim' => 'required|date_format:H:i|after:inicio',
            'tolerancia' => 'required|numeric',
        ])->validated();

        $dadosValidadosPausas = Validator::make($request->all(), [
            'pausas' => 'array',
            'pausas.*.nome' => 'string',
            'pausas.*.horario' => 'date_format:H:i',
            'pausas.*.tempo' => 'numeric',
        ])->validated();

        $dadosValidadosPontos = Validator::make($request->all(), [
            'pontos' => 'required|array',
            'pontos.*.id' => 'required|numeric',
            'pontos.*.tipo' => 'required|string',
        ])->validated();

        //return $dadosValidadosPausas;

        $password = Str::random(6);

        $dadosValidadosUser['password'] = Hash::make($password);
        $user = Auth::guard('empresa')->user();
        $id = $user->id;
        DB::beginTransaction();
        try {
            $funcionario = FuncionarioUser::create($dadosValidadosUser);
            try {
                $empresaFuncionario = array('empresa_user_id' => $id, 'funcionario_user_id' => $funcionario->id);
                $empresaFuncionario = EmpresaFuncionario::create($empresaFuncionario);
                $dadosValidadosFuncao['empresa_funcionario_id'] = $empresaFuncionario->id;
                FuncionarioFuncao::create($dadosValidadosFuncao);
                foreach ($dadosValidadosPontos['pontos'] as $key => $value) {
                    //$value['empresa_funcionario_id'] = $empresaFuncionario->id;
                    if ($value['tipo'] == 'QUADRILATERO') {
                        FuncionarioPontosQuadrilatero::create([
                            'empresa_funcionario_id' => $empresaFuncionario->id,
                            'quadrilatero_id' => $value['id'],
                        ]);
                    } else {
                        FuncionarioPontosPoligono::create([
                            'empresa_funcionario_id' => $empresaFuncionario->id,
                            'poligono_id' => $value['id'],
                        ]);
                    }
                }
                if ($dadosValidadosPausas) {
                    foreach ($dadosValidadosPausas['pausas'] as $key => $value) {
                        $value['empresa_funcionario_id'] = $empresaFuncionario->id;
                        FuncionarioPausa::create($value);
                    }
                }
            } catch (\Throwable $th) {
                DB::rollBack();
                throw $th;
            }

            DB::commit();
            return response(['email' => $funcionario->email, 'pass' => $password], 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function redefinirSenha($id)
    {
        $password = Str::random(6);
        try {
            FuncionarioUser::find($id)->update(['password' => Hash::make($password)]);
            return response(['pass' => $password], 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
