<?php

namespace App\Http\Controllers;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Connection;
use MongoDB\Client;
use Illuminate\Http\Request;
use DB;
use Jenssegers\Mongodb\Facades\MongoDB;

class ClaseConexion {
    public static $mongoClient;
    public static $mongoDB;

    public function __construct()
    {
        if (!isset(self::$mongoClient)) {
            self::$mongoClient = new Client('mongodb://localhost:27017');
        }

        if (!isset(self::$mongoDB)) {
            self::$mongoDB = self::$mongoClient->selectDatabase('ped_biblioteca');
        }
    }
}
