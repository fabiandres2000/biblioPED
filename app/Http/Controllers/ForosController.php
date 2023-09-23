<?php

namespace App\Http\Controllers;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Connection;
use MongoDB\Client;
use Illuminate\Http\Request;
use DB;

use Jenssegers\Mongodb\Facades\MongoDB;

use Illuminate\Support\Facades\Session;


class ForosController extends Controller
{
    public function foros(Request $request){
        
        $mongoClient = new Client('mongodb://localhost:27017');
        $mongoDB = $mongoClient->selectDatabase('ped_biblioteca');
        $collection = $mongoDB->selectCollection('foros');

        $idUsuario = Session::get('id');

        $tipo = $request->input('tipo');

        if($tipo == "estudiante"){
            $result = $collection->aggregate([
                [
                    '$match' => [
                        'estudiantes' =>  new \MongoDB\BSON\Regex($idUsuario)
                    ],
                ],
                [
                    '$sort' => [
                        'fecha' => -1,
                        'horas' => -1,
                    ],
                ],
            ])->toArray();
            

            $collection2 = $mongoDB->selectCollection('usuarios');
            foreach ($result as $dato){
                $dato->profesor = $collection2->findOne([
                    '_id' => new \MongoDB\BSON\ObjectID($dato->id_profesor),
                ]);
            }
        }else{
            $result = $collection->aggregate([
                [
                    '$match' => [
                        'id_profesor' =>  new \MongoDB\BSON\ObjectID($idUsuario),
                    ],
                ],
                [
                    '$sort' => [
                        'fecha' => -1,
                        'horas' => -1,
                    ],
                ],
            ])->toArray();
            
            $collection2 = $mongoDB->selectCollection('usuarios');
            

            foreach ($result as $dato){
                $dato->profesor = $collection2->findOne([
                    '_id' => new \MongoDB\BSON\ObjectID($dato->id_profesor),
                ]);

                $lista_estudiantes = [];

                foreach($dato->estudiantes as $dato2){
                    $lista_estudiantes[] = $collection2->findOne([
                        '_id' => new \MongoDB\BSON\ObjectID($dato2),
                    ]);
                }

                $dato->lista_estudiantes = $lista_estudiantes;

            }
        }

        return $result;
    }

    public function foro(Request $request){

        $mongoClient = new Client('mongodb://localhost:27017');
        $mongoDB = $mongoClient->selectDatabase('ped_biblioteca');
        $collection = $mongoDB->selectCollection('foros');

        $id = $request->input('id');

        $foro = $collection->findOne([
            '_id' => new \MongoDB\BSON\ObjectID($id),
        ]);

        $collection2 = $mongoDB->selectCollection('usuarios');
        $collection3 = $mongoDB->selectCollection('respuestas_comentarios');

        $foro->profesor = $collection2->findOne([
            '_id' => new \MongoDB\BSON\ObjectID($foro->id_profesor),
        ]);

        foreach ($foro->comentarios as $comentario){
            $comentario->usuario = $collection2->findOne([
                '_id' => new \MongoDB\BSON\ObjectID($comentario->id_usuario),
            ]);
            
            $respuestas = $collection3->find([
                'id_comentario' => new \MongoDB\BSON\ObjectID($comentario->_id),
            ])->toArray();

            usort($respuestas, function($a, $b) {
                $dateTimeA = \DateTime::createFromFormat('d/m/Y H:i:s', $a['fecha'] . ' ' . $a['horas'], new \DateTimeZone('America/Bogota'));
                $dateTimeB = \DateTime::createFromFormat('d/m/Y H:i:s', $b['fecha'] . ' ' . $b['horas'], new \DateTimeZone('America/Bogota'));
                return $dateTimeB <=> $dateTimeA; 
            });

            foreach($respuestas as $respuesta){
                $respuesta->usuario = $collection2->findOne([
                    '_id' => new \MongoDB\BSON\ObjectID($respuesta->id_usuario),
                ]);
            }

            $comentario->respuestas = $respuestas;
        }

        $comentarios = $foro->comentarios;
        if(count($comentarios) > 0){
            $comentarios = iterator_to_array($foro['comentarios']);
            usort($comentarios, function($a, $b) {
                $dateTimeA = \DateTime::createFromFormat('d/m/Y H:i:s', $a['fecha'] . ' ' . $a['horas'], new \DateTimeZone('America/Bogota'));
                $dateTimeB = \DateTime::createFromFormat('d/m/Y H:i:s', $b['fecha'] . ' ' . $b['horas'], new \DateTimeZone('America/Bogota'));
                return $dateTimeB <=> $dateTimeA; 
            });
        
            $foro['comentarios'] = $comentarios;
        }

        $parametros = explode('/',$foro->ruta);

        if($parametros[2] == 'N'){
            $foro->contenido_html = $mongoDB->selectCollection('cont_documento')->findOne([
                'id' => (int) $parametros[1],
            ]);
        }else{
            $foro->contenido_html = $mongoDB->selectCollection('cont_documento_modulos')->findOne([
                'id' => (int) $parametros[1],
            ]);
        }

        return $foro;
    }


    public function guardarRespuesta(Request $request){
        $mongoClient = new Client('mongodb://localhost:27017');
        $mongoDB = $mongoClient->selectDatabase('ped_biblioteca');
        $collection = $mongoDB->selectCollection('foros');

        $idUsuario = Session::get('id');
        $idForo = $request->input('id_foro');
        $respuesta = $request->input('respuesta');
       

        $elemento_ingresar = [
            '_id' => new \MongoDB\BSON\ObjectID(),
            'id_usuario' => Session::get('id'),
            'respuesta' => $respuesta,
            'likes' => 0,
            'fecha' => date('d/m/Y'),
            'horas' => date('H:i:s'),
        ];

        $collection->updateOne(
            ['_id' => new \MongoDB\BSON\ObjectID($idForo)],
            ['$push' => ['comentarios' => $elemento_ingresar]]
        );

        return response()->json("¡Se ha registrado su respuesta correctamente!", 200);
    }

    public function guardarRespuestaComentario(Request $request){
        $mongoClient = new Client('mongodb://localhost:27017');
        $mongoDB = $mongoClient->selectDatabase('ped_biblioteca');
        $collection = $mongoDB->selectCollection('respuestas_comentarios');

        $id_comentario = $request->input('id_comentario');
        $respuesta = $request->input('respuesta');

        $elemento_ingresar = [
            'id_comentario' => new \MongoDB\BSON\ObjectID($id_comentario),
            'id_usuario' => Session::get('id'),
            'respuesta' => $respuesta,
            'fecha' => date('d/m/Y'),
            'horas' => date('H:i:s'),
        ];

        $collection->insertOne($elemento_ingresar);
    }

    public function eliminarRespuesta(Request $request){
        $mongoClient = new Client('mongodb://localhost:27017');
        $mongoDB = $mongoClient->selectDatabase('ped_biblioteca');
        $collection = $mongoDB->selectCollection('respuestas_comentarios');

        $id_respuesta = $request->input('id');

        $collection->deleteOne(
            [
                '_id' =>new \MongoDB\BSON\ObjectID($id_respuesta),
            ]
        );
    }

    public function editarForo(Request $request){
        $mongoClient = new Client('mongodb://localhost:27017');
        $mongoDB = $mongoClient->selectDatabase('ped_biblioteca');
        $collection = $mongoDB->selectCollection('foros');
        $collection2 = $mongoDB->selectCollection('notificaciones');

        $ids = $request->input('ids');
        $id_foro = $request->input('id_foro');
       
        $foro = $collection->findOne([
            '_id' => new \MongoDB\BSON\ObjectID($id_foro),
        ]);

        $log = "";

        foreach ($ids as $key) {

            $estudiantes = iterator_to_array($foro['estudiantes']);

            $hay = array_filter($estudiantes, function ($value) use ($key)  {
                return $value == $key["id"];
            });

            if(count($hay) != 0){
                $log .= "<p><i class='fas fa-times'></i> El estudiante: ".$key["nombre"]." esta registrado en este foro </p>";
            }else{

                $collection->updateOne(
                    ['_id' => new \MongoDB\BSON\ObjectID($id_foro)],
                    ['$push' => ['estudiantes' => $key["id"]]]
                );

                $collection2 = $mongoDB->selectCollection('notificaciones');

                $noti = [
                    'id_profesor' => Session::get('id'),
                    'id_estudiante' => $key["id"],
                    'ruta' => $foro->ruta,
                    'tema' => $foro->titulo,
                    'fecha' => date('d/m/Y'),
                    'horas' => date('H:i:s'),
                    'estado' => 'cerrado',
                    'tipo' => 1
                ];
        
                $collection2->insertOne($noti);
        
                $log .= "<p><i class='fas fa-check'></i> El estudiante: ".$key["nombre"]." fue agregado al foro  </p>";
            }
        }

        return response()->json($log, 200);
    }

    public function cambiarEstado(Request $request){
        $mongoClient = new Client('mongodb://localhost:27017');
        $mongoDB = $mongoClient->selectDatabase('ped_biblioteca');
        $collection = $mongoDB->selectCollection('foros');

        $id = $request->input('id');
        $estado_actual = $request->input('estado_actual');

        $log = "";

        if($estado_actual == "Abierto"){
            $collection->updateOne(
                ['_id' => new \MongoDB\BSON\ObjectID($id)], 
                [            
                    '$set' => [
                        'estado' => 'Cerrado',
                    ]
                ]
            );

            $log = "Estado cambiado a (<strong> Cerrado </strong>) correctamente";
        }else{
            $collection->updateOne(
                ['_id' => new \MongoDB\BSON\ObjectID($id)], 
                [            
                    '$set' => [
                        'estado' => 'Abierto',
                    ]
                ]
            );

            $log = "Estado cambiado a (<strong> Abierto </strong>) correctamente";

        }

        return response()->json($log, 200);
    }
}
