<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BusquedaController;
use App\Http\Controllers\ImagenController;
use App\Http\Controllers\MongoController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\FavoritosController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ForosController;
use App\Http\Controllers\DatosController;
use App\Http\Controllers\ExportarController;

use Illuminate\Http\Request;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// routes/web.php
// Rutas de la API
Route::prefix('api')->group(function () {
    Route::get('/check-connection', function () {
        if (checkInternetConnection()) {
            return true;
        } else {
            return false;
        }
    });
    
    Route::get('/busqueda', [MongoController::class, 'busquedaMongo'])->name('busqueda');
    Route::get('/paginacion', [MongoController::class, 'Paginacion'])->name('paginacion');
    Route::get('/busqueda-contenido', [MongoController::class, 'busquedaContenido'])->name('busquedaContenido');
    Route::get('/historial', [MongoController::class, 'historial'])->name('historial');
    Route::get('/eliminar-historial', [MongoController::class, 'eliminar_historial'])->name('eliminar_historial');
    Route::get('/busqueda-apunte', [MongoController::class, 'busquedaApunte'])->name('busquedaApunte');

    // BUSQUEDA DE VIDEOS Y METAFACTOS
    Route::get('/paginacion-multimedia', [MongoController::class, 'paginacion_multimedia'])->name('paginacion_multimedia');

   
    Route::post('/login', [UsuarioController::class, 'loginUsuario'])->name('login');
    Route::post('/registrar', [UsuarioController::class, 'registroUsuarioEstudiante'])->name('registrar');
    Route::get('/cerrar-sesion', [UsuarioController::class, 'cerrarSesion'])->name('cerrarSesion');
    Route::get('/mis-datos', [UsuarioController::class, 'misDatos'])->name('misDatos');
    Route::post('/editar-usuario-estudiante', [UsuarioController::class, 'editarEstudiante'])->name('editarEstudiante');
    Route::post('/cambiar-password', [UsuarioController::class, 'cambiarPassword'])->name('cambiarPassword');
    Route::get('/session-data', [UsuarioController::class, 'sessionData'])->name('sessionData');
    Route::get('/estudiantes-compartir', [UsuarioController::class, 'estudiantesCompartir'])->name('estudiantesCompartir');
    Route::post('/compartir-contenido', [UsuarioController::class, 'compartirContenido'])->name('compartirContenido');
    Route::get('/recomendaciones-docente', [UsuarioController::class, 'recomendacionesDocente'])->name('recomendacionesDocente');
    Route::get('/recomendaciones-estudiante', [UsuarioController::class, 'recomendacionesEstudiante'])->name('recomendacionesEstudiante');
    Route::get('/notificaciones', [UsuarioController::class, 'notificaciones'])->name('notificaciones');
    Route::get('/cambiarestadoNotificacion', [UsuarioController::class, 'cambiarestadoNotificacion'])->name('cambiarestadoNotificacion');
    Route::get('/verificarLogin', [UsuarioController::class, 'verificarLogin'])->name('verificarLogin');
    Route::post('/crear-foro', [UsuarioController::class, 'crearForo'])->name('crearForo');
    Route::post('/guardar-seleccion', [UsuarioController::class, 'guardarSeleccion'])->name('guardarSeleccion');
    Route::get('/listarApuntes', [UsuarioController::class, 'listarApuntes'])->name('listarApuntes');
    Route::get('/eliminar-apunte', [UsuarioController::class, 'eliminarApunte'])->name('eliminarApunte');


    Route::post('/agregar-favorito', [FavoritosController::class, 'agregarFavorito'])->name('agregarFavorito');
    Route::get('/verificar-favorito', [FavoritosController::class, 'BuscarFavorito'])->name('BuscarFavorito');
    Route::get('/eliminar-favorito', [FavoritosController::class, 'EliminarFavorito'])->name('EliminarFavorito');
    Route::get('/mis-favoritos', [FavoritosController::class, 'MisFavoritos'])->name('MisFavoritos');


    //para cargar el contenido en mongo
    Route::get('/bajar-peso', [ImagenController::class, 'ConvertirImagen'])->name('convertirImagen');
    Route::get('/copiar', [DatosController::class, 'migrartablasCont'])->name('migrartablasCont');
    Route::get('/crear-tabla-contenido', [DatosController::class, 'crearContenidoBusqueda'])->name('crear_tabla_contenido');
    Route::get('/migrar-videos', [DatosController::class, 'migrarVideos'])->name('migrarVideos');


    Route::post('/registro-docente', [AdminController::class, 'RegistroDocente'])->name('RegistroDocente');
    Route::get('/listar-docentes', [AdminController::class, 'listarDocentes'])->name('listarDocentes');
    Route::post('/editar-docente', [AdminController::class, 'editarDocente'])->name('editarDocente');

    Route::get('/foros', [ForosController::class, 'foros'])->name('foros');
    Route::get('/foro', [ForosController::class, 'foro'])->name('foro');
    Route::post('/guardar-respuesta', [ForosController::class, 'guardarRespuesta'])->name('guardarRespuesta');
    Route::post('/guardar-respuesta-comentario', [ForosController::class, 'guardarRespuestaComentario'])->name('guardarRespuestaComentario');
    Route::get('/eliminar-respuesta', [ForosController::class, 'eliminarRespuesta'])->name('eliminarRespuesta');
    Route::post('/editar-foro', [ForosController::class, 'editarForo'])->name('editarForo');
    Route::get('/cambiar-estado', [ForosController::class, 'cambiarEstado'])->name('cambiarEstado');

    Route::post('/corregir-texto', [AdminController::class, 'corregirTexto'])->name('corregirTexto');
    Route::post('/guardar-contenido', [AdminController::class, 'guardarContenido'])->name('guardarContenido');

    Route::post('/pdf-apuntes', [ExportarController::class, 'generateApuntesPDF'])->name('generateApuntesPDF');
});

Route::get('/{any}', function () {
    return view('vue');
})->where('any', '.*');


function checkInternetConnection()
{
    try {
        $response = \Illuminate\Support\Facades\Http::get('https://www.google.com');

        return $response->successful();
    } catch (Exception $e) {
        return false;
    }
}