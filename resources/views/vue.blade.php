<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description"
        content="Stack admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords"
        content="admin template, stack admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="PIXINVENT">
    <title>Inicio - BiblioPED</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('/img/isotipo.png') }}">
    <link
        href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i%7COpen+Sans:300,300i,400,400i,600,600i,700,700i"
        rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/vendors.min.css') }}">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/bootstrap-extended.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/colors.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/components.css') }}">
    <!-- END: Theme CSS-->

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('app-assets/css/core/menu/menu-types/horizontal-menu.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/core/colors/palette-gradient.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/pages/search.css') }}">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->


    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/font.css.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/5.14/css/all.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/plugins/extensions/toastr.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/extensions/toastr.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/pages/app-email.css') }}">

    <link rel="stylesheet" type="text/css"
        href="{{ asset('app-assets/fonts/font-awesome/css/font-awesome.min.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/core/colors/palette-tooltip.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('app-assets/vendors/css/tables/datatable/datatables.min.css') }}">

    <link rel="stylesheet" type="text/css"
        href="{{ asset('app-assets/vendors/css/file-uploaders/dropzone.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('app-assets/css-rtl/plugins/file-uploaders/dropzone.css') }}">


    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('css/navegador.css') }}">

    <script type="text/javascript" src="{{ asset('js/tsparticles.bundle.min.js') }}"></script>

    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/fonts/simple-line-icons/style.css') }}">

    <style>
        body {
            overflow-x: hidden
        }

        .img_avatar_sel {
            height: 84px;
            cursor: pointer;
        }

        .col-3 {
            text-align: center;
            padding: 5px
        }

        .colavatar {
            text-align: center;
            padding: 5px;
        }

        thead {
            background-color: #16d39a94;
        }

        body::before {
            position: absolute;
            width: 0;
            height: 0;
            overflow: hidden;
            z-index: -1;
            content: url("/img/fondo_inicio.png") url("/img/fondo_resultados.png") url("/img/logo_1_2.png") url("/img/fondo_imagen.png") url("/img/fondo_video.png") url("/img/no_results.gif") url('/img/fondo_social.png') url('/images/google.png') url('/images/astronaut.svg') url('/images/planet.svg');
        }

        .breadcrumb-item {
            font-weight: 700
        }

        /* scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }


        ::-webkit-scrollbar-thumb {
            border-radius: 200px !important;
            background: #a6a3b6 !important;
            border: none !important;
            border-left: 0 !important;
            border-right: 0 !important;
        }

        ::-webkit-scrollbar-track {
            background-color: rgba(255, 255, 255, 0);
            border-radius: 100px;
        }

        .btn-warning {
            border-color: #fc4f00 !important;
            background-color: #fc4f00 !important;
            color: #FFFFFF;
        }

        .tooltip {
            background-color: transparent !important; 
            color: white;
            padding: 5px;
            border-radius: 4px;
        }
    </style>
</head>

<body class="vertical-layout vertical-menu 2-columns menu-expanded fixed-navbar" data-open="click"
    data-menu="vertical-menu" data-col="content-left-sidebar"data-col="2-columns"
    style="background-color: #f5f7fa; overflow-y: auto">
    <!-- BEGIN: Header-->
    <nav
        class="header-navbar navbar-expand-md navbar navbar-with-menu fixed-top navbar-dark navbar-border navbar-brand-center">
        <div class="navbar-wrapper">
            <div class="navbar-header">
                <ul class="nav navbar-nav flex-row">
                    <li class="nav-item mobile-menu d-md-none mr-auto"><a
                            class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i
                                class="feather icon-menu font-large-1"></i></a></li>
                    <li class="nav-item"><a class="navbar-brand" href="index.html"></li>
                    <li class="nav-item d-md-none"><a class="nav-link open-navbar-container" data-toggle="collapse"
                            data-target="#navbar-mobile"><i class="fa fa-ellipsis-v"></i></a></li>

                </ul>
            </div>
            <div class="navbar-container container center-layout" style="max-width: 100%;">
                <div class="collapse navbar-collapse" id="navbar-mobile">
                    <ul class="nav navbar-nav mr-auto float-left">
                        <a href="/"><img class="brand-logo" alt="stack admin logo"
                                src="{{ asset('img/letras.png') }}" height="40"></a>
                    </ul>
                    <ul class="nav navbar-nav float-right">
                        <li class="nav-item"
                            style="display: flex; justify-content: center; align-items: center; margin-right: 20px">
                            <a data-toggle="modal" data-target="#modal_diccionario"
                                style="padding: 0.6rem 0.8rem 0.6rem 0.9rem"
                                class="nav-link nav-link-label btn btn-warning" href="/mi-comunidad"><i
                                    class="fas fa-book"></i> Diccionario</a>
                        </li>
                        @if (Session::has('logueado'))
                            <li class="nav-item" style="display: flex; justify-content: center; align-items: center;">
                                <a style="padding: 0.6rem 0.8rem 0.6rem 0.9rem"
                                    class="nav-link nav-link-label btn btn-primary" href="/mi-comunidad"><i
                                        class="fas fa-school"></i> Mi Comunidad</a>
                            </li>
                            <li class="dropdown dropdown-notification nav-item"><a class="nav-link nav-link-label"
                                    href="#" data-toggle="dropdown"><i
                                        class="ficon feather icon-bell"></i><span
                                        class="badge badge-pill badge-danger badge-up"
                                        id="numero_notificaciones">0</span></a>
                                <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                                    <li class="dropdown-menu-header">
                                        <h6 class="dropdown-header m-0"><span
                                                class="grey darken-2">Notificaciones</span></h6>
                                    </li>
                                    <li class="scrollable-container media-list" id="lista_notificaciones">

                                    </li>
                                    <li class="dropdown-menu-footer"><a class="dropdown-item text-muted text-center"
                                            href="javascript:void(0)">Leer todas las notificaciones</a></li>
                                </ul>
                            </li>
                        @endif
                        <li class="dropdown dropdown-user nav-item"><a
                                class="dropdown-toggle nav-link dropdown-user-link" href="#"
                                data-toggle="dropdown">
                                @if (Session::has('logueado'))
                                    <div class="avatar avatar-online">
                                        <img src="{{ asset(session('imagen')) }}" alt="avatar">
                                        <i></i>
                                    </div>
                                    <span class="user-name">{{ session('nombre') }}</span>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        @if (session('tipo_registro') == 'administrador')
                                            <a class="dropdown-item" href="/dashboard">
                                                <i class="fas fa-chalkboard-teacher"></i>
                                                Dashboard
                                            </a>
                                            <hr>
                                        @endif
                                        <a class="dropdown-item" href="/historial">
                                            <i class="feather icon-user"></i>
                                            Mis Busquedas
                                        </a>
                                        <a class="dropdown-item" href="/mis-favoritos">
                                            <i class="feather icon-star"></i>
                                            Mis Favoritos
                                        </a>
                                        <a class="dropdown-item" href="/mi-perfil">
                                            <i class="fas fa-user-alt"></i>
                                            Mi Perfil
                                        </a>

                                        @if (session('tipo_registro') == 'docente')
                                            <hr>
                                            <a class="dropdown-item" href="/apuntes">
                                                <i class="fas fa-edit"></i>
                                                Mis Apuntes
                                            </a>
                                            <a class="dropdown-item" href="/lista-contenido">
                                                <i class="fas fa-book"></i>
                                                Gestión de Contenido
                                            </a>
                                            <a class="dropdown-item" href="/recomendaciones-docente">
                                                <i class="fas fa-share-alt"></i>
                                                Recomendaciones
                                            </a>
                                            <a class="dropdown-item" href="/foros-profesor">
                                                <i class="fab fa-weixin"></i>
                                                Foros
                                            </a>
                                        @endif
                                        @if (session('tipo_registro') == 'estudiante')
                                            <hr>
                                            <a class="dropdown-item" href="/apuntes">
                                                <i class="fas fa-edit"></i>
                                                Mis Apuntes
                                            </a>
                                            <a class="dropdown-item" href="/recomendaciones-estudiante">
                                                <i class="fas fa-share-alt"></i>
                                                Recomendaciones
                                            </a>
                                            <a class="dropdown-item" href="/foros">
                                                <i class="fab fa-weixin"></i>
                                                Foros
                                            </a>
                                        @endif
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" type="button" id="btnCerrarSesion" href="#">
                                            <i class="feather icon-power"></i>
                                            Cerrar Sesión
                                        </a>
                                    </div>
                                @else
                                    <div class="avatar avatar-offline">
                                        <img src="{{ asset('app-assets/images/portrait/small/user.png') }}"
                                            alt="avatar">
                                        <i></i>
                                    </div>
                                    <span class="user-name">Opciones</span>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a style="padding: 11px 21px 10px 25px" class="dropdown-item btn btn-info m-2"
                                            data-toggle="modal" data-target="#modalLoginForm">
                                            <i class="feather icon-unlock"></i>
                                            Iniciar Sesión
                                        </a>
                                        <a style="padding: 11px 21px 10px 25px"
                                            class="dropdown-item btn btn-warning m-2" data-toggle="modal"
                                            data-target="#modalLoginForm2">
                                            <i class="feather icon-user"></i>
                                            Registrate
                                        </a>
                                    </div>
                                @endif
                            </a>

                        </li>
                        <li class="nav-item d-none d-md-block"><a class="nav-link nav-link-expand" href="#"><i
                                    class="ficon feather icon-maximize"></i></a></li>

                    </ul>
                </div>
            </div>
            <div class="navbar-container">
                <div class="collapse navbar-toggleable-sm justify-content-end" id="navbar-mobile">
                    <ul class="nav navbar-nav">
                        <li class="nav-item"><a class="nav-link mr-2 nav-link-label" href="index.html"><i
                                    class="ficon feather icon-arrow-left"></i></a></li>
                        <li class="dropdown nav-item"><a class="nav-link mr-2 nav-link-label" href="#"
                                data-toggle="dropdown"><i class="ficon feather icon-settings"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="modal fade" id="modalLoginForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document" style="margin-top: 10%;">
            <div class="modal-content">
                <div class="modal-body">
                    <section class="row flexbox-container">
                        <div class="col-12 d-flex align-items-center justify-content-center">
                            <div class="col-lg-12 col-md-8 col-10  p-0">
                                <div class="card border-grey border-lighten-3 px-1 py-1 m-0" style="box-shadow: none">
                                    <div class="card-header border-0">
                                        <div class="card-title text-center">
                                            <img src="{{ asset('img/logo_1.png') }}" style="height: 90px;"
                                                alt="branding logo">
                                        </div>

                                    </div>
                                    <div class="card-content">
                                        <p
                                            class="card-subtitle line-on-side text-muted text-center font-small-3 mx-2 my-1">
                                            <span>Ingrese los siguientes datos</span></p>
                                        <div class="card-body">
                                            <form class="form-horizontal" id="miFormulario" method="POST" validate>
                                                @csrf
                                                <fieldset class="form-group position-relative has-icon-left">
                                                    <input type="text" class="form-control" name="correo"
                                                        placeholder="Ingrese un email" required>
                                                    <div class="form-control-position">
                                                        <i class="feather icon-mail"></i>
                                                    </div>
                                                </fieldset>
                                                <fieldset class="form-group position-relative has-icon-left">
                                                    <input type="password" class="form-control" name="password"
                                                        placeholder="Ingrese su contraseña" required>
                                                    <div class="form-control-position">
                                                        <i class="fa fa-key"></i>
                                                    </div>
                                                </fieldset>
                                                <div class="form-group row">
                                                    <div class="col-sm-6 col-12 text-center text-sm-left pr-0">
                                                        <fieldset>
                                                            <input type="checkbox" id="remember-me"
                                                                class="chk-remember">
                                                            <label for="remember-me"> Recordar contraseña</label>
                                                        </fieldset>
                                                    </div>
                                                    <div
                                                        class="col-sm-6 col-12 float-sm-left text-center text-sm-right">
                                                        <a href="recover-password.html" class="card-link">Has olvidado
                                                            tu contraseña?</a></div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="card-body"
                                            style="display: flex; padding: 0.5rem; justify-content: space-between;">
                                            <button style="width: 48%" id="btnLogin"
                                                class="btn btn-outline-success btn-block"><i
                                                    class="feather icon-user"></i> Iniciar Sesión</button>
                                            <button data-dismiss="modal" aria-label="Close"
                                                style="width: 48%; margin: 0"
                                                class="btn btn-outline-danger btn-block"><i
                                                    class="feather icon-x"></i> Cancelar</button>
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

    <div class="modal fade text-left" id="modalLoginForm2" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel17" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document" style="margin-top: 4%;">
            <div class="modal-content">
                <div class="modal-body">
                    <section class="row flexbox-container">
                        <div class="col-12 d-flex align-items-center justify-content-center">
                            <div class="col-lg-12 col-md-8 col-10  p-0">
                                <div class="card border-grey border-lighten-3 px-1 py-1 m-0" style="box-shadow: none">
                                    <div class="card-header border-0">
                                        <div class="card-title text-center">
                                            <img src="{{ asset('img/logo_1.png') }}" style="height: 90px;"
                                                alt="branding logo">
                                        </div>

                                    </div>
                                    <div class="card-content">
                                        <p
                                            class="card-subtitle line-on-side text-muted text-center font-small-3 mx-2 my-1">
                                            <span>Ingrese los siguientes datos</span></p>
                                        <div class="card-body">
                                            <form class="form-horizontal" id="miFormulario2" method="POST" validate>
                                                @csrf
                                                <div class="row">
                                                    <div class="col-6">
                                                        <fieldset class="form-group position-relative has-icon-left">
                                                            <input type="text" class="form-control" name="nombre"
                                                                placeholder="Ingrese su nombre" required>
                                                            <div class="form-control-position">
                                                                <i class="feather icon-user"></i>
                                                            </div>
                                                        </fieldset>
                                                    </div>
                                                    <div class="col-5">
                                                        <fieldset class="form-group position-relative has-icon-left">
                                                            <select name="sexo" class="form-control">
                                                                <option value="">Seleccione su sexo</option>
                                                                <option value="Masculino">Masculino</option>
                                                                <option value="Femenino">Femenino</option>
                                                            </select>
                                                            <div class="form-control-position">
                                                                <i class="fas fa-user"></i>
                                                            </div>
                                                        </fieldset>
                                                    </div>
                                                    <div class="col-1" style="padding-top: 4px">
                                                        <div class="avatar">
                                                            <img style="width: 155%; max-width: 154%;"
                                                                data-toggle="modal" data-target="#modal_avatar"
                                                                id="imagen_avatar"
                                                                src="{{ asset('avatars/default.png') }}"
                                                                alt="avatar">
                                                            <i></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-4">
                                                        <fieldset class="form-group position-relative has-icon-left">
                                                            <select name="grado" class="form-control">
                                                                <option value="">Seleccione su grado</option>
                                                                <option value="1">1º</option>
                                                                <option value="2">2º</option>
                                                                <option value="3">3º</option>
                                                                <option value="4">4º</option>
                                                                <option value="5">5º</option>
                                                                <option value="6">6º</option>
                                                                <option value="7">7º</option>
                                                                <option value="8">8º</option>
                                                                <option value="9">9º</option>
                                                                <option value="10">10º</option>
                                                                <option value="11">11º</option>
                                                            </select>
                                                            <div class="form-control-position">
                                                                <i class="fas fa-graduation-cap"></i>
                                                            </div>
                                                        </fieldset>
                                                    </div>
                                                    <div class="col-4">
                                                        <fieldset class="form-group position-relative has-icon-left">
                                                            <select name="grupo" class="form-control">
                                                                <option value="">Seleccione su grupo</option>
                                                                <option value="Grupo 1">Grupo 1</option>
                                                                <option value="Grupo 2">Grupo 2</option>
                                                                <option value="Grupo 3">Grupo 3</option>
                                                                <option value="Grupo 4">Grupo 4</option>
                                                                <option value="Grupo 5">Grupo 5</option>
                                                                <option value="Grupo 6">Grupo 6</option>
                                                                <option value="Grupo 7">Grupo 7</option>
                                                                <option value="Grupo 8">Grupo 8</option>
                                                                <option value="Grupo 9">Grupo 9</option>
                                                                <option value="Grupo 10">Grupo 10</option>
                                                            </select>
                                                            <div class="form-control-position">
                                                                <i class="fas fa-users"></i>
                                                            </div>
                                                        </fieldset>
                                                    </div>
                                                    <div class="col-4">
                                                        <fieldset class="form-group position-relative has-icon-left">
                                                            <select name="jornada" class="form-control">
                                                                <option value="">Jornada</option>
                                                                <option value="Mañana">Mañana</option>
                                                                <option value="Tarde">Tarde</option>
                                                                <option value="Continua">Continua</option>
                                                            </select>
                                                            <div class="form-control-position">
                                                                <i class="fas fa-sun"></i>
                                                            </div>
                                                        </fieldset>

                                                        <input type="hidden" name="tipo_registro"
                                                            value="estudiante">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <fieldset class="form-group position-relative has-icon-left">
                                                            <input type="text" class="form-control" name="correo"
                                                                placeholder="Ingrese un email" required>
                                                            <div class="form-control-position">
                                                                <i class="feather icon-mail"></i>
                                                            </div>
                                                        </fieldset>
                                                    </div>
                                                    <div class="col-6">
                                                        <fieldset class="form-group position-relative has-icon-left">
                                                            <input type="password" class="form-control"
                                                                name="password" placeholder="Ingrese su contraseña"
                                                                required>
                                                            <div class="form-control-position">
                                                                <i class="fa fa-key"></i>
                                                            </div>
                                                        </fieldset>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="form-group row">
                                                    <div class="col-sm-6 col-12 text-center text-sm-left pr-0">
                                                        <fieldset>
                                                            <input type="checkbox" id="remember-me2"
                                                                class="chk-remember">
                                                            <label for="remember-me2"> Recordar contraseña</label>
                                                        </fieldset>
                                                    </div>
                                                    <div
                                                        class="col-sm-6 col-12 float-sm-left text-center text-sm-right">
                                                        <a href="recover-password.html" class="card-link">Has olvidado
                                                            tu contraseña?</a></div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="card-body"
                                            style="display: flex; padding: 0.5rem; justify-content: space-between;">
                                            <button style="width: 48%" id="btnRegistrar"
                                                class="btn btn-outline-success btn-block"><i
                                                    class="feather icon-user"></i> Registrate</button>
                                            <button data-dismiss="modal" aria-label="Close"
                                                style="width: 48%; margin: 0"
                                                class="btn btn-outline-danger btn-block"><i
                                                    class="feather icon-x"></i> Cancelar</button>
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

    <div class="modal fade text-left" id="modal_avatar" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel17" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document" style="max-width: 820px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel17">Selecciona tu avatar favorito</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="base-tab1" data-toggle="tab" aria-controls="tab1"
                                href="#tab1" role="tab" aria-selected="true">Primaria</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="base-tab2" data-toggle="tab" aria-controls="tab2"
                                href="#tab2" role="tab" aria-selected="false">Secundaria</a>
                        </li>
                    </ul>
                    <div class="tab-content px-1 pt-1">
                        <div class="tab-pane active" id="tab1" role="tabpanel" aria-labelledby="base-tab1">
                            <div class="row">
                                <div class="col-3"><img class="img_avatar_sel" onclick="asignarURL('avatars/1.png')"
                                        src="{{ asset('avatars/1.png') }}" alt="1.png"></div>
                                <div class="col-3"><img class="img_avatar_sel" onclick="asignarURL('avatars/2.png')"
                                        src="{{ asset('avatars/2.png') }}" alt="1.png"></div>
                                <div class="col-3"><img class="img_avatar_sel" onclick="asignarURL('avatars/3.png')"
                                        src="{{ asset('avatars/3.png') }}" alt="1.png"></div>
                                <div class="col-3"><img class="img_avatar_sel" onclick="asignarURL('avatars/4.png')"
                                        src="{{ asset('avatars/4.png') }}" alt="1.png"></div>
                            </div>
                            <div class="row">
                                <div class="col-3"><img class="img_avatar_sel" onclick="asignarURL('avatars/5.png')"
                                        src="{{ asset('avatars/5.png') }}" alt="1.png"></div>
                                <div class="col-3"><img class="img_avatar_sel" onclick="asignarURL('avatars/6.png')"
                                        src="{{ asset('avatars/6.png') }}" alt="1.png"></div>
                                <div class="col-3"><img class="img_avatar_sel" onclick="asignarURL('avatars/7.png')"
                                        src="{{ asset('avatars/7.png') }}" alt="1.png"></div>
                                <div class="col-3"><img class="img_avatar_sel" onclick="asignarURL('avatars/8.png')"
                                        src="{{ asset('avatars/8.png') }}" alt="1.png"></div>
                            </div>
                            <div class="row">
                                <div class="col-3"><img class="img_avatar_sel" onclick="asignarURL('avatars/9.png')"
                                        src="{{ asset('avatars/9.png') }}" alt="1.png"></div>
                                <div class="col-3"><img class="img_avatar_sel"
                                        onclick="asignarURL('avatars/10.png')" src="{{ asset('avatars/10.png') }}"
                                        alt="1.png"></div>
                                <div class="col-3"><img class="img_avatar_sel"
                                        onclick="asignarURL('avatars/11.png')" src="{{ asset('avatars/11.png') }}"
                                        alt="1.png"></div>
                                <div class="col-3"><img class="img_avatar_sel"
                                        onclick="asignarURL('avatars/12.png')" src="{{ asset('avatars/12.png') }}"
                                        alt="1.png"></div>
                            </div>
                            <div class="row">
                                <div class="col-3"><img class="img_avatar_sel"
                                        onclick="asignarURL('avatars/13.png')" src="{{ asset('avatars/13.png') }}"
                                        alt="1.png"></div>
                                <div class="col-3"><img class="img_avatar_sel"
                                        onclick="asignarURL('avatars/14.png')" src="{{ asset('avatars/14.png') }}"
                                        alt="1.png"></div>
                                <div class="col-3"><img class="img_avatar_sel"
                                        onclick="asignarURL('avatars/15.png')" src="{{ asset('avatars/15.png') }}"
                                        alt="1.png"></div>
                                <div class="col-3"><img class="img_avatar_sel"
                                        onclick="asignarURL('avatars/16.png')" src="{{ asset('avatars/16.png') }}"
                                        alt="1.png"></div>
                            </div>
                            <div class="row">
                                <div class="col-3"><img class="img_avatar_sel"
                                        onclick="asignarURL('avatars/17.png')" src="{{ asset('avatars/17.png') }}"
                                        alt="1.png"></div>
                                <div class="col-3"><img class="img_avatar_sel"
                                        onclick="asignarURL('avatars/18.png')" src="{{ asset('avatars/18.png') }}"
                                        alt="1.png"></div>
                                <div class="col-3"><img class="img_avatar_sel"
                                        onclick="asignarURL('avatars/19.png')" src="{{ asset('avatars/19.png') }}"
                                        alt="1.png"></div>
                                <div class="col-3"><img class="img_avatar_sel"
                                        onclick="asignarURL('avatars/20.png')" src="{{ asset('avatars/20.png') }}"
                                        alt="1.png"></div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab2" role="tabpanel" aria-labelledby="base-tab2">
                            <div class="row">
                                <div class="col-4 colavatar"><img class="img_avatar_sel"
                                        onclick="asignarURL('avatars/21.png')" src="{{ asset('avatars/21.png') }}"
                                        alt="1.png"></div>
                                <div class="col-4 colavatar"><img class="img_avatar_sel"
                                        onclick="asignarURL('avatars/22.png')" src="{{ asset('avatars/22.png') }}"
                                        alt="1.png"></div>
                                <div class="col-4 colavatar"><img class="img_avatar_sel"
                                        onclick="asignarURL('avatars/23.png')" src="{{ asset('avatars/23.png') }}"
                                        alt="1.png"></div>
                            </div>
                            <div class="row">
                                <div class="col-4 colavatar"><img class="img_avatar_sel"
                                        onclick="asignarURL('avatars/24.png')" src="{{ asset('avatars/24.png') }}"
                                        alt="1.png"></div>
                                <div class="col-4 colavatar"><img class="img_avatar_sel"
                                        onclick="asignarURL('avatars/25.png')" src="{{ asset('avatars/25.png') }}"
                                        alt="1.png"></div>
                                <div class="col-4 colavatar"><img class="img_avatar_sel"
                                        onclick="asignarURL('avatars/26.png')" src="{{ asset('avatars/26.png') }}"
                                        alt="1.png"></div>
                            </div>
                            <div class="row">
                                <div class="col-4 colavatar"><img class="img_avatar_sel"
                                        onclick="asignarURL('avatars/27.png')" src="{{ asset('avatars/27.png') }}"
                                        alt="1.png"></div>
                                <div class="col-4 colavatar"><img class="img_avatar_sel"
                                        onclick="asignarURL('avatars/28.png')" src="{{ asset('avatars/28.png') }}"
                                        alt="1.png"></div>
                                <div class="col-4 colavatar"><img class="img_avatar_sel"
                                        onclick="asignarURL('avatars/29.png')" src="{{ asset('avatars/29.png') }}"
                                        alt="1.png"></div>
                            </div>
                            <div class="row">
                                <div class="col-4 colavatar"><img class="img_avatar_sel"
                                        onclick="asignarURL('avatars/30.png')" src="{{ asset('avatars/30.png') }}"
                                        alt="1.png"></div>
                                <div class="col-4 colavatar"><img class="img_avatar_sel"
                                        onclick="asignarURL('avatars/31.png')" src="{{ asset('avatars/31.png') }}"
                                        alt="1.png"></div>
                                <div class="col-4 colavatar"><img class="img_avatar_sel"
                                        onclick="asignarURL('avatars/32.png')" src="{{ asset('avatars/32.png') }}"
                                        alt="1.png"></div>
                            </div>
                            <div class="row">
                                <div class="col-4 colavatar"><img class="img_avatar_sel"
                                        onclick="asignarURL('avatars/33.png')" src="{{ asset('avatars/33.png') }}"
                                        alt="1.png"></div>
                                <div class="col-4 colavatar"><img class="img_avatar_sel"
                                        onclick="asignarURL('avatars/34.png')" src="{{ asset('avatars/34.png') }}"
                                        alt="1.png"></div>
                                <div class="col-4 colavatar"><img class="img_avatar_sel"
                                        onclick="asignarURL('avatars/35.png')" src="{{ asset('avatars/35.png') }}"
                                        alt="1.png"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade text-left" id="modal_diccionario" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel17" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel17">Diccionario <strong>BiblioPED</strong></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="padding: 25px">
                    <h3 style="font-size: 20px; color: #009199; font-weight: bold">Escribe una palabra en la caja de
                        texto para encontrar su definición.</h3>
                    <br>
                    <div class="row">
                        <div class="col-4">
                            <input type="text" id="palabra_buscar" class="form-control"
                                placeholder="Ingresa una palabra...">
                        </div>
                        <div class="col-1" style="display: flex; justify-content: center; align-items: center">
                            <button onclick="buscarPablabraDiccionario()" class="btn btn-success"><i
                                    class="fas fa-search"></i></button>
                        </div>
                    </div>
                    <br>
                    <p style="font-size: 20px; color: #009199; font-style: italic;" id="mensaje_opcional"></p>
                    <p style="font-size: 20px" id="definicion"></p>
                    <hr>
                    <strong style='font-style: italic; font-size: 20px'>Imagenes relacionadas</strong><br>
                    <div id="imagenes_palabra"
                        style="display: flex; justify-content: space-around; align-items: center">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Cerrar
                        modal</button>
                </div>
            </div>
        </div>
    </div>

    <div style="display: none; position: fixed; z-index: 10000; width: 100%; top: 0; height: 100vh;"
        id="errorNavegador">
        <div class="permission_denied">
            <div id="tsparticles"></div>
            <div class="denied__wrapper">
                <h1>BiblioPED</h1>
                <h3>
                    Para una mejor experiencia se recomienda utilizar el navegador
                    <strong>( <img style="width: 23px" src="/images/google.png" alt=""> Google Chrome
                        )</strong>
                </h3>
                <img id="astronaut" src="images/astronaut.svg" />
                <img id="planet" src="images/planet.svg" />
            </div>
        </div>
    </div>
    <div id="app"></div>
    <!-- BEGIN: Footer-->
    <footer class="footer fixed-bottom footer-dark navbar-shadow">
        <p class="clearfix blue-grey lighten-2 text-sm-center mb-0 px-2 container center-layout"><span
                class="float-md-left d-block d-md-inline-block">Copyright &copy; {{ date('Y') }} <a
                    class="text-bold-800 grey darken-2" href="https://1.envato.market/pixinvent_portfolio"
                    target="_blank">LEER INGENIERIA S.A.S </a></span><span class="float-md-right d-none d-lg-block">Tu
                bliblioteca al alcance <i style="color: #fc4f00" class="fa fa-book"></i></span></p>
    </footer>
    <!-- END: Footer-->

    <script src="{{ asset('js/jquery.3.6.min.js') }}"></script>

    <script src="{{ asset('js/app.js') }}"></script>

    <!-- BEGIN: Vendor JS-->
    <script src="{{ asset('app-assets/vendors/js/vendors.min.js') }}"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="{{ asset('app-assets/vendors/js/ui/jquery.sticky.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/charts/jquery.sparkline.min.js') }}"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="{{ asset('app-assets/js/core/app-menu.js') }}"></script>
    <script src="{{ asset('app-assets/js/core/app.js') }}"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <script src="{{ asset('app-assets/js/scripts/ui/breadcrumbs-with-stats.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/extensions/toastr.min.js') }}"></script>
    <script src="{{ asset('app-assets/js/scripts/extensions/toastr.js') }}"></script>
    <script src="{{ asset('app-assets/js/scripts/tooltip/tooltip.js') }}"></script>
    <script src="{{ asset('app-assets/js/html2pdf.bundle.min.js') }}"></script>
    <!-- END: Page JS-->

    <script src="{{ asset('app-assets/vendors/js/tables/datatable/datatables.min.js') }}"></script>

    <script>
        getBrowserInfo();

        toastr.options = {
            "closeButton": true,
            "newestOnTop": false,
            "progressBar": false,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "500",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }

        var imagen_ruta = 'avatars/default.png';

        $(document).ready(function() {
            $('#btnLogin').on('click', function(e) {
                e.preventDefault();
                var formData = $('#miFormulario').serialize();
                $.ajax({
                    url: '/api/login',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response[1] == 1) {
                            toastr.success(response[0]);
                            $('#modalLoginForm').modal('hide');
                            if (response[2] == "estudiante" || response[2] == "docente") {
                                setTimeout(() => {
                                    window.location.reload();
                                }, 2000);
                            } else {
                                setTimeout(() => {
                                    location.href = "/admin";
                                }, 2000);
                            }

                        } else {
                            toastr.error(response[0]);
                        }
                    },
                    error: function(error) {
                        toastr.warning(error);
                    }
                });
            });

            $('#btnRegistrar').on('click', function(e) {
                e.preventDefault();
                var formDataSerialized = $('#miFormulario2').serialize();

                // Agregar la variable extra a la cadena serializada
                var variableExtra = 'imagen=' + imagen_ruta;
                formDataSerialized += '&' + variableExtra;

                $.ajax({
                    url: '/api/registrar',
                    type: 'POST',
                    data: formDataSerialized,
                    success: function(response) {
                        if (response[1] == 1) {
                            toastr.success(response[0]);
                            $('#modalLoginForm2').modal('hide');
                            setTimeout(() => {
                                window.location.reload();
                            }, 2000);
                        } else {
                            toastr.error(response[0]);
                        }
                    },
                    error: function(error) {
                        toastr.warning(error);
                    }
                });
            });

            $('#btnCerrarSesion').on('click', function(e) {
                e.preventDefault();
                $.ajax({
                    url: '/api/cerrar-sesion',
                    type: 'GET',
                    success: function(response) {
                        setTimeout(() => {
                            location.href = "/";
                        }, 1000);
                    },
                    error: function(error) {
                        toastr.warning(error);
                    }
                });
            });

            $.ajax({
                url: '/api/session-data',
                type: 'GET',
                success: function(response) {
                    if (response.id != null) {
                        verNotificaciones();

                        setInterval(() => {
                            verNotificaciones();
                        }, 10000);
                    }
                },
                error: function(error) {
                    toastr.warning(error);
                }
            });
        });

        function getBrowserInfo() {
            var ua = navigator.userAgent,
                tem,
                M = ua.match(/(opera|chrome|safari|firefox|msie|trident(?=\/))\/?\s*(\d+)/i) || [];
            if (/trident/i.test(M[1])) {
                tem = /\brv[ :]+(\d+)/g.exec(ua) || [];
                return 'IE ' + (tem[1] || '');
            }
            if (M[1] === 'Chrome') {
                tem = ua.match(/\b(OPR|Edge)\/(\d+)/);
                if (tem != null) return tem.slice(1).join(' ').replace('OPR', 'Opera');
            }
            M = M[2] ? [M[1], M[2]] : [navigator.appName, navigator.appVersion, '-?'];
            if ((tem = ua.match(/version\/(\d+)/i)) != null) M.splice(1, 1, tem[1]);

            if (M[0] != "Chrome") {
                mostrarErrorNavegador();
            }
        };

        function mostrarErrorNavegador() {
            document.getElementById("errorNavegador").style.display = "block";
            var particles = {
                fpsLimit: 60,
                particles: {
                    number: {
                        value: 160,
                        density: {
                            enable: true,
                            area: 700,
                        },
                    },
                    color: {
                        value: "#ffffff",
                    },
                    shape: {
                        type: "circle",
                    },
                    opacity: {
                        value: 1,
                        random: {
                            enable: true,
                            minimumValue: 0.1,
                        },
                        animation: {
                            enable: true,
                            speed: 1,
                            minimumValue: 0,
                            sync: false,
                        },
                    },
                    size: {
                        value: 3,
                        random: {
                            enable: true,
                            minimumValue: 1,
                        },
                    },
                    move: {
                        enable: true,
                        speed: 0.17,
                        direction: "none",
                        random: true,
                        straight: false,
                        outModes: {
                            default: "out",
                        },
                    },
                },
                interactivity: {
                    detectsOn: "canvas",
                    events: {
                        resize: false,
                    },
                },
                detectRetina: true,
            };

            tsParticles.load("tsparticles", particles);
        }

        function asignarURL(url) {
            var url_nueva = "{{ asset('') }}" + url;
            $('#modal_avatar').modal('hide');
            $("#imagen_avatar").attr("src", url_nueva);
            imagen_ruta = url;
        }

        function verNotificaciones() {
            $.ajax({
                url: '/api/notificaciones',
                type: 'GET',
                success: function(response) {
                    var numero_n = document.getElementById("numero_notificaciones");
                    var count = 0;
                    var div = document.getElementById("lista_notificaciones");
                    div.innerHTML = "";
                    response.forEach(element => {
                        var estilo = "";
                        var clase = "";

                        if (element.estado == 'cerrado') {
                            estilo = "style='background-color: #f9a8252e'";
                            count++;
                        }


                        if (element.tipo == 0) {
                            clase = "feather icon-share-2 icon-bg-circle bg-yellow bg-darken-3";
                            div.innerHTML += "<a onclick='cambiarEstadoNotificacion(\"" + element._id
                                .$oid + "\", \"" + element.ruta + "\")' type='button'>" +
                                "<div " + estilo + " class='media'>" +
                                "<div class='media-left align-self-center'><i class='" + clase +
                                "'></i></div>" +
                                "<div class='media-body'>" +
                                "<h6 class='media-heading'><strong>Nueva Recomendación!</strong></h6>" +
                                "<p class='notification-text font-small-3 text-muted'>El docente <strong>" +
                                element.profesor.nombre +
                                "</strong> te recomendado un contenido.</p><small>" +
                                "<time class='media-meta text-muted' datetime='2015-06-11T18:29:20+08:00'><strong>" +
                                element.fecha + " | " + element.horas + "</strong></time></small>" +
                                "</div>" +
                                "</div>" +
                                "</a>"
                        } else {
                            if (element.tipo == 1) {
                                clase = "feather icon-users icon-bg-circle bg-yellow bg-darken-3";
                                div.innerHTML += "<a onclick='cambiarEstadoNotificacion(\"" + element
                                    ._id.$oid + "\", \"" + element.ruta + "\")' type='button'>" +
                                    "<div " + estilo + " class='media'>" +
                                    "<div class='media-left align-self-center'><i class='" + clase +
                                    "'></i></div>" +
                                    "<div class='media-body'>" +
                                    "<h6 class='media-heading'><strong>Nueva invitación a foro!</strong></h6>" +
                                    "<p class='notification-text font-small-3 text-muted'>El docente <strong>" +
                                    element.profesor.nombre +
                                    "</strong> te invito a un foro.</p><small>" +
                                    "<time class='media-meta text-muted' datetime='2015-06-11T18:29:20+08:00'><strong>" +
                                    element.fecha + " | " + element.horas + "</strong></time></small>" +
                                    "</div>" +
                                    "</div>" +
                                    "</a>"
                            } else {
                                if (element.tipo == 2) {
                                    clase =
                                        "feather icon-thumbs-up icon-bg-circle bg-yellow bg-darken-3";
                                    div.innerHTML += "<a onclick='cambiarEstadoNotificacion(\"" +
                                        element._id.$oid + "\", \"" + element.ruta +
                                        "\")' type='button'>" +
                                        "<div " + estilo + " class='media'>" +
                                        "<div class='media-left align-self-center'><i class='" + clase +
                                        "'></i></div>" +
                                        "<div class='media-body'>" +
                                        "<h6 class='media-heading'><strong>Nueva reacción!</strong></h6>" +
                                        "<p class='notification-text font-small-3 text-muted' style='text-transform: capitalize'>" +
                                        element.tema + ".</p><small>" +
                                        "<time class='media-meta text-muted' datetime='2015-06-11T18:29:20+08:00'><strong>" +
                                        element.fecha + " | " + element.horas +
                                        "</strong></time></small>" +
                                        "</div>" +
                                        "</div>" +
                                        "</a>"
                                } else {
                                    clase =
                                        "feather icon-message-circle icon-bg-circle bg-yellow bg-darken-3";
                                    div.innerHTML += "<a onclick='cambiarEstadoNotificacion(\"" +
                                        element._id.$oid + "\", \"" + element.ruta +
                                        "\")' type='button'>" +
                                        "<div " + estilo + " class='media'>" +
                                        "<div class='media-left align-self-center'><i class='" + clase +
                                        "'></i></div>" +
                                        "<div class='media-body'>" +
                                        "<h6 class='media-heading'><strong>Nuevo comentario!</strong></h6>" +
                                        "<p class='notification-text font-small-3 text-muted' style='text-transform: capitalize'>" +
                                        element.tema + ".</p><small>" +
                                        "<time class='media-meta text-muted' datetime='2015-06-11T18:29:20+08:00'><strong>" +
                                        element.fecha + " | " + element.horas +
                                        "</strong></time></small>" +
                                        "</div>" +
                                        "</div>" +
                                        "</a>"
                                }
                            }

                        }
                    });

                    numero_n.innerHTML = count;
                },
                error: function(error) {
                    toastr.warning(error);
                }
            });
        }

        function buscarPablabraDiccionario() {
            const abreviaturas = [{
                    "abreviatura": "adj. ",
                    "color": "#FF0000"
                },
                {
                    "abreviatura": "adv. ",
                    "color": "#00FF00"
                },
                {
                    "abreviatura": " s. ",
                    "color": "#0000FF"
                },
                {
                    "abreviatura": "v. ",
                    "color": "#FFFF00"
                },
                {
                    "abreviatura": "pl. ",
                    "color": "#FF00FF"
                },
                {
                    "abreviatura": "sing. ",
                    "color": "#00FFFF"
                },
                {
                    "abreviatura": "f. ",
                    "color": "#FFA500"
                },
                {
                    "abreviatura": " m. ",
                    "color": "#800080"
                },
                {
                    "abreviatura": " n. ",
                    "color": "#008000"
                },
                {
                    "abreviatura": "prep. ",
                    "color": "#008080"
                },
                {
                    "abreviatura": "conj. ",
                    "color": "#800000"
                },
                {
                    "abreviatura": "pron. ",
                    "color": "#808000"
                },
                {
                    "abreviatura": "interj. ",
                    "color": "#FF1493"
                },
                {
                    "abreviatura": "refl. ",
                    "color": "#FFD700"
                },
                {
                    "abreviatura": "fig. ",
                    "color": "#A0522D"
                },
                {
                    "abreviatura": "lit. ",
                    "color": "#006400"
                },
                {
                    "abreviatura": "obs. ",
                    "color": "#8B0000"
                },
                {
                    "abreviatura": "esp. ",
                    "color": "#FF4500"
                },
                {
                    "abreviatura": "etc. ",
                    "color": "#2E8B57"
                },
                {
                    "abreviatura": "pág. ",
                    "color": "#4B0082"
                },
                {
                    "abreviatura": "ed. ",
                    "color": "#9932CC"
                },
                {
                    "abreviatura": "sig. ",
                    "color": "#DC143C"
                },
                {
                    "abreviatura": "gr. ",
                    "color": "#000080"
                },
                {
                    "abreviatura": "fam. ",
                    "color": "#4B0082"
                },
                {
                    "abreviatura": "orig. ",
                    "color": "#00BFFF"
                },
                {
                    "abreviatura": "tech. ",
                    "color": "#800000"
                },
                {
                    "abreviatura": "p. ej. ",
                    "color": "#008B8B"
                },
                {
                    "abreviatura": "c. ",
                    "color": "#8B4513"
                },
                {
                    "abreviatura": "apr. ",
                    "color": "#556B2F"
                },
                {
                    "abreviatura": "fig. ret. ",
                    "color": "#FF69B4"
                },
                {
                    "abreviatura": "tr. ",
                    "color": "#FFA500"
                }
            ];
            const textoBuscar = document.getElementById("palabra_buscar").value;
            $.ajax({
                url: '/api/buscar-palabra-diccionario?palabra=' + textoBuscar,
                type: 'GET',
                success: function(response) {
                    for (const item of abreviaturas) {
                        if (response.significado.indexOf(item.abreviatura) !== -1) {
                            response.significado = response.significado.replace(item.abreviatura,
                                "<span style='color:" + item.color + "; font-weight: bold'>" + item
                                .abreviatura + "</span>");
                        }
                    }

                    document.getElementById("definicion").innerHTML =
                        "<strong style='font-style: italic; font-size: 20px'>Definición</strong><br>" + response
                        .significado;
                    document.getElementById("mensaje_opcional").innerHTML = response.mensaje_opcional;

                    var div = "";
                    response.imagenes.forEach(element => {
                        const imageHTML =
                            `<img src="data:image/png;base64,${element.url}" alt="Imagen" />`;
                        div += imageHTML;
                    });

                    document.getElementById("imagenes_palabra").innerHTML = div;
                },
                error: function(error) {
                    toastr.warning(error);
                }
            });

        }

        function cambiarEstadoNotificacion(elemento, ruta) {
            var id = elemento;
            $.ajax({
                url: '/api/cambiarestadoNotificacion?id=' + id,
                type: 'GET',
                success: function(response) {
                    verNotificaciones();
                    location.href = "/" + ruta;
                },
            });
        }
    </script>
</body>

</html>
