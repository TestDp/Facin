<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>FACIN | Facturación e Inventario</title>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
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
    <!-- Metis Menu -->
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <!-- sweet plugins-->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.4/Chart.bundle.min.js"></script>

</head>
<body class="cbp-spmenu-push">
<div class="main-content">
    <div class=" sidebar" role="navigation">
        <div class="navbar-collapse">
            <nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left" id="cbp-spmenu-s1">
                <ul class="nav" id="side-menu">
                    @if(Auth::user()->buscarRecurso('Facturacion'))
                        <li>
                            <a href="#ulFacturacion" data-toggle="collapse"><i class="fa fa-book nav_icon"></i>Facturación<span
                                        class="fa arrow"></span></a>
                            <ul class="nav nav-second-level collapse" id="ulFacturacion">
                                @if(Auth::user()->buscarRecurso('Pedidos'))
                                    <li>
                                        <a href="#" onclick="ajaxRenderSectionVistaListaPedidos(1)">Pedidos</a>
                                    </li>
                                @endif
                                @if(Auth::user()->buscarRecurso('POS'))
                                    <li>
                                        <a href="#" onclick="ajaxRenderSectionVistaPos(1)">Pos</a>
                                    </li>
                                @endif
                                @if(Auth::user()->buscarRecurso('PedidosEliminados'))
                                    <li>
                                        <a href="#" onclick="ajaxRenderSectionVistaListaPedidos(3)">Pedidos eliminados</a>
                                    </li>
                                @endif
                                @if(Auth::user()->buscarRecurso('Facturas'))
                                    <li>
                                        <a href="#" onclick="ajaxRenderSectionVistaListaPedidos(2)">Facturas</a>
                                    </li>
                                @endif
                                @if(Auth::user()->buscarRecurso('FacturasAnuladas'))
                                    <li>
                                        <a href="#" onclick="ajaxRenderSectionVistaListaPedidos(4)">Facturas anuladas</a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                    @if(Auth::user()->buscarRecurso('Inventario'))
                        <li>
                            <a href="#ulInventario" data-toggle="collapse"><i class="fa fa-archive nav_icon"></i>Inventario
                                <span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level collapse" id="ulInventario">
                        <!--  @if(Auth::user()->buscarRecurso('ActualizarInventario'))
                                    <li>
                                        <a href="#" onclick="ajaxRenderSectionActualizarInventario()" >Ajustar inventario</a>
                                    </li>
                                @endif-->
                                    @if(Auth::user()->buscarRecurso('Compras'))
                                        <li>
                                            <a href="#" onclick="ajaxRenderSectionListaCompras()" >Compras</a>
                                        </li>
                                    @endif
                                @if(Auth::user()->buscarRecurso('Productos'))
                                    <li>
                                        <a href="#" onclick="ajaxRenderSectionListaProductos()">Productos</a>
                                    </li>
                                @endif
                                @if(Auth::user()->buscarRecurso('Proveedores'))
                                    <li>
                                        <a href="#" onclick="ajaxRenderSectionListaProveedores()">Proveedores </a>
                                    </li>
                                @endif
                                @if(Auth::user()->buscarRecurso('Categorias'))
                                    <li>
                                        <a href="#" onclick="ajaxRenderSectionListaCategorias()">Categorías </a>
                                    </li>
                                @endif
                                @if(Auth::user()->buscarRecurso('Almacenes'))
                                    <li>
                                        <a href="#" onclick="ajaxRenderSectionListaAlmacenes()">Almacenes </a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                    @if(Auth::user()->buscarRecurso('Reportes'))
                    <li>
                        <a href="#ulReportes" data-toggle="collapse"><i class="fa fa-dashboard nav_icon"></i>Reportes<span
                                    class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse" id="ulReportes">
                            @if(Auth::user()->buscarRecurso('VistaInformeDiario'))
                                <li>
                                    <a href="#" onclick="ajaxRenderSectionVisualizarInformeDarios()">Informe diario</a>
                                </li>
                            @endif
                            @if(Auth::user()->buscarRecurso('VistaInformeXFecha'))
                                <li>
                                    <a href="#" onclick="ajaxRenderSectionVisualizarXRangoFechas()">Informe por fechas</a>
                                </li>
                            @endif
                            @if(Auth::user()->buscarRecurso('VistaVentasXProducto'))
                                <li>
                                    <a href="#" onclick="ajaxRenderSectionVisualizarVentasXProducto()">Ventas por producto</a>
                                </li>
                            @endif
                        </ul>

                    </li>
                    @endif
                    @if(Auth::user()->buscarRecurso('Empresa'))
                        <li>
                            <a href="#ulEmpresa" data-toggle="collapse"><i class="fa fa-table nav_icon"></i>Empresa<span
                                        class="fa arrow"></span></a>
                            <ul class="nav nav-second-level collapse" id="ulEmpresa">
                                @if(Auth::user()->buscarRecurso('Sedes'))
                                    <li>
                                        <a href="#" onclick="ajaxRenderSectionListaSedes()" >Sedes</a>
                                    </li>
                                @endif
                                @if(Auth::user()->buscarRecurso('Usuarios'))
                                    <li>
                                        <a href="#" onclick="ajaxRenderSectionListaUsuarios()">Usuarios</a>
                                    </li>
                                @endif
                                @if(Auth::user()->buscarRecurso('Roles'))
                                    <li>
                                        <a href="#" onclick="ajaxRenderSectionListaRoles()">Roles</a>
                                    </li>
                                @endif
                                @if(Auth::user()->buscarRecurso('UnidadesDeMedida'))
                                    <li>
                                        <a href="#" onclick="ajaxRenderSectionListaUnidades()">Unidad de medida</a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                    @if(Auth::user()->buscarRecurso('Administrador'))
                        <li>
                            <a href="#ulAdministrador" data-toggle="collapse"><i class="fa fa-cogs nav_icon"></i>Administrador<span
                                        class="fa arrow"></span></a>
                            <ul class="nav nav-second-level collapse" id="ulAdministrador">
                                @if(Auth::user()->buscarRecurso('TiposDeDocumentos'))
                                    <li>
                                        <a href="#" onclick="ajaxRenderSectionListaTiposDocumentos()" >Tipos de documentos</a>
                                    </li>
                                @endif
                                @if(Auth::user()->buscarRecurso('TiposProductos'))
                                    <li>
                                        <a href="#" onclick="ajaxRenderSectionListaTiposProductos()">Tipos de productos</a>
                                    </li>
                                @endif
                                @if(Auth::user()->buscarRecurso('EstadosFacturas'))
                                    <li>
                                        <a href="#" onclick="ajaxRenderSectionListaEstadoFactura()">Estados de factura</a>
                                    </li>
                                @endif
                               <!-- @if(Auth::user()->buscarRecurso('TiposdeFacturas'))
                                    <li>
                                        <a href="#" onclick="ajaxRenderSectionListaTiposProductos()">Tipos de Facturas</a>
                                    </li>-->
                                @endif
                                @if(Auth::user()->buscarRecurso('MediosDePago'))
                                    <li>
                                        <a href="#" onclick="ajaxRenderSectionListaMediosDePago()">Medios de pago</a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif
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
                               <!-- <span class="prfil-img"><img src="images/a.png" alt=""> </span>-->
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
        <div class="main-page" id="principalPanel">
            @yield('content')
<!--
            <div id="_loading" class="_loading" style="display:none;">
                <div id="capa_loading" class="capa_loading" style="display:none;">Procesando...</div>
                <img class="img_loading" src="{{ asset('images/loader.gif') }}" /><br>
            </div>-->
<!--            <div id="principalPanel">

            </div>-->
        </div>
    </div>
</div>
<!--footer-->
<div class="footer">
    <p>FACIN | Facturación e Inventario - Desarrollado por <a href="https://dpsoluciones.co/" target="_blank">DPSoluciones</a>
    </p>
</div>
<!--//footer-->

<!-- Classie -->
<script src="{{ asset('js/classie.js') }}"></script>

<!--scrolling js-->
<script src="{{ asset('js/jquery.nicescroll.js') }}"></script>
<script src="{{ asset('js/scripts.js') }}"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>

<!-- js de la apliacion-->
<script src="{{ asset('js/Transversal/generales.js') }}"></script>
<script src="{{ asset('js/MSistema/TipoDocumento.js') }}"></script>
<script src="{{ asset('js/MEmpresa/UnidadDeMedida.js') }}"></script>
<script src="{{ asset('js/MSistema/Rol.js') }}"></script>
<script src="{{ asset('js/MSistema/Usuario.js') }}"></script>
<script src="{{ asset('js/MSistema/TipoProducto.js') }}"></script>
<script src="{{ asset('js/MInventario/Proveedor.js') }}"></script>
<script src="{{ asset('js/MInventario/Categoria.js') }}"></script>
<script src="{{ asset('js/MInventario/Almacen.js') }}"></script>
<script src="{{ asset('js/MInventario/Producto.js') }}"></script>
<script src="{{ asset('js/MInventario/Inventario.js') }}"></script>
<script src="{{ asset('js/MEmpresa/Sede.js') }}"></script>
<script src="{{ asset('js/MInventario/Equivalencia.js') }}"></script>
<script src="{{ asset('js/MCliente/Cliente.js') }}"></script>
<script src="{{ asset('js/MFacturacion/Factura.js') }}"></script>
<script src="{{ asset('js/MFacturacion/EstadoFactura.js') }}"></script>
<script src="{{ asset('js/MFacturacion/MedioDePago.js') }}"></script>
<script src="{{ asset('js/MReporte/Reporte.js') }}"></script>
<script src="{{ asset('js/Plugins/JsPDF/dist/jspdf.min.js') }}"></script>
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
</body>
</html>
