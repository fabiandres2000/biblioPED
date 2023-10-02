<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        '/agregar-favorito',
        '/editar-usuario-estudiante',
        '/cambiar-password',
        '/registro-docente',
        '/compartir-contenido',
        '/crear-foro',
        '/guardar-respuesta',
        '/guardar-respuesta-comentario',
        '/editar-foro',
        '/corregir-texto',
        '/guardar-seleccion',
        '/pdf-apuntes',
        '/guardar-contenido',
        '/editar-contenido',
        '/eliminar-contenido',
        '/guardar-publicacion',
        '/editar-publicacion',
        '/me-gusta'
    ];
}
