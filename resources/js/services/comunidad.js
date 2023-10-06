import {http} from "./http_services";

export function guardarPublicacion($data) {
    return http().post(
        '/api/guardar-publicacion', 
        $data, 
        {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        }
    );
}

export function listarPublicaciones() {
    return http().get('/api/listar-publicaciones');
}

export function registrarComentarioPost($data) {
    return http().post(
        '/api/guardar-comentario-post', 
        $data, 
        {
            headers: {
                'Content-Type': 'application/json'
            }
        }
    );
}

export function eliminarRespuestaComentario(id_publicacion, id_comentario) {
    return http().get('/api/eliminar-comentario-post?id_publicacion='+id_publicacion+'&id_comentario='+id_comentario);
}

export function listarUsuariosComunidad() {
    return http().get('/api/listar-usuarios-comunidad');
}

export function editarPublicacion($data) {
    return http().post(
        '/api/editar-publicacion', 
        $data, 
        {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        }
    );
}

export function EliminarPost(id_publicacion) {
    return http().get('/api/eliminar-post?id_publicacion='+id_publicacion);
}

export function meGustaPost($data) {
    return http().post(
        '/api/me-gusta', 
        $data, 
        {
            headers: {
                'Content-Type': 'application/json'
            }
        }
    );
}

export function listarPublicacionPorID(id_publicacion) {
    return http().get('/api/publicacion-get?id_publicacion='+id_publicacion);
}
