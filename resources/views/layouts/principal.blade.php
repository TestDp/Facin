<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>FACIN | Facturación e Inventario</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->


    <script type="application/x-javascript"> addEventListener("load", function () {
            setTimeout(hideURLbar, 0);
        }, false);

        function hideURLbar() {
            window.scrollTo(0, 1);
        } </script>
    <!-- Bootstrap Core CSS -->
    <link href="{{ asset('css/bootstrap.css') }}" rel='stylesheet' type='text/css'/>
    <!-- Custom CSS -->
    <link href="{{ asset('css/style.css') }}" rel='stylesheet' type='text/css'/>
    <!-- font CSS -->
    <!-- font-awesome icons -->
    <link href="{{ asset('css/font-awesome.css') }}" rel="stylesheet">
    <!-- //font-awesome icons -->
    <!-- js-->
    <script src="{{ asset('js/jquery-1.11.1.min.js') }}"></script>
    <script src="{{ asset('js/modernizr.custom.js') }}"></script>
    <!--webfonts-->
    <link href='//fonts.googleapis.com/css?family=Roboto+Condensed:400,300,300italic,400italic,700,700italic'
          rel='stylesheet' type='text/css'>
    <!--//webfonts-->
    <!--animate-->
    <link href="{{ asset('css/animate.css') }}" rel="stylesheet" type="text/css" media="all">
    <script src="{{ asset('js/wow.min.js') }}"></script>
    <script>
        new WOW().init();
    </script>
    <!--//end-animate-->
    <!-- chart -->
    <script src="{{ asset('js/Chart.js') }}"></script>
    <!-- //chart -->
    <!--Calender-->
    <link rel="stylesheet" href="{{ asset('css/clndr.css') }}" type="text/css"/>
    <script src="{{ asset('js/underscore-min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/moment-2.2.1.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/clndr.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/site.js') }}" type="text/javascript"></script>
    <!--End Calender-->
    <!-- Metis Menu -->
    <script src="{{ asset('js/metisMenu.min.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <!--//Metis Menu -->

</head>
<body class="cbp-spmenu-push">
<div class="main-content">

    <div class=" sidebar" role="navigation">
        <div class="navbar-collapse">
            <nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left" id="cbp-spmenu-s1">
                <ul class="nav" id="side-menu">
                    <li>
                        <a href="index.html" class="active"><i class="fa fa-home nav_icon"></i>Dashboard</a>
                    </li>
                    <li>
                        <a href="#ulInventario" data-toggle="collapse"><i class="fa fa-cogs nav_icon"></i>Inventario
                            <span class="nav-badge">12</span> <span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse" id="ulInventario">
                            <li>
                                <a href="#ulInventarioProductos" data-toggle="collapse">Productos <span
                                            class="fa arrow"></span></a>
                                <ul class="nav nav-third-level collapse" id="ulInventarioProductos">
                                    <li>
                                        <a href="#">Lista Productos</a>
                                    </li>
                                    <li>
                                        <a href="#">Crear Producto</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#ulInventarioProveedores" data-toggle="collapse">Proveedores <span
                                            class="fa arrow"></span></a>
                                <ul class="nav nav-third-level collapse" id="ulInventarioProveedores">
                                    <li>
                                        <a href="#" onclick="ajaxRenderSectionListaProveedores()">Lista Provedores</a>
                                    </li>
                                    <li>
                                        <a href="#" onclick="ajaxRenderSectionCrearProveedor()">Crear Proveedor</a>
                                    </li>

                                    <li>
                                </ul>
                            </li>
                            <li>
                                <a href="#ulInventarioCategorias" data-toggle="collapse">Categorias <span
                                            class="fa arrow"></span></a>
                                <ul class="nav nav-third-level collapse" id="ulInventarioCategorias">
                                    <li>
                                        <a href="#" onclick="ajaxRenderSectionListaCategorias()">Lista Categorias</a>
                                    </li>
                                    <li>
                                        <a href="#" onclick="ajaxRenderSectionCrearCategoria()">Crear Categoria</a>
                                    </li>
                                    </li>
                                </ul>
                                <!-- /nav-second-level -->
                            </li>
                            <li>
                                <a href="#ulInventarioAlmacenes" data-toggle="collapse">Almacenes <span
                                            class="fa arrow"></span></a>
                                <ul class="nav nav-third-level collapse" id="ulInventarioAlmacenes">
                                    <li>
                                        <a href="#" onclick="ajaxRenderSectionListaCategorias()">Lista Almacenes</a>
                                    </li>
                                    <li>
                                        <a href="#" onclick="ajaxRenderSectionCrearCategoria()">Crear Almacenes</a>
                                    </li>
                                    </li>
                                </ul>
                                <!-- /nav-second-level -->
                            </li>
                        </ul>
                    @if(Auth::user()->hasRole('SuperAdmin'))
                    <li class="">
                        <a href="#ulAdministrador" data-toggle="collapse"><i class="fa fa-book nav_icon"></i>Administrador<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse" id="ulAdministrador">
                            <li>
                                <a href="#ulTiposDocumentos" data-toggle="collapse">Tipo de Documentos<span class="fa arrow"></span></a>
                                <ul class="nav nav-third-level collapse" id="ulTiposDocumentos">
                                    <li>
                                        <a href="#" onclick="ajaxRenderSectionListaTiposDocumentos()">Tipos</a>
                                    </li>
                                    <li>
                                        <a href="#" onclick="ajaxRenderSectionCrearTipoDocumento()">Crear Tipo</a>
                                    </li>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="typography.html">Ciudades</a>
                            </li>
                        </ul>
                        <!-- /nav-second-level -->
                    </li>
                    @endif
                    <li>
                        <a href="widgets.html"><i class="fa fa-th-large nav_icon"></i>Widgets <span
                                    class="nav-badge-btm">08</span></a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-envelope nav_icon"></i>Mailbox<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse">
                            <li>
                                <a href="inbox.html">Inbox <span class="nav-badge-btm">05</span></a>
                            </li>
                            <li>
                                <a href="compose.html">Compose email</a>
                            </li>
                        </ul>
                        <!-- //nav-second-level -->
                    </li>
                    <li>
                        <a href="tables.html"><i class="fa fa-table nav_icon"></i>Tables <span
                                    class="nav-badge">05</span></a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-check-square-o nav_icon"></i>Forms<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse">
                            <li>
                                <a href="forms.html">Basic Forms <span class="nav-badge-btm">07</span></a>
                            </li>
                            <li>
                                <a href="validation.html">Validation</a>
                            </li>
                        </ul>
                        <!-- //nav-second-level -->
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-file-text-o nav_icon"></i>Pages<span class="nav-badge-btm">02</span><span
                                    class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse">
                            <li>
                                <a href="login.html">Login</a>
                            </li>
                            <li>
                                <a href="signup.html">SignUp</a>
                            </li>
                            <li>
                                <a href="blank-page.html">Blank Page</a>
                            </li>
                        </ul>
                        <!-- //nav-second-level -->
                    </li>
                    <li>
                        <a href="charts.html" class="chart-nav"><i class="fa fa-bar-chart nav_icon"></i>Charts <span
                                    class="nav-badge-btm pull-right">new</span></a>
                    </li>
                </ul>
                <!-- //sidebar-collapse -->
            </nav>
        </div>
    </div>
    <!--left-fixed -navigation-->
    <!-- header-starts -->
    <div class="sticky-header header-section ">
        <div class="header-left">
            <!--toggle button start-->
            <button id="showLeftPush"><i class="fa fa-bars"></i></button>
            <!--toggle button end-->
            <!--logo -->
            <div class="logo">
                <a href="{{ url('/welcome') }}">
                    <img src="{{ asset('images/Logo-home.png') }}"></img>
                </a>
            </div>
            <!--//logo-->

            <div class="clearfix"></div>
        </div>
        <div class="header-right">

            <div class="profile_details">
                <ul>
                    <li class="dropdown profile_details_drop">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <div class="profile_img">
                                <span class="prfil-img"><img src="images/a.png" alt=""> </span>
                                <div class="user-name">
                                    <p>{{ Auth::user()->name }} </p>
                                    <span>Bienvenido</span>
                                </div>
                                <i class="fa fa-angle-down lnr"></i>
                                <i class="fa fa-angle-up lnr"></i>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                        <ul class="dropdown-menu drp-mnu">
                            <li><a href="#"><i class="fa fa-cog"></i> Settings</a></li>
                            <li><a href="#"><i class="fa fa-user"></i> Profile</a></li>
                            <li><a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><i
                                            class="fa fa-sign-out"></i> Logout</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                      style="display: none;">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
    </div>

    <div id="page-wrapper">
        <div class="main-page">
            <div id="principalPanel">
                @yield('content')
            </div>
        </div>
    </div>
</div>
<!--footer-->
<div class="footer">
    <p>FACIN | Facturación e Inventario - Desarrollado por <a href="https://dpsoluciones.co/" target="_blank">DPSoluciones</a>
    </p>
</div>
<!--//footer-->
</div>
<!-- Classie -->
<script src="{{ asset('js/classie.js') }}"></script>
<script>
    var menuLeft = document.getElementById('cbp-spmenu-s1'),
        showLeftPush = document.getElementById('showLeftPush'),
        body = document.body;

    showLeftPush.onclick = function () {
        classie.toggle(this, 'active');
        classie.toggle(body, 'cbp-spmenu-push-toright');
        classie.toggle(menuLeft, 'cbp-spmenu-open');
        disableOther('showLeftPush');
    };


    function disableOther(button) {
        if (button !== 'showLeftPush') {
            classie.toggle(showLeftPush, 'disabled');
        }
    }
</script>
<!--scrolling js-->
<script src="{{ asset('js/jquery.nicescroll.js') }}"></script>
<script src="{{ asset('js/scripts.js') }}"></script>
<!--//scrolling js-->
<!-- Bootstrap Core JavaScript -->
<script src="{{ asset('js/bootstrap.js') }}"></script>

<!-- js de la apliacion-->
<script src="{{ asset('js/MInventario/Proveedor.js') }}"></script>
<script src="{{ asset('js/MInventario/Categoria.js') }}"></script>
<script src="{{ asset('js/MSistema/TipoDocumento.js') }}"></script>
</body>
</html>
