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

    public function leerDiccionario(Request $request) {
        $collection = self::$mongoDB->selectCollection('diccionario');

        $rutaPdf = public_path('diccionario.pdf');

        $pdfParser = new Parser();

        $pdf = $pdfParser->parseFile($rutaPdf);

        $texto = $pdf->getText();

        $palabrasArray = explode('->', $texto);
        

        $palabras_agregadas = 0;
        $i = 0;
        foreach ($palabrasArray as $palabra) {
            if($i > 0){
                $palabra = explode('.', $palabra, 2);
                $elemento_ingresar = [
                    'palabra' => $palabra[0],
                    'significado' => $palabra[1],
                ];
                $collection->insertOne($elemento_ingresar);
                $palabras_agregadas++;
            }
            $i++;
        }
        
        return 'se agregaron: '.$palabras_agregadas;

    }

    public function limpiar_palabras(Request $request) {
        $collection_diccionario = self::$mongoDB->selectCollection('diccionario');
      

        $expresionRegular = new \MongoDB\BSON\Regex("[(1)]");
        $valoresUnicos = $collection_diccionario->find(
            ['palabra' => $expresionRegular],
        )->toArray();

        $caracteresEspeciales = array('1', '(', ')', ' ');
        foreach ($valoresUnicos as &$documento) {
            $documento->palabra = str_replace($caracteresEspeciales, '', $documento->palabra);
            $collection_diccionario->updateOne(
                ['_id' => new \MongoDB\BSON\ObjectID($documento->_id)], 
                [            
                    '$set' => [
                        'palabra' => $documento->palabra,
                    ]
                ]
            );
        }
    }

    public function insertarPalabras(){
        $collection_diccionario = self::$mongoDB->selectCollection('diccionario');
        $collection = self::$mongoDB->selectCollection('palabras');

        $palabras = '[
            {
            "name": "Afghanistan",
            "es_name": "Afganistán"
            },
            {
            "name": "Albania",
            "es_name": "Albania"
            },
            {
            "name": "Algeria",
            "es_name": "Algeria"
            },
            {
            "name": "American Samoa",
            "es_name": "Samoa Americana"
            },
            {
            "name": "Andorra",
            "es_name": "Andorra"
            },
            {
            "name": "Angola",
            "es_name": "Angola"
            },
            {
            "name": "Anguilla",
            "es_name": "Anguilla"
            },
            {
            "name": "Antarctica",
            "es_name": "Antártida"
            },
            {
            "name": "Antigua and Barbuda",
            "es_name": "Antigua y Barbuda"
            },
            {
            "name": "Argentina",
            "es_name": "Argentina"
            },
            {
            "name": "Armenia",
            "es_name": "Armenia"
            },
            {
            "name": "Aruba",
            "es_name": "Aruba"
            },
            {
            "name": "Australia",
            "es_name": "Australia"
            },
            {
            "name": "Austria",
            "es_name": "Austria"
            },
            {
            "name": "Azerbaijan",
            "es_name": "Azerbaiyán"
            },
            {
            "name": "Bahamas",
            "es_name": "Bahamas"
            },
            {
            "name": "Bahrain",
            "es_name": "Bahrein"
            },
            {
            "name": "Bangladesh",
            "es_name": "Bangladesh"
            },
            {
            "name": "Barbados",
            "es_name": "Barbados"
            },
            {
            "name": "Belarus",
            "es_name": "Bielorrusia"
            },
            {
            "name": "Belgium",
            "es_name": "Bélgica"
            },
            {
            "name": "Belize",
            "es_name": "Belice"
            },
            {
            "name": "Benin",
            "es_name": "Benín"
            },
            {
            "name": "Bermuda",
            "es_name": "Bermuda"
            },
            {
            "name": "Bhutan",
            "es_name": "Bután"
            },
            {
            "name": "Bolivia",
            "es_name": "Bolivia"
            },
            {
            "name": "Bosnia and Herzegovina",
            "es_name": "Bosnia-Herzegovina"
            },
            {
            "name": "Botswana",
            "es_name": "Botswana"
            },
            {
            "name": "Brazil",
            "es_name": "Brasil"
            },
            {
            "name": "Brunei Darussalam",
            "es_name": "Brunei"
            },
            {
            "name": "Bulgaria",
            "es_name": "Bulgaria"
            },
            {
            "name": "Burkina Faso",
            "es_name": "Burkina Faso"
            },
            {
            "name": "Burundi",
            "es_name": "Burundi"
            },
            {
            "name": "Cambodia",
            "es_name": "Camboya"
            },
            {
            "name": "Cameroon",
            "es_name": "Camerún"
            },
            {
            "name": "Canada",
            "es_name": "Canadá"
            },
            {
            "name": "Cape Verde",
            "es_name": "Cabo Verde"
            },
            {
            "name": "Cayman Islands",
            "es_name": "Islas Caimán"
            },
            {
            "name": "Central African Republic",
            "es_name": "República Centroafricana"
            },
            {
            "name": "Chad",
            "es_name": "Chad"
            },
            {
            "name": "Chile",
            "es_name": "Chile"
            },
            {
            "name": "China",
            "es_name": "China"
            },
            {
            "name": "Christmas Island",
            "es_name": "Isla de Navidad"
            },
            {
            "name": "Cocos (Keeling) Islands",
            "es_name": "Islas Cocos"
            },
            {
            "name": "Colombia",
            "es_name": "Colombia"
            },
            {
            "name": "Comoros",
            "es_name": "Comores"
            },
            {
            "name": "Congo",
            "es_name": "República del Congo"
            },
            {
            "name": "Congo, The Democratic Republic of the",
            "es_name": "República Democrática del Congo"
            },
            {
            "name": "Cook Islands",
            "es_name": "Islas Cook"
            },
            {
            "name": "Costa Rica",
            "es_name": "Costa Rica"
            },
            {
            "es_name": "Costa de Marfíl"
            },
            {
            "name": "Croatia",
            "es_name": "Croacia"
            },
            {
            "name": "Cuba",
            "es_name": "Cuba"
            },
            {
            "name": "Cyprus",
            "es_name": "Chipre"
            },
            {
            "name": "Czech Republic",
            "es_name": "República Checa"
            },
            {
            "name": "Denmark",
            "es_name": "Dinamarca"
            },
            {
            "name": "Djibouti",
            "es_name": "Djibouti"
            },
            {
            "name": "Dominica",
            "es_name": "Dominica"
            },
            {
            "name": "Dominican Republic",
            "es_name": "República Dominicana"
            },
            {
            "name": "Ecuador",
            "es_name": "Ecuador"
            },
            {
            "name": "Egypt",
            "es_name": "Egipto"
            },
            {
            "name": "El Salvador",
            "es_name": "El Salvador"
            },
            {
            "name": "Equatorial Guinea",
            "es_name": "Guinea Ecuatorial"
            },
            {
            "name": "Eritrea",
            "es_name": "Eritrea"
            },
            {
            "name": "Estonia",
            "es_name": "Estonia"
            },
            {
            "name": "Ethiopia",
            "es_name": "Etiopía"
            },
            {
            "name": "Falkland Islands (Malvinas)",
            "es_name": "Islas Malvinas"
            },
            {
            "name": "Faroe Islands",
            "es_name": "Islas Feroe"
            },
            {
            "name": "Fiji",
            "es_name": "Fiji"
            },
            {
            "name": "Finland",
            "es_name": "Finlandia"
            },
            {
            "name": "France",
            "es_name": "Francia"
            },
            {
            "name": "French Guiana",
            "es_name": "Guyana Francesa"
            },
            {
            "name": "French Polynesia",
            "es_name": "Polinesia Francesa"
            },
            {
            "name": "French Southern Territories",
            "es_name": "Tierras Australes y Antárticas Francesas"
            },
            {
            "name": "Gabon",
            "es_name": "Gabón"
            },
            {
            "name": "Gambia",
            "es_name": "Gambia"
            },
            {
            "name": "Georgia",
            "es_name": "Georgia"
            },
            {
            "name": "Germany",
            "es_name": "Alemania"
            },
            {
            "name": "Ghana",
            "es_name": "Ghana"
            },
            {
            "name": "Gibraltar",
            "es_name": "Gibraltar"
            },
            {
            "name": "Greece",
            "es_name": "Grecia"
            },
            {
            "name": "Greenland",
            "es_name": "Groenlandia"
            },
            {
            "name": "Grenada",
            "es_name": "Granada"
            },
            {
            "name": "Guadeloupe",
            "es_name": "Guadalupe"
            },
            {
            "name": "Guam",
            "es_name": "Guam"
            },
            {
            "name": "Guatemala",
            "es_name": "Guatemala"
            },
            {
            "name": "Guinea",
            "es_name": "Guinea"
            },
            {
            "name": "Guinea-Bissau",
            "es_name": "Guinea-Bissau"
            },
            {
            "name": "Guyana",
            "es_name": "Guyana"
            },
            {
            "name": "Haiti",
            "es_name": "Haití"
            },
            {
            "name": "Holy See (Vatican City State)",
            "es_name": "Vaticano"
            },
            {
            "name": "Honduras",
            "es_name": "Honduras"
            },
            {
            "name": "Hong Kong",
            "es_name": "Hong Kong"
            },
            {
            "name": "Hungary",
            "es_name": "Hungría"
            },
            {
            "name": "Iceland",
            "es_name": "Islandia"
            },
            {
            "name": "India",
            "es_name": "India"
            },
            {
            "name": "Indonesia",
            "es_name": "Indonesia"
            },
            {
            "name": "Iran, Islamic Republic Of",
            "es_name": "Irán"
            },
            {
            "name": "Iraq",
            "es_name": "Iraq"
            },
            {
            "name": "Ireland",
            "es_name": "Irlanda"
            },
            {
            "name": "Israel",
            "es_name": "Israel"
            },
            {
            "name": "Italy",
            "es_name": "Italia"
            },
            {
            "name": "Jamaica",
            "es_name": "Jamaica"
            },
            {
            "name": "Japan",
            "es_name": "Japón"
            },
            {
            "name": "Jordan",
            "es_name": "Jordania"
            },
            {
            "name": "Kazakhstan",
            "es_name": "Kazajstán"
            },
            {
            "name": "Kenya",
            "es_name": "Kenia"
            },
            {
            "name": "Kiribati",
            "es_name": "Kiribati"
            },
            {
            "es_name": "Corea del Norte"
            },
            {
            "name": "Korea, Republic of",
            "es_name": "Corea del Sur"
            },
            {
            "name": "Kuwait",
            "es_name": "Kuwait"
            },
            {
            "name": "Kyrgyzstan",
            "es_name": "Kirguistán"
            },
            {
            "es_name": "Laos"
            },
            {
            "name": "Latvia",
            "es_name": "Letonia"
            },
            {
            "name": "Lebanon",
            "es_name": "Líbano"
            },
            {
            "name": "Lesotho",
            "es_name": "Lesotho"
            },
            {
            "name": "Liberia",
            "es_name": "Liberia"
            },
            {
            "name": "Libyan Arab Jamahiriya",
            "es_name": "Libia"
            },
            {
            "name": "Liechtenstein",
            "es_name": "Liechtenstein"
            },
            {
            "name": "Lithuania",
            "es_name": "Lituania"
            },
            {
            "name": "Luxembourg",
            "es_name": "Luxemburgo"
            },
            {
            "name": "Macao",
            "es_name": "Macao"
            },
            {
            "name": "Macedonia, The Former Yugoslav Republic of",
            "es_name": "Macedonia"
            },
            {
            "name": "Madagascar",
            "es_name": "Madagascar"
            },
            {
            "name": "Malawi",
            "es_name": "Malawi"
            },
            {
            "name": "Malaysia",
            "es_name": "Malasia"
            },
            {
            "name": "Maldives",
            "es_name": "Maldivas"
            },
            {
            "name": "Mali",
            "es_name": "Mali"
            },
            {
            "name": "Malta",
            "es_name": "Malta"
            },
            {
            "name": "Marshall Islands",
            "es_name": "Islas Marshall"
            },
            {
            "name": "Martinique",
            "es_name": "Martinica"
            },
            {
            "name": "Mauritania",
            "es_name": "Mauritania"
            },
            {
            "name": "Mauritius",
            "es_name": "Mauricio"
            },
            {
            "name": "Mayotte",
            "es_name": "Mayotte"
            },
            {
            "name": "Mexico",
            "es_name": "México"
            },
            {
            "name": "Micronesia, Federated States of",
            "es_name": "Estados Federados de Micronesia"
            },
            {
            "name": "Moldova, Republic of",
            "es_name": "Moldavia"
            },
            {
            "name": "Monaco",
            "es_name": "Mónaco"
            },
            {
            "name": "Mongolia",
            "es_name": "Mongolia"
            },
            {
            "name": "Montserrat",
            "es_name": "Montserrat"
            },
            {
            "name": "Morocco",
            "es_name": "Marruecos"
            },
            {
            "name": "Mozambique",
            "es_name": "Mozambique"
            },
            {
            "name": "Myanmar",
            "es_name": "Myanmar"
            },
            {
            "name": "Namibia",
            "es_name": "Namibia"
            },
            {
            "name": "Nauru",
            "es_name": "Nauru"
            },
            {
            "name": "Nepal",
            "es_name": "Nepal"
            },
            {
            "name": "Netherlands",
            "es_name": "Holanda"
            },
            {
            "name": "Netherlands Antilles",
            "es_name": "Antillas Holandesas"
            },
            {
            "name": "New Caledonia",
            "es_name": "Nueva Caledonia"
            },
            {
            "name": "New Zealand",
            "es_name": "Nueva Zelanda"
            },
            {
            "name": "Nicaragua",
            "es_name": "Nicaragua"
            },
            {
            "name": "Niger",
            "es_name": "Niger"
            },
            {
            "name": "Nigeria",
            "es_name": "Nigeria"
            },
            {
            "name": "Niue",
            "es_name": "Niue"
            },
            {
            "name": "Norfolk Island",
            "es_name": "Islas Norfolk"
            },
            {
            "name": "Northern Mariana Islands",
            "es_name": "Islas Marianas del Norte"
            },
            {
            "name": "Norway",
            "es_name": "Noruega"
            },
            {
            "name": "Oman",
            "es_name": "Omán"
            },
            {
            "name": "Pakistan",
            "es_name": "Pakistán"
            },
            {
            "name": "Palau",
            "es_name": "Palau"
            },
            {
            "name": "Palestinian Territory, Occupied",
            "es_name": "Palestina"
            },
            {
            "name": "Panama",
            "es_name": "Panamá"
            },
            {
            "name": "Papua New Guinea",
            "es_name": "Papua Nueva Guinea"
            },
            {
            "name": "Paraguay",
            "es_name": "Paraguay"
            },
            {
            "name": "Peru",
            "es_name": "Perú"
            },
            {
            "name": "Philippines",
            "es_name": "Filipinas"
            },
            {
            "name": "Pitcairn",
            "es_name": "Pitcairn"
            },
            {
            "name": "Poland",
            "es_name": "Polonia"
            },
            {
            "name": "Portugal",
            "es_name": "Portugal"
            },
            {
            "name": "Puerto Rico",
            "es_name": "Puerto Rico"
            },
            {
            "name": "Qatar",
            "es_name": "Qatar"
            },
            {
            "name": "Reunion",
            "es_name": "Reunión"
            },
            {
            "name": "Romania",
            "es_name": "Rumanía"
            },
            {
            "name": "Russian Federation",
            "es_name": "Rusia"
            },
            {
            "name": "Rwanda",
            "es_name": "Ruanda"
            },
            {
            "name": "Saint Helena",
            "es_name": "Santa Helena"
            },
            {
            "name": "Saint Kitts and Nevis",
            "es_name": "San Kitts y Nevis"
            },
            {
            "name": "Saint Lucia",
            "es_name": "Santa Lucía"
            },
            {
            "name": "Saint Vincent and the Grenadines",
            "es_name": "San Vicente y Granadinas"
            },
            {
            "name": "Samoa",
            "es_name": "Samoa"
            },
            {
            "name": "San Marino",
            "es_name": "San Marino"
            },
            {
            "name": "Sao Tome and Principe",
            "es_name": "Santo Tomé y Príncipe"
            },
            {
            "name": "Saudi Arabia",
            "es_name": "Arabia Saudita"
            },
            {
            "name": "Senegal",
            "es_name": "Senegal"
            },
            {
            "name": "Serbia and Montenegro",
            "es_name": "Serbia"
            },
            {
            "name": "Seychelles",
            "es_name": "Seychelles"
            },
            {
            "name": "Sierra Leone",
            "es_name": "Sierra Leona"
            },
            {
            "name": "Singapore",
            "es_name": "Singapur"
            },
            {
            "name": "Slovakia",
            "es_name": "Eslovaquía"
            },
            {
            "name": "Slovenia",
            "es_name": "Eslovenia"
            },
            {
            "name": "Solomon Islands",
            "es_name": "Islas Salomón"
            },
            {
            "name": "Somalia",
            "es_name": "Somalia"
            },
            {
            "name": "South Africa",
            "es_name": "Sudáfrica"
            },
            {
            "name": "Spain",
            "es_name": "España"
            },
            {
            "name": "Sri Lanka",
            "es_name": "Sri Lanka"
            },
            {
            "name": "Sudan",
            "es_name": "Sudán"
            },
            {
            "name": "Suriname",
            "es_name": "Surinam"
            },
            {
            "name": "Swaziland",
            "es_name": "Swazilandia"
            },
            {
            "name": "Sweden",
            "es_name": "Suecia"
            },
            {
            "name": "Switzerland",
            "es_name": "Suiza"
            },
            {
            "name": "Syrian Arab Republic",
            "es_name": "Siria"
            },
            {
            "name": "Taiwan, Province of China",
            "es_name": "Taiwán"
            },
            {
            "name": "Tajikistan",
            "es_name": "Tadjikistan"
            },
            {
            "name": "Tanzania, United Republic of",
            "es_name": "Tanzania"
            },
            {
            "name": "Thailand",
            "es_name": "Tailandia"
            },
            {
            "name": "Timor-Leste",
            "es_name": "Timor Oriental"
            },
            {
            "name": "Togo",
            "es_name": "Togo"
            },
            {
            "name": "Tokelau",
            "es_name": "Tokelau"
            },
            {
            "name": "Tonga",
            "es_name": "Tonga"
            },
            {
            "name": "Trinidad and Tobago",
            "es_name": "Trinidad y Tobago"
            },
            {
            "name": "Tunisia",
            "es_name": "Túnez"
            },
            {
            "name": "Turkey",
            "es_name": "Turquía"
            },
            {
            "name": "Turkmenistan",
            "es_name": "Turkmenistan"
            },
            {
            "name": "Turks and Caicos Islands",
            "es_name": "Islas Turcas y Caicos"
            },
            {
            "name": "Tuvalu",
            "es_name": "Tuvalu"
            },
            {
            "name": "Uganda",
            "es_name": "Uganda"
            },
            {
            "name": "Ukraine",
            "es_name": "Ucrania"
            },
            {
            "name": "United Arab Emirates",
            "es_name": "Emiratos Árabes Unidos"
            },
            {
            "name": "United Kingdom",
            "es_name": "Reino Unido"
            },
            {
            "name": "United States",
            "es_name": "Estados Unidos"
            },
            {
            "name": "Uruguay",
            "es_name": "Uruguay"
            },
            {
            "name": "Uzbekistan",
            "es_name": "Uzbekistán"
            },
            {
            "name": "Vanuatu",
            "es_name": "Vanuatu"
            },
            {
            "name": "Venezuela",
            "es_name": "Venezuela"
            },
            {
            "name": "Viet Nam",
            "es_name": "Vietnam"
            },
            {
            "name": "Virgin Islands, British",
            "es_name": "Islas Vírgenes Británicas"
            },
            {
            "name": "Virgin Islands, U.S.",
            "es_name": "Islas Vírgenes Americanas"
            },
            {
            "name": "Wallis and Futuna",
            "es_name": "Wallis y Futuna"
            },
            {
            "name": "Western Sahara",
            "es_name": "Sáhara Occidental"
            },
            {
            "name": "Yemen",
            "es_name": "Yemen"
            },
            {
            "name": "Zambia",
            "es_name": "Zambia"
            },
            {
            "name": "Zimbabwe",
            "es_name": "Zimbabwe"
            }
        ]';

        $palabras = json_decode($palabras, true);

        foreach ($palabras as $key) {  
            $elemento_ingresar = [
                'palabra' =>  mb_strtolower($key["es_name"], 'UTF-8')
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
            if(strlen($palabra) > 2){
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
    
                        if ($distanciaEdicion < $distanciaEdicionMinima && strlen($palabra) == strlen($palabraEnColeccion)) {
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
            }else{
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
                "corregido" => $bandera,
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
        $palabra_similar = self::palabraAproximadaDiccionario($palabra_r);

        $collection_diccionario = self::$mongoDB->selectCollection('diccionario');

        $palabra_encontrada = $collection_diccionario->findOne([
            'palabra' => [
                '$regex' => '^' . preg_quote($palabra_r) . '$',
                '$options' => 'i' 
            ]
        ]);

        $bandera = false;
        $bandera2 = false;
        $mensaje_opcional = "";

        if($palabra_encontrada == null){
            $bandera2 = true;
            $palabra_r = $palabra_similar[0];
            $palabra_encontrada = $collection_diccionario->findOne([
                'palabra' => [
                    '$regex' => '^' . preg_quote($palabra_r) . '$',
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
            "sugerencias" => $bandera2 == true ?  $palabra_similar[1] : []
        ];
    }

    public function palabraAproximadaDiccionario($palabras) {

        $palabras = self::verificarTildes2($palabras);

        $palabras = explode(' ', $palabras);

        $collection = self::$mongoDB->selectCollection('palabras');
        $cache = [];

        $string_resultante = [];
        $stings = [];

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

                    if($distanciaEdicion < 2){
                        $stings[] = $palabraEnColeccion;
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
       
        return [$concatenado, $stings];
    }

    public function insertarImagenes(){

        $collection_diccionario = self::$mongoDB->selectCollection('diccionario');

        $palabra_encontrada = $collection_diccionario->find(
            [], 
            [ 'skip' => 48713 ],
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


            $images = [
                ['url' => $imageData],
                ['url' => $imageData2],
            ];

            $collection_diccionario->updateOne(
                ['_id' => new \MongoDB\BSON\ObjectID($documento->_id)],
                ['$set' => ['imagenes' => $images]]
            );
        }
    }
}