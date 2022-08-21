<?php

namespace App\Http\Controllers\WebControllers\Empresa;

use App\Http\Controllers\Controller;
use App\Models\EmpresaFuncionario;
use App\Models\FuncionarioFuncao;
use App\Models\FuncionarioUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            return EmpresaFuncionario::withTrashed()->with(['funcionario' => fn($q) => $q->withTrashed()])->where('empresa_user_id', $id)->get();
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

        /* $dadosValidadosFuncao = Validator::make($request->all(), [
            'funcao' => 'required|string',
            'comeco' => 'required|date_format:H:i',
            'fim' => 'required|date_format:H:i|after:comeco',
        ])->validated(); */

        $password = Str::random(6);

        $dadosValidadosUser['password'] = Hash::make($password);
        $user = Auth::guard('empresa')->user();
        $id = $user->id;
        try {
            $funcionario = FuncionarioUser::create($dadosValidadosUser);
            $empresaFuncionario = array('empresa_user_id' => $id, 'funcionario_user_id' => $funcionario->id);
            EmpresaFuncionario::create($empresaFuncionario);
           /*  $dadosValidadosFuncao['empresa_funcionario_id'] = $funcionario->id;
            FuncionarioFuncao::create($dadosValidadosFuncao); */
            return response(['email' => $funcionario->email, 'pass' => $password], 200);
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
