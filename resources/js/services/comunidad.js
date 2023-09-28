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