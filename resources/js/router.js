import { createRouter, createWebHistory } from 'vue-router'
import paginaBusqueda from './components/paginaBusqueda.vue'
import ResultadoBusqueda from './components/resultadoBusqueda.vue'
import ContenidoBusqueda from './components/contenido.vue'
import ResultadoImagenes from './components/imagenes.vue'
import ResultadoVideos from './components/resultadoVideos.vue'
import historial from './components/historial.vue'
import favoritos from './components/misFavoritos.vue'
import miPerfil from './components/miPerfil.vue'
import admin from './components/admin.vue'
import recomendacionesDocente from './components/recomendacionesDocente.vue'
import recomendacionesEstudiante from './components/recomendacionesEstudiante.vue'
import sitioProhibido from './components/admin/sitioProhibido.vue'
import listaForos from './components/foros/listaForos.vue'
import Foro from './components/foros/foro.vue'
import listaForosProfesor from './components/foros/listaForosProfesor.vue'
import listaApuntes from './components/listaApuntes.vue'
import listaContenido from './components/contenido/listaContenido.vue'
import agregarContenido from './components/contenido/agregarContenido.vue'


const routes = [
  {
    path: '/',
    name: 'paginaBusqueda',
    component: paginaBusqueda
  },
  {
    path: '/resultado-busqueda/:texto/:tipo/:pagina',
    name: 'ResultadoBusqueda',
    component: ResultadoBusqueda
  },
  {
    path: '/contenido/:id/:tipo',
    name: 'ContenidoBusqueda',
    component: ContenidoBusqueda
  },
  {
    path: '/resultado-imagenes/:texto/:tipo',
    name: 'ResultadoImagenes',
    component: ResultadoImagenes
  },
  {
    path: '/resultado-videos/:texto/:tipo/:pagina',
    name: 'ResultadoVideos',
    component: ResultadoVideos
  },
  {
    path: '/historial',
    name: 'historial',
    component: historial
  },
  {
    path: '/mis-favoritos',
    name: 'favoritos',
    component: favoritos
  },
  {
    path: '/mi-perfil',
    name: 'miPerfil',
    component: miPerfil
  },
  {
    path: '/admin',
    name: 'admin',
    component: admin
  },
  {
    path: '/sitioProhibido',
    name: 'sitioProhibido',
    component: sitioProhibido
  },
  {
    path: '/recomendaciones-docente',
    name: 'recomendacionesDocente',
    component: recomendacionesDocente
  },
  {
    path: '/recomendaciones-estudiante',
    name: 'recomendacionesEstudiante',
    component: recomendacionesEstudiante
  },
  {
    path: '/foros',
    name: 'listaForos',
    component: listaForos
  },
  {
    path: '/foro/:id',
    name: 'Foro',
    component: Foro,
    props: true
  },
  {
    path: '/foros-profesor',
    name: 'listaForosProfesor',
    component: listaForosProfesor
  },
  {
    path: '/apuntes',
    name: 'listaApuntes',
    component: listaApuntes
  },
  {
    path: '/lista-contenido',
    name: 'listaContenido',
    component: listaContenido
  },
  {
    path: '/agregar-contenido',
    name: 'agregarContenido',
    component: agregarContenido
  },
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router