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
