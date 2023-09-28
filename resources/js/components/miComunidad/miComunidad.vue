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
                                                                    <li class="pr-1"><a href="#" class=""><span class="fa fa-commenting-o"></span> Comentarios</a></li>
                                                                </ul>
                                                            </div>
                                                        </div>                     
                                                        <div class="card-footer px-0 py-0">
                                                            <div class="card-body">
                                                                <div class="media">
                                                                    <div class="media-left mr-1">
                                                                        <a href="#">
                                                                            <span class="avatar avatar-online"><img src="/app-assets/images/portrait/small/avatar-s-1.png" alt="avatar"></span>
                                                                        </a>
                                                                    </div>
                                                                    <div class="media-body">
                                                                        <p class="text-bold-600 mb-0"><a href="#">Jason Ansley</a></p>
                                                                        <p>Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante
                                                                            sollicitudin commodo.</p>
                                                                        <ul class="list-inline">
                                                                            <li class="pr-1"><a href="#" class=""><span class="fa fa-thumbs-o-up"></span> Like</a></li>
                                                                            <li class="pr-1"><a href="#" class=""><span class="fa fa-commenting-o"></span> Reply</a></li>
                                                                        </ul>
                                                                        <div class="media">
                                                                            <div class="media-left mr-1">
                                                                                <a href="#">
                                                                                    <span class="avatar avatar-online"><img src="/app-assets/images/portrait/small/avatar-s-18.png" alt="avatar"></span>
                                                                                </a>
                                                                            </div>
                                                                            <div class="media-body">
                                                                                <p class="text-bold-600 mb-0"><a href="#">Janice Johnston</a></p>
                                                                                <p>Gravida nulla. Nulla vel metus scelerisque ante sollicitudin.</p>
                                                                                <ul class="list-inline">
                                                                                    <li class="pr-1"><a href="#" class=""><span class="fa fa-thumbs-o-up"></span> Like</a></li>
                                                                                    <li class="pr-1"><a href="#" class=""><span class="fa fa-commenting-o"></span> Reply</a></li>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="card-body">
                                                                <fieldset class="form-group position-relative has-icon-left mb-0">
                                                                    <input type="text" class="form-control" placeholder="Write comments...">
                                                                    <div class="form-control-position">
                                                                        <i class="fa fa-dashcube"></i>
                                                                    </div>
                                                                </fieldset>
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
            <div class="col-1"></div>
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

export default {
    data(){
        return {
            detallePublicacion: '',
            selectedImage: null,
            imageFile: null,
            pixelesDesplazados: 0,
            datos: []
        }
    },
    mounted() {
        window.addEventListener("scroll", this.actualizarPixelesDesplazados);
        this.listarPublicaciones();
    },
    beforeDestroy() {
        window.removeEventListener("scroll", this.actualizarPixelesDesplazados);
    },
    methods: {
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
            await comunidadService.listarPublicaciones().then(respuesta => {
                this.datos = respuesta.data;
            });
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

</style>
