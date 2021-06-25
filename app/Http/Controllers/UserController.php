<?php

/*
Autor: Franklin Valoyes López <franklin032010@hotmail.com>
*/

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

class UserController extends Controller
{
    public function __construct() {
        $this->middleware('api.auth', ['except' => []]);
    }

    public function index(){
        $User = User::All()
        ->load('tipo_documento');

        return response()->json([
            'code'              => 200,
            'status'            => 'success',
            'users'             => $User
        ]);
    }

    public function show($id){
        $User = User::find($id);

        if (is_object($User)) {
            $data = [
                'code'      => 200,
                'status'    => 'success',
                'users'      => $User
            ];
        }else {
            $data = [
                'code'      => 404,
                'status'    => 'error',
                'message'   => 'El usuario no existe'
            ];
        }

        return response()->json($data, $data['code']);
    }

    public function store(Request $request){

        // Recoger los datos del User por POST
        $json = $request->input('json', null);
        $params_array = json_decode($json, true); // Array

        if (!empty($params_array)) {
            
            // Limpiar datos
            $params_array = array_map('trim', $params_array);

            // Validar datos
            $validate = \Validator::make($params_array, [
                'primer_nombre'     => 'required',
                'segundo_nombre'    => 'required',
                'primer_apellido'   => 'required',
                'segundo_apellido'  => 'required',
                'nro_documento'     => 'required|numeric',
                'tipo_documento_id' => 'required|numeric'
            ]);

            if ($validate->fails()) {
                // Validacion ha fallado
                $data = array(
                    'status'    => 'error',
                    'code'      => 400,
                    'message'   => 'El usuario no se ha creado',
                    'error'     => $validate->errors()
                );
            }else {
                // Validacion ha pasado correctamente

                // Crear el User
                $User                        = new User();
                $User->primer_nombre         = $params_array['primer_nombre'];
                $User->segundo_nombre        = $params_array['segundo_nombre'];
                $User->primer_apellido       = $params_array['primer_apellido'];
                $User->segundo_apellido      = $params_array['segundo_apellido'];
                $User->nro_documento         = $params_array['nro_documento'];
                $User->tipo_documento_id     = $params_array['tipo_documento_id'];

                //Guardar el User
                $User->save();

                $data = array(
                    'status'    => 'success',
                    'code'      => 200,
                    'message'   => 'El usuario se ha creado correctamente',
                    'users'     => $User
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
                'primer_nombre'     => 'required',
                'segundo_nombre'    => 'required',
                'primer_apellido'   => 'required',
                'segundo_apellido'  => 'required',
                'nro_documento'     => 'required|numeric',
                'tipo_documento_id' => 'required|numeric'
            ]);

                if ($validate->fails()) {
                    $data = array(
                        'status'    => 'error',
                        'code'      => 400,
                        'message'   => 'El usuario no se pudo actualizar',
                        'errors'    => $validate->errors()
                    );
                }else {
                    // Mencionar lo que no quiero actualizar
                    unset($params_array['id']);
                    unset($params_array['created_at']);
                    unset($params_array['updated_at']);

                    // Actualizar el registro (User)
                    $User = User::where('id', $id)->update($params_array);

                    // Mostrar resultado exitoso
                    $data = [
                        'code'              => 200,
                        'status'            => 'success',
                        'message'           => 'El usuario ha sido actualizado con éxito',
                        'users'              => $User
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
        $User = User::where('id', $id)->first();

        if (!empty($User)) {
            // Borrarlo
            $User->delete();

            // Devolver resultado exitoso
            $data = [
                'code'              => 200,
                'status'            => 'success',
                'message'           => 'Se ha eliminado el siguiente usuario',
                'users'             => $User
            ];
        }else {
            $data = [
                'code'      => 400,
                'status'    => 'error',
                'message'   => 'Usuario no encontrado'        
            ];
        }

        return response()->json($data, $data['code']);
    }
}
