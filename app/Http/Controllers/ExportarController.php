<?php

namespace App\Http\Controllers;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Connection;
use MongoDB\Client;
use Illuminate\Http\Request;
use DB;

use Jenssegers\Mongodb\Facades\MongoDB;

use Illuminate\Support\Facades\Session;
use PDF;
use Illuminate\Http\Response;

class ExportarController extends Controller
{
    public function generateApuntesPDF(Request $request){

        $mongoClient = new Client('mongodb://localhost:27017');
        $mongoDB = $mongoClient->selectDatabase('ped_biblioteca');

        $collection = $mongoDB->selectCollection('apuntes');

        $id = $request->input('id');

        $apunte = $collection->findOne(
            [
                '_id' => new \MongoDB\BSON\ObjectID($id),
            ]
        );

        $data = [
            'titulo' => $request->input('titulo'),
            'html' => $apunte->data
        ];
        
        $pdf = PDF::loadView('pdf.apuntes', $data, ['size' => 'A1']);
    
        $pdfContent = $pdf->stream();

        return new Response($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="ejemplo.pdf"',
        ]);
    } 
}
