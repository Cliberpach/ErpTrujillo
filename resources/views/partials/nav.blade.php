    <li class="nav-header">
        <div class="dropdown profile-element">

            @if(auth()->user()->ruta_imagen)
                <img alt="image"  alt="{{auth()->user()->usuario}}" class="rounded-circle" height="48" width="48"  src="{{Storage::url(auth()->user()->ruta_imagen)}}"/>
            @else
                <img alt="{{auth()->user()->usuario}}" alt="{{auth()->user()->usuario}}" class="rounded-circle" height="48" width="48"  src="{{ asset('storage/usuarios/default.jpg') }}"/>

            @endif


            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                <span class="block m-t-xs font-bold">{{auth()->user()->usuario}}</span>
                <span class="text-muted text-xs block">Administrador <b class="caret"></b></span>
            </a>
            <ul class="dropdown-menu animated fadeInRight m-t-xs">
                <li><a class="dropdown-item" href="login.html">Cerrar Sesión</a></li>
            </ul>
        </div>
        <div class="logo-element">
            <img src="{{asset('img/ecologo.jpeg')}}" height="30" width="45">
        </div>
    </li>



    <li>
        <a href="{{route('home')}}"><i class="fa fa-th-large"></i> <span class="nav-label">Panel de control</span></a>
    </li>
    @if(auth()->user()->can('crud_caja_chica'))
    <li class="@yield('pos-active')">
        <a href="#"><i class="fa fa-archive"></i> <span class="nav-label">Pos</span><span class="fa arrow"></span></a>
        <ul class="nav nav-second-level collapse">
            @can('crud_caja_chica')
            <li class="@yield('caja_chica-active')"><a href="{{route('pos.caja.index')}}">Caja Chica Pos</a></li>
            @endcan
        </ul>
    </li>
    @endif

    @if(auth()->user()->can('crud_articulo') or auth()->user()->can('crud_categoria') or auth()->user()->can('crud_proveedor') or auth()->user()->can('crud_orden') or auth()->user()->can('crud_doccompra'))
    <li class="@yield('compras-active')">
        <a href="#"><i class="fa fa-shopping-cart"></i> <span class="nav-label">Compras</span><span class="fa arrow"></span></a>
        <ul class="nav nav-second-level collapse">
            @can('crud_articulo')
            <li class="@yield('articulo-active')"><a href="{{route('compras.articulo.index')}}">Artículos</a></li>
            @endcan
            @can('crud_categoria')
            <li class="@yield('categoria-active')"><a href="{{route('compras.categoria.index')}}">Categorias</a></li>
            @endcan
            @can('crud_proveedor')
            <li class="@yield('proveedor-active')"><a href="{{route('compras.proveedor.index')}}">Proveedores</a></li>
            @endcan
            @can('crud_orden')
            <li class="@yield('orden-compra-active')"><a href="{{route('compras.orden.index')}}">Ordenes</a></li>
            @endcan
            @can('crud_doccompra')
            <li class="@yield('documento-active')"><a href="{{route('compras.documento.index')}}">Doc. Compra</a></li>
            @endcan
        </ul>
    </li>
    @endif
    @if(auth()->user()->can('crud_cliente') OR auth()->user()->can('crud_cotizacion') or auth()->user()->can('crud_docventa') or auth()->user()->can('crud_comprobante') or auth()->user()->can('crud_guia_remision'))
    <li class="@yield('ventas-active')">
        <a href="#"><i class="fa fa-signal"></i> <span class="nav-label">Ventas</span><span class="fa arrow"></span></a>
        <ul class="nav nav-second-level collapse">
            @can('crud_cliente')
            <li class="@yield('clientes-active')"><a href="{{ route('ventas.cliente.index') }}">Clientes</a></li>
            @endcan
            @can('crud_cotizacion')
            <li class="@yield('cotizaciones-active')"><a href="{{ route('ventas.cotizacion.index') }}">Cotizaciones</a></li>
            @endcan
            @can('crud_docventa')
            <li class="@yield('documentos-active')"><a href="{{route('ventas.documento.index')}}">Doc. Venta</a></li>
            @endcan
            @can('crud_comprobante')
            <li class="@yield('comprobantes-active')"><a href="{{route('ventas.comprobantes')}}">Comprobantes</a></li>
            @endcan
            @can('crud_guia_remision')
            <li class="@yield('guias-remision-active')"><a href="{{route('ventas.guiasremision.index')}}">Guias de Remision</a></li>
            @endcan
            <li class="@yield('notas-active')"><a href="{{route('ventas.notas')}}">Nota Credito / Debito</a></li>
        </ul>
    </li>
    @endif
    @if(auth()->user()->can('crud_composicion_producto') OR auth()->user()->can('crud_linea_produccion') or auth()->user()->can('crud_programacion_produccion'))
    <li class="@yield('produccion-active')">
        <a href="#"><i class="fa fa-bar-chart-o"></i> <span class="nav-label">Producción</span><span class="fa arrow"></span></a>
        <ul class="nav nav-second-level collapse">
            @can('crud_composicion_producto')
            <li class="@yield('composicion-active')"><a href="{{ route('produccion.composicion.index') }}">Composición de Productos Terminados</a></li>
            @endcan
            @can('crud_linea_produccion')
            <li class="@yield('linea_produccion-active')"><a href="{{route('produccion.linea_produccion.index')}}">Lineas de Producción</a></li>
            @endcan
            @can('crud_programacion_produccion')
            <li class="@yield('programacion_produccion-active')"><a href="{{route('produccion.programacion_produccion.index')}}">Programación de la Producción</a></li>
            @endcan
            <li class="@yield('produccion_aprobada-active')"><a href="{{route('produccion.programacion_produccion.orden.approved')}}">Producciones Aprobadas</a></li>
            <li class="@yield('ordenes_produccion-active')"><a href="{{route('produccion.orden.index')}}">Ordenes de Producción</a></li>

        </ul>
    </li>
    @endif
    @if(auth()->user()->can('crud_registro_sanitario') OR auth()->user()->can('crud_prototipo') or auth()->user()->can('crud_guia_interna'))
    <li class="@yield('invdesarrollo-active')">
        <a href="#"><i class="fa fa-bar-chart-o"></i> <span class="nav-label">Inv + Desarrollo </span><span class="fa arrow"></span></a>
        <ul class="nav nav-second-level collapse">
            @can('crud_registro_sanitario')
            <li class="@yield('registro_sanitario-active')"><a href="{{route('invdesarrollo.registro_sanitario.index')}}">Registro Sanitario</a></li>
             @endcan
            @can('crud_prototipo')
           <li class="@yield('prototipo-active')"><a href="{{route('invdesarrollo.prototipo.index')}}">Prototipos</a></li>
            @endcan
           @can('crud_guia_interna')
           <li class="@yield('guia-active')"><a href="{{route('invdesarrollo.guia.index')}}">Guias Internas</a></li>
            @endcan
        </ul>
    </li>
    @endif
    <li class="@yield('almacenes-active')">
        <a href="#"><i class="fa fa-suitcase"></i> <span class="nav-label">Almacenes </span><span class="fa arrow"></span></a>
        <ul class="nav nav-second-level collapse">
            @can('crud_almacen')
            <li class="@yield('almacen-active')"><a href="{{route('almacenes.almacen.index')}}">Almacen</a></li>
             @endcan
             @can('crud_categoriapt')
            <li class="@yield('familia-active')"><a href="{{route('almacenes.familias.index')}}">Categoria PT</a></li>
             @endcan
             @can('crud_subcategoriapt')
            <li class="@yield('subfamilia-active')"><a href="{{route('almacenes.subfamilia.index')}}">Sub Categorias PT</a></li>
             @endcan
             @can('crud_producto')
            <li class="@yield('productos-active')"><a href="{{ route('almacenes.producto.index') }}">Producto Terminado</a></li>
             @endcan
            <li><a href="search_results.html">Transferencias</a></li>
            <li>
                <a href="#">Consultas <span class="fa arrow"></span></a>
                <ul class="nav nav-third-level">
                    <li><a href="#">Stock</a></li>
                    <li><a href="#">Valorizada</a></li>
                 </ul>
            </li>
            @can('crud_maquinaria_equipo')
            <li class="@yield('maquinaria_equipo-active')"><a href="{{route('almacenes.maquinaria_equipo.index')}}">Maquinarias-Equipos</a></li>
             @endcan
             @can('crud_ingreso_mercaderia')
            <li class="@yield('ingreso_mercaderia-active')"><a href="{{route('almacenes.ingreso_mercaderia.index')}}">Ingreso de Mercaderia</a></li>
             @endcan
        </ul>
    </li>

    <li>
        <a href="#"><i class="fa fa-money"></i> <span class="nav-label">Cuentas </span><span class="fa arrow"></span></a>
        <ul class="nav nav-second-level collapse">
            <li>
                <a href="#">Proveedores <span class="fa arrow"></span></a>
                <ul class="nav nav-third-level">
                    <li>
                        <a href="#">Consultas</a>
                    </li>
                    <li>
                        <a href="#">Reporte</a>
                    </li>
                    <li>
                        <a href="#">Adelanto</a>
                    </li>

                </ul>
            </li>

            <li>
                <a href="#">Clientes <span class="fa arrow"></span></a>
                <ul class="nav nav-third-level">
                    <li>
                        <a href="#">Consultas</a>
                    </li>
                    <li>
                        <a href="#">Reporte</a>
                    </li>
                    <li>
                        <a href="#">Adelanto</a>
                    </li>

                </ul>
            </li>

        </ul>
    </li>
     @if(auth()->user()->can('crud_actividad') OR auth()->user()->can('crud_colaborador') or auth()->user()->can('crud_empresa') or auth()->user()->can('crud_talonario') or auth()->user()->can('crud_general'))
    <li class="@yield('mantenimiento-active')">
        <a href="#"><i class="fa fa-cogs"></i> <span class="nav-label">Mantenimiento</span><span class="fa arrow"></span></a>
        <ul class="nav nav-second-level collapse">
            @can('crud_actividad')
            <li class="@yield('actividades-active')"><a href="{{ route('mantenimiento.actividad.index') }}">Actividades</a></li>
            @endcan
            @can('crud_colaborador')
            <li class="@yield('colaboradores-active')"><a href="{{ route('mantenimiento.colaborador.index') }}">Colaboradores</a></li>
            @endcan
            @can('crud_empresa')
            <li class="@yield('empresas-active')"><a href="{{route('mantenimiento.empresas.index')}}">Empresas</a></li>
            @endcan
            @can('crud_vendedor')
            <li class="@yield('vendedores-active')"><a href="{{ route('mantenimiento.vendedor.index') }}">Vendedores</a></li>
            @endcan
            @can('crud_talonario')
            <li class="@yield('talonarios-active')"><a href="{{ route('mantenimiento.talonario.index') }}">Talonarios</a></li>
            @endcan
            @can('crud_general')
            <li class="@yield('tablas-active')"><a href="{{route('mantenimiento.tabla.general.index')}}">Tablas Generales</a></li>
            @endcan
        </ul>
    </li>
    @endif

    @if(auth()->user()->can('crud_usuario') OR auth()->user()->can('crud_rol') or auth()->user()->can('crud_permiso'))
    <li class="@yield('seguridad-active')">
        <a href="#"><i class="fa fa-shield"></i> <span class="nav-label">Seguridad</span><span class="fa arrow"></span></a>
        <ul class="nav nav-second-level collapse">
            @can('crud_usuario')
            <li class="@yield('usuarios-active')"><a href="{{route('seguridad.usuario.index')}}">Usuarios</a></li>
            @endcan
            @can('crud_rol')
            <li class="@yield('roles-active')"><a href="{{route('seguridad.roles.index')}}">Roles</a></li>
            @endcan
            @can('crud_permiso')
            <li class="@yield('permissions-active')"><a href="{{route('seguridad.permissions.index')}}">Permisos</a></li>
            @endcan
        </ul>
    </li>
    @endif
