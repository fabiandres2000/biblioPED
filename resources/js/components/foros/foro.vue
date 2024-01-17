<template>
    <div style="background-color: #f5f7fa">
        <div class="app-content container center-layout mt-2" style="max-width: 90%;">
            <div class="content-overlay"></div>
            <div class="content-wrapper" style="padding: 0.8rem">
                <div class="content-header row">
                    <div class="content-header-left col-md-6 col-12 mb-2">
                        <h3 class="content-header-title mb-0">Foros</h3>
                        <div class="row breadcrumbs-top">
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="/">Inicio</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="/foros-profesor">Foros</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#">{{ foro.titulo }}</a>
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-body">
                    <!-- Search form-->
                    <section id="search-website" class="card overflow-hidden">
                        <div style="padding-left: 10px; padding-top: 22px; padding-bottom: 10px; background-color: #16d39a94; height: 65px;">
                            <p v-if="!loading"><i class="fas fa-comment"></i> <strong>{{ foro.fecha }}, {{ foro.horas }}</strong></p>
                            <div style="    position: absolute; right: 125px; top: 22px;">
                                <span v-if="foro.estado == 'Cerrado'" class="badge badge-danger ml-1">Estado del foro <strong>"Cerrado"</strong></span>
                                <span v-if="foro.estado == 'Abierto'" class="badge badge-success ml-1">Estado del foro <strong>"Abierto"</strong></span>
                            </div>
                        </div>
                        <div class="card-header">
                            <h4 class="card-title">{{ foro.titulo }}</h4>
                            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                            <div class="heading-elements" style="background-color: #16d39a00;">
                                <ul class="list-inline mb-0">
                                    <li><a @click="goBack"><i class="fas fa-arrow-left"></i></a></li>
                                    <li><a data-action="expand"><i class="fas fa-compress"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-content collapse show">
                            <div id="search-results" class="card-body">
                                <div style="width: 100%;">
                                    <Skeleton v-if="loading"></Skeleton>
                                </div>
                                <div v-if="!loading">
                                    <h1 style="text-transform: uppercase; font-weight: bold;">{{ foro.descripcion }}</h1>
                                    <br>
                                    <div class="autor">
                                        <div style="display: flex; justify-content: center; align-items: center;">
                                            <img style="width: 30px; height: 30px" :src="'/'+foro.profesor.imagen"> <strong style="margin-left: 10px;"> {{ foro.profesor.nombre }}</strong>
                                        </div>
                                        <a style="margin-left: 60px;" href="" data-toggle="modal" data-target="#xlargeContenido"><i class="far fa-file-word"></i> Contenido asociado</a>
                                    </div>
                                    <br>
                                    <hr>
                                    <div style="display: flex; align-items: center;">
                                        <button v-if="foro.estado == 'Abierto'" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-edit"></i> Publica tu Respuesta</button>
                                        <i :style="foro.estado == 'Abierto' ? 'margin-left: 60px; margin-right: 5px;' : 'margin-left: 10px; margin-right: 5px;'" class="fas fa-comments"></i>{{ foro.comentarios.length }} Respuestas
                                    </div> 
                                </div>
                            </div>
                        </div>
                    </section>

                    <section v-for="(item, index) in foro.comentarios" :key="index" id="search-website" class="card" style="width:  90%; margin-left: 10%; border-radius: 10px 10px;">
    
                        <div class="cabeza" style=" padding-left: 10px; padding-top: 9px; padding-bottom: 10px; background-color: #f9a82557; border-radius: 10px 10px 0px 0px">
                            <div style="display: flex; align-items: center;">
                                <img style="position: absolute;width: 60px;height: 60px;left: -95px;top: 0px;" :src="'/'+item.usuario.imagen">
                                <div style="margin-left: 10px;">
                                    <strong>{{ item.usuario.nombre }}</strong> <br> <strong style="color: gray">Comentado el {{ item.fecha }} a las  {{ item.horas }}</strong>
                                </div>
                            </div>
                        </div>
                        <div class="card-header">
                            <h6 class="card-title" style="font-weight: bold; font-size: 1rem">En respuesta a "{{ foro.titulo }}"</h6>
                            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                        </div>
                        <div class="card-content collapse show">
                            <div id="search-results" class="card-body" v-html="item.respuesta"></div>
                            <a type="button" @click="mostrarOcultar(index)" style="margin-left: 25px; text-decoration: underline; color: #009c9f">Mostrtar/ocultar  respuestas ({{ item.respuestas.length }})</a>
                            <div v-if="foro.estado == 'Cerrado'" style="height: 20px"></div>
                            <div style="margin: 10px; display: none; opacity: 0;" :id="'caja_comentarios'+index" class="miDiv">
                                <div v-for="(item2, index2) in item.respuestas" :key="index" class="media ml-4" style="margin-top: 10px; border-top: 1px solid #80808052; position: relative; padding-top: 12px; margin-right: 100px;">
                                    <div class="media-left mr-1">
                                        <a href="#">
                                            <span class="avatar avatar-online"><img :src="'/'+item2.usuario.imagen" alt="avatar"></span>
                                        </a>
                                    </div>
                                    <div class="media-body">
                                        <p class="text-bold-600 mb-0"><a href="#">{{ item2.usuario.nombre }}</a></p>
                                        <p>{{ item2.respuesta }}</p> 
                                    </div>
                                    <p style="font-size: 11px; position: absolute; right: 10px; bottom: 5px;"><strong>{{ item2.fecha }} a las {{ item2.horas }}</strong></p>
                                    <i @click="eliminarRespuesta(item2)" v-if="item2.usuario._id.$oid == id_usuariosession" style="position: absolute; color: #959595;right: -50px; top: 31px; cursor: pointer;"  class="fas fa-trash-alt"></i>
                                </div>
                            </div>
                            <div v-if="foro.estado == 'Abierto'" class="row" style="margin: 10px;">
                                <div class="col-11">
                                    <input type="text" :id="'comentario'+index" style="border-radius: 40px !important; background-color: #404e670f" class="form-control" placeholder="Escribe una respuesta a este comentario....">
                                </div>
                                <div class="col-1" style="display: flex; align-items: center">
                                    <button @click="responderComentario('comentario'+index, index)" style="width: 100%; background-color: #00b5b8 !important;" class="btn btn-success"><i style="color: #fff" class="fas fa-paper-plane"></i></button>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>


        <div class="modal fade text-left" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17" aria-hidden="true" data-backdrop="static">
            <div class="modal-dialog modal-lg" role="document" style="max-width: 820px;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 style="text-transform: uppercase;"><strong>{{ foro.descripcion }}</strong></h3>
                    </div>
                    <div class="modal-body">
                        <div style="padding: 10px">
                            <QuillEditor  style="height: 300px;" theme="snow" toolbar="full" />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" @click="guardarCambios" class="btn btn-primary"><i class="fas fa-save"></i> Guardar Cambios</button>
                        <button type="button" @click="cancelarCambios" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times"></i> Cancelar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade text-left" id="xlargeContenido" tabindex="-1" role="dialog" aria-labelledby="myModalLabel16" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel16">{{ foro.contenido_html.titulo }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="padding: 55px;" v-html="foro.contenido_html.cont_documento"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn red btn-outline-danger" data-dismiss="modal">Cerrar Pestaña</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </template>
<script>
    import Skeleton from '../skeleton/skeleton.vue';
    import * as usuarioService from "../../services/usuario";
    import * as forosService from "../../services/foros";
    import { QuillEditor } from '@vueup/vue-quill'
    import '@vueup/vue-quill/dist/vue-quill.snow.css';
    import Swal from 'sweetalert2';

    export default {
        props: ['id'],
        components: {
            Skeleton,
            QuillEditor
        },
        data() {
            return {
                loading: true,
                foro: {
                    titulo: '',
                    descripcion: '',
                    fecha: '',
                    horas: '',
                    profesor: {
                        imagen: '',
                        nombre: '',
                    },
                    contenido_html: {
                        titulo: '',
                        cont_documento: ''
                    }
                },
                editorContent: "",
                sessionData: {},
                id_usuariosession: "",
                intervalId: ""
            };
        },
        mounted() {
            this.verificarLogin();
            this.getSessionData();
            this.intervalId = setInterval(this.consultarComentariosForo, 5000);
        },
        beforeDestroy() {
            clearInterval(this.intervalId);
        },
        methods: {
            goBack() {
                this.$router.go(-1);
            },
            async verificarLogin(){
                var navigate = this.$router;
                await usuarioService.verificarLogin().then(respuesta => {
                    if(respuesta.data == 0){
                        navigate.push({ name: 'paginaBusqueda'})
                    }
                });
            },
            async getSessionData() {
                await usuarioService.getSessionData().then(respuesta => {
                    this.sessionData = respuesta.data;
                    this.id_usuariosession = this.sessionData.id.$oid;
                    this.foroData();
                });
            },
            async foroData() {
                await forosService.foro(this.id).then(respuesta => {
                    this.foro = respuesta.data;
                    document.title = 'Foro - '+this.foro.titulo;
                    this.loading = false
                });
            },
            async guardarCambios(){
                this.editorContent = document.querySelector(".ql-editor").innerHTML;

                const datos = {
                    id_foro: this.id,
                    respuesta: this.editorContent,
                };

                await forosService.guardarRespuesta(datos).then(respuesta => {
                    toastr.success(respuesta.data);  
                    $("#exampleModal").modal('hide');
                    this.cancelarCambios();
                    this.foroData();
                });
            },
            async cancelarCambios(){
                document.querySelector(".ql-editor").innerHTML = "";
            },
            async responderComentario(elemento, index){
                var valor = document.getElementById(elemento).value;
                
                var datos = {
                    id_comentario: this.foro.comentarios[index]._id.$oid,
                    respuesta: valor,
                }

                await forosService.guardarRespuestaComentario(datos).then(respuesta => {
                    this.foroData();
                    document.getElementById(elemento).value = "";
                });

            },
            agregarCeros(valor) {
                return valor.toString().padStart(2, '0');
            },
            mostrarOcultar(index){
                const div = document.getElementById("caja_comentarios"+index);
                if (div.style.opacity == "0" || div.style.display == "none") {
                    div.style.opacity = "1";    
                    div.style.display = "block";
                } else {
                    div.style.opacity = "0";
                    setTimeout(function() {
                    div.style.display = "none";
                    }, 500);
                }
            },
            async eliminarRespuesta(id){
                Swal.fire({
                    title: '¿Estas seguro?',
                    text: "¡No podrás revertir esto!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '¡Sí, borrar!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.eliminarOK(id._id.$oid);
                    }
                })
                
            },
            async eliminarOK(id){
                await forosService.eliminarRespuestaComentario(id).then(respuesta => {
                    this.foroData();
                });
            },
            async consultarComentariosForo(){
                await forosService.comentariosForos(this.id).then(respuesta => {
                    this.foro.comentarios = respuesta.data;
                });
            }
        }
    };
</script>
<style>
    .autor{
        display: flex;
        align-items: center;
    }

    .miDiv {
        opacity: 0;
        display: none; 
        padding: 10px;
        transition: opacity 0.5s ease-in-out;
    }

    .cabeza::before {
        position: absolute;
        top: 17px;
        right: 100%;
        left: -22px;
        display: block;
        width: 23px;
        height: 29px;
        pointer-events: none;
        content: " ";
        -webkit-clip-path: polygon(0 50%, 100% 0, 100% 100%);
        clip-path: polygon(0 50%, 100% 0, 100% 100%);
        background-color: #fde1b5;
    }
    
</style>