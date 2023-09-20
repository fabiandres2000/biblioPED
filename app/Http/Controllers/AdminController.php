<?php

namespace App\Http\Controllers;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Connection;
use MongoDB\Client;
use Illuminate\Http\Request;
use DB;

use Jenssegers\Mongodb\Facades\MongoDB;

use Illuminate\Support\Facades\Session;

use HTMLPurifier;
use HTMLPurifier_Config;

use Illuminate\Support\Str;

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

        $idUsuario = Session::get('id');

        switch ($tipo_contenido) {
            case 'normal':
                $consecutivo = self::tomar_ultimo_id($tipo_subida);
                self::guardarContenidoHTML($request, $consecutivo);
                $resultadoInsercion = self::guardarContenidoBusqueda($request, $consecutivo);
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
                    'tema_sin_tilde' => self::removeAccents($tema),
                    'ruta' => $nombreArchivo,
                    'fecha' => date('d/m/Y'),
                    'horas' => date('H:i:s'),
                    'id_usuario_registra' => $idUsuario
                ];

                $resultadoInsercion = $collection->insertOne($dato);
                break;
            case 'video':

                $consecutivo = self::tomar_ultimo_id($tipo_subida);

                $multimedia = $request->file('multimedia');
                $nombreArchivo = $multimedia->getClientOriginalName();
                $multimedia->move(public_path('videos'), $nombreArchivo);

                $collection = $mongoDB->selectCollection('multimedia');
                
                $dato = [
                    'tipo_multimedia' => $tipo_contenido,
                    'tipo_contenido' => $tipo_subida,
                    'id_contenido' => $consecutivo[1]."",
                    'asignatura' => $asignatura,
                    'grado' => $grado,
                    'tema' => $tema,
                    'tema_sin_tilde' => self::removeAccents($tema),
                    'ruta' => $nombreArchivo,
                    'fecha' => date('d/m/Y'),
                    'horas' => date('H:i:s'),
                    'id_usuario_registra' => $idUsuario
                ];

                self::guardarContenidoHTML($request, $consecutivo);

                $resultadoInsercion = $collection->insertOne($dato);
                break;
        }

        if ($resultadoInsercion->isAcknowledged()) {
            return response()->json(['mensaje' => 'Contenido subido y registrado correctamente', 'estado' => 1]);
        } else {
            return response()->json(['mensaje' => 'Error al registrar el contenido en la base de datos', 'estado' => 0]);
        }

    }

    function removeAccents($str) {
        $unwanted = array(
            'á' => 'a',
            'é' => 'e',
            'í' => 'i',
            'ó' => 'o',
            'ú' => 'u',
            'Á' => 'A',
            'É' => 'E',
            'Í' => 'I',
            'Ó' => 'O',
            'Ú' => 'U',
        );
    
        return strtr($str, $unwanted);
    }

    function tomar_ultimo_id($tipo_tabla){
        $mongoClient = new Client('mongodb://localhost:27017');
        $mongoDB = $mongoClient->selectDatabase('ped_biblioteca');
        
        if($tipo_tabla == 'asignatura'){
            $collection = $mongoDB->selectCollection('cont_documento');
            $latestDocument = $collection->find([], ['sort' => ['_id' => -1], 'limit' => 1])->toArray()[0];
        
            
        }else{
            $collection = $mongoDB->selectCollection('cont_documento_modulos');
            $latestDocument = $collection->find([], ['sort' => ['_id' => -1], 'limit' => 1])->toArray()[0];
        }

        $ultimosID = [
            $latestDocument->id + 1,
            $latestDocument->contenido + 1
        ];
        
        return $ultimosID;
    }

    function guardarContenidoHTML($request, $consecutivo){
        $mongoClient = new Client('mongodb://localhost:27017');
        $mongoDB = $mongoClient->selectDatabase('ped_biblioteca');
        
        $idUsuario = Session::get('id');

        if($request->input('tipo_subida') == 'asignatura'){
            $collection = $mongoDB->selectCollection('cont_documento');
        }else{
            $collection = $mongoDB->selectCollection('cont_documento_modulos');
        }

        $dato = [
            'id' => $consecutivo[0],
            'contenido' => $consecutivo[1],
            'titulo' => $request->input('tema'),
            'cont_documento' => $request->input('contenido'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'id_usuario_registra' => $idUsuario,
            'asignatura' => $request->input('asignatura'),
            'grado' => $request->input('grado'),
        ];

        $collection->insertOne($dato);
    }

    function guardarContenidoBusqueda($request, $consecutivo){
        $mongoClient = new Client('mongodb://localhost:27017');
        $mongoDB = $mongoClient->selectDatabase('ped_biblioteca');
        
        $idUsuario = Session::get('id');

        if($request->input('tipo_subida') == 'asignatura'){
            $tipo_contenido = "N";
        }else{
            $tipo_contenido = "T";
        }

        $collection = $mongoDB->selectCollection('contenido_busqueda');
        $latestDocument = $collection->find([], ['sort' => ['_id' => -1], 'limit' => 1])->toArray()[0];

        $ultimo_id = $latestDocument->id + 1;

        $contenido_texto = self::convertirHtmlATexto($request->input('contenido'));
        $imagen = self::obtenerPrimeraImagen($request->input('contenido'));

        $dato = [
            'id' => $ultimo_id,
            'id_contenido' => $consecutivo[0],
            'tipo_contenido' => $tipo_contenido,
            'contenido_texto' => $contenido_texto,
            'imagen' => $imagen,
            'modulo' => 0,
            'titulo' => $request->input('tema'),
            'grado' => $request->input('grado'),
            'asignatura' => $request->input('asignatura'),
        ];

        return $collection->insertOne($dato);
    }

    public function convertirHtmlATexto($html){
       
        $config = HTMLPurifier_Config::createDefault();
        $config->set('HTML.Allowed', '');
        $purifier = new HTMLPurifier($config);
        
        $texto = $purifier->purify($html);
        
        return $texto;
    }

    function obtenerPrimeraImagen($html){
        if(strlen($html) > 0){
            $dom = new \DOMDocument();
            libxml_use_internal_errors(true);
            $dom->loadHTML($html);

            $imagenes = $dom->getElementsByTagName('img');

            if ($imagenes->length > 0) {
                $primeraImagen = $imagenes->item(0);
                $src = $primeraImagen->getAttribute('src');
                return $src;
            }else{
                return "";
            }
        }else{ 
            return "";
        }
    }

    function consultarContenidoRegistrado(){
        $mongoClient = new Client('mongodb://localhost:27017');
        $mongoDB = $mongoClient->selectDatabase('ped_biblioteca');
        $collection = $mongoDB->selectCollection('multimedia');
        $collection2 = $mongoDB->selectCollection('cont_documento');
        $collection3 = $mongoDB->selectCollection('cont_documento_modulos');

        $idUsuario = Session::get('id');

        $multimedia = $collection->find(
            [
                'id_usuario_registra' => new \MongoDB\BSON\ObjectID($idUsuario),
            ]
        )->toArray();

        $array_ids = [];
        foreach ($multimedia as $item){
            $item->tipo_contenido_registrado = "Multimedia";
            if($item->tipo_multimedia == "video"){
                array_push($array_ids, (int) $item->id_contenido);
                if($item->tipo_contenido == "asignatura"){
                    $item->cont_documento = $collection2->findOne(
                        [
                            'contenido' => (int) $item->id_contenido
                        ]
                    )->cont_documento;
                }else{
                    $item->cont_documento = $collection3->findOne(
                        [
                            'contenido' => (int) $item->id_contenido
                        ]
                    )->cont_documento;
                }
            }
        }

        $contenido_asignatura = $collection2->find(
            [
                'id_usuario_registra' => new \MongoDB\BSON\ObjectID($idUsuario),
                'contenido' => ['$nin' => $array_ids]
            ]
        )->toArray();

        foreach ($contenido_asignatura as $item){
            $item->tipo_contenido_registrado = "Normal";
            $item->tipo_contenido = "asignatura";
            $item->tipo_multimedia = "normal";
        }
        
        $contenido_modulo = $collection3->find(
            [
                'id_usuario_registra' => new \MongoDB\BSON\ObjectID($idUsuario),
                'contenido' => ['$nin' => $array_ids]
            ]
        )->toArray();

        foreach ($contenido_modulo as $item){
            $item->tipo_contenido_registrado = "Normal";
            $item->tipo_contenido = "modulo transversal";
            $item->tipo_multimedia = "normal";
        }

        $mergedArray = array_merge($multimedia, $contenido_asignatura, $contenido_modulo);


        return response()->json( $mergedArray, 200);
    }

    public function editarContenido(Request $request){
        $mongoClient = new Client('mongodb://localhost:27017');
        $mongoDB = $mongoClient->selectDatabase('ped_biblioteca');

        $tipo_subida = $request->input('tipo_subida');
        $tipo_contenido = $request->input('tipo_contenido');
       
        $asignatura = $request->input('asignatura');
        $grado = $request->input('grado');
        $tema = $request->input('tema');
        $oid = $request->input('oid');

        $idUsuario = Session::get('id');

        $tipo_subida_anterior = $request->input('tipo_subida_anterior');
        $tipo_contenido_anterior = $request->input('tipo_contenido_anterior');

        $collection_m = $mongoDB->selectCollection('multimedia');
        $collection_cd = $mongoDB->selectCollection('cont_documento');
        $collection_cdm = $mongoDB->selectCollection('cont_documento_modulos');
        $collection_cb = $mongoDB->selectCollection('contenido_busqueda');
       
        //dd($tipo_subida_anterior." - ".$tipo_contenido_anterior." - ".$oid);
        self::eliminarContenidoEditar($tipo_subida_anterior, $tipo_contenido_anterior, $oid);

        switch ($tipo_contenido) {
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
                    'tema_sin_tilde' => self::removeAccents($tema),
                    'ruta' => $nombreArchivo,
                    'fecha' => date('d/m/Y'),
                    'horas' => date('H:i:s'),
                    'id_usuario_registra' => $idUsuario
                ];

                $resultadoInsercion = $collection->insertOne($dato);
                break;
            case 'normal':
                $consecutivo = self::tomar_ultimo_id($tipo_subida);
                self::guardarContenidoHTML($request, $consecutivo);
                $resultadoInsercion = self::guardarContenidoBusqueda($request, $consecutivo);
                break;
            case 'video':
                $consecutivo = self::tomar_ultimo_id($tipo_subida);

                $multimedia = $request->file('multimedia');
                $nombreArchivo = $multimedia->getClientOriginalName();
                $multimedia->move(public_path('videos'), $nombreArchivo);

                $collection = $mongoDB->selectCollection('multimedia');
                
                $dato = [
                    'tipo_multimedia' => $tipo_contenido,
                    'tipo_contenido' => $tipo_subida,
                    'id_contenido' => $consecutivo[1]."",
                    'asignatura' => $asignatura,
                    'grado' => $grado,
                    'tema' => $tema,
                    'tema_sin_tilde' => self::removeAccents($tema),
                    'ruta' => $nombreArchivo,
                    'fecha' => date('d/m/Y'),
                    'horas' => date('H:i:s'),
                    'id_usuario_registra' => $idUsuario
                ];

                self::guardarContenidoHTML($request, $consecutivo);

                $resultadoInsercion = $collection_m->insertOne($dato);
                break;
        }

        if ($resultadoInsercion->isAcknowledged()) {
            return response()->json(['mensaje' => 'Contenido modificado correctamente', 'estado' => 1]);
        } else {
            return response()->json(['mensaje' => 'Error al modificar el contenido en la base de datos', 'estado' => 0]);
        }

    }

    public function eliminarContenido(Request $request){
        $mongoClient = new Client('mongodb://localhost:27017');
        $mongoDB = $mongoClient->selectDatabase('ped_biblioteca');


        $tipo_contenido = $request->input('tipo_contenido');
        $tipo_multimedia = $request->input('tipo_multimedia');
        $oid = $request->input('oid');
        
        $collection_m = $mongoDB->selectCollection('multimedia');
        $collection_cd = $mongoDB->selectCollection('cont_documento');
        $collection_cdm = $mongoDB->selectCollection('cont_documento_modulos');
        $collection_cb = $mongoDB->selectCollection('contenido_busqueda');
       
        switch ($tipo_multimedia) {
            case 'metafacto':
                $collection_m->deleteOne(
                    ['_id' => new \MongoDB\BSON\ObjectID($oid)], 
                );
                break;
            case 'normal':
                if($tipo_contenido == "asignatura"){
                    $anterior = $collection_cd->findOne(
                        ['_id' => new \MongoDB\BSON\ObjectID($oid)], 
                    );
    
                    $collection_cb->deleteOne(
                        [
                            'id_contenido' => (int) $anterior->id,
                            'tipo_contenido' => 'N'
                        ], 
                    );

                    $collection_cd->deleteOne(
                        ['_id' => new \MongoDB\BSON\ObjectID($oid)], 
                    );
    
                }else{
                    $anterior = $collection_cdm->findOne(
                        ['_id' => new \MongoDB\BSON\ObjectID($oid)], 
                    );
    
                    $collection_cb->deleteOne(
                        [
                            'id_contenido' => (int) $anterior->id,
                            'tipo_contenido' => 'T'
                        ], 
                    );

                    $collection_cdm->deleteOne(
                        ['_id' => new \MongoDB\BSON\ObjectID($oid)], 
                    );
    
                }
                break;
            case 'video':
                if($tipo_contenido == "asignatura"){
                    $anterior = $collection_m->findOne(
                        ['_id' => new \MongoDB\BSON\ObjectID($oid)], 
                    );
    
                    $collection_cd->deleteOne(
                        ['contenido' => (int) $anterior->id_contenido], 
                    );

                    $collection_m->deleteOne(
                        ['_id' => new \MongoDB\BSON\ObjectID($oid)], 
                    );
                }else{
                    $anterior = $collection_m->findOne(
                        ['_id' => new \MongoDB\BSON\ObjectID($oid)], 
                    );
    
                    $collection_cdm->deleteOne(
                        ['contenido' => (int) $anterior->id_contenido], 
                    );

                    $collection_m->deleteOne(
                        ['_id' => new \MongoDB\BSON\ObjectID($oid)], 
                    );
                }
                break;
        }
        return response()->json(['mensaje' => 'Contenido eliminado correctamente', 'estado' => 1]);
    }

    public function eliminarContenidoEditar($tipo_contenido, $tipo_multimedia, $oid){
        $mongoClient = new Client('mongodb://localhost:27017');
        $mongoDB = $mongoClient->selectDatabase('ped_biblioteca');
        
        $collection_m = $mongoDB->selectCollection('multimedia');
        $collection_cd = $mongoDB->selectCollection('cont_documento');
        $collection_cdm = $mongoDB->selectCollection('cont_documento_modulos');
        $collection_cb = $mongoDB->selectCollection('contenido_busqueda');
       
        switch ($tipo_multimedia) {
            case 'metafacto':
                $collection_m->deleteOne(
                    ['_id' => new \MongoDB\BSON\ObjectID($oid)], 
                );
                break;
            case 'normal':
                if($tipo_contenido == "asignatura"){
                    $anterior = $collection_cd->findOne(
                        ['_id' => new \MongoDB\BSON\ObjectID($oid)], 
                    );
    
                    $collection_cb->deleteOne(
                        [
                            'id_contenido' => (int) $anterior->id,
                            'tipo_contenido' => 'N'
                        ], 
                    );

                    $collection_cd->deleteOne(
                        ['_id' => new \MongoDB\BSON\ObjectID($oid)], 
                    );
    
                }else{
                    $anterior = $collection_cdm->findOne(
                        ['_id' => new \MongoDB\BSON\ObjectID($oid)], 
                    );
    
                    $collection_cb->deleteOne(
                        [
                            'id_contenido' => (int) $anterior->id,
                            'tipo_contenido' => 'T'
                        ], 
                    );

                    $collection_cdm->deleteOne(
                        ['_id' => new \MongoDB\BSON\ObjectID($oid)], 
                    );
    
                }
                break;
            case 'video':
                if($tipo_contenido == "asignatura"){
                    $anterior = $collection_m->findOne(
                        ['_id' => new \MongoDB\BSON\ObjectID($oid)], 
                    );
    
                    $collection_cd->deleteOne(
                        ['contenido' => (int) $anterior->id_contenido], 
                    );

                    $collection_m->deleteOne(
                        ['_id' => new \MongoDB\BSON\ObjectID($oid)], 
                    );
                }else{
                    $anterior = $collection_m->findOne(
                        ['_id' => new \MongoDB\BSON\ObjectID($oid)], 
                    );
    
                    $collection_cdm->deleteOne(
                        ['contenido' => (int) $anterior->id_contenido], 
                    );

                    $collection_m->deleteOne(
                        ['_id' => new \MongoDB\BSON\ObjectID($oid)], 
                    );
                }
                break;
        }
        return 1;
    }
}
