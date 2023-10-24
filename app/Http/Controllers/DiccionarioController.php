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

use Smalot\PdfParser\Parser;

use Goutte\Client as GoutteClient;

require 'conexion.php';


class DiccionarioController extends Controller{

    protected static $mongoClient;
    protected static $mongoDB;

    public function __construct() {
        $instanciaConexion = new ClaseConexion();

        if (!isset(self::$mongoClient)) {
            self::$mongoClient = $instanciaConexion::$mongoClient;
        }

        if (!isset(self::$mongoDB)) {
            self::$mongoDB = $instanciaConexion::$mongoDB;
        }
    }

    public function palabras_tilde(Request $request) {
        $collection = self::$mongoDB->selectCollection('palabras');
      
        $resultado = $collection->find([
            'palabra' => ['$regex' => '[áéíóúÁÉÍÓÚ]']
        ])->toArray();

        $collection2 = self::$mongoDB->selectCollection('palabras_tilde');

        $palabras_agregadas = 0;
        foreach ($resultado as $line) {
            $line = $line->palabra;
            $line = mb_strtolower($line, 'UTF-8');
            if (preg_match('/[áéíóú]/u', $line)) {
                $wordCount = $collection2->count(['palabra' => $line]);
                if ($wordCount == 0) {
                    $elemento_ingresar = [
                        'palabra' => $line,
                        'sin_tilde' =>  self::removeAccents($line),
                    ];
                    $collection2->insertOne($elemento_ingresar);
                    $palabras_agregadas++;
                }
            }
        }
        return 'se agregaron: '.$palabras_agregadas;
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

    /*
     public function leerDiccionario(Request $request) {
        $collection = self::$mongoDB->selectCollection('diccionario');
        $pdfPath = public_path('palabras.txt');

        $contenido = file_get_contents($pdfPath);
        
        $palabrasArray = preg_split('/\r\n|\r|\n/', $contenido);

        $minusculas = [];
        foreach ($palabrasArray as $palabra) {
            if($palabra != '' && $palabra != " " &&  (count(explode('.', $palabra)) > 1)){
                $palabra = mb_strtolower($palabra, 'UTF-8');
                $partes = explode('.', $palabra, 2);
                $minusculas[] = [
                    "palabra" => $partes[0],
                    "significado" => $partes[1]
                ];
            }
        }

        $palabras_agregadas = 0;
        foreach ($minusculas as $palabra) {
            $collection->insertOne($palabra);
            $palabras_agregadas++;
        }

        return 'se agregaron: '.$palabras_agregadas;

    }
    */
    public function leerDiccionario(Request $request) {
        $collection = self::$mongoDB->selectCollection('palabras');
        $pdfPath = public_path('palabras.txt');

        $palabras = file_get_contents($pdfPath);
        $palabrasArray = preg_split('/[\s]+/', $palabras);

        $minusculas = [];
        foreach ($palabrasArray as $palabra) {
            $palabra = mb_strtolower($palabra, 'UTF-8');
            $minusculas[] = $palabra;
        }

        $palabras_agregadas = 0;
        foreach ($minusculas as $palabra) {
            $wordCount = $collection->count(['palabra' => $palabra]);
            if ($wordCount == 0) {
                $elemento_ingresar = [
                    'palabra' => $palabra,
                ];
                $collection->insertOne($elemento_ingresar);
                $palabras_agregadas++;
            }
        }

        return 'se agregaron: '.$palabras_agregadas;

    }

    public function limpiar_palabras(Request $request) {
        $collection = self::$mongoDB->selectCollection('palabras');
      
        $valoresUnicos = $collection->distinct('palabra');

        foreach ($valoresUnicos as $valorUnico) {
            // Encuentra los documentos duplicados
            $duplicados = $collection->find(['palabra' => $valorUnico])->toArray();
        
            if (count($duplicados) > 1) {
                $primerDocumento = array_shift($duplicados);
                foreach ($duplicados as $duplicado) {
                    $collection->deleteOne(
                        [
                            '_id' => $duplicado->_id,
                        ], 
                    );
                }
            }
        }
      
    }

    public function insertarPalabras(){
        $palabras = [];

        $collection_diccionario = self::$mongoDB->selectCollection('palabras');

        foreach ($palabras as $key) {
            $palabra = mb_strtolower($key, 'UTF-8');
            
            $palabra_encontrada = $collection_diccionario->count([
                'palabra' => $palabra
            ]);

            if($palabra_encontrada == 0){
                $elemento_ingresar = [
                    'palabra' => $palabra,
                ];
                $collection_diccionario->insertOne($elemento_ingresar);
            }else{
                echo $palabra." - ya esta.<br>";
            }
        }
    }

    public function palabraAproximada(Request $request) {
        $palabras = $request->input("cadena");

        $palabras = self::verificarTildes2($palabras);

        $palabras = explode(' ', $palabras);

        $collection = self::$mongoDB->selectCollection('palabras');
        $cache = [];

        $string_resultante = [];

        foreach ($palabras as $palabra) {
            $palabra = mb_strtolower($palabra, 'UTF-8');
            // Comprobar si ya hemos buscado esta palabra antes
            if (isset($cache[$palabra])) {
                $palabraMasSimilar = $cache[$palabra];
            } else {
                
                $resultado = $collection->find();

                $palabraMasSimilar = "";
                $distanciaEdicionMinima = PHP_INT_MAX;

                foreach ($resultado as $documento) {
                    $palabraEnColeccion = $documento->palabra;
                    $distanciaEdicion = levenshtein($palabra, $palabraEnColeccion);

                    if ($distanciaEdicion < $distanciaEdicionMinima) {
                        $distanciaEdicionMinima = $distanciaEdicion;
                        $palabraMasSimilar = $palabraEnColeccion;
                    }
                }

                $cache[$palabra] = $palabraMasSimilar;
            }

            if ($palabraMasSimilar !== "") {
                $string_resultante[] = $palabraMasSimilar;
            } else {
                $string_resultante[] = $palabra;
            }
        }

        if (count($cache) > 100) {
            $cache = [];
        }


        $concatenado = implode(' ', $string_resultante);
        
        $bandera = true;
        return response()->json(
            [
                "original" => $request->input("cadena"), 
                "cadena" => $concatenado, 
                "corregido" => $bandera
            ], 
            200
        );
    }

    public function verificarTildes2($cadena) {
        $collection = self::$mongoDB->selectCollection('palabras_tilde');
        $palabras = explode(' ', $cadena);

        $string_resultante = [];
        $bandera = false;
        
        foreach ($palabras as $key) {
            $condiciones = [
                'sin_tilde' => [
                    '$regex' => '^' . preg_quote($key) . '$',
                    '$options' => 'i' 
                ]
            ];

            $palabra = $collection->findOne($condiciones);
            
            if ($palabra) {
                $string_resultante[] = $palabra->palabra;
                $bandera = true;
            } else {
                $string_resultante[] = $key;
            }
        }

        $concatenado = implode(' ', $string_resultante);

        return $concatenado;
    }

    public function buscarPalabraDiccionario(Request $request){
        $palabra_r = $request->input("palabra");

        $collection_diccionario = self::$mongoDB->selectCollection('diccionario');

        $palabra_encontrada = $collection_diccionario->findOne([
            'palabra' => [
                '$regex' => '^' . preg_quote($palabra_r) . '$',
                '$options' => 'i' 
            ]
        ]);

        $bandera = false;
        $mensaje_opcional = "";

        if($palabra_encontrada == null){
            $palabra_r = self::palabraAproximadaDiccionario($palabra_r);
            $palabra_encontrada = $collection_diccionario->findOne([
                'palabra' => [
                    '$regex' => preg_quote($palabra_r),
                    '$options' => 'i' 
                ]
            ]);
            if($palabra_encontrada != null){
                $bandera = true;
                $mensaje_opcional = "Se muestran resultados de <strong>(".$palabra_r.")</strong><br>";
                $significado = $palabra_encontrada->significado;
            }else{
                $significado = "No se encontraron resultados para la palabra <strong>(".$palabra_r.")</strong>";
            }
        }else{
            $bandera = true;
            $significado = $palabra_encontrada->significado;
        }

        
        return [
            "mensaje_opcional" => $mensaje_opcional,
            "significado" => $significado,
            "bandera" => $bandera,
            "imagenes" => $palabra_encontrada->imagenes,
        ];
    }

    public function palabraAproximadaDiccionario($palabras) {

        $palabras = self::verificarTildes2($palabras);

        $palabras = explode(' ', $palabras);

        $collection = self::$mongoDB->selectCollection('palabras');
        $cache = [];

        $string_resultante = [];

        foreach ($palabras as $palabra) {
            // Comprobar si ya hemos buscado esta palabra antes
            if (isset($cache[$palabra])) {
                $palabraMasSimilar = $cache[$palabra];
            } else {
                
                $resultado = $collection->find();

                $palabraMasSimilar = "";
                $distanciaEdicionMinima = PHP_INT_MAX;

                foreach ($resultado as $documento) {
                    $palabraEnColeccion = $documento->palabra;
                    $distanciaEdicion = levenshtein($palabra, $palabraEnColeccion);

                    if ($distanciaEdicion < $distanciaEdicionMinima) {
                        $distanciaEdicionMinima = $distanciaEdicion;
                        $palabraMasSimilar = $palabraEnColeccion;
                    }
                }

                $cache[$palabra] = $palabraMasSimilar;
            }

            if ($palabraMasSimilar !== "") {
                $string_resultante[] = $palabraMasSimilar;
            } else {
                $string_resultante[] = $palabra;
            }
        }

        if (count($cache) > 100) {
            $cache = [];
        }


        $concatenado = implode(' ', $string_resultante);
        
        $bandera = true;
       
        return $concatenado;
    }

    public function insertarImagenes(){

        $collection_diccionario = self::$mongoDB->selectCollection('diccionario');

        $palabra_encontrada = $collection_diccionario->find(
            [], 
            [ 'skip' => 10108 ],
            [ 'limit' => 1000 ]
        );

        foreach ($palabra_encontrada as $documento) {
            $query = $documento->palabra;

            $client = new GoutteClient();
    
            $crawler = $client->request('GET', 'https://www.google.com/search?q=' . $query . '&tbm=isch&tbs=isz:ex,iszw:400,iszh:400');
    
            $htmlContent = $crawler->html();
          
            $dom = new \DOMDocument();
            $dom->loadHTML($htmlContent);
    
            $imageElements = $dom->getElementsByTagName('img');

            $element = $imageElements[2];
            $element2 = $imageElements[3];
            $element3 = $imageElements[4];
           
            
            if ($element) {
                $imageUrl =  $element->getAttribute('src');
                $imageData = base64_encode(file_get_contents($imageUrl));
            }else{
                $imageData = "";
            }

            if ($element2) {
                $imageUrl2 =  $element2->getAttribute('src');
                $imageData2 = base64_encode(file_get_contents($imageUrl2));
            }else{
                $imageData2 = "";
            }

            if ($element3) {
                $imageUrl3 =  $element3->getAttribute('src');
                $imageData3 = base64_encode(file_get_contents($imageUrl3));
            }else{
                $imageData3 = "";
            }


            $images = [
                ['url' => $imageData],
                ['url' => $imageData2],
                ['url' => $imageData3]
            ];

            $collection_diccionario->updateOne(
                ['_id' => new \MongoDB\BSON\ObjectID($documento->_id)],
                ['$set' => ['imagenes' => $images]]
            );
        }
    }
}