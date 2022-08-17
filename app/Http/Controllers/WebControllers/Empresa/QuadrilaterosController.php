<?php

namespace App\Http\Controllers\WebControllers\Empresa;

use App\Http\Controllers\Controller;
use App\Models\BatepontoQuadrilateros;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class QuadrilaterosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            return BatepontoQuadrilateros::withTrashed()->get();
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
        $dadosValidados = Validator::make($request->all(),[
            'pontos' => 'required|array:lat,lng',
            'nome' => 'required|string',
        ])->validated();

        $user = Auth::guard('empresa')->user();
        $dadosValidados['empresa_user_id'] = $user->id;
        $dadosValidados['pontos'] = json_encode($dadosValidados['pontos']);
        try {
            BatepontoQuadrilateros::create($dadosValidados);
            return response('success', 200);
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
        return BatepontoQuadrilateros::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $dadosValidados = Validator::make([
            'pontos' => 'required|array:lat,lng',
            'nome' => 'required|string',
        ])->validated();

        try {
            BatepontoQuadrilateros::create($dadosValidados);
            return response('success', 200);
        } catch (\Throwable $th) {
            throw $th;
        }
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
