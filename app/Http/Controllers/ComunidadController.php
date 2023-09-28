<?php

namespace App\Http\Controllers;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Connection;
use MongoDB\Client;
use Illuminate\Http\Request;
use DB;

use Jenssegers\Mongodb\Facades\MongoDB;

use HTMLPurifier;
use HTMLPurifier_Config;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;

class ComunidadController extends Controller
{
    public function guardarPublicacion(Request $request){
        $mongoClient = new Client('mongodb://localhost:27017');
        $mongoDB = $mongoClient->selectDatabase('ped_biblioteca');
        $collection = $mongoDB->selectCollection('publicaciones');

        $idUsuario = Session::get('id');
        $detalle = $request->input('detalle');

        
        $multimedia = $request->file('imagen');
        $nombreArchivo  = "";

        if ($multimedia !== null) {
            $nombreArchivo = $multimedia->getClientOriginalName();
            $multimedia->move(public_path('imagenes_comunidad'), $nombreArchivo);
        }
       
        $timezone = new \DateTimeZone('America/Bogota');

        $fechaActual = new \DateTime('now', $timezone);
        $horaActual = new \DateTime('now', $timezone);

        $elemento_ingresar = [
            'id_usuario' => Session::get('id'),
            'detalle' => $detalle,
            'imagen' => $nombreArchivo,
            'comentarios' => [],
            'likes' => [],
            'fecha' => $fechaActual->format('d/m/Y'),
            'horas' => $horaActual->format('H:i:s'),
        ];

        $resultado = $collection->insertOne($elemento_ingresar);

        if ($resultado->getInsertedCount() === 1) {
            return response()->json(["¡Su publicación fue publicada correctamente!", 1], 200);
        }else{
            return response()->json(["¡Ocurrio un error, intente nuevamente!", 0], 200);
        }
    }

    public function listarPublicaciones(){

        $mongoClient = new Client('mongodb://localhost:27017');
        $mongoDB = $mongoClient->selectDatabase('ped_biblioteca');
        $collection = $mongoDB->selectCollection('publicaciones');
        $collection2 = $mongoDB->selectCollection('usuarios');

        $publicaciones = $collection->find([], ['sort' => ['_id' => -1]])->toArray();


        
        
        foreach ($publicaciones as $publicacion) {
            $publicacion->usuario = $collection2->findOne([
                '_id' => new \MongoDB\BSON\ObjectID($publicacion->id_usuario),
            ]);

            $comentarios = $publicacion->comentarios;
            if(count($comentarios) > 0){
                $comentarios = iterator_to_array($publicacion['comentarios']);
                usort($comentarios, function($a, $b) {
                    $dateTimeA = \DateTime::createFromFormat('d/m/Y H:i:s', $a['fecha'] . ' ' . $a['horas'], new \DateTimeZone('America/Bogota'));
                    $dateTimeB = \DateTime::createFromFormat('d/m/Y H:i:s', $b['fecha'] . ' ' . $b['horas'], new \DateTimeZone('America/Bogota'));
                    return $dateTimeB <=> $dateTimeA; 
                });  
                
                $publicacion->comentarios = $comentarios;
            }

            $dateTimeA = \DateTime::createFromFormat('d/m/Y H:i:s', $publicacion['fecha'] . ' ' . $publicacion['horas'], new \DateTimeZone('America/Bogota'));

            $publicacion->fecha_formateada = $dateTimeA->format('d M, Y \a\ \l\a\s g.i A');

            foreach ($publicacion->comentarios as $comentario){
                $comentario->usuario = $collection2->findOne([
                    '_id' => new \MongoDB\BSON\ObjectID($comentario->id_usuario),
                ]);

                $fechaHora = $comentario['fecha'] . ' ' . $comentario['horas'];
                $timezone = new \DateTimeZone('America/Bogota');

                $fechaActual = new \DateTime('now', $timezone);
                $dateTimeA = \DateTime::createFromFormat('d/m/Y H:i:s', $fechaHora, $timezone);

                $diferencia =(int)$fechaActual->getTimestamp() - (int)$dateTimeA->getTimestamp();

                $fechaFormateada = '';
                if ($diferencia < 60) {
                    $fechaFormateada = "Hace un momento";
                } elseif ($diferencia < 3600) {
                    $minutos = round($diferencia / 60);
                    $fechaFormateada = "Hace {$minutos} minuto(s)";
                } elseif ($diferencia < 86400) {
                    $horas = round($diferencia / 3600);
                    $fechaFormateada = "Hace {$horas} horas";
                } elseif ($diferencia < 1296000) { 
                    $dias = round($diferencia / 86400);
                    $fechaFormateada = "Hace {$dias} días";
                } else {
                    $fechaFormateada = $dateTimeA->format('d M, Y \a \l\a\s h:i A');
                }

                $comentario->fechaFormateada = $fechaFormateada;
            }

            
        }

        return $publicaciones;
    }

    public function registrarComentarioPost(Request $request){
        $mongoClient = new Client('mongodb://localhost:27017');
        $mongoDB = $mongoClient->selectDatabase('ped_biblioteca');
        $collection = $mongoDB->selectCollection('publicaciones');

        $idUsuario = Session::get('id');
        $idPost = $request->input('idPost');
        $comentarioTexto = $request->input('comentarioTexto');
       
        $timezone = new \DateTimeZone('America/Bogota');

        $fechaActual = new \DateTime('now', $timezone);
        $horaActual = new \DateTime('now', $timezone);

        $elemento_ingresar = [
            '_id' => new \MongoDB\BSON\ObjectID(),
            'id_usuario' => Session::get('id'),
            'comentarioTexto' => $comentarioTexto,
            'fecha' => $fechaActual->format('d/m/Y'),
            'horas' => $horaActual->format('H:i:s'),
        ];

        $resultado = $collection->updateOne(
            ['_id' => new \MongoDB\BSON\ObjectID($idPost)],
            ['$push' => ['comentarios' => $elemento_ingresar]]
        );
        if ($resultado->getModifiedCount() > 0) {
            return response()->json(["¡Se ha registrado su comentario correctamente!", 1], 200);
        }else{
            return response()->json(["¡Ocurrio un error, intente nuevamente!", 0], 200);
        }
    }

    public function eliminarComentarioPost(Request $request){
        $mongoClient = new Client('mongodb://localhost:27017');
        $mongoDB = $mongoClient->selectDatabase('ped_biblioteca');
        $collection = $mongoDB->selectCollection('publicaciones');

        $id_publicacion = $request->input('id_publicacion');
        $id_comentario = $request->input('id_comentario');

        $result = $collection->updateOne(
            ['_id' => new \MongoDB\BSON\ObjectID($id_publicacion)],
            ['$pull' => ['comentarios' => ['_id' => new \MongoDB\BSON\ObjectID($id_comentario)]]]
        );
        
        if ($result->getModifiedCount() > 0) {
            return response()->json(["¡Se ha eliminado su comentario correctamente!", 1], 200);
        } else {
            return response()->json(["¡ No se encontró la publicación o el comentario no existe!", 0], 200);
        }
    }
}
