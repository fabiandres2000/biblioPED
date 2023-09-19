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

class DatosController extends Controller
{
    public function crearContenidoBusqueda(){
        $mongoClient = new Client('mongodb://localhost:27017');
        $mongoDB = $mongoClient->selectDatabase('ped_biblioteca');

        $collection = $mongoDB->selectCollection('contenido_busqueda');

        $datos = DB::connection('mysql')->table('cont_documento_modulos') 
        ->join('contenido_modulo', 'contenido_modulo.id', 'cont_documento_modulos.contenido')
        ->join('grados_modulos', 'grados_modulos.id', 'contenido_modulo.modulo')
        ->join('modulos_transversales', 'modulos_transversales.id', 'grados_modulos.modulo')
        ->select(
        "cont_documento_modulos.*", 
        "contenido_modulo.modulo", 
        "cont_documento_modulos.titulo", 
        "grados_modulos.grado_modulo", 
        "modulos_transversales.nombre as asignatura"
        )->get();

        $cont = 2015;
        foreach ($datos as $dato) {
            $contenido_texto = self::convertirHtmlATexto($dato->cont_documento);
            $imagen = self::obtenerPrimeraImagen($dato->cont_documento);

            $datoInport = [
                'id' => intval($cont),
                'id_contenido' => $dato->id,
                'tipo_contenido' => 'T',
                'contenido_texto' => $contenido_texto,
                'imagen' => $imagen,
                'modulo' => intval($dato->modulo),
                'titulo' => $dato->titulo,
                'grado' => $dato->grado_modulo,
                'asignatura' => $dato->asignatura
            ];

            $datoData = json_decode(json_encode($datoInport), true);
            $collection->insertOne($datoData);
            $cont++;
        }

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

    public function migrartablasCont()
    {
        $mongoClient = new Client('mongodb://localhost:27017');
        $mongoDB = $mongoClient->selectDatabase('ped_biblioteca');

        
        $resultados = DB::table('cont_documento_modulos')
        ->select('cont_documento_modulos.*')
        ->get();
        
        foreach ($resultados as $resultado) {
          
            $dato = [
                'id' => $resultado->id,
                'contenido' => $resultado->contenido,
                'titulo' => $resultado->titulo,
                'cont_documento' => $resultado->cont_documento,
                'created_at' => $resultado->created_at,
                'updated_at' => $resultado->updated_at,
            ];

            $collection = $mongoDB->selectCollection('cont_documento_modulos');

            $collection->insertOne($dato);
        }

        return response()->json("guardado", 200);
    }

    public function migrarVideos()
    {
        $mongoClient = new Client('mongodb://localhost:27017');
        $mongoDB = $mongoClient->selectDatabase('ped_biblioteca');

        /*
        $resultados = DB::connection('mysql')
        ->table('cont_didactico as cd')
        ->select('cd.contenido', 'cd.titulo', 'cd.cont_didactico', 'c.titu_contenido', 'a.nombre', 'm.grado_modulo')
        ->join('contenido as c', 'cd.contenido', '=', 'c.id')
        ->join('modulos as m', 'c.modulo', '=', 'm.id')
        ->join('asignaturas as a', 'm.asignatura', '=', 'a.id')
        ->get();
        */
        
        $resultados = DB::table('cont_didactico_modulos as cd')
        ->select('cd.contenido', 'cd.titulo', 'cd.cont_didactico', 'c.titu_contenido', 'a.nombre', 'm.grado_modulo')
        ->join('contenido_modulo as c', 'cd.contenido', '=', 'c.id')
        ->join('grados_modulos as m', 'c.modulo', '=', 'm.id')
        ->join('modulos_transversales as a', 'm.modulo', '=', 'a.id')
        ->get();
        

        foreach ($resultados as $resultado) {
          
            $dato = [
                'tipo_multimedia' => 'video',
                'tipo_contenido' => 'modulo transversal',
                'id_contenido' => $resultado->contenido,
                'asignatura' => $resultado->nombre,
                'grado' => $resultado->grado_modulo,
                'tema' => $resultado->titu_contenido,
                'tema_sin_tilde' => self::removeAccents($resultado->titu_contenido),
                'ruta' => $resultado->cont_didactico,
                'fecha' => date('d/m/Y'),
                'horas' => date('H:i:s'),
            ];

            $collection = $mongoDB->selectCollection('multimedia');

            $collection->insertOne($dato);
        }

        return response()->json("guardado", 200);
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
}
