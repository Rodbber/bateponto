<?php

namespace App\Http\Controllers\WebControllers\Funcionario;

use App\Http\Controllers\Controller;
use App\Models\FuncionarioUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AutenticacaoController extends Controller
{
    //
    public function login(Request $request)
    {
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'email' => 'required|email',
                    'password' => 'required'
                ]
            );
            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'Erro de validação',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            //return $request->only('email', 'password');

            if(!Auth::guard('funcionario')->attempt($request->only('email', 'password'))){
                return response()->json([
                    'status' => false,
                    'message' => 'E-mail e senha não correspondem ao nosso registro.',
                ], 401);
            }



            $user = FuncionarioUser::where('email', $request->email)->first();

            return response()->json([
                'status' => true,
                'message' => 'Logado com sucesso!',
                'token_type' => 'Bearer',
                'token' => $user->createToken("$request->email")->plainTextToken
            ], 200);

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function eu(Request $request){
        try {
            return $request->user();
        } catch (\Throwable $th) {
            return response(['message' => 'user não encontrado!'], 401);
        }

    }

    public function logout(Request $request){
        $user = $request->user();
        $request->user()->currentAccessToken()->delete();
        return ['message' => 'Deslogado!', 'email' => $user->email];
    }
}
