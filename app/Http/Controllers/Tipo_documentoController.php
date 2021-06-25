<?php

/*
Autor: Franklin Valoyes López <franklin032010@hotmail.com>
*/

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Middleware\TrimStrings;
use App\Http\Middleware\ConvertEmptyStringsToNull;

use App\Models\Tipo_documento;

class Tipo_documentoController extends Controller
{
    public function __construct() {
        $this->middleware('api.auth', ['except' => []]);
    }

    public function index(){
        $Tipo_documento = Tipo_documento::All();

        return response()->json([
            'code'              => 200,
            'status'            => 'success',
            'Tipo_documento'    => $Tipo_documento
        ]);
    }

    public function show($id){
        $Tipo_documento = Tipo_documento::find($id);

        if (is_object($Tipo_documento)) {
            $data = [
                'code'      => 200,
                'status'    => 'success',
                'Tipo_documento'     => $Tipo_documento
            ];
        }else {
            $data = [
                'code'      => 404,
                'status'    => 'error',
                'message'   => 'El tipo documento no existe'
            ];
        }

        return response()->json($data, $data['code']);
    }

    public function store(Request $request){

        // Recoger los datos del Tipo_documento por POST
        $json = $request->input('json', null);
        $params_array = json_decode($json, true); // Array

        if (!empty($params_array)) {
            
            // Limpiar datos
            $params_array = array_map('trim', $params_array);

            // Validar datos
            $validate = \Validator::make($params_array, [
                'nombre'    => 'required'
            ]);

            if ($validate->fails()) {
                // Validacion ha fallado
                $data = array(
                    'status'    => 'error',
                    'code'      => 400,
                    'message'   => 'El tipo documento no se ha creado',
                    'error'     => $validate->errors()
                );
            }else {
                // Validacion ha pasado correctamente

                // Crear el Tipo_documento
                $Tipo_documento             = new Tipo_documento();
                $Tipo_documento->nombre     = $params_array['nombre'];

                //Guardar el Tipo_documento
                $Tipo_documento->save();

                $data = array(
                    'status'                => 'success',
                    'code'                  => 200,
                    'message'               => 'El tipo documento se ha creado correctamente',
                    'Tipo_documento'        => $Tipo_documento
                );
            }
        }else {
            $data = array(
                'status'    => 'error',
                'code'      => 400,
                'message'   => 'Los datos enviados no son correctos'
            );
        }

        return response()->json($data, $data['code']);
    }

    public function update($id, Request $request){
        // Recoger los datos por POST
        $json = $request->input('json', null);
        $params_array = json_decode($json, true);

        if (!empty($params_array)) {
            // Validar los datos
            $validate = \Validator::make($params_array, [
                'nombre'    => 'required'
            ]);

                if ($validate->fails()) {
                    $data = array(
                        'status'    => 'error',
                        'code'      => 400,
                        'message'   => 'El tipo documento no se pudo actualizar',
                        'errors'    => $validate->errors()
                    );
                }else {
                    // Mencionar lo que no quiero actualizar
                    unset($params_array['id']);
                    unset($params_array['created_at']);
                    unset($params_array['updated_at']);

                    // Actualizar el registro (Tipo_documento)
                    $Tipo_documento = Tipo_documento::where('id', $id)->update($params_array);

                    // Mostrar resultado exitoso
                    $data = [
                        'code'              => 200,
                        'status'            => 'success',
                        'message'           => 'El tipo documento ha sido actualizado con éxito',
                        'Tipo_documento'    => $Tipo_documento
                    ];
                }

        }else {
            $data = [
                'code'      => 400,
                'status'    => 'error',
                'message'   => 'No has enviado ningún dato válido'
            ];
        }

        // Devolver los datos
        return response()->json($data, $data['code']);
    }

    public function destroy($id, Request $request){
        // Conseguir el registro
        $Tipo_documento = Tipo_documento::where('id', $id)->first();

        if (!empty($Tipo_documento)) {
            // Borrarlo
            $Tipo_documento->delete();

            // Devolver resultado exitoso
            $data = [
                'code'              => 200,
                'status'            => 'success',
                'message'           => 'Se ha eliminado el siguiente Tipo_documento',
                'Tipo_documento'    => $Tipo_documento
            ];
        }else {
            $data = [
                'code'      => 400,
                'status'    => 'error',
                'message'   => 'Tipo documento no encontrado'        
            ];
        }

        return response()->json($data, $data['code']);
    }
}
