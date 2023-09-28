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
       
        $elemento_ingresar = [
            'id_usuario' => Session::get('id'),
            'detalle' => $detalle,
            'imagen' => $nombreArchivo,
            'comentarios' => [],
            'likes' => [],
            'fecha' => date('d/m/Y'),
            'horas' => date('H:i:s'),
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

            $dateTimeA = \DateTime::createFromFormat('d/m/Y H:i:s', $publicacion['fecha'] . ' ' . $publicacion['horas'], new \DateTimeZone('America/Bogota'));

            $publicacion->fecha_formateada = $dateTimeA->format('d M, Y \a\ \l\a\s g.i A');

            foreach ($publicacion->comentarios as $comentario){
                $comentario->usuario = $collection2->findOne([
                    '_id' => new \MongoDB\BSON\ObjectID($comentario->id_usuario),
                ]);
            }

            $comentarios = $publicacion->comentarios;
            if(count($comentarios) > 0){
                $comentarios = iterator_to_array($foro['comentarios']);
                usort($comentarios, function($a, $b) {
                    $dateTimeA = \DateTime::createFromFormat('d/m/Y H:i:s', $a['fecha'] . ' ' . $a['horas'], new \DateTimeZone('America/Bogota'));
                    $dateTimeB = \DateTime::createFromFormat('d/m/Y H:i:s', $b['fecha'] . ' ' . $b['horas'], new \DateTimeZone('America/Bogota'));
                    return $dateTimeB <=> $dateTimeA; 
                });
            
                $publicacion->comentarios = $comentarios;
            }
        }

        return $publicaciones;
    }
}
