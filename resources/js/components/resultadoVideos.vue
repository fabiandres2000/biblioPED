<template >
    <div id="fondo_video">
        <filtro></filtro>
        <div class="app-content container center-layout mt-2 pagina_resultado">
            <div class="content-overlay"></div>
            <div class="content-wrapper" style="padding: 0.8rem">
                <div class="content-header row">
                    <div class="content-header-left col-md-6 col-12 mb-2">
                        <h3 class="content-header-title mb-0">Resultado de la búsqueda</h3>
                        <div class="row breadcrumbs-top">
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="/">Inicio</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="/">Busqueda</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="/">Busqueda de Contenido</a> 
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-body">
                    <!-- Search form-->
                    <section id="search-website" class="card overflow-hidden">
                        <div class="card-header">
                            
                            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                   
                                </ul>
                            </div>
                        </div>
                        <div class="card-content collapse show">
                            <div class="card-body pb-0">
                                <div class="row">
                                    <div class="col-11">
                                        <fieldset class="form-group position-relative mb-0">
                                            <input type="text" class="form-control form-control-xl input-xl" v-model="texto"
                                                id="textoBusqueda" placeholder="Explore Stack ..." @keyup.enter="BuscarResultadoNuevamente">
                                            <div class="form-control-position">
                                                <i ref="microfono"  class="feather icon-mic font-medium-4" id="microfono" @click.prevent="BuscarConAudio"></i>
                                            </div>
                                        </fieldset>
                                    </div>
                                    <div class="col-1">
                                        <button @click.prevent="BuscarResultadoNuevamente" style="width: 100%;"  class="btn btn-primary btn-md"><i
                                                class="feather icon-search"></i></button>
                                    </div>
                                </div>
                            </div>
                            <!--Search Navbar-->
                           <TipoBusqueda :tipo="'videos'"></TipoBusqueda>
                            <!--/ Search Navbar-->
                            <!--Search Result-->
                            <div id="search-results" class="card-body">
                                <div class="row">
                                    <div class="col-10 col-md-10">
                                        <p style="padding-left: 18px" class="text-muted font-small-3">Cerca de {{ paginacion.numero_registros }} resultados ({{ tiempoConsulta  }} segundos) </p>
                                        <ul class="media-list p-0">
                                            <!--search with image-->
                                            <div style="width: 100%;">
                                                <Skeleton v-if="loading"></Skeleton>
                                            </div>
                                            <button @click="mostrarFiltros" id="boton_filtro_video" class="add-task-btn btn btn-blue btn-darken-4">
                                                <i class="fas fa-filter"></i>
                                            </button>
                                            <li style="padding-left: 15px; margin-top: 20px;"  v-for="(item, index) in datos" :key="index" class="row item_lista">
                                                <p class="lead mb-0 col-12"><a href="#"><span class="text-bold-600">{{ item.contenido_busqueda.tema }}</span></a></p>
                                                <div class="col-md-4 col-sm-12">
                                                    <video :key="'video'+index" width="270" height="200" controls>
                                                        <source :src="'/videos/'+item.contenido_busqueda.ruta" type="video/mp4">
                                                        <source :src="'/videos/'+(item.contenido_busqueda.ruta.split('.')[0])+'.ogg'" type="video/ogg">
                                                    </video>

                                                </div>
                                                <div style="padding-top: 20px;" class="col-md-8 col-sm-12">
                                                    <p class="mb-0"><a :href="'/contenido/'+item.contenido_busqueda.id_original+'/'+(item.contenido_busqueda.tipo_contenido ==  'asignatura' ? 'N' : 'T')" class="teal darken-1">{{ '/contenido/'+item.contenido_busqueda.id_original+'/'+(item.contenido_busqueda.tipo_contenido == "asignatura" ? 'N' : 'T')  }}<span class="text-bold-600"></span> <i class="fa fa-angle-down" aria-hidden="true"></i></a></p>
                                                    <ul class="list-inline list-inline-pipe text-muted">
                                                        <li><strong>{{ item.contenido_busqueda.asignatura }}</strong></li>
                                                        <li><strong>Grado {{ item.contenido_busqueda.grado }}°</strong></li>
                                                        <li>{{ item.contenido_busqueda.fecha }}</li>
                                                    </ul>
                                                    <p>{{ item.contenido_busqueda.parrafo }}</p>
                                                </div>
                                            </li>
                                        </ul>
                                        <div v-if="datos.length == 0 && !loading" style="padding-left: 20px;">
                                            <p>No se han encontrado resultados para tu búsqueda <strong> ({{ texto }})</strong></p>
                                            <p>Sugerencias: </p>
                                            <ul>
                                                <li>Asegúrate de que todas las palabras estén escritas correctamente.</li>
                                                <li>Prueba diferentes palabras clave.</li>
                                                <li>Prueba palabras clave más generales.</li>
                                                <li>Prueba menos palabras clave.</li>
                                            </ul>
                                            <br>
                                                <img src="/img/no_results.gif" style="position: absolute; width: 465px; right: 1%; top: -41px;" alt="">
                                        </div>
                                        <p class="px-1"></p>
                                        <div style="margin-left: 6px;" class="row" v-if="paginacion.numero_registros > 0">
                                            <div class="col-md-10">
                                                <ul class="pagination">
                                                    <!-- flecha anterior -->
                                                    <li v-if="pagina !== 1" class="page-item">
                                                        <button class="page-link" @click="decrementarPagina" aria-label="Previous">
                                                        <span aria-hidden="true">«</span>
                                                        </button>
                                                    </li>

                                                    <!-- mostrar página 1 y los ... si la primera del grupo no es la página 1 -->
                                                    <li v-if="primera !== 1" class="page-item">
                                                        <button class="page-link" @click="irAPagina(1)" aria-label="Previous">
                                                        <span aria-hidden="true">1</span>
                                                        </button>
                                                    </li>
                                                    <li v-if="primera !== 1" class="page-item disabled">
                                                        <button class="page-link" disabled aria-label="Previous">
                                                        <span aria-hidden="true">...</span>
                                                        </button>
                                                    </li>

                                                    <!-- mostrar página actual, las 5 anteriores y las 5 posteriores -->
                                                    <li v-for="i in ultima - primera + 1" :key="i" :class="{ 'page-item': true, 'active': pagina === i + primera - 1 }">
                                                        <button class="page-link" @click="irAPagina(i + primera - 1)" aria-label="Previous">
                                                        <span aria-hidden="true">{{ i + primera - 1 }}</span>
                                                        </button>
                                                    </li>

                                                    <!-- mostrar la última y los ... si la última del grupo no es la última -->
                                                    <li v-if="ultima !== paginacion.paginas_consulta" class="page-item disabled">
                                                        <button class="page-link" disabled aria-label="Previous">
                                                        <span aria-hidden="true">...</span>
                                                        </button>
                                                    </li>
                                                    <li v-if="ultima !== paginacion.paginas_consulta" class="page-item">
                                                        <button class="page-link" @click="irAPagina(paginacion.paginas_consulta)" aria-label="Previous">
                                                        <span aria-hidden="true">{{ paginacion.paginas_consulta }}</span>
                                                        </button>
                                                    </li>

                                                    <!-- flecha siguiente -->
                                                    <li v-if="pagina !== paginacion.paginas_consulta" class="page-item">
                                                        <button class="page-link" @click="incrementarPagina" aria-label="Next">
                                                        »
                                                        </button>
                                                    </li>
                                                    </ul>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import * as busquedaService from "../services/busqueda";
import Skeleton from './skeleton/skeleton.vue';
import TipoBusqueda from './tipoBusqueda.vue';
import filtro from './filtro/filtro.vue'

export default {
    components: {
        Skeleton,
        TipoBusqueda,
        filtro
    },
    data() {
        return {
            loading: false,
            texto: '',
            tipo: '',
            pagina: 0,
            datos: [],
            paginacion: [],
            primera: 0,
            ultima: 0,
            tiempoConsulta : 0,
            filtradoGradoAsignatura: false,
            gradoFiltro: '',
            asignaturaFiltro: ''
        };
    },
    mounted() {
        this.texto = this.$route.params.texto;
        this.tipo = this.$route.params.tipo;
        this.pagina = this.$route.params.pagina;
        this.BuscarResultado();
        this.verificarConexion();
        document.title = 'Resultados - '+this.texto;
    },
    methods: {
        scrollToTop() {
            document.documentElement.scrollTop = 0;
        },
        BuscarResultado: async function () {
            this.loading = true;
            try {
                await busquedaService.busqueda(this.texto, this.tipo, this.pagina).then(respuesta => {
                    this.datos = respuesta.data;
                    this.loading = false;
                });

                this.paginador();   
                
            } catch (error) {
                console.log(error);
            }
        },
        async paginador() {
            const inicio = Date.now(); 

            await busquedaService.paginacionMultimedia(this.texto, this.tipo, this.pagina).then(respuesta => {
                this.paginacion = respuesta.data;
                this.pagina = parseInt(this.pagina);
                this.primera = this.pagina - 4 > 1 ? this.pagina - 4 : 1;
                this.ultima = this.pagina + 4 < this.paginacion.paginas_consulta ? this.pagina + 4 : this.paginacion.paginas_consulta;

                const finalizacion = Date.now(); 
                const tiempoTranscurrido = (finalizacion - inicio) / 1000; 
                this.tiempoConsulta = tiempoTranscurrido;
            });
        },
        incrementarPagina() {
            if (this.pagina < this.paginacion.paginas_consulta) {
                this.pagina++;
            }
            if(this.filtradoGradoAsignatura){
                this.buscarResultadosFiltrados(this.asignaturaFiltro, this.gradoFiltro, this.pagina);
            }else{
                this.BuscarResultadoPaginado();
            }
        },
        decrementarPagina() {
            if (this.pagina > 1) {
                this.pagina--;
            }
            if(this.filtradoGradoAsignatura){
                this.buscarResultadosFiltrados(this.asignaturaFiltro, this.gradoFiltro, this.pagina);
            }else{
                this.BuscarResultadoPaginado();
            }
        },
        irAPagina(pagina) {
            this.pagina = pagina;
            if(this.filtradoGradoAsignatura){
                this.buscarResultadosFiltrados(this.asignaturaFiltro, this.gradoFiltro, this.pagina);
            }else{
                this.BuscarResultadoPaginado();
            }
        },
        async BuscarResultadoPaginado () {
            this.loading = true;
            this.datos = [];
            this.$router.replace({ path: '/resultado-videos/' + this.texto + '/' + this.tipo + '/' + this.pagina });
            try {
                await busquedaService.busqueda(this.texto, this.tipo, this.pagina).then(respuesta => {
                    this.datos = respuesta.data;
                    this.loading = false;
                });

                if (this.pagina == 1) {
                   this.paginador();
                }
            } catch (error) {
                console.log(error);
            }
        },
        async BuscarResultadoNuevamente () {
            this.loading = true;
            this.pagina = 1;
            this.datos = [];
            this.$router.replace({ path: '/resultado-videos/' + this.texto + '/' + this.tipo + '/' + this.pagina });
            try {
                await busquedaService.busqueda(this.texto, this.tipo, this.pagina).then(respuesta => {
                    this.datos = respuesta.data;
                    this.loading = false;
                });

                this.paginador();
            } catch (error) {
                console.log(error);
            }
        },
        async BuscarConAudio() {
            var elemento = this.$refs.microfono;
            elemento.style.color = "green";
            var recognition = new webkitSpeechRecognition();
            recognition.lang = "es-CO";

            var self = this; 

            recognition.onresult = function (event) {

                var resultadovoz  = event.results[0][0].transcript;
                elemento.style.color = "#404e67";

                if (resultadovoz != "") {
                    self.texto = resultadovoz;
                    self.BuscarResultadoNuevamente();
                }

            }
            recognition.start();
        },
        async verificarConexion() {
            await busquedaService.verificarConexion().then(response => { 
                if (response.data == 0) {
                    document.getElementById("microfono").style.display = "none";
                }
                console.log(response);
            });
        },
        mostrarFiltros() {
            var todoNewTasksidebar = $(".todo-new-task-sidebar"),
            appContentOverlay = $(".app-content-overlay-filtro");

            todoNewTasksidebar.addClass('show');
            appContentOverlay.addClass('show');

            var self = this;
            $('.cerrar-filtros').on('click', function () {
                appContentOverlay.removeClass('show');
                todoNewTasksidebar.removeClass('show');
            });

            $('.aplicar-filtros-ok').on('click', function () {
                appContentOverlay.removeClass('show');
                todoNewTasksidebar.removeClass('show');
                self.pagina = 1;
                self.$router.replace({ path: '/resultado-videos/' + self.texto + '/' + self.tipo + '/' + self.pagina });
                self.filtradoGradoAsignatura = true;
                self.gradoFiltro = $('#gradoFiltro').val();
                self.asignaturaFiltro = $('#asignaturaFiltro').val();
                self.buscarResultadosFiltrados(self.asignaturaFiltro, self.gradoFiltro, 1);
            });

            $('.limpiar-filtros-ok').on('click', function () {
                appContentOverlay.removeClass('show');
                todoNewTasksidebar.removeClass('show');
                self.gradoFiltro = 'no';
                self.asignaturaFiltro = 'no';
                self.BuscarResultadoNuevamente();
            });
        },
        async buscarResultadosFiltrados(asignatura, grado, paginaP){
            this.loading = true;
            this.datos = [];
            const inicio = Date.now(); 

            try {
                await busquedaService.busqueda(this.texto, this.tipo, paginaP, grado, asignatura).then(respuesta => {
                    this.datos = respuesta.data;
                });

                await busquedaService.paginacionMultimedia(this.texto, this.tipo, this.pagina, grado, asignatura).then(respuesta => {
                    this.paginacion = respuesta.data;
                    this.pagina = parseInt(this.pagina);
                    this.primera = this.pagina - 4 > 1 ? this.pagina - 4 : 1;
                    this.ultima = this.pagina + 4 < this.paginacion.paginas_consulta ? this.pagina + 4 : this.paginacion.paginas_consulta;

                    const finalizacion = Date.now(); 
                    const tiempoTranscurrido = (finalizacion - inicio) / 1000; 
                    this.tiempoConsulta = tiempoTranscurrido;
                    this.loading = false;
                });
            } catch (error) {
                console.log(error);
            }
        }
    }
}
</script>
<style>
    .item_lista:hover{
        background-color: aliceblue;
    }

    #fondo_video{
        background-image: url('/img/fondo_video.png') !important; 
        background-size: 100% 100%;
    }  

    .pagina_resultado {
        max-width: 100%; 
        height: 92vh; 
        margin-top: 0.7rem !important;
        padding-top: 20px;
        padding-left: 5%;
        padding-right: 5%;
        overflow: scroll !important;
        width: 100%;
    }

    #boton_filtro_video {
        position: absolute;
        right: -179px;
        top: -17px;
    }
</style>