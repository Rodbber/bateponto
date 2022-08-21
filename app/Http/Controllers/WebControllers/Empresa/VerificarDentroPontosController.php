<?php

namespace App\Http\Controllers\WebControllers\Empresa;

use App\Http\Controllers\Controller;
use App\Models\BatepontoPoligono;
use App\Models\BatepontoQuadrilateros;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class VerificarDentroPontosController extends Controller
{
    //

    public function distancia($lat1, $lon1, $lat2, $lon2)
    {

        $dlat = (($lat1 - $lat2) * pi()) / 180.0;
        $dlng = (($lon1 - $lon2) * pi()) / 180.0;

        $lat1 = deg2rad($lat1);
        $lat2 = deg2rad($lat2);
        $lon1 = deg2rad($lon1);
        $lon2 = deg2rad($lon2);

        $a = pow(sin($dlat / 2), 2) + pow(sin($dlng / 2), 2) * cos($lat1) * cos($lat2);
        $dist = 6371 * (2 * asin(sqrt($a)));
        //dist = number_format(dist, 2, '.', '');
        return $dist; // em km
    }

    public function dentroDaAreaPoligono($latlngs, $lat, $lng)
    {
        $inside = false;
        for ($i = 0, $j = count($latlngs) - 1; $i < count($latlngs); $j = $i++) {
            $xi = $latlngs[$i]['lat'];
            $yi = $latlngs[$i]['lng'];
            $xj = $latlngs[$j]['lat'];
            $yj = $latlngs[$j]['lng'];

            $intersect = (($yi > $lng) != ($yj > $lng))
                && ($lat < ($xj - $xi) * ($lng - $yi) / ($yj - $yi) + $xi);
            if ($intersect) {
                $inside = !$inside;
            }
        }
        return $inside;
    }

    public function verificarSeEstaDentroDeAlgumPonto($id, Request $request)
    {
        $dadosValidados = Validator($request->all(),[
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
        ])->validated();
        $user = Auth::guard('empresa')->user();
        $idEmp = $user->id;
        $quadrilatero = BatepontoQuadrilateros::where('empresa_user_id', $idEmp)->get();

        foreach ($quadrilatero as $key => $value) {
            $latlngs = json_decode($value['pontos'], true);
            $ver = $this->dentroDaAreaPoligono($latlngs, $dadosValidados['lat'], $dadosValidados['lng']);
            if ($ver) {
                return $value;
            }
        }
        $poligonos = BatepontoPoligono::where('empresa_user_id', $idEmp)->get();
        foreach ($poligonos as $key => $value) {
            $latlngs = json_decode($value['pontos'], true);
            $ver = $this->dentroDaAreaPoligono($latlngs, $dadosValidados['lat'], $dadosValidados['lng']);
            if ($ver) {
                return $value;
            }
        }
        return false;
    }

    public function verificarSeEstaDentroDeAlgumPontoExpecifico($id, Request $request)
    {
        $dadosValidados = Validator($request->all(),[
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
        ])->validated();

        /* $user = Auth::guard('empresa')->user();
        $idEmp = $user->id; */
        $quadrilatero = BatepontoQuadrilateros::find($id)->get();
        foreach ($quadrilatero as $key => $value) {
            $latlngs = json_decode($value['pontos'], true);
            $ver = $this->dentroDaAreaPoligono($latlngs, $dadosValidados['lat'], $dadosValidados['lng']);
            if ($ver) {
                return $value;
            }
        }

        $poligonos = BatepontoPoligono::find($id)->get();
        foreach ($poligonos as $key => $value) {
            $latlngs = json_decode($value['pontos'], true);
            $ver = $this->dentroDaAreaPoligono($latlngs, $dadosValidados['lat'], $dadosValidados['lng']);
            if ($ver) {
                return $value;
            }
        }

        return false;
    }
}
