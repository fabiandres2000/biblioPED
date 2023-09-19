import {http} from "./http_services";


export function registrar_docente($data) {
    return http().post(
        '/api/registro-docente', 
        $data, 
        {
            headers: {
                'Content-Type': 'application/json'
            }
        }
    );
}

export function listarDocentes() {
    return http().get('/api/listar-docentes');
}

export function editar_docente($data) {
    return http().post(
        '/api/editar-docente', 
        $data, 
        {
            headers: {
                'Content-Type': 'application/json'
            }
        }
    );
}


export function guardarDatosContenido($data) {
    return http().post(
        '/api/guardar-contenido', 
        $data, 
        {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        }
    );
}