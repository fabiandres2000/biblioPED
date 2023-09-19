<?php

namespace App\Http\Controllers;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Connection;
use MongoDB\Client;
use Illuminate\Http\Request;
use DB;

use Jenssegers\Mongodb\Facades\MongoDB;

use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{

    public function RegistroDocente(Request $request){
        $mongoClient = new Client('mongodb://localhost:27017');
        $mongoDB = $mongoClient->selectDatabase('ped_biblioteca');

        $collection = $mongoDB->selectCollection('usuarios');

        $correo = $request->input('correo');
        $direccion = $request->input('direccion');
        $identificacion = $request->input('identificacion');
        $nombre = $request->input('nombre');
        $password = $request->input('password');
        $sexo = $request->input('sexo');
        $telefono = $request->input('telefono');

        if($sexo == "Masculino"){
            $imagen = "avatars/profesor.png";
        }else{
            $imagen = "avatars/profesora.png";
        }
       

        $usuario = $collection->findOne(['correo' => $correo]);

        if (!$usuario) {

            $usuario = [
                'correo' => $correo,
                'direccion' => $direccion,
                'identificacion' => $identificacion,
                'nombre' => $nombre,
                'password' => $password,
                'sexo' => $sexo,
                'telefono' => $telefono,
                'imagen' => $imagen,
                'tipo_registro' => "docente",
                'estado' => "Activo",
            ];

            $collection->insertOne($usuario);

            return response()->json(["Docente registrado corectamente.", 1, "docente"], 200);
        } else {
            return response()->json(["Ya hay un usuario registrado con ese nombre de correo.", 0], 200);
        }

    }

    public function listarDocentes(){
        $mongoClient = new Client('mongodb://localhost:27017');
        $mongoDB = $mongoClient->selectDatabase('ped_biblioteca');

        $collection = $mongoDB->selectCollection('usuarios');

        $usuarios = $collection->find(
            [
                'tipo_registro' => 'docente',
            ]
        )->toArray();

        return response()->json( $usuarios, 200);
    }


    public function editarDocente(Request $request){
        $mongoClient = new Client('mongodb://localhost:27017');
        $mongoDB = $mongoClient->selectDatabase('ped_biblioteca');

        $collection = $mongoDB->selectCollection('usuarios');

        $correo = $request->input('correo');
        $direccion = $request->input('direccion');
        $identificacion = $request->input('identificacion');
        $nombre = $request->input('nombre');
        $password = $request->input('password');
        $sexo = $request->input('sexo');
        $telefono = $request->input('telefono');
        $estado = $request->input('estado');
        $imagen = $request->input('imagen');
        $_id = $request->input('_id');

        $collection->updateOne(
            ['_id' => new \MongoDB\BSON\ObjectID($_id)], 
            [            
                '$set' => [
                    'correo' => $correo,
                    'direccion' => $direccion,
                    'identificacion' => $identificacion,
                    'nombre' => $nombre,
                    'password' => $password,
                    'sexo' => $sexo,
                    'telefono' => $telefono,
                    'imagen' => $imagen,
                    'tipo_registro' => "docente",
                    'estado' => $estado,
                ]
            ]
        );
        return response()->json(["Docente modificado corectamente.", 1, "docente"], 200);
    }

    public function guardarContenido(Request $request){
        $mongoClient = new Client('mongodb://localhost:27017');
        $mongoDB = $mongoClient->selectDatabase('ped_biblioteca');

        $tipo_subida = $request->input('tipo_subida');
        $tipo_contenido = $request->input('tipo_contenido');
        $asignatura = $request->input('asignatura');
        $grado = $request->input('grado');
        $tema = $request->input('tema');

        switch ($tipo_contenido) {
            case 'normal':
                break;
            case 'metafacto':
                $multimedia = $request->file('multimedia');
                $nombreArchivo = $multimedia->getClientOriginalName();
                $multimedia->move(public_path('metafactos'), $nombreArchivo);


                $collection = $mongoDB->selectCollection('multimedia');

                $dato = [
                    'tipo_multimedia' => $tipo_contenido,
                    'tipo_contenido' => $tipo_subida,
                    'asignatura' => $asignatura,
                    'grado' => $grado,
                    'tema' => $tema,
                    'ruta' => "/"."metafactos/".$nombreArchivo,
                    'fecha' => date('d/m/Y'),
                    'horas' => date('H:i:s'),
                ];

                $resultadoInsercion = $collection->insertOne($dato);
                break;
            case 'video':
                $multimedia = $request->file('multimedia');
                $nombreArchivo = $multimedia->getClientOriginalName();
                $multimedia->move(public_path('videos'), $nombreArchivo);


                $collection = $mongoDB->selectCollection('multimedia');
                
                $dato = [
                    'tipo_multimedia' => $tipo_contenido,
                    'tipo_contenido' => $tipo_subida,
                    'asignatura' => $asignatura,
                    'grado' => $grado,
                    'tema' => $tema,
                    'ruta' => "/"."videos/".$nombreArchivo,
                    'fecha' => date('d/m/Y'),
                    'horas' => date('H:i:s'),
                ];

                $resultadoInsercion = $collection->insertOne($dato);
                break;
        }

        if ($resultadoInsercion->isAcknowledged()) {
            return response()->json(['mensaje' => 'Contenido subido y registrado correctamente', 'estado' => 1]);
        } else {
            return response()->json(['mensaje' => 'Error al registrar el contenido en la base de datos', 'estado' => 0]);
        }

    }

    function corregirTexto(Request $request){
        $texto = $request->input('texto');
        
    }
}
