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

    public function insertarPaises(){
        $paises = '[
            {
                "id" : 144,
                "name" : "Afganistán"
            },
            {
                "id" : 114,
                "name" : "Albania"
            },
            {
                "id" : 18,
                "name" : "Alemania"
            },
            {
                "id" : 98,
                "name" : "Algeria"
            },
            {
                "id" : 145,
                "name" : "Andorra"
            },
            {
                "id" : 119,
                "name" : "Angola"
            },
            {
                "id" : 4,
                "name" : "Anguilla"
            },
            {
                "id" : 147,
                "name" : "Antigua y Barbuda"
            },
            {
                "id" : 207,
                "name" : "Antillas Holandesas"
            },
            {
                "id" : 91,
                "name" : "Arabia Saudita"
            },
            {
                "id" : 5,
                "name" : "Argentina"
            },
            {
                "id" : 6,
                "name" : "Armenia"
            },
            {
                "id" : 142,
                "name" : "Aruba"
            },
            {
                "id" : 1,
                "name" : "Australia"
            },
            {
                "id" : 2,
                "name" : "Austria"
            },
            {
                "id" : 3,
                "name" : "Azerbaiyán"
            },
            {
                "id" : 80,
                "name" : "Bahamas"
            },
            {
                "id" : 127,
                "name" : "Bahrein"
            },
            {
                "id" : 149,
                "name" : "Bangladesh"
            },
            {
                "id" : 128,
                "name" : "Barbados"
            },
            {
                "id" : 9,
                "name" : "Bélgica"
            },
            {
                "id" : 8,
                "name" : "Belice"
            },
            {
                "id" : 151,
                "name" : "Benín"
            },
            {
                "id" : 10,
                "name" : "Bermudas"
            },
            {
                "id" : 7,
                "name" : "Bielorrusia"
            },
            {
                "id" : 123,
                "name" : "Bolivia"
            },
            {
                "id" : 79,
                "name" : "Bosnia y Herzegovina"
            },
            {
                "id" : 100,
                "name" : "Botsuana"
            },
            {
                "id" : 12,
                "name" : "Brasil"
            },
            {
                "id" : 155,
                "name" : "Brunéi"
            },
            {
                "id" : 11,
                "name" : "Bulgaria"
            },
            {
                "id" : 156,
                "name" : "Burkina Faso"
            },
            {
                "id" : 157,
                "name" : "Burundi"
            },
            {
                "id" : 152,
                "name" : "Bután"
            },
            {
                "id" : 159,
                "name" : "Cabo Verde"
            },
            {
                "id" : 158,
                "name" : "Camboya"
            },
            {
                "id" : 31,
                "name" : "Camerún"
            },
            {
                "id" : 32,
                "name" : "Canadá"
            },
            {
                "id" : 130,
                "name" : "Chad"
            },
            {
                "id" : 81,
                "name" : "Chile"
            },
            {
                "id" : 35,
                "name" : "China"
            },
            {
                "id" : 33,
                "name" : "Chipre"
            },
            {
                "id" : 82,
                "name" : "Colombia"
            },
            {
                "id" : 164,
                "name" : "Comores"
            },
            {
                "id" : 112,
                "name" : "Congo (Brazzaville)"
            },
            {
                "id" : 165,
                "name" : "Congo (Kinshasa)"
            },
            {
                "id" : 166,
                "name" : "Cook, Islas"
            },
            {
                "id" : 84,
                "name" : "Corea del Norte"
            },
            {
                "id" : 69,
                "name" : "Corea del Sur"
            },
            {
                "id" : 168,
                "name" : "Costa de Marfil"
            },
            {
                "id" : 36,
                "name" : "Costa Rica"
            },
            {
                "id" : 71,
                "name" : "Croacia"
            },
            {
                "id" : 113,
                "name" : "Cuba"
            },
            {
                "id" : 22,
                "name" : "Dinamarca"
            },
            {
                "id" : 169,
                "name" : "Djibouti, Yibuti"
            },
            {
                "id" : 103,
                "name" : "Ecuador"
            },
            {
                "id" : 23,
                "name" : "Egipto"
            },
            {
                "id" : 51,
                "name" : "El Salvador"
            },
            {
                "id" : 93,
                "name" : "Emiratos Árabes Unidos"
            },
            {
                "id" : 173,
                "name" : "Eritrea"
            },
            {
                "id" : 52,
                "name" : "Eslovaquia"
            },
            {
                "id" : 53,
                "name" : "Eslovenia"
            },
            {
                "id" : 28,
                "name" : "España"
            },
            {
                "id" : 55,
                "name" : "Estados Unidos"
            },
            {
                "id" : 68,
                "name" : "Estonia"
            },
            {
                "id" : 121,
                "name" : "Etiopía"
            },
            {
                "id" : 175,
                "name" : "Feroe, Islas"
            },
            {
                "id" : 90,
                "name" : "Filipinas"
            },
            {
                "id" : 63,
                "name" : "Finlandia"
            },
            {
                "id" : 176,
                "name" : "Fiyi"
            },
            {
                "id" : 64,
                "name" : "Francia"
            },
            {
                "id" : 180,
                "name" : "Gabón"
            },
            {
                "id" : 181,
                "name" : "Gambia"
            },
            {
                "id" : 21,
                "name" : "Georgia"
            },
            {
                "id" : 105,
                "name" : "Ghana"
            },
            {
                "id" : 143,
                "name" : "Gibraltar"
            },
            {
                "id" : 184,
                "name" : "Granada"
            },
            {
                "id" : 20,
                "name" : "Grecia"
            },
            {
                "id" : 94,
                "name" : "Groenlandia"
            },
            {
                "id" : 17,
                "name" : "Guadalupe"
            },
            {
                "id" : 185,
                "name" : "Guatemala"
            },
            {
                "id" : 186,
                "name" : "Guernsey"
            },
            {
                "id" : 187,
                "name" : "Guinea"
            },
            {
                "id" : 172,
                "name" : "Guinea Ecuatorial"
            },
            {
                "id" : 188,
                "name" : "Guinea-Bissau"
            },
            {
                "id" : 189,
                "name" : "Guyana"
            },
            {
                "id" : 16,
                "name" : "Haiti"
            },
            {
                "id" : 137,
                "name" : "Honduras"
            },
            {
                "id" : 73,
                "name" : "Hong Kong"
            },
            {
                "id" : 14,
                "name" : "Hungría"
            },
            {
                "id" : 25,
                "name" : "India"
            },
            {
                "id" : 74,
                "name" : "Indonesia"
            },
            {
                "id" : 140,
                "name" : "Irak"
            },
            {
                "id" : 26,
                "name" : "Irán"
            },
            {
                "id" : 27,
                "name" : "Irlanda"
            },
            {
                "id" : 215,
                "name" : "Isla Pitcairn"
            },
            {
                "id" : 83,
                "name" : "Islandia"
            },
            {
                "id" : 228,
                "name" : "Islas Salomón"
            },
            {
                "id" : 58,
                "name" : "Islas Turcas y Caicos"
            },
            {
                "id" : 154,
                "name" : "Islas Virgenes Británicas"
            },
            {
                "id" : 24,
                "name" : "Israel"
            },
            {
                "id" : 29,
                "name" : "Italia"
            },
            {
                "id" : 132,
                "name" : "Jamaica"
            },
            {
                "id" : 70,
                "name" : "Japón"
            },
            {
                "id" : 193,
                "name" : "Jersey"
            },
            {
                "id" : 75,
                "name" : "Jordania"
            },
            {
                "id" : 30,
                "name" : "Kazajstán"
            },
            {
                "id" : 97,
                "name" : "Kenia"
            },
            {
                "id" : 34,
                "name" : "Kirguistán"
            },
            {
                "id" : 195,
                "name" : "Kiribati"
            },
            {
                "id" : 37,
                "name" : "Kuwait"
            },
            {
                "id" : 196,
                "name" : "Laos"
            },
            {
                "id" : 197,
                "name" : "Lesotho"
            },
            {
                "id" : 38,
                "name" : "Letonia"
            },
            {
                "id" : 99,
                "name" : "Líbano"
            },
            {
                "id" : 198,
                "name" : "Liberia"
            },
            {
                "id" : 39,
                "name" : "Libia"
            },
            {
                "id" : 126,
                "name" : "Liechtenstein"
            },
            {
                "id" : 40,
                "name" : "Lituania"
            },
            {
                "id" : 41,
                "name" : "Luxemburgo"
            },
            {
                "id" : 85,
                "name" : "Macedonia"
            },
            {
                "id" : 134,
                "name" : "Madagascar"
            },
            {
                "id" : 76,
                "name" : "Malasia"
            },
            {
                "id" : 125,
                "name" : "Malawi"
            },
            {
                "id" : 200,
                "name" : "Maldivas"
            },
            {
                "id" : 133,
                "name" : "Malí"
            },
            {
                "id" : 86,
                "name" : "Malta"
            },
            {
                "id" : 131,
                "name" : "Man, Isla de"
            },
            {
                "id" : 104,
                "name" : "Marruecos"
            },
            {
                "id" : 201,
                "name" : "Martinica"
            },
            {
                "id" : 202,
                "name" : "Mauricio"
            },
            {
                "id" : 108,
                "name" : "Mauritania"
            },
            {
                "id" : 42,
                "name" : "México"
            },
            {
                "id" : 43,
                "name" : "Moldavia"
            },
            {
                "id" : 44,
                "name" : "Mónaco"
            },
            {
                "id" : 139,
                "name" : "Mongolia"
            },
            {
                "id" : 117,
                "name" : "Mozambique"
            },
            {
                "id" : 205,
                "name" : "Myanmar"
            },
            {
                "id" : 102,
                "name" : "Namibia"
            },
            {
                "id" : 206,
                "name" : "Nauru"
            },
            {
                "id" : 107,
                "name" : "Nepal"
            },
            {
                "id" : 209,
                "name" : "Nicaragua"
            },
            {
                "id" : 210,
                "name" : "Níger"
            },
            {
                "id" : 115,
                "name" : "Nigeria"
            },
            {
                "id" : 212,
                "name" : "Norfolk Island"
            },
            {
                "id" : 46,
                "name" : "Noruega"
            },
            {
                "id" : 208,
                "name" : "Nueva Caledonia"
            },
            {
                "id" : 45,
                "name" : "Nueva Zelanda"
            },
            {
                "id" : 213,
                "name" : "Omán"
            },
            {
                "id" : 19,
                "name" : "Países Bajos, Holanda"
            },
            {
                "id" : 87,
                "name" : "Pakistán"
            },
            {
                "id" : 124,
                "name" : "Panamá"
            },
            {
                "id" : 88,
                "name" : "Papúa-Nueva Guinea"
            },
            {
                "id" : 110,
                "name" : "Paraguay"
            },
            {
                "id" : 89,
                "name" : "Perú"
            },
            {
                "id" : 178,
                "name" : "Polinesia Francesa"
            },
            {
                "id" : 47,
                "name" : "Polonia"
            },
            {
                "id" : 48,
                "name" : "Portugal"
            },
            {
                "id" : 246,
                "name" : "Puerto Rico"
            },
            {
                "id" : 216,
                "name" : "Qatar"
            },
            {
                "id" : 13,
                "name" : "Reino Unido"
            },
            {
                "id" : 65,
                "name" : "República Checa"
            },
            {
                "id" : 138,
                "name" : "República Dominicana"
            },
            {
                "id" : 49,
                "name" : "Reunión"
            },
            {
                "id" : 217,
                "name" : "Ruanda"
            },
            {
                "id" : 72,
                "name" : "Rumanía"
            },
            {
                "id" : 50,
                "name" : "Rusia"
            },
            {
                "id" : 242,
                "name" : "Sáhara Occidental"
            },
            {
                "id" : 223,
                "name" : "Samoa"
            },
            {
                "id" : 219,
                "name" : "San Cristobal y Nevis"
            },
            {
                "id" : 224,
                "name" : "San Marino"
            },
            {
                "id" : 221,
                "name" : "San Pedro y Miquelón"
            },
            {
                "id" : 225,
                "name" : "San Tomé y Príncipe"
            },
            {
                "id" : 222,
                "name" : "San Vincente y Granadinas"
            },
            {
                "id" : 218,
                "name" : "Santa Elena"
            },
            {
                "id" : 220,
                "name" : "Santa Lucía"
            },
            {
                "id" : 135,
                "name" : "Senegal"
            },
            {
                "id" : 226,
                "name" : "Serbia y Montenegro"
            },
            {
                "id" : 109,
                "name" : "Seychelles"
            },
            {
                "id" : 227,
                "name" : "Sierra Leona"
            },
            {
                "id" : 77,
                "name" : "Singapur"
            },
            {
                "id" : 106,
                "name" : "Siria"
            },
            {
                "id" : 229,
                "name" : "Somalia"
            },
            {
                "id" : 120,
                "name" : "Sri Lanka"
            },
            {
                "id" : 141,
                "name" : "Sudáfrica"
            },
            {
                "id" : 232,
                "name" : "Sudán"
            },
            {
                "id" : 67,
                "name" : "Suecia"
            },
            {
                "id" : 66,
                "name" : "Suiza"
            },
            {
                "id" : 54,
                "name" : "Surinam"
            },
            {
                "id" : 234,
                "name" : "Swazilandia"
            },
            {
                "id" : 56,
                "name" : "Tadjikistan"
            },
            {
                "id" : 92,
                "name" : "Tailandia"
            },
            {
                "id" : 78,
                "name" : "Taiwan"
            },
            {
                "id" : 101,
                "name" : "Tanzania"
            },
            {
                "id" : 171,
                "name" : "Timor Oriental"
            },
            {
                "id" : 136,
                "name" : "Togo"
            },
            {
                "id" : 235,
                "name" : "Tokelau"
            },
            {
                "id" : 236,
                "name" : "Tonga"
            },
            {
                "id" : 237,
                "name" : "Trinidad y Tobago"
            },
            {
                "id" : 122,
                "name" : "Túnez"
            },
            {
                "id" : 57,
                "name" : "Turkmenistan"
            },
            {
                "id" : 59,
                "name" : "Turquía"
            },
            {
                "id" : 239,
                "name" : "Tuvalu"
            },
            {
                "id" : 62,
                "name" : "Ucrania"
            },
            {
                "id" : 60,
                "name" : "Uganda"
            },
            {
                "id" : 111,
                "name" : "Uruguay"
            },
            {
                "id" : 61,
                "name" : "Uzbekistán"
            },
            {
                "id" : 240,
                "name" : "Vanuatu"
            },
            {
                "id" : 95,
                "name" : "Venezuela"
            },
            {
                "id" : 15,
                "name" : "Vietnam"
            },
            {
                "id" : 241,
                "name" : "Wallis y Futuna"
            },
            {
                "id" : 243,
                "name" : "Yemen"
            },
            {
                "id" : 116,
                "name" : "Zambia"
            },
            {
                "id" : 96,
                "name" : "Zimbabwe"
            }
        ]';

        $array_php = json_decode($paises, true);

        $collection = self::$mongoDB->selectCollection('palabras');

        foreach ($array_php as $key) {
            $elemento_ingresar = [
                'palabra' => str_replace(range('A', 'Z'), range('a', 'z'), $key["name"]),
            ];
            $collection->insertOne($elemento_ingresar);
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
            $dosPrimerasLetras = substr($palabra, 0, 2);

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
}