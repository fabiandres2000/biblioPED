<template>
    <div id="fondo_imagen">
        <div class="app-content container center-layout mt-2 pagina_resultado">
            <div class="content-overlay"></div>
            <div class="content-wrapper" style="padding: 0.8rem">
                <div class="content-header row">
                    <div class="content-header-left col-md-6 col-12 mb-2">
                        <h3 class="content-header-title mb-0">
                            Resultado de la búsqueda
                        </h3>
                        <div class="row breadcrumbs-top">
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a @click.prevent="getAboutLink(0)" href="#">Inicio</a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="#">Busqueda</a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="#">Busqueda de Imagenes</a>
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
                                    <li>
                                        <a data-action="reload"><i class="feather icon-rotate-cw"></i></a>
                                    </li>
                                    <li>
                                        <a data-action="expand"><i class="feather icon-maximize"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-content collapse show">
                            <div class="card-body pb-0">
                                <div class="row">
                                    <div class="col-11">
                                        <fieldset class="form-group position-relative mb-0">
                                            <input type="text" class="form-control form-control-xl input-xl" v-model="texto"
                                                id="textoBusqueda" placeholder="Explore Stack ..." />
                                            <div class="form-control-position">
                                                <i ref="microfono" class="feather icon-mic font-medium-4" id="microfono"
                                                    @click.prevent="BuscarConAudio"></i>
                                            </div>
                                        </fieldset>
                                    </div>
                                    <div class="col-1">
                                        <button @click.prevent="BuscarResultadoNuevamente" style="width: 100%" class="btn btn-primary btn-md">
                                            <i class="feather icon-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <!--Search Navbar-->
                            <div id="search-nav" class="card-body">
                                <ul class="nav nav-inline">
                                    <li class="nav-item">
                                        <a class="nav-link" @click.prevent="getAboutLink(1)"><i class="fa fa-link"></i>
                                            Contenido</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link active" @click.prevent="getAboutLink(2)"><i class="fa fa-file-image-o"></i>
                                            Imagenes</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" @click.prevent="getAboutLink(3)"><i class="fa fa-file-video-o"></i>
                                            Videos</a>
                                    </li>
                                </ul>
                            </div>
                            <!--/ Search Navbar-->
                            <!--Search Result-->
                            <div id="search-results" class="card-body">
                                <div class="row">
                                    <div class="col-12 col-md-12 contenedor_imagenes">
                                        <div v-for="(image, index) in images" :key="index" class="imagen_busqueda">
                                            <img style="height: 80%; width: 100%;" @click.prevent="seleccionarImagen(image.src, image.titulo)" :src="image.src" alt="Imagen" :ref="'imageRef' + index" />
                                            <p class="texto_imagen"><router-link :to="image.ruta">{{ image.titulo }}</router-link> </p>
                                        </div>
                                        <div v-if="loading" class="loader" style="width: 100%;">
                                            <Skeleton></Skeleton>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="col-12 text-center">
                                        <button @click.prevent="AumentarPaginaImagen" v-if="images.length > 0" class="btn btn-primary btn-md">Mostrar más...</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
        <div class="modal fade text-left" id="modImagen" tabindex="-1" role="dialog" aria-labelledby="myModalLabel15"
            aria-hidden="true">
            <div class="modal-dialog  modal-lg" role="document" style="margin-top: 9%;">
                <div class="modal-content">
                    <div class="modal-header bg-success white">
                        <h4 class="modal-title" style="text-transform: capitalize;"><span>{{ tituloImagen }}</span></h4>
                    </div>
                    <div class="modal-body">
                        <div id='ListEval' style="height: 400px; overflow: auto;text-align: center;display: flex;justify-content: center;align-items: center;">
                            <img style="height: 85%;" :src="imagenSeleccionada" alt="">
                        </div>
                        
                        <button @click.prevent="descargarImagen"  type="button" class="btn btn-success"><i class="fas fa-cloud-download-alt"></i> Descargar</button>
                        <button style="margin-left: 20px;" type="button" id="btn_salir" class="btn btn-danger" data-dismiss="modal"><i class="ft-corner-up-left position-right"></i><i class="fas fa-times"></i> Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import * as busquedaService from "../services/busqueda";
import Skeleton from './skeleton/skeletonImagen.vue';
import cheerio from 'cheerio';
export default {
    components: {
        Skeleton
    },
    data() {
        return {
            images: [],
            texto: '',
            tipo: '',
            loading: false, 
            pagina: 1,
            imagenSeleccionada: '',
            tituloImagen: ''
        };
    },
    mounted() {
        this.texto = this.$route.params.texto;
        this.tipo = this.$route.params.tipo;

        this.verificarConexion();
        this.BuscarResultadoNuevamente(); 
        document.title = 'Resultados - '+this.texto;
    },
    methods: {
        async BuscarResultadoNuevamente() {
            this.images = [];
            this.$router.replace({ path: '/resultado-imagenes/' + this.texto + '/' + this.tipo  });
            try {
                this.loading = true; 
                await busquedaService.busqueda(this.texto, this.tipo, this.pagina).then(respuesta => {
                    var html_array = respuesta.data;
                    html_array.forEach(element => {
                        this.obtenerImagenesDesdeHTML(element)
                    });
                });
            } catch (error) {
                console.error(error);
            } finally {
                this.loading = false; 
            }
        },
        obtenerImagenesDesdeHTML(elemento) {
            const $ = cheerio.load(elemento.datos.cont_documento);
            $('img').each((index, element) => {
                const src = $(element).attr('src');
                if (src) {
                    this.images.push({
                        src: src,
                        titulo: elemento.datos.titulo,
                        ruta: '/contenido/' + elemento.datos.id_contenido + '/' + elemento.datos.tipo_contenido
                    });
                }
            });
        },
        async BuscarConAudio() {
            var elemento = this.$refs.microfono;
            elemento.style.color = "green";
            var recognition = new webkitSpeechRecognition();
            recognition.lang = "es-US";

            var self = this;

            recognition.onresult = function (event) {

                var resultadovoz = event.results[0][0].transcript;
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
        async  AumentarPaginaImagen(){
            this.pagina +=1;
            this.loading = true; 
            await busquedaService.busqueda(this.texto, this.tipo, this.pagina).then(respuesta => {
                var html_array = respuesta.data;
                html_array.forEach(element => {
                    this.obtenerImagenesDesdeHTML(element);
                });

                this.loading = false;
            });
        },
        seleccionarImagen(rutaSeleccionada, tituloImagenS) {
            this.imagenSeleccionada = rutaSeleccionada;
            this.tituloImagen = tituloImagenS;
            $("#modImagen").modal("show");
        },
        descargarImagen() {
            const link = document.createElement('a');
            link.href = this.imagenSeleccionada;
            link.download = this.tituloImagen+".png";
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        },
        getAboutLink(tipo_enlace){
            var navigate = this.$router;
            var texto = this.$route.params.texto;
            switch  (tipo_enlace) { 
                case 0:
                    navigate.push({ name: 'paginaBusqueda' })
                break     
                case 1: 
                    navigate.push({ name: 'ResultadoBusqueda', params: { texto: texto, tipo: "contenido", pagina: 1 } })
                break;
                case 2: 
                    navigate.push({ name: 'ResultadoImagenes', params: { texto: texto, tipo: "imagenes" } })
                break;
                case 3: 
                    navigate.push({ name: 'ResultadoVideos', params: { texto: texto, tipo: "videos", pagina: 1 } })
                break
            }
        }
    },
};
</script>

<style>
.loader {
    text-align: center;
    margin: 20px 0;
}

#fondo_imagen{
    background-image: url('/img/fondo_imagen.png') !important; 
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
</style>
