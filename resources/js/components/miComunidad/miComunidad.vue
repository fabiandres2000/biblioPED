<template lang="">
    <div>
        <div class="row" style="padding-top: 20px">
            <div class="col-1"></div>
            <div class="col-10">
                <div class="app-content content">
                <div class="content-overlay"></div>
                <div class="content-wrapper">
                    <div class="content-header row">
                    </div>
                    <div class="content-body">
                        <div id="user-profile">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card profile-with-cover">
                                        <div class="card-img-top img-fluid bg-cover height-300" style="background: url('/img/comunidad/upc_baner.png') 50%;"></div>
                                        <div class="media profil-cover-details w-100">
                                            <div class="media-left pl-2 pt-2">
                                                <a href="#" class="profile-image">
                                                    <img src="/img/comunidad/logo.png" class="rounded-circle img-border height-100" alt="Card image">
                                                </a>
                                            </div>
                                            <div class="media-body pt-3 px-2">
                                                <div class="row">
                                                    <div class="col">
                                                        <h3 style="margin-bottom: 10px" class="card-title">Universidad Popular del Cesar</h3>
                                                        <h3 class="card-title">Sede - Principal</h3>
                                                    </div>
                                                    <div class="col text-right">
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <nav class="navbar navbar-light navbar-profile align-self-end">
                                            <button class="navbar-toggler d-sm-none" type="button" data-toggle="collapse" aria-expanded="false" aria-label="Toggle navigation"></button>
                                            <nav class="navbar navbar-expand-lg">
                                                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                                    <ul class="navbar-nav mr-auto">
                                                        <li style="margin-right: 15px" class="nav-item">
                                                            <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i> Follow</button>
                                                        </li>
                                                        <li class="nav-item active">
                                                            <button type="button" class="btn btn-warning"  data-toggle="modal" data-target="#modalNewPublicacion"><i class="fa  fa-dashcube"></i> Realizar una publicación <span class="sr-only"></span></button>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </nav>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                            <div v-if="!loading">
                                <div id="miembros" style="position: absolute; top: 472px;height: 600px; width: 31%;" class="miembrosComunidad">

                                </div>
                                <div class="row">
                                    <div class="col-4">

                                    </div>
                                    <div class="col-8">
                                        <section id="timeline" class="timeline-center timeline-wrapper">
                                            <h3 class="page-title text-center">Últimas publicaciones</h3>
                                            <hr>
                                            <ul class="timeline">                                   
                                                <li v-for="(item, index) in datos" :key="index" class="timeline-item" style="border-radius: 20px">
                                                    
                                                    <div class="timeline-card card border-grey border-lighten-2">
                                                        <div class="card-header" style="background-color: #a8dbc4">
                                                            <div class="media">
                                                                <div class="media-left mr-1">
                                                                    <a href="#">
                                                                        <span class="avatar avatar-md avatar-busy"><img :src="'/'+item.usuario.imagen" alt="avatar"></span>
                                                                        <i></i>
                                                                    </a>
                                                                </div>
                                                                <div class="media-body">
                                                                    <h4 class="card-title"><a href="#">{{ item.usuario.nombre }} - <strong v-if="item.usuario.tipo_registro == 'estudiante'" style="color: #7d7d7d">{{ item.usuario.grado }}° grado</strong><strong v-if="item.usuario.tipo_registro == 'docente'" style="color: #7d7d7d">Docente</strong></a></h4>
                                                                    <p class="card-subtitle text-muted mb-0 pt-1">
                                                                        <span class="font-small-3">{{ item.fecha_formateada }}</span>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="card-content">
                                                            <div class="card-content">
                                                                <div class="card-body">
                                                                    <p class="card-text" style="font-size: 29px; font-weight: bold; color: #595757;">{{ item.detalle }}</p>
                                                                    <img style="margin-bottom: 20px" v-if="item.imagen != ''" class="img-fluid" :src="'/imagenes_comunidad/'+item.imagen" alt="Timeline Image 1">
                                                                    <ul class="list-inline">
                                                                        <li class="pr-1"><a href="#" class=""><span class="fa fa-thumbs-o-up"></span> Me gusta</a></li>
                                                                        <li class="pr-1"><a href="#" class=""><span class="fa fa-commenting-o"></span> ({{item.comentarios.length}}) Comentarios</a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>                     
                                                            <div class="card-footer px-0 py-0">
                                                                <div class="card-body">
                                                                    <div v-for="(item2, index2) in item.comentarios" :key="index2">
                                                                        <div class="media" v-if="index2 < 3" style="padding-left: 20px; margin-bottom: 15px">
                                                                            <div class="media-body">
                                                                                <div class="media" style="position: relative">
                                                                                    <div class="media-left mr-1">
                                                                                        <a href="#">
                                                                                            <span class="avatar avatar-online"><img :src="item2.usuario.imagen" alt="avatar"></span>
                                                                                        </a>
                                                                                    </div>
                                                                                    <div class="media-body">
                                                                                        <div class="burbuja">
                                                                                            <p class="text-bold-600 mb-0"><a href="#">{{ item2.usuario.nombre }}</a></p>
                                                                                            <p style="margin-bottom: 5px">{{ item2.comentarioTexto }}</p>
                                                                                        </div>
                                                                                        <i v-if="datosLogin._id.$oid == item2.usuario._id.$oid" @click="eliminarRespuestaComentarioPregunta(item._id.$oid, item2._id.$oid)" class="fas fa-trash-alt eliminarcomemntario"></i>
                                                                                        <ul class="list-inline" style="margin-left: 20px">
                                                                                            <li class="pr-1"><a href="#" class=""><span class="fa fa-thumbs-o-up"></span> Like</a></li>
                                                                                            <li class="pr-1"><strong> {{ item2.fechaFormateada }}</strong></li>
                                                                                        </ul>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <a  data-toggle="modal" data-target="#modalPublicacion" @click.prevent="verTodosComentarios(index)" style="margin-left: 30px" href="" v-if="item.comentarios.length > 3">Mostrar todos los comentarios({{ item.comentarios.length - 3 }})</a>
                                                                </div>                                                        
                                                                <div class="card-body" style="height: 60px; padding-top: 0px">
                                                                    <fieldset class="form-group position-relative has-icon-left mb-0">
                                                                        <input @click='setIdPublicacion(item._id.$oid, index)' :id="'inputComentario'+index" type="text" class="form-control" placeholder="Write comments...">
                                                                        <div style="top: 7px; left: 4px" class="form-control-position">
                                                                            <i @click="mostrarEmojis(index)" style="font-size: 1.6em; cursor: pointer" class="far fa-laugh-beam"></i>
                                                                        </div>
                                                                        <i @click="guardarComentario"  class="comentar fas fa-paper-plane"></i>
                                                                    </fieldset>
                                                                    <div :id="'EmojiPicker'+index" style="position: relative; top: -378px; right: -233px; display: none">
                                                                        <EmojiPicker 
                                                                            :disable-skin-tones="true"
                                                                            :native="true" 
                                                                            @select="onSelectEmoji"
                                                                            :disable-sticky-group-names="true"
                                                                            :hide-search="true"
                                                                            :hide-group-icons="false"
                                                                            :disabled-groups="['activities', 'travel_places', 'objects', 'flags']"
                                                                        />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </section>
                                    </div>    
                                </div> 
                            </div>
                             
                        </div>
                    </div>
                </div>
            </div>
            </div>
            <div class="col-1"></div>
        </div>

        <div class="modal fade text-left" id="modalPublicacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document" v-if="publiSeleccionada != null">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="card-header" style="background-color: #a8dbc4; width: 100%">
                            <div class="media">
                                <div class="media-left mr-1">
                                    <a href="#">
                                        <span class="avatar avatar-md avatar-busy"><img :src="'/'+publiSeleccionada.usuario.imagen" alt="avatar"></span>
                                        <i></i>
                                    </a>
                                </div>
                                <div class="media-body">
                                    <h4 class="card-title"><a href="#">{{ publiSeleccionada.usuario.nombre }} - <strong v-if="publiSeleccionada.usuario.tipo_registro == 'estudiante'" style="color: #7d7d7d">{{ publiSeleccionada.usuario.grado }}° grado</strong><strong v-if="publiSeleccionada.usuario.tipo_registro == 'docente'" style="color: #7d7d7d">Docente</strong></a></h4>
                                    <p class="card-subtitle text-muted mb-0 pt-1">
                                        <span class="font-small-3">{{ publiSeleccionada.fecha_formateada }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <button type="button"  @click="cerrarTodosComentarios" class="close btn_cerar_modal" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="max-height: 600px; overflow-y: auto; padding-bottom: 7px;">
                        <div class="card-content">
                            <div class="card-body">
                                <p class="card-text" style="font-size: 25px; font-weight: bold; color: #595757;">{{ publiSeleccionada.detalle }}</p>
                                <img style="margin-bottom: 20px" v-if="publiSeleccionada.imagen != ''" class="img-fluid" :src="'/imagenes_comunidad/'+publiSeleccionada.imagen" alt="Timeline Image 1">
                                <ul class="list-inline">
                                    <li class="pr-1"><a href="#" class=""><span class="fa fa-thumbs-o-up"></span> Me gusta</a></li>
                                    <li class="pr-1"><a href="#" class=""><span class="fa fa-commenting-o"></span> ({{publiSeleccionada.comentarios.length}}) Comentarios</a></li>
                                </ul>
                                <hr>
                            </div>
                        </div> 
                        <div v-for="(item2, index2) in publiSeleccionada.comentarios" :key="index2">
                            <div class="media" style="padding-left: 20px; margin-bottom: 15px">
                                <div class="media-body">
                                    <div class="media" style="position: relative">
                                        <div class="media-left mr-1">
                                            <a href="#">
                                                <span class="avatar avatar-online"><img :src="item2.usuario.imagen" alt="avatar"></span>
                                            </a>
                                        </div>
                                        <div class="media-body">
                                            <div class="burbuja">
                                                <p class="text-bold-600 mb-0"><a href="#">{{ item2.usuario.nombre }}</a></p>
                                                <p style="margin-bottom: 5px">{{ item2.comentarioTexto }}</p>
                                            </div>
                                            <i style="right: 4px;" v-if="datosLogin._id.$oid == item2.usuario._id.$oid" @click="eliminarRespuestaComentarioPregunta(publiSeleccionada._id.$oid, item2._id.$oid)" class="fas fa-trash-alt eliminarcomemntario"></i>
                                            <ul class="list-inline" style="margin-left: 20px">
                                                <li class="pr-1"><a href="#" class=""><span class="fa fa-thumbs-o-up"></span> Like</a></li>
                                                <li class="pr-1"><strong> {{ item2.fechaFormateada }}</strong></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="width: 100%; background-color: white; position: sticky; bottom: -7px;">
                            <div class="card-body" style="height: 60px; padding-top: 12px">
                                <fieldset class="form-group position-relative has-icon-left mb-0">
                                    <input @click='setIdPublicacion(publiSeleccionada._id.$oid, indexpubliSeleccionada)' :id="'inputComentario01'" type="text" class="form-control" placeholder="Write comments...">
                                    <div style="top: 7px; left: 4px" class="form-control-position">
                                        <i @click="mostrarEmojis('01')" style="font-size: 1.6em; cursor: pointer" class="far fa-laugh-beam"></i>
                                    </div>
                                    <i @click="guardarComentarioModal"  class="comentar fas fa-paper-plane"></i>
                                </fieldset>
                                <div :id="'EmojiPicker01'" style="position: relative; top: -378px; right: -233px; display: none">
                                    <EmojiPicker 
                                        :disable-skin-tones="true"
                                        :native="true" 
                                        @select="onSelectEmoji"
                                        :disable-sticky-group-names="true"
                                        :hide-search="true"
                                        :hide-group-icons="false"
                                        :disabled-groups="['activities', 'travel_places', 'objects', 'flags']"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade text-left" id="modalNewPublicacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18" aria-hidden="true">
            <div class="modal-dialog" role="document" style="margin-top: 9%">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel18">Crear publicación</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <label for="detallePublicacion"><strong>Detalles de la publicación</strong></label>
                        <textarea v-model="detallePublicacion" rows="6" placeholder="Escribe aquí tu publicación" cols="100" class="form-control" id="detallePublicacion"></textarea>
                        <br>
                        <form style="min-height: 250px; display: flex; align-items: center; justify-content: center;" @click="openFileInputPublicacion" action="#" class="dropzone dropzone-area" id="dpz-single-file">
                            <input type="file" accept="image/*" ref="fileInputPublicacion" style="display: none" @change="handleFileChangePublicacion" />
                            <div v-if="!selectedImage" style="display: flex; align-items: center; justify-content: center; flex-direction: column; width: 70%; height: 200px; text-align: center">
                                <img src="/img/upload_icon.png" width="90" height="75" alt="">
                                <h6 style="color: #808080; margin-top: 10px"><strong>Se admite, JPG, PNG, Gif <br> tamaño máximo 2 MB</strong></h6>
                            </div>
                        </form>
                        <div v-if="selectedImage" style="z-index: 10; position: absolute; top: 47%; left: 14%; display: flex; align-items: center; justify-content: center; width: 70%; height: 200px; text-align: center">
                            <img style="width: 80%; max-height: 100%;" :src="selectedImage" alt="Imagen cargada" />
                            <div class="btn_eliminar"><i @click="eliminarImagenPublicacion" style="color: white" class="fas fa-trash fa-3x"></i></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn grey btn-outline-danger" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
                        <button type="button" class="btn btn-outline-primary" @click="guardarPublicacion"><i class="fa fa-save"></i> Publicar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import * as comunidadService from "../../services/comunidad";
import EmojiPicker from 'vue3-emoji-picker'
import 'vue3-emoji-picker/css'
import * as usuarioService from "../../services/usuario";
import Swal from 'sweetalert2';

export default {
    components: {
        EmojiPicker
    },
    data(){
        return {
            detallePublicacion: '',
            selectedImage: null,
            imageFile: null,
            pixelesDesplazados: 0,
            datos: [],
            loading: true,
            indexComentario: 0,
            selectedPosted: null,
            datosLogin: null,
            publiSeleccionada: null,
            indexpubliSeleccionada: null
        }
    },
    mounted() {
        window.addEventListener("scroll", this.actualizarPixelesDesplazados);
        this.misDatos();
    },
    beforeDestroy() {
        window.removeEventListener("scroll", this.actualizarPixelesDesplazados);
    },
    methods: {
        misDatos: async function () {
            await usuarioService.misDatos().then(respuesta => {
                this.datosLogin = respuesta.data;
                this.listarPublicaciones();
            });
        },
        openFileInputPublicacion() {
            this.$refs.fileInputPublicacion.click();
        },
        handleFileChangePublicacion(event) {
            const file = event.target.files[0];
            this.imageFile = event.target.files[0];
            if (file) {
                this.selectedImage = URL.createObjectURL(file);
            }
        },
        eliminarImagenPublicacion(){
            this.selectedImage = null;
        },
        async guardarPublicacion() {
            const formData = new FormData();
            formData.append('detalle', this.detallePublicacion);
            formData.append('imagen', this.imageFile);
                   
            if(this.detallePublicacion != "" ){
                const response = await comunidadService.guardarPublicacion(formData);
                const respuesta_ok = response.data;
                if (respuesta_ok[1] === 1) {
                    toastr.success(respuesta_ok[0]);
                    this.listarPublicaciones();
                } else {
                    toastr.error(respuesta_ok[0]);
                }

                this.detallePublicacion = '';
                this.selectedImage = null;
                this.imageFile = null;
                $("#modalNewPublicacion").modal('hide');
            }else{
                toastr.error('¡El campo detalle de la publicación es obligatorio!');
            }
        },
        actualizarPixelesDesplazados() {
            this.pixelesDesplazados = window.scrollY;
            console.log(this.pixelesDesplazados);
            if(this.pixelesDesplazados >= 461){
                $('#miembros').css({
                    'position': 'fixed',
                    'top': '11%',
                    'height': '600px',
                    'width': '25.7%'
                });
            } else {
                $('#miembros').css({
                    'position': 'absolute',
                    'top': '472px',
                    'height': '600px',
                    'width': '31%'
                });
            }
        },
        async listarPublicaciones() {
            this.loading = true;
            await comunidadService.listarPublicaciones().then(respuesta => {
                this.datos = respuesta.data;
                this.loading = false;
            });
        },
        onSelectEmoji(emoji) {
            var valorExistente = $("#inputComentario"+this.indexComentario).val();
            var nuevoValor = valorExistente + " " + emoji.i;
            $("#inputComentario"+this.indexComentario).val(nuevoValor);
        },
        mostrarEmojis(index) {
            this.indexComentario = index;
            var miDiv = $("#EmojiPicker"+index);
            if (miDiv.css("display") === "none") {
                miDiv.css("display", "block");
            } else {
                miDiv.css("display", "none");
            }
        },
        setIdPublicacion(id, index){
            this.selectedPosted = id;
            this.indexComentario = index;
        },
        async guardarComentario() {
            var comentarioTexto = $("#inputComentario"+this.indexComentario).val();
            var datos = {
                comentarioTexto: comentarioTexto,
                idPost: this.selectedPosted 
            }

            if(comentarioTexto != ""){
                await comunidadService.registrarComentarioPost(datos).then(respuesta => {
                    var respuesta_ok = respuesta.data;
                    if(respuesta_ok[1] == 1){
                        $("#inputComentario"+this.indexComentario).val("");
                        var miDiv = $("#EmojiPicker"+this.indexComentario);
                        if (miDiv.css("display") === "block") {
                            miDiv.css("display", "none");
                        }
                        toastr.success(respuesta_ok[0]);
                        comunidadService.listarPublicaciones().then(respuesta => {
                            this.datos = respuesta.data;
                        });
                    }else{
                        toastr.error(respuesta_ok[0]);
                    }
                });
            }else{
                toastr.warning("¡No ha escrito nada en la caja de comentarios");
            }
        },
        async guardarComentarioModal() {
            var comentarioTexto = $("#inputComentario01").val();

            var datos = {
                comentarioTexto: comentarioTexto,
                idPost: this.selectedPosted 
            }

            if(comentarioTexto != ""){
                await comunidadService.registrarComentarioPost(datos).then(respuesta => {
                    var respuesta_ok = respuesta.data;
                    if(respuesta_ok[1] == 1){
                        $("#inputComentario01").val("");
                        var miDiv = $("#EmojiPicker01");
                        if (miDiv.css("display") === "block") {
                            miDiv.css("display", "none");
                        }
                        toastr.success(respuesta_ok[0]);
                        comunidadService.listarPublicaciones().then(respuesta => {
                            this.datos = respuesta.data;
                            if(this.indexpubliSeleccionada != null){
                                this.publiSeleccionada = this.datos[this.indexpubliSeleccionada];
                            }
                        });
                    }else{
                        toastr.error(respuesta_ok[0]);
                    }
                });
            }else{
                toastr.warning("¡No ha escrito nada en la caja de comentarios");
            }
        },
        async eliminarRespuestaComentarioPregunta(id_publicacion, id_comentario) {
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
                        this.eliminarRespuestaComentario(id_publicacion, id_comentario);
                    }
                })
        },
        async eliminarRespuestaComentario(id_publicacion, id_comentario) {
            await comunidadService.eliminarRespuestaComentario(id_publicacion, id_comentario).then(respuesta => {
                var respuesta_ok = respuesta.data;
                if(respuesta_ok[1] == 1){
                    toastr.success(respuesta_ok[0]);
                    comunidadService.listarPublicaciones().then(respuesta => {
                        this.datos = respuesta.data;
                        if(this.indexpubliSeleccionada != null){
                            this.publiSeleccionada = this.datos[this.indexpubliSeleccionada];
                        }
                    });
                }else{
                    toastr.error(respuesta_ok[0]);
                }
            });
        },
        verTodosComentarios(index){
            this.indexpubliSeleccionada = index;
            this.publiSeleccionada = this.datos[this.indexpubliSeleccionada];
        },
    }
};
</script>
<style>
.profile-card-with-stats .btn-float {
    padding: 8px 14px 4px 14px;
}

.profile-card-with-cover .card-profile-image {
    position: absolute;
    top: 130px;
    width: 100%;
    text-align: center;
}

.profile-card-with-cover .card-profile-image img.img-border {
    border: 5px solid #fff;
    width: 122px;
    height: 122px;
}

.profile-card-with-cover .profile-card-with-cover-content {
    padding-top: 4rem;
}

#user-profile .profile-with-cover .profil-cover-details {
    position: absolute;
    margin-top: 210px;
}

#user-profile .profile-with-cover .profil-cover-details .profile-image img.img-border {
    border: 5px solid #fff;
}

#user-profile .profile-with-cover .profil-cover-details .card-title {
    color: #fff;
    text-shadow: 1px 1px 4px #1b2942;
}

#user-profile .navbar-profile {
    margin-left: 130px;
}

#users-contacts .delete i,
#users-contacts .favorite i {
    font-size: 1.25rem;
    cursor: pointer;
}

#users-contacts .favorite.active {
    color: #ffa87d;
}

.app-content .sidebar-toggle {
    position: absolute;
    cursor: pointer;
    margin-top: 4px;
}

.app-content .content-overlay {
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    position: absolute;
    display: block;
    z-index: 2;
    visibility: hidden;
}

.app-content .content-overlay.show {
    visibility: visible;
    background-color: rgba(0, 0, 0, 0.6);
}

@media only screen and (max-width: 992px) {
    .app-content .bug-list-search form {
        margin-left: 3rem;
    }

    .app-content .sidebar-left {
        transform: translateX(-100%);
        transition: 300ms ease all;
        display: none;
    }

    .app-content .sidebar-left.show {
        display: block;
        position: fixed;
        top: 56px;
        width: 300px;
        z-index: 1036;
        left: 0;
        transform: translateX(0%);
        height: calc(100% - 56px);
        transition: 300ms ease all;
        overflow-y: scroll;
    }

    .app-content .sidebar-left.show .card {
        margin-bottom: 0;
    }
}

.timeline-item {
    list-style: none;
}

.dropzone {
    min-height: 350px;
    border: 2px dashed #808080;
    background: #F5F7FA;
    border-radius: 19px;
}

.miembrosComunidad{
    background-color: #d7d7d7;
    border-radius: 20px;

}


.v3-footer {
    display: none;
}

.comentar {
    color: white;
    background-color: #009199;
    position: absolute;
    right: 0px;
    top: 0px;
    font-size: 1.6em;
    cursor: pointer;
    padding: 9px;
    border-radius: 0px 4px 4px 0px;
}

.burbuja {
    border-radius: 14px;
    padding: 10px;
    background-color: #efefefeb;
    width: 92%;
}

.eliminarcomemntario{
    position: absolute;
    top: 30px;
    right: 17px;
    font-size: 15px;
    color: gray;
    cursor: pointer;
}

.eliminarcomemntario:hover{
    color: rgb(85, 84, 84);
}

.btn_cerar_modal {
    position: absolute;
    right: 15px;
    top: 17px;
    background-color: #e75252 !important;
    opacity: 1;
    color: white;
    border-radius: 50%;
    width: 50px;
    height: 50px;
    border: 6px solid white !important;
    display: flex;
    align-items: center;
    justify-content: center;
}

.btn_cerar_modal:hover{
    background-color: #d81515 !important;
    color: white !important;
    opacity: 1 !important;
}
</style>
