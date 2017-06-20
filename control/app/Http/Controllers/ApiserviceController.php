<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiserviceController extends Controller
{
    public function firstservice(Request $request)
    {
        $alldata = $request->all();
        $response = array(
            'status' => 'success',
            'msg' => 'Se cambió la contraseña satisfactoriamente',
            'user' => $alldata,
        );
        return \Response::json($response);
    }
}
