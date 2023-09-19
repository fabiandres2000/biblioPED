<template lang="">
    <div>
        <div class="content-center p-5" style="background-color: #f5f7fa">
            <div class="row">
                <div class="col-3">
                    <div class="content-overlay"></div>
                    <div class="content-wrapper">
                        <h1>Historial</h1>
                        <hr>
                        <div style="display: flex; align-items: center">
                            <i style="font-size: 1.5rem;" class="feather icon-trash-2"></i><a style="padding-left: 25px; text-align: left" href="#" data-toggle="modal" data-target="#defaultSize" type="button"><strong> Borrar datos de <br> navegacion</strong></a> 
                        </div>
                        
                    </div>
                </div>
                <div class="col-9">
                    <div class="content-overlay"></div>
                    <div class="content-wrapper">
                        <div class="content-header row">
                        </div>
                        <div class="content-body">
                            <!-- email app overlay -->
                            <div class="app-content-overlay"></div>
                            <div class="email-app-area">
                                <!-- Email list Area -->
                                <div class="email-app-list-wrapper">
                                    <div class="email-app-list">
                                        <div class="email-action">
                                            <!-- action right start here -->
                                            <div class="action-right d-flex flex-grow-1 align-items-center justify-content-around">
                                                <!-- search bar  -->
                                                <div class="email-fixed-search flex-grow-1">
                                                    <div class="sidebar-toggle d-block d-lg-none">
                                                        <i class="feather icon-menu"></i>
                                                    </div>
                                                    <fieldset style="padding-right: 13px; padding-left: 9px;" class="form-group position-relative has-icon-left m-0">
                                                        <input @input="handleChange" style="border-radius: 50px" type="text" class="form-control" id="email-search" placeholder="Filtrar busquedas...">
                                                        <div class="form-control-position">
                                                            <i class="feather icon-search"></i>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                            
                                            </div>
                                        </div>
                                        <!-- / action right -->
                                        <br><br>
                                        <!-- email user list start -->
                                        <div v-for="(item, index) in datos" :key="index" class="email-user-list list-group" style="background-color: white;padding: 12px;border-radius: 20px;margin: 10px;box-shadow: 0px -1px 17px 0px #bfbcbf; margin-bottom: 40px">
                                            <h4 style="margin: 20px;padding-bottom: 16px;border-bottom: 2px solid #dbd9d9;">{{ item._id }}</h4>
                                            <ul class="users-list-wrapper media-list">
                                                <li v-for="(item2, index2) in item.busquedas_dia" :key="index2" class="media mail-read" style="border-bottom: 1px solid #dbdbdb;">
                                                    <div class="user-action">
                                                        <div class="checkbox-con ">
                                                            <div class="custom-control custom-checkbox" style="display: flex; justify-content: center; align-items: center;">
                                                                <input type="checkbox" class="custom-control-input" id="checkboxsmall1">
                                                                <label class="custom-control-label" for="checkboxsmall1">{{ item2.hora }}</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="pr-50" style="margin-left: 8%">
                                                        <div style="width: 40px; height: 30px">
                                                            <img src="app-assets/images/portrait/small/seo.png" style="height: 100%; width: 100%">
                                                        </div>
                                                    </div>
                                                    <div class="media-body">
                                                        <div class="row">
                                                            <div class="col-11">
                                                                <div class="user-details">
                                                                    <div class="mail-items">
                                                                        <span class="list-group-item-text text-truncate">Buscaste: <strong>{{ item2.texto_busqueda }}</strong></span>
                                                                    </div>
                                                                </div>
                                                                <div class="mail-message">
                                                                    <p class="list-group-item-text truncate mb-0">
                                                                        ir a: <router-link style="color: #009c9f;" :to="'/'+item2.ruta">{{ item2.ruta }}</router-link> 
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade text-left" id="defaultSize" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel18">Borrar datos de navegación</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="">
                            <h5><strong>Seleccione una opción y luego de clik en "Borrar Datos"</strong></h5>
                            <hr>
                            <select ref="tipo_borrado" id="" class="form-control">
                                <option value="1">Hoy</option>
                                <option value="2">Últimos 7 dias</option>
                                <option value="3">Desde siempre</option>
                            </select>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Cancelar</button>
                        <button @click="eliminar" type="button" class="btn btn-outline-primary">Borrar Datos</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import * as usuarioService from "../services/usuario";
export default {
    data() {
        return {
            datos: [],
            inputValue: "todo",
            tipo_borrado: ""
        };
    },
    mounted() {
        this.obtenerHistorial();
        this.verificarLogin();
    },
    methods: {
        async verificarLogin(){
            var navigate = this.$router;
            await usuarioService.verificarLogin().then(respuesta => {
                if(respuesta.data == 0){
                    navigate.push({ name: 'paginaBusqueda'})
                }
            });
        },
        async obtenerHistorial() {
            await usuarioService.historial(this.inputValue).then(respuesta => {
                this.datos = respuesta.data;
            });
        },
        handleChange(event) {

            if (event.target.value == "") {
                this.inputValue = "todo"
            } else {
                this.inputValue = event.target.value;
            }
            this.obtenerHistorial();
        },
        async eliminar(){
            this.tipo_borrado = this.$refs.tipo_borrado.value;
            await usuarioService.eliminar_historial(this.tipo_borrado).then(respuesta => {
                var respuesta = respuesta.data;
                toastr.success("Se hán eliminado "+respuesta+ " busquedas.");
                $('#defaultSize').modal('hide');
                setTimeout(()=>{
                    this.obtenerHistorial();
                }, 1000)
            });
        }
    }
}
</script>
<style lang="">
    
</style>