<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::group([
    'middleware' => 'auth',
    // 'middleware' => 'Cors'
],
function(){
    Route::get('/home', 'HomeController@index')->name('home');

    Route::get('logout', 'Auth\LoginController@logout')->name('logout');

    //Parametro
    Route::get('parametro/getApiruc/{ruc}', 'ParametroController@apiRuc')->name('getApiruc');
    Route::get('parametro/getApidni/{dni}', 'ParametroController@apiDni')->name('getApidni');


    // Mantenimiento
    //Tabla General - Protegido con crud_general
    Route::prefix('mantenimiento/tablas/generales')->group(function() {
        Route::get('index', 'Mantenimiento\Tabla\GeneralController@index')->name('mantenimiento.tabla.general.index')->middleware('permission:crud_general');
        Route::get('getTable','Mantenimiento\Tabla\GeneralController@getTable')->name('getTable');
        Route::put('update', 'Mantenimiento\Tabla\GeneralController@update')->name('mantenimiento.tabla.general.update')->middleware('permission:crud_general');
    });

    //Tabla Detalle
    Route::prefix('mantenimiento/tablas/detalles')->group(function() {
        Route::get('index/{id}', 'Mantenimiento\Tabla\DetalleController@index')->name('mantenimiento.tabla.detalle.index');
        Route::get('getTable/{id}','Mantenimiento\Tabla\DetalleController@getTable')->name('getTableDetalle');
        Route::get('destroy/{id}', 'Mantenimiento\Tabla\DetalleController@destroy')->name('mantenimiento.tabla.detalle.destroy');
        Route::post('store', 'Mantenimiento\Tabla\DetalleController@store')->name('mantenimiento.tabla.detalle.store');
        Route::put('update', 'Mantenimiento\Tabla\DetalleController@update')->name('mantenimiento.tabla.detalle.update');
        Route::get('getDetail/{id}','Mantenimiento\Tabla\DetalleController@getDetail')->name('mantenimiento.tabla.detalle.getDetail');
        Route::post('/exist', 'Mantenimiento\Tabla\DetalleController@exist')->name('mantenimiento.tabla.detalle.exist');

    });

    //Empresas
    Route::prefix('mantenimiento/empresas')->group(function() {
        Route::get('index', 'Mantenimiento\Empresa\EmpresaController@index')->name('mantenimiento.empresas.index')->middleware('permission:crud_empresa');
        Route::get('getBusiness','Mantenimiento\Empresa\EmpresaController@getBusiness')->name('getBusiness');
        Route::get('create','Mantenimiento\Empresa\EmpresaController@create')->name('mantenimiento.empresas.create')->middleware('permission:crud_empresa');
        Route::post('store', 'Mantenimiento\Empresa\EmpresaController@store')->name('mantenimiento.empresas.store')->middleware('permission:crud_empresa');
        Route::get('destroy/{id}', 'Mantenimiento\Empresa\EmpresaController@destroy')->name('mantenimiento.empresas.destroy')->middleware('permission:crud_empresa');
        Route::get('show/{id}', 'Mantenimiento\Empresa\EmpresaController@show')->name('mantenimiento.empresas.show')->middleware('permission:crud_empresa');
        Route::get('edit/{id}', 'Mantenimiento\Empresa\EmpresaController@edit')->name('mantenimiento.empresas.edit')->middleware('permission:crud_empresa');
        Route::put('update/{id}', 'Mantenimiento\Empresa\EmpresaController@update')->name('mantenimiento.empresas.update')->middleware('permission:crud_empresa');
        Route::get('serie/{id}', 'Mantenimiento\Empresa\EmpresaController@serie')->name('serie.empresa.facturacion')->middleware('permission:crud_empresa');
        Route::post('certificate', 'Mantenimiento\Empresa\EmpresaController@certificate')->name('mantenimiento.empresas.certificado')->middleware('permission:crud_empresa');
        Route::get('obtenerNumeracion/{id}','Mantenimiento\Empresa\EmpresaController@obtenerNumeracion')->name('mantenimiento.empresas.obtenerNumeracion')->middleware('permission:crud_empresa');

    });
    //Compras
    //Categoria
    Route::prefix('compras/categorias')->group(function() {
        Route::get('index', 'Compras\CategoriaController@index')->name('compras.categoria.index')->middleware('permission:crud_categoria');
        Route::get('getCategory','Compras\CategoriaController@getCategory')->name('getCategory');
        Route::get('destroy/{id}', 'Compras\CategoriaController@destroy')->name('compras.categoria.destroy')->middleware('permission:crud_categoria');
        Route::post('store', 'Compras\CategoriaController@store')->name('compras.categoria.store')->middleware('permission:crud_categoria');
        Route::put('update', 'Compras\CategoriaController@update')->name('compras.categoria.update')->middleware('permission:crud_categoria');
    });
    //Articulos
    Route::prefix('compras/articulos')->group(function() {
        Route::get('create','Compras\ArticuloController@create')->name('compras.articulo.create')->middleware('permission:crud_articulo');
        Route::get('edit/{id}','Compras\ArticuloController@edit')->name('compras.articulo.edit')->middleware('permission:crud_articulo');
        Route::get('show/{id}','Compras\ArticuloController@show')->name('compras.articulo.show')->middleware('permission:crud_articulo');
        Route::get('index', 'Compras\ArticuloController@index')->name('compras.articulo.index')->middleware('permission:crud_articulo');
        Route::get('getArticles','Compras\ArticuloController@getArticles')->name('getArticles');
        Route::get('getArticle/{id}','Compras\ArticuloController@getArticle')->name('getArticle');
        Route::get('destroy/{id}', 'Compras\ArticuloController@destroy')->name('compras.articulo.destroy')->middleware('permission:crud_articulo');
        Route::post('store', 'Compras\ArticuloController@store')->name('compras.articulo.store')->middleware('permission:crud_articulo');
        Route::put('update/{id}', 'Compras\ArticuloController@update')->name('compras.articulo.update')->middleware('permission:crud_articulo');
    });
    //Proveedores
    Route::prefix('compras/proveedores')->group(function() {
        Route::get('index', 'Compras\ProveedorController@index')->name('compras.proveedor.index')->middleware('permission:crud_proveedor');
        Route::get('getProvider','Compras\ProveedorController@getProvider')->name('getProvider');
        Route::get('create','Compras\ProveedorController@create')->name('compras.proveedor.create')->middleware('permission:crud_proveedor');
        Route::post('store', 'Compras\ProveedorController@store')->name('compras.proveedor.store')->middleware('permission:crud_proveedor');
        Route::get('edit/{id}','Compras\ProveedorController@edit')->name('compras.proveedor.edit')->middleware('permission:crud_proveedor');
        Route::get('show/{id}','Compras\ProveedorController@show')->name('compras.proveedor.show')->middleware('permission:crud_proveedor');
        Route::put('update/{id}', 'Compras\ProveedorController@update')->name('compras.proveedor.update')->middleware('permission:crud_proveedor');
        Route::get('destroy/{id}', 'Compras\ProveedorController@destroy')->name('compras.proveedor.destroy')->middleware('permission:crud_proveedor');
    });

    //Ordenes de Compra
    Route::prefix('compras/ordenes')->group(function() {
        Route::get('index', 'Compras\OrdenController@index')->name('compras.orden.index')->middleware('permission:crud_orden');
        Route::get('getOrder','Compras\OrdenController@getOrder')->name('getOrder');
        Route::get('create','Compras\OrdenController@create')->name('compras.orden.create')->middleware('permission:crud_orden');
        Route::post('store', 'Compras\OrdenController@store')->name('compras.orden.store')->middleware('permission:crud_orden');
        Route::get('edit/{id}','Compras\OrdenController@edit')->name('compras.orden.edit')->middleware('permission:crud_orden');
        Route::get('show/{id}','Compras\OrdenController@show')->name('compras.orden.show')->middleware('permission:crud_orden');
        Route::put('update/{id}', 'Compras\OrdenController@update')->name('compras.orden.update')->middleware('permission:crud_orden');
        Route::get('destroy/{id}', 'Compras\OrdenController@destroy')->name('compras.orden.destroy')->middleware('permission:crud_orden');
        Route::get('reporte/{id}','Compras\OrdenController@report')->name('compras.orden.reporte')->middleware('permission:crud_orden');
        Route::get('email/{id}','Compras\OrdenController@email')->name('compras.orden.email')->middleware('permission:crud_orden');
        Route::get('concretada/{id}','Compras\OrdenController@concretized')->name('compras.orden.concretada');
        Route::get('consultaEnvios/{id}','Compras\OrdenController@send')->name('compras.orden.envios');
        Route::get('documento/{id}','Compras\OrdenController@document')->name('compras.orden.documento');
        Route::get('nuevodocumento/{id}','Compras\OrdenController@newdocument')->name('compras.orden.nuevodocumento');
        Route::get('confirmarEliminar/{id}','Compras\OrdenController@confirmDestroy')->name('compras.orden.confirmDestroy');

        //Pagos
        Route::get('pagos/index/{id}', 'Compras\PagoController@index')->name('compras.pago.index');
        Route::get('getPay/{id}','Compras\PagoController@getPay')->name('getPay');
        Route::get('pagos/create/{id}', 'Compras\PagoController@create')->name('compras.pago.create');
        Route::post('pagos/store/', 'Compras\PagoController@store')->name('compras.pago.store');
        Route::get('pagos/destroy/', 'Compras\PagoController@destroy')->name('compras.pago.destroy');
        Route::get('pagos/show/', 'Compras\PagoController@show')->name('compras.pago.show');
    });

    Route::prefix('compras/documentos')->group(function(){

        Route::get('index', 'Compras\DocumentoController@index')->name('compras.documento.index')->middleware('permission:crud_doccompra');
        Route::get('getDocument','Compras\DocumentoController@getDocument')->name('getDocument');
        Route::get('create', 'Compras\DocumentoController@create')->name('compras.documento.create')->middleware('permission:crud_doccompra');
        Route::post('store', 'Compras\DocumentoController@store')->name('compras.documento.store')->middleware('permission:crud_doccompra');
        Route::get('edit/{id}','Compras\DocumentoController@edit')->name('compras.documento.edit')->middleware('permission:crud_doccompra');
        Route::put('update/{id}', 'Compras\DocumentoController@update')->name('compras.documento.update')->middleware('permission:crud_doccompra');
        Route::get('destroy/{id}', 'Compras\DocumentoController@destroy')->name('compras.documento.destroy')->middleware('permission:crud_doccompra');
        Route::get('show/{id}','Compras\DocumentoController@show')->name('compras.documento.show')->middleware('permission:crud_doccompra');
        Route::get('reporte/{id}','Compras\DocumentoController@report')->name('compras.documento.reporte')->middleware('permission:crud_doccompra');

        Route::get('tipoPago/{id}','Compras\DocumentoController@TypePay')->name('compras.documento.tipo_pago.existente')->middleware('permission:crud_doccompra');

        //Pagos
        Route::get('pagos/index/{id}', 'Compras\Documentos\PagoController@index')->name('compras.documentos.pago.index');
        Route::get('getPay/{id}','Compras\Documentos\PagoController@getPayDocument')->name('getPay.documentos');
        Route::get('pagos/create/{id}', 'Compras\Documentos\PagoController@create')->name('compras.documentos.pago.create');
        Route::post('pagos/store/', 'Compras\Documentos\PagoController@store')->name('compras.documentos.pago.store');
        Route::get('pagos/destroy/{id}', 'Compras\Documentos\PagoController@destroy')->name('compras.documentos.pago.destroy');
        Route::get('pagos/show/{id}', 'Compras\Documentos\PagoController@show')->name('compras.documentos.pago.show');
        Route::get('getBox/document/{id}', 'Compras\Documentos\PagoController@getBox')->name('compras.documentos.pago.getBox');

        //Pago Transferencia
        Route::get('transferencia/pagos/index/{id}', 'Compras\Documentos\TransferenciaController@index')->name('compras.documentos.transferencia.pago.index');
        Route::get('transferencia/getPay/{id}','Compras\Documentos\TransferenciaController@getPay')->name('compras.documentos.transferencia.getPay');
        Route::get('transferencia/pagos/create/{id}', 'Compras\Documentos\TransferenciaController@create')->name('compras.documentos.transferencia.pago.create');
        Route::post('transferencia/pagos/store/', 'Compras\Documentos\TransferenciaController@store')->name('compras.documentos.transferencia.pago.store');
        Route::get('transferencia/pagos/destroy/', 'Compras\Documentos\TransferenciaController@destroy')->name('compras.documentos.transferencia.pago.destroy');
        Route::get('transferencia/pagos/show/', 'Compras\Documentos\TransferenciaController@show')->name('compras.documentos.transferencia.pago.show');


    });

    //Seguridad
    //Usuarios
    Route::prefix('seguridad/usuarios')->group(function() {
        Route::get('index', 'Seguridad\UsuarioController@index')->name('seguridad.usuario.index')->middleware('permission:crud_usuario');
        Route::get('getUsers','Seguridad\UsuarioController@getUsers')->name('getUsers');
        Route::get('create', 'Seguridad\UsuarioController@create')->name('seguridad.usuario.create')->middleware('permission:crud_usuario');
        Route::get('edit/{id}', 'Seguridad\UsuarioController@edit')->name('seguridad.usuario.edit')->middleware('permission:crud_usuario');
        Route::put('update/{id}', 'Seguridad\UsuarioController@update')->name('seguridad.usuario.update')->middleware('permission:crud_usuario');
        Route::post('store', 'Seguridad\UsuarioController@store')->name('seguridad.usuario.store')->middleware('permission:crud_usuario');
        Route::get('getEmployee', 'Seguridad\UsuarioController@getEmployee')->name('seguridad.usuario.getEmployee');
        Route::get('getEmployeeedit/{id}', 'Seguridad\UsuarioController@getEmployeeedit')->name('seguridad.usuario.getEmployee.edit');
        Route::get('destroy/{id}', 'Seguridad\UsuarioController@destroy')->name('seguridad.usuario.destroy')->middleware('permission:crud_usuario');
    });

    //Caja Chica Pos
    Route::prefix('pos/')->group(function() {
        Route::get('cajachica/index', 'Pos\CajaController@index')->name('pos.caja.index')->middleware('permission:crud_caja_chica');
        Route::get('getBox','Pos\CajaController@getBox')->name('getBox');
        Route::get('cajachica/destroy/{id}', 'Pos\CajaController@destroy')->name('pos.caja.destroy')->middleware('permission:crud_caja_chica');
        Route::get('cajachica/cerrar/{id}', 'Pos\CajaController@cerrar')->name('pos.caja.cerrar')->middleware('permission:crud_caja_chica');
        Route::post('cajachica/store', 'Pos\CajaController@store')->name('pos.caja.store')->middleware('permission:crud_caja_chica');
        Route::put('update', 'Pos\CajaController@update')->name('pos.caja.update')->middleware('permission:crud_caja_chica');
        Route::get('getEmployee/caja_chica', 'Pos\CajaController@getEmployee')->name('pos.caja.getEmployee');
    });

    //Almacen
    Route::prefix('almacenes/almacen')->group(function() {
        Route::get('index', 'Almacenes\AlmacenController@index')->name('almacenes.almacen.index')->middleware('permission:crud_almacen');
        Route::get('getRepository','Almacenes\AlmacenController@getRepository')->name('getRepository');
        Route::get('destroy/{id}', 'Almacenes\AlmacenController@destroy')->name('almacenes.almacen.destroy')->middleware('permission:crud_almacen');
        Route::post('store', 'Almacenes\AlmacenController@store')->name('almacenes.almacen.store')->middleware('permission:crud_almacen');
        Route::put('update', 'Almacenes\AlmacenController@update')->name('almacenes.almacen.update')->middleware('permission:crud_almacen');
        Route::post('almacen/exist', 'Almacenes\AlmacenController@exist')->name('almacenes.almacen.exist');
    });

    //Familias
    Route::prefix('almacenes/categorias/pt')->group(function() {
        Route::get('index', 'Almacenes\FamiliaController@index')->name('almacenes.familias.index')->middleware('permission:crud_categoriapt');
        Route::get('getfamilia','Almacenes\FamiliaController@getfamilia')->name('getfamilia');
        Route::get('destroy/{id}', 'Almacenes\FamiliaController@destroy')->name('almacenes.familias.destroy')->middleware('permission:crud_categoriapt');
        Route::post('store', 'Almacenes\FamiliaController@store')->name('almacenes.familias.store')->middleware('permission:crud_categoriapt');
        Route::put('update', 'Almacenes\FamiliaController@update')->name('almacenes.familias.update')->middleware('permission:crud_categoriapt');
        Route::post('/exist', 'Almacenes\FamiliaController@exist')->name('almacenes.familias.exist');
    });

    //SubFamilias
    Route::prefix('almacenes/subcategoria/pt')->group(function() {
        Route::get('index', 'Almacenes\SubFamiliaController@index')->name('almacenes.subfamilia.index')->middleware('permission:crud_subfamilia');
        Route::get('getsubfamilia','Almacenes\SubFamiliaController@getSub')->name('getSub');
        Route::get('destroy/{id}', 'Almacenes\SubFamiliaController@destroy')->name('almacenes.subfamilia.destroy')->middleware('permission:crud_subfamilia');

        Route::post('store', 'Almacenes\SubFamiliaController@store')->name('almacenes.subfamilia.store')->middleware('permission:crud_subfamilia');
        
        Route::put('update', 'Almacenes\SubFamiliaController@update')->name('almacenes.subfamilia.update')->middleware('permission:crud_subfamilia');
        Route::post('getByFamilia', 'Almacenes\SubFamiliaController@getByFamilia')->name('almacenes.subfamilia.getByFamilia');

        Route::get('getBySubFamilia/{id}', 'Almacenes\SubFamiliaController@getBySubFamilia')->name('almacenes.subfamilia.getBySubFamilia')->middleware('permission:crud_subfamilia');

        Route::get('subfamilia/familia', 'Almacenes\SubFamiliaController@getFamilia')->name('subfamilia.familia');

        Route::post('subfamilia/exist', 'Almacenes\SubFamiliaController@exist')->name('almacenes.subfamilia.exist');
    });

    // Productos
    Route::prefix('almacenes/productos')->group(function() {
        Route::get('/', 'Almacenes\ProductoController@index')->name('almacenes.producto.index')->middleware('permission:crud_producto');
        Route::get('/getTable', 'Almacenes\ProductoController@getTable')->name('almacenes.producto.getTable');
        Route::get('/registrar', 'Almacenes\ProductoController@create')->name('almacenes.producto.create')->middleware('permission:crud_producto');
        Route::post('/registrar', 'Almacenes\ProductoController@store')->name('almacenes.producto.store')->middleware('permission:crud_producto');
        Route::get('/actualizar/{id}', 'Almacenes\ProductoController@edit')->name('almacenes.producto.edit')->middleware('permission:crud_producto');
        Route::put('/actualizar/{id}', 'Almacenes\ProductoController@update')->name('almacenes.producto.update')->middleware('permission:crud_producto');
        Route::get('/datos/{id}', 'Almacenes\ProductoController@show')->name('almacenes.producto.show')->middleware('permission:crud_producto');
        Route::get('/destroy/{id}', 'Almacenes\ProductoController@destroy')->name('almacenes.producto.destroy')->middleware('permission:crud_producto');
        Route::post('/destroyDetalle', 'Almacenes\ProductoController@destroyDetalle')->name('almacenes.producto.destroyDetalle')->middleware('permission:crud_producto');
        Route::post('/getCodigo', 'Almacenes\ProductoController@getCodigo')->name('almacenes.producto.getCodigo');

        Route::get('/obtenerProducto/{id}', 'Almacenes\ProductoController@obtenerProducto')->name('almacenes.producto.obtenerProducto');

        Route::get('/productoDescripcion/{id}', 'Almacenes\ProductoController@productoDescripcion')->name('almacenes.producto.productoDescripcion')->middleware('permission:crud_producto');

    });

    // Composicion de Producto
    Route::prefix('produccion/composicion')->group(function() {
        Route::get('/', 'Produccion\ComposicionController@index')->name('produccion.composicion.index')->middleware('permission:crud_composicion_producto');
        Route::get('/getTable', 'Produccion\ComposicionController@getTable')->name('produccion.composicion.getTable');
        Route::get('/getTable2/{id}', 'Produccion\ComposicionController@getTable2')->name('produccion.composicion.getTable2');
        Route::get('/registrar', 'Produccion\ComposicionController@create')->name('produccion.composicion.create')->middleware('permission:crud_composicion_producto');
        Route::post('/registrar', 'Produccion\ComposicionController@store')->name('produccion.composicion.store')->middleware('permission:crud_composicion_producto');
        Route::get('/actualizar/{id}', 'Produccion\ComposicionController@edit')->name('produccion.composicion.edit')->middleware('permission:crud_composicion_producto');
        Route::put('/actualizar/{id}', 'Produccion\ComposicionController@update')->name('produccion.composicion.update')->middleware('permission:crud_composicion_producto');
        Route::get('/datos/{id}', 'Produccion\ComposicionController@show')->name('produccion.composicion.show')->middleware('permission:crud_composicion_producto');
        Route::get('/destroy/{id}', 'Produccion\ComposicionController@destroy')->name('produccion.composicion.destroy')->middleware('permission:crud_composicion_producto');
        Route::post('/destroyDetalle', 'Produccion\ComposicionController@destroyDetalle')->name('produccion.composicion.destroyDetalle')->middleware('permission:crud_composicion_producto');
        Route::post('/getCodigo', 'Produccion\ComposicionController@getCodigo')->name('produccion.composicion.getCodigo');
    });


    // Ubigeo
    Route::prefix('mantenimiento/ubigeo')->group(function() {
        Route::post('/provincias', 'Mantenimiento\Ubigeo\UbigeoController@provincias')->name('mantenimiento.ubigeo.provincias');
        Route::post('/distritos', 'Mantenimiento\Ubigeo\UbigeoController@distritos')->name('mantenimiento.ubigeo.distritos');
        Route::post('/api_ruc', 'Mantenimiento\Ubigeo\UbigeoController@api_ruc')->name('mantenimiento.ubigeo.api_ruc');
    });

    // Colaboradores
    Route::prefix('mantenimiento/colaboradores')->group(function() {
        Route::get('/', 'Mantenimiento\Colaborador\ColaboradorController@index')->name('mantenimiento.colaborador.index')->middleware('permission:crud_colaborador');
        Route::get('/getTable', 'Mantenimiento\Colaborador\ColaboradorController@getTable')->name('mantenimiento.colaborador.getTable');
        Route::get('/registrar', 'Mantenimiento\Colaborador\ColaboradorController@create')->name('mantenimiento.colaborador.create')->middleware('permission:crud_colaborador');
        Route::post('/registrar', 'Mantenimiento\Colaborador\ColaboradorController@store')->name('mantenimiento.colaborador.store')->middleware('permission:crud_colaborador');
        Route::get('/actualizar/{id}', 'Mantenimiento\Colaborador\ColaboradorController@edit')->name('mantenimiento.colaborador.edit')->middleware('permission:crud_colaborador');
        Route::put('/actualizar/{id}', 'Mantenimiento\Colaborador\ColaboradorController@update')->name('mantenimiento.colaborador.update')->middleware('permission:crud_colaborador');
        Route::get('/datos/{id}', 'Mantenimiento\Colaborador\ColaboradorController@show')->name('mantenimiento.colaborador.show')->middleware('permission:crud_colaborador');
        Route::get('/destroy/{id}', 'Mantenimiento\Colaborador\ColaboradorController@destroy')->name('mantenimiento.colaborador.destroy')->middleware('permission:crud_colaborador');
        Route::post('/getDNI', 'Mantenimiento\Colaborador\ColaboradorController@getDNI')->name('mantenimiento.colaborador.getDni');
    });

    // Vendedores
    Route::prefix('mantenimiento/vendedores')->group(function() {
        Route::get('/', 'Mantenimiento\Vendedor\VendedorController@index')->name('mantenimiento.vendedor.index')->middleware('permission:crud_vendedor');
        Route::get('/getTable', 'Mantenimiento\Vendedor\VendedorController@getTable')->name('mantenimiento.vendedor.getTable');
        Route::get('/registrar', 'Mantenimiento\Vendedor\VendedorController@create')->name('mantenimiento.vendedor.create')->middleware('permission:crud_vendedor');
        Route::post('/registrar', 'Mantenimiento\Vendedor\VendedorController@store')->name('mantenimiento.vendedor.store')->middleware('permission:crud_vendedor');
        Route::get('/actualizar/{id}', 'Mantenimiento\Vendedor\VendedorController@edit')->name('mantenimiento.vendedor.edit')->middleware('permission:crud_vendedor');
        Route::put('/actualizar/{id}', 'Mantenimiento\Vendedor\VendedorController@update')->name('mantenimiento.vendedor.update')->middleware('permission:crud_vendedor');
        Route::get('/datos/{id}', 'Mantenimiento\Vendedor\VendedorController@show')->name('mantenimiento.vendedor.show')->middleware('permission:crud_vendedor');
        Route::get('/destroy/{id}', 'Mantenimiento\Vendedor\VendedorController@destroy')->name('mantenimiento.vendedor.destroy')->middleware('permission:crud_vendedor');
        Route::post('/getDNI', 'Mantenimiento\Vendedor\VendedorController@getDNI')->name('mantenimiento.vendedor.getDni');
    });

    // Clientes
    Route::prefix('ventas/clientes')->group(function() {

        Route::get('/', 'Ventas\ClienteController@index')->name('ventas.cliente.index')->middleware('permission:crud_cliente');
        Route::get('/getTable', 'Ventas\ClienteController@getTable')->name('ventas.cliente.getTable');
        Route::get('/registrar', 'Ventas\ClienteController@create')->name('ventas.cliente.create')->middleware('permission:crud_cliente');
        Route::post('/registrar', 'Ventas\ClienteController@store')->name('ventas.cliente.store')->middleware('permission:crud_cliente');
        Route::get('/actualizar/{id}', 'Ventas\ClienteController@edit')->name('ventas.cliente.edit')->middleware('permission:crud_cliente');
        Route::put('/actualizar/{id}', 'Ventas\ClienteController@update')->name('ventas.cliente.update')->middleware('permission:crud_cliente');
        Route::get('/datos/{id}', 'Ventas\ClienteController@show')->name('ventas.cliente.show')->middleware('permission:crud_cliente');
        Route::get('/destroy/{id}', 'Ventas\ClienteController@destroy')->name('ventas.cliente.destroy')->middleware('permission:crud_cliente');
        Route::post('/getDocumento', 'Ventas\ClienteController@getDocumento')->name('ventas.cliente.getDocumento');
        Route::post('/getCustomer', 'Ventas\ClienteController@getCustomer')->name('ventas.cliente.getcustomer');
        //Tiendas
        Route::get('tiendas/index/{id}', 'Ventas\TiendaController@index')->name('clientes.tienda.index');
        Route::get('tiendas/getShop/{id}','Ventas\TiendaController@getShop')->name('clientes.tienda.shop');
        Route::get('tiendas/create/{id}', 'Ventas\TiendaController@create')->name('clientes.tienda.create');
        Route::post('tiendas/store/', 'Ventas\TiendaController@store')->name('clientes.tienda.store');
        Route::put('tiendas/update/{id}', 'Ventas\TiendaController@update')->name('clientes.tienda.update');
        Route::get('tiendas/destroy/{id}', 'Ventas\TiendaController@destroy')->name('clientes.tienda.destroy');
        Route::get('tiendas/show/{id}', 'Ventas\TiendaController@show')->name('clientes.tienda.show');
        Route::get('tiendas/actualizar/{id}', 'Ventas\TiendaController@edit')->name('clientes.tienda.edit');


    });


    // Cotizaciones
    Route::prefix('ventas/cotizaciones')->group(function() {
        Route::get('/', 'Ventas\CotizacionController@index')->name('ventas.cotizacion.index')->middleware('permission:crud_cotizacion');
        Route::get('/getTable', 'Ventas\CotizacionController@getTable')->name('ventas.cotizacion.getTable');
        Route::get('/registrar', 'Ventas\CotizacionController@create')->name('ventas.cotizacion.create')->middleware('permission:crud_cotizacion');
        Route::post('/registrar', 'Ventas\CotizacionController@store')->name('ventas.cotizacion.store')->middleware('permission:crud_cotizacion');
        Route::get('/actualizar/{id}', 'Ventas\CotizacionController@edit')->name('ventas.cotizacion.edit')->middleware('permission:crud_cotizacion');
        Route::put('/actualizar/{id}', 'Ventas\CotizacionController@update')->name('ventas.cotizacion.update')->middleware('permission:crud_cotizacion');
        Route::get('/datos/{id}', 'Ventas\CotizacionController@show')->name('ventas.cotizacion.show')->middleware('permission:crud_cotizacion');
        Route::get('/destroy/{id}', 'Ventas\CotizacionController@destroy')->name('ventas.cotizacion.destroy')->middleware('permission:crud_cotizacion');
        Route::get('reporte/{id}','Ventas\CotizacionController@report')->name('ventas.cotizacion.reporte')->middleware('permission:crud_cotizacion');
        Route::get('email/{id}','Ventas\CotizacionController@email')->name('ventas.cotizacion.email')->middleware('permission:crud_cotizacion');
        Route::get('documento/{id}','Ventas\CotizacionController@document')->name('ventas.cotizacion.documento')->middleware('permission:crud_cotizacion');
        Route::get('nuevodocumento/{id}','Ventas\CotizacionController@newdocument')->name('ventas.cotizacion.nuevodocumento')->middleware('permission:crud_cotizacion');
    });

    // Documentos - cotizaciones
    Route::prefix('ventas/documentos')->group(function(){

        Route::get('index', 'Ventas\DocumentoController@index')->name('ventas.documento.index')->middleware('permission:crud_docventa');
        Route::get('getDocument','Ventas\DocumentoController@getDocument')->name('ventas.getDocument');
        Route::get('create', 'Ventas\DocumentoController@create')->name('ventas.documento.create');
        Route::post('store', 'Ventas\DocumentoController@store')->name('ventas.documento.store');
        Route::get('edit/{id}','Ventas\DocumentoController@edit')->name('ventas.documento.edit');
        Route::put('update/{id}', 'Ventas\DocumentoController@update')->name('ventas.documento.update');
        Route::get('destroy/{id}', 'Ventas\DocumentoController@destroy')->name('ventas.documento.destroy');
        Route::get('show/{id}','Ventas\DocumentoController@show')->name('ventas.documento.show');
        Route::get('reporte/{id}','Ventas\DocumentoController@report')->name('ventas.documento.reporte');
        Route::get('tipoPago/{id}','Ventas\DocumentoController@TypePay')->name('ventas.documento.tipo_pago.existente');
        Route::get('comprobante/{id}','Ventas\DocumentoController@voucher')->name('ventas.documento.comprobante');
        Route::post('cantidad', 'Ventas\DocumentoController@quantity')->name('ventas.documento.cantidad');
        Route::post('devolver/cantidad', 'Ventas\DocumentoController@returnQuantity')->name('ventas.documento.devolver.cantidades');
        

        //Pagos
        Route::get('pagos/index/{id}', 'Ventas\Documentos\PagoController@index')->name('ventas.documentos.pago.index');
        Route::get('pagos/getPay/{id}','Ventas\Documentos\PagoController@getPayDocument')->name('ventas.getPay.documentos');
        Route::get('pagos/create/{id}', 'Ventas\Documentos\PagoController@create')->name('ventas.documentos.pago.create');
        Route::post('pagos/store/', 'Ventas\Documentos\PagoController@store')->name('ventas.documentos.pago.store');
        Route::get('pagos/destroy/{id}', 'Ventas\Documentos\PagoController@destroy')->name('ventas.documentos.pago.destroy');
        Route::get('pagos/show/{id}', 'Ventas\Documentos\PagoController@show')->name('ventas.documentos.pago.show');
        // Route::get('getBox/document/{id}', 'Compras\Documentos\PagoController@getBox')->name('compras.documentos.pago.getBox');
        Route::post('customers','Ventas\DocumentoController@customers')->name('ventas.customers');
        Route::get('getLot/{id}','Ventas\DocumentoController@getLot')->name('ventas.getLot');
        Route::post('vouchersAvaible','Ventas\DocumentoController@vouchersAvaible')->name('ventas.vouchersAvaible');

        //Pago Transferencia
        Route::get('transferencia/pagos/index/{id}', 'Ventas\Documentos\TransferenciaController@index')->name('ventas.documentos.transferencia.pago.index');
        Route::get('transferencia/getPay/{id}','Ventas\Documentos\TransferenciaController@getPay')->name('ventas.documentos.transferencia.getPay');
        Route::get('transferencia/pagos/create/{id}', 'Ventas\Documentos\TransferenciaController@create')->name('ventas.documentos.transferencia.pago.create');
        Route::post('transferencia/pagos/store/', 'Ventas\Documentos\TransferenciaController@store')->name('ventas.documentos.transferencia.pago.store');
        Route::get('transferencia/pagos/destroy/', 'Ventas\Documentos\TransferenciaController@destroy')->name('ventas.documentos.transferencia.pago.destroy');
        Route::get('transferencia/pagos/show/', 'Ventas\Documentos\TransferenciaController@show')->name('ventas.documentos.transferencia.pago.show');

    });

    //COMPROBANTES ELECTRONICOS
    Route::prefix('comprobantes/electronicos')->group(function(){
        Route::get('/', 'Ventas\Electronico\ComprobanteController@index')->name('ventas.comprobantes');
        Route::get('getVouchers','Ventas\Electronico\ComprobanteController@getVouchers')->name('ventas.getVouchers');
        Route::get('sunat/{id}','Ventas\Electronico\ComprobanteController@sunat')->name('ventas.documento.sunat');
    });

    //GUIAS DE REMISION
    Route::prefix('guiasremision/')->group(function(){

        Route::get('index', 'Ventas\GuiaController@index')->name('ventas.guiasremision.index')->middleware('permission:crud_guia_remision');
        Route::get('getGuia','Ventas\GuiaController@getGuias')->name('ventas.getGuia');
        Route::get('create/{id}', 'Ventas\GuiaController@create')->name('ventas.guiasremision.create')->middleware('permission:crud_guia_remision');
        Route::post('store', 'Ventas\GuiaController@store')->name('ventas.guiasremision.store')->middleware('permission:crud_guia_remision');
        Route::put('update/{id}', 'Ventas\GuiaController@update')->name('ventas.guiasremision.update')->middleware('permission:crud_guia_remision');
        Route::get('destroy/{id}', 'Ventas\GuiaController@destroy')->name('ventas.guiasremision.destroy')->middleware('permission:crud_guia_remision');
        Route::get('show/{id}','Ventas\GuiaController@show')->name('ventas.guiasremision.show')->middleware('permission:crud_guia_remision');
        Route::get('reporte/{id}','Ventas\GuiaController@report')->name('ventas.guiasremision.reporte')->middleware('permission:crud_guia_remision');
        Route::get('tiendaDireccion/{id}', 'Ventas\GuiaController@tiendaDireccion')->name('ventas.guiasremision.tienda_direccion');
        Route::get('sunat/guia/{id}','Ventas\GuiaController@sunat')->name('ventas.guiasremision.sunat');
        // Route::get('tipoPago/{id}','Ventas\GuiaController@TypePay')->name('ventas.documento.tipo_pago.existente');
        // Route::get('comprobante/{id}','Ventas\GuiaController@voucher')->name('ventas.documento.comprobante');
        // Route::get('sunat/comprobante/{id}','Ventas\GuiaController@sunat')->name('ventas.documento.sunat');

    });

    //NOTAS DE CREDITO / DEBITO
    Route::prefix('notas/electronicos')->group(function(){
        Route::get('/', 'Ventas\Electronico\NotaController@index')->name('ventas.notas');
        Route::get('create/', 'Ventas\Electronico\NotaController@create')->name('ventas.notas.create');
        Route::post('store', 'Ventas\Electronico\NotaController@store')->name('ventas.notas.store');
        Route::get('getNotes','Ventas\Electronico\NotaController@getNotes')->name('ventas.getNotes');
        Route::get('show/{id}','Ventas\Electronico\NotaController@show')->name('ventas.notas.show');
        Route::get('sunat/{id}','Ventas\Electronico\NotaController@sunat')->name('ventas.notas.sunat');
    });

    // Talonarios
    Route::prefix('mantenimiento/talonarios')->group(function() {
        Route::get('/', 'Mantenimiento\TalonarioController@index')->name('mantenimiento.talonario.index')->middleware('permission:crud_talonario');
        Route::get('/getTable', 'Mantenimiento\TalonarioController@getTable')->name('mantenimiento.talonario.getTable');
        Route::post('/registrar', 'Mantenimiento\TalonarioController@store')->name('mantenimiento.talonario.store')->middleware('permission:crud_talonario');
        Route::put('/actualizar', 'Mantenimiento\TalonarioController@update')->name('mantenimiento.talonario.update')->middleware('permission:crud_talonario');
        Route::get('/destroy/{id}', 'Mantenimiento\TalonarioController@destroy')->name('mantenimiento.talonario.destroy')->middleware('permission:crud_talonario');
    });

    // Actividades 
    Route::prefix('mantenimiento/actividades')->group(function() {
        Route::get('index', 'Mantenimiento\Actividad\ActividadController@index')->name('mantenimiento.actividad.index')->middleware('permission:crud_actividad');;
        Route::get('getActivity','Mantenimiento\Actividad\ActividadController@getActivity')->name('actividad.getActivity');
    });

    //Registro_Sanitario
    Route::prefix('invdesarrollo/registro_sanitario')->group(function() {
        Route::get('index', 'InvDesarrollo\RegistroSanitarioController@index')->name('invdesarrollo.registro_sanitario.index')->middleware('permission:crud_registro_sanitario');
        Route::get('getRegistroSanitario','InvDesarrollo\RegistroSanitarioController@getRegistroSanitario')->name('getRegistroSanitario');
        Route::get('destroy/{id}', 'InvDesarrollo\RegistroSanitarioController@destroy')->name('invdesarrollo.registro_sanitario.destroy')->middleware('permission:crud_registro_sanitario');
        Route::post('store', 'InvDesarrollo\RegistroSanitarioController@store')->name('invdesarrollo.registro_sanitario.store')->middleware('permission:crud_registro_sanitario');
        Route::put('update', 'InvDesarrollo\RegistroSanitarioController@update')->name('invdesarrollo.registro_sanitario.update')->middleware('permission:crud_registro_sanitario');
    });


    //Prototipos
    Route::prefix('invdesarrollo/prototipos')->group(function() {
        Route::get('index', 'InvDesarrollo\PrototipoController@index')->name('invdesarrollo.prototipo.index')->middleware('permission:crud_prototipo');
        Route::get('getPrototipo','InvDesarrollo\PrototipoController@getPrototipo')->name('getPrototipo');
        Route::get('create','InvDesarrollo\PrototipoController@create')->name('invdesarrollo.prototipo.create')->middleware('permission:crud_prototipo');
        Route::post('store', 'InvDesarrollo\PrototipoController@store')->name('invdesarrollo.prototipo.store')->middleware('permission:crud_prototipo');
        Route::get('edit/{id}','InvDesarrollo\PrototipoController@edit')->name('invdesarrollo.prototipo.edit')->middleware('permission:crud_prototipo');
        Route::get('show/{id}','InvDesarrollo\PrototipoController@show')->name('invdesarrollo.prototipo.show')->middleware('permission:crud_prototipo');
        Route::put('update/{id}', 'InvDesarrollo\PrototipoController@update')->name('invdesarrollo.prototipo.update')->middleware('permission:crud_prototipo');
        Route::get('destroy/{id}', 'InvDesarrollo\PrototipoController@destroy')->name('invdesarrollo.prototipo.destroy')->middleware('permission:crud_prototipo');
        Route::get('reporte/{id}','InvDesarrollo\PrototipoController@report')->name('invdesarrollo.prototipo.reporte')->middleware('permission:crud_prototipo');
        Route::get('email/{id}','InvDesarrollo\PrototipoController@email')->name('invdesarrollo.prototipo.email')->middleware('permission:crud_prototipo');
    });

    // Guia Interna
    Route::prefix('invdesarrollo/guias')->group(function() {
        Route::get('index', 'InvDesarrollo\GuiaController@index')->name('invdesarrollo.guia.index')->middleware('permission:crud_guia_interna');
        Route::get('getGuia','InvDesarrollo\GuiaController@getGuia')->name('getGuia');
        Route::get('create','InvDesarrollo\GuiaController@create')->name('invdesarrollo.guia.create')->middleware('permission:crud_guia_interna');
        Route::post('store', 'InvDesarrollo\GuiaController@store')->name('invdesarrollo.guia.store')->middleware('permission:crud_guia_interna');
        Route::get('edit/{id}','InvDesarrollo\GuiaController@edit')->name('invdesarrollo.guia.edit')->middleware('permission:crud_guia_interna');
        Route::get('show/{id}','InvDesarrollo\GuiaController@show')->name('invdesarrollo.guia.show')->middleware('permission:crud_guia_interna');
        Route::put('update/{id}', 'InvDesarrollo\GuiaController@update')->name('invdesarrollo.guia.update')->middleware('permission:crud_guia_interna');
        Route::get('destroy/{id}', 'InvDesarrollo\GuiaController@destroy')->name('invdesarrollo.guia.destroy')->middleware('permission:crud_guia_interna');
        Route::get('reporte/{id}','InvDesarrollo\GuiaController@report')->name('invdesarrollo.guia.reporte')->middleware('permission:crud_guia_interna');
        Route::get('email/{id}','InvDesarrollo\GuiaController@email')->name('invdesarrollo.guia.email')->middleware('permission:crud_guia_interna');
    });

    // Maquinaria_equipos
    Route::prefix('almacenes/maquinarias_equipos')->group(function() {
        Route::get('index', 'Almacenes\Maquinarias_equiposController@index')->name('almacenes.maquinaria_equipo.index')->middleware('permission:crud_maquinaria_equipo');
        Route::get('getPrototipo','Almacenes\Maquinarias_equiposController@getMaquinaria_equipo')->name('getMaquinaria_equipo');
        Route::get('destroy/{id}', 'Almacenes\Maquinarias_equiposController@destroy')->name('almacenes.maquinaria_equipo.destroy')->middleware('permission:crud_maquinaria_equipo');
        Route::post('store', 'Almacenes\Maquinarias_equiposController@store')->name('almacenes.maquinaria_equipo.store')->middleware('permission:crud_maquinaria_equipo');
        Route::put('update', 'Almacenes\Maquinarias_equiposController@update')->name('almacenes.maquinaria_equipo.update')->middleware('permission:crud_maquinaria_equipo');
        
    });

    // Linea de Produccionlinea_produccion
    Route::prefix('produccion/lineas_produccion')->group(function() {
        Route::get('index', 'Produccion\LineaProduccionController@index')->name('produccion.linea_produccion.index')->middleware('permission:crud_linea_produccion');
        Route::get('getLineaProduccion','Produccion\LineaProduccionController@getLineaProduccion')->name('getLineaProduccion');
        Route::get('create','Produccion\LineaProduccionController@create')->name('produccion.linea_produccion.create')->middleware('permission:crud_linea_produccion');
        Route::post('store', 'Produccion\LineaProduccionController@store')->name('produccion.linea_produccion.store')->middleware('permission:crud_linea_produccion');
        Route::get('edit/{id}','Produccion\LineaProduccionController@edit')->name('produccion.linea_produccion.edit')->middleware('permission:crud_linea_produccion');
        Route::get('show/{id}','Produccion\LineaProduccionController@show')->name('produccion.linea_produccion.show')->middleware('permission:crud_linea_produccion');
        Route::put('update/{id}', 'Produccion\LineaProduccionController@update')->name('produccion.linea_produccion.update')->middleware('permission:crud_linea_produccion');
        Route::get('destroy/{id}', 'Produccion\LineaProduccionController@destroy')->name('produccion.linea_produccion.destroy')->middleware('permission:crud_linea_produccion');
        Route::get('reporte/{id}','Produccion\LineaProduccionController@report')->name('produccion.linea_produccion.reporte')->middleware('permission:crud_linea_produccion');
        Route::get('email/{id}','Produccion\LineaProduccionController@email')->name('produccion.linea_produccion.email')->middleware('permission:crud_linea_produccion');
    });

    // Ingreso de Mercaderias
    Route::prefix('almacenes/ingresos_mercaderia')->group(function() {
        Route::get('index', 'Almacenes\Ingreso_mercaderiaController@index')->name('almacenes.ingreso_mercaderia.index')->middleware('permission:crud_ingreso_mercaderia');
        Route::get('getIngreso_mercaderia','Almacenes\Ingreso_mercaderiaController@getIngreso_mercaderia')->name('getIngreso_mercaderia');
        Route::get('create','Almacenes\Ingreso_mercaderiaController@create')->name('almacenes.ingreso_mercaderia.create')->middleware('permission:crud_ingreso_mercaderia');
        Route::post('store', 'Almacenes\Ingreso_mercaderiaController@store')->name('almacenes.ingreso_mercaderia.store')->middleware('permission:crud_ingreso_mercaderia');
        Route::get('edit/{id}','Almacenes\Ingreso_mercaderiaController@edit')->name('almacenes.ingreso_mercaderia.edit')->middleware('permission:crud_ingreso_mercaderia');
        Route::get('show/{id}','Almacenes\Ingreso_mercaderiaController@show')->name('almacenes.ingreso_mercaderia.show')->middleware('permission:crud_ingreso_mercaderia');
        Route::put('update/{id}', 'Almacenes\Ingreso_mercaderiaController@update')->name('almacenes.ingreso_mercaderia.update')->middleware('permission:crud_ingreso_mercaderia');
        Route::get('destroy/{id}', 'Almacenes\Ingreso_mercaderiaController@destroy')->name('almacenes.ingreso_mercaderia.destroy')->middleware('permission:crud_ingreso_mercaderia');
        Route::get('reporte/{id}','Almacenes\Ingreso_mercaderiaController@report')->name('almacenes.ingreso_mercaderia.reporte')->middleware('permission:crud_ingreso_mercaderia');
        Route::get('email/{id}','Almacenes\Ingreso_mercaderiaController@email')->name('almacenes.ingreso_mercaderia.email')->middleware('permission:crud_ingreso_mercaderia');
    });

    // Programacion de la Produccion
    Route::prefix('produccion/programacion_produccion')->group(function() {
        Route::get('index', 'Produccion\Programacion_produccionController@index')->name('produccion.programacion_produccion.index')->middleware('permission:crud_programacion_produccion');
        Route::get('getProgramacionProduccion','Produccion\Programacion_produccionController@getProgramacionProduccion')->name('getProgramacionProduccion');
        Route::get('create','Produccion\Programacion_produccionController@create')->name('produccion.programacion_produccion.create')->middleware('permission:crud_programacion_produccion');
        Route::post('store', 'Produccion\Programacion_produccionController@store')->name('produccion.programacion_produccion.store')->middleware('permission:crud_programacion_produccion');
        Route::get('edit/{id}','Produccion\Programacion_produccionController@edit')->name('produccion.programacion_produccion.edit')->middleware('permission:crud_programacion_produccion');
        Route::get('show/{id}','Produccion\Programacion_produccionController@show')->name('produccion.programacion_produccion.show')->middleware('permission:crud_programacion_produccion');
        Route::put('update/{id}', 'Produccion\Programacion_produccionController@update')->name('produccion.programacion_produccion.update')->middleware('permission:crud_programacion_produccion');
        Route::post('destroy', 'Produccion\Programacion_produccionController@destroy')->name('produccion.programacion_produccion.destroy')->middleware('permission:crud_programacion_produccion');
        Route::get('reporte/{id}','Produccion\Programacion_produccionController@report')->name('produccion.programacion_produccion.reporte')->middleware('permission:crud_programacion_produccion');
        Route::get('email/{id}','Produccion\Programacion_produccionController@email')->name('produccion.programacion_produccion.email')->middleware('permission:crud_programacion_produccion');
        Route::get('produccion/{id}','Produccion\Programacion_produccionController@production')->name('produccion.programacion_produccion.produccion')->middleware('permission:crud_programacion_produccion');
    });

    // Producciones aprobados
    Route::prefix('produccion/aprobados')->group(function() {
        Route::get('index','Produccion\Programacion_produccionController@approved')->name('produccion.programacion_produccion.orden.approved');
        Route::get('getApproved','Produccion\Programacion_produccionController@getApproved')->name('produccion.programacion_produccion.getApproved');
    });

    // ORDENES DE PRODUCCCION
    Route::prefix('produccion/ordenes')->group(function() {
        Route::get('/','Produccion\OrdenController@index')->name('produccion.orden.index');
        Route::get('getOrdenes','Produccion\OrdenController@getOrdenes')->name('produccion.aprobado.getOrdenes');
        Route::get('create/{id}','Produccion\OrdenController@create')->name('produccion.orden.create');
        Route::get('edit/','Produccion\OrdenController@edit')->name('produccion.orden.edit');
        Route::post('store','Produccion\OrdenController@store')->name('produccion.orden.store');
        Route::post('update/{id}','Produccion\OrdenController@update')->name('produccion.orden.update');
        Route::get('productoDetalle/{id}','Produccion\OrdenController@getArticles')->name('produccion.orden.articulos');
        Route::get('show/{id}','Produccion\OrdenController@show')->name('produccion.orden.show');
        Route::get('destroy/{id}','Produccion\OrdenController@destroy')->name('produccion.orden.destroy');
        Route::post('cancel', 'Produccion\OrdenController@cancel')->name('produccion.orden.cancel');
        Route::get('getOrden/{id}', 'Produccion\OrdenController@getOrden')->name('produccion.getOrden');


    });

    //ORDENES DE PRODUCCION - DETALLE - (LOTES-ARTICULOS)
    Route::prefix('produccion/ordenes')->group(function() {
        Route::get('detalles/lotes','Produccion\OrdenDetalleController@create')->name('produccion.orden.detalle.lote.create');
        Route::get('detalles/lotes/edit','Produccion\OrdenDetalleController@edit')->name('produccion.orden.detalle.lote.edit');
        Route::post('detalles/lotes/update','Produccion\OrdenDetalleController@update')->name('produccion.orden.detalle.lote.update');
        Route::post('detalles/lotes/store','Produccion\OrdenDetalleController@store')->name('produccion.orden.detalle.lote.store');
        Route::get('detalles/lotes/articulos/{id}','Produccion\OrdenDetalleController@getLotArticle')->name('produccion.orden.detalle.lote.articulos');
        Route::post('detalles/lotes/articulos/cantidad','Produccion\OrdenDetalleController@quantity')->name('produccion.orden.detalle.lote.articulos.cantidad');
        Route::post('devolver/cantidad', 'Produccion\OrdenDetalleController@returnQuantity')->name('produccion.orden.detalle.lote.articulos.devolver.cantidades');
    });

    //ORDENES DE PRODUCCION - DETALLES - (LOTES - ARTICULOS) - DEVOLUCIONES
    Route::prefix('produccion/ordenes')->group(function() {
        // Route::get('detalles/lotes/','Produccion\OrdenDetalleController@create')->name('produccion.orden.detalle.lote.create');
        Route::get('detalles/lotes/devolucion/','Produccion\OrdenDetalleDevolucionController@loteReturns')->name('produccion.orden.detalle.lote.devolucion');
        Route::post('/cantidad', 'Produccion\OrdenDetalleDevolucionController@quantity')->name('produccion.orden.detalle.lote.devolucion.cantidad');
        Route::post('detalles/lotes/devolucion/update','Produccion\OrdenDetalleDevolucionController@update')->name('produccion.orden.detalle.lote.devolucion.update');
       
        // Route::post('detalles/lotes/update','Produccion\OrdenDetalleController@update')->name('produccion.orden.detalle.lote.update');
        // Route::post('detalles/lotes/store','Produccion\OrdenDetalleController@store')->name('produccion.orden.detalle.lote.store');
        // Route::get('detalles/lotes/articulos/{id}','Produccion\OrdenDetalleController@getLotArticle')->name('produccion.orden.detalle.lote.articulos');
        // Route::post('detalles/lotes/articulos/cantidad','Produccion\OrdenDetalleController@quantity')->name('produccion.orden.detalle.lote.articulos.cantidad');
    });


    // Route::post('cantidad', 'Ventas\DocumentoController@quantity')->name('ventas.documento.cantidad');
    // Route::post('devolver/cantidad', 'Ventas\DocumentoController@returnQuantity')->name('ventas.documento.devolver.cantidades');





    Route::prefix('produccion/confirmacion')->group(function() {
        Route::post('storeLote','Produccion\LoteController@store')->name('produccion.lote.store');
        Route::get('edit/{id}', 'Produccion\LoteController@edit')->name('produccion.lote.edit');
        Route::post('updateLote','Produccion\LoteController@update')->name('produccion.lote.update');
    });

    // Roles
    Route::prefix('seguridad/roles')->group(function() {
        Route::get('index', 'Seguridad\RolController@index')->name('seguridad.roles.index')->middleware('permission:crud_rol');
        Route::get('create','Seguridad\RolController@create')->name('seguridad.roles.create')->middleware('permission:crud_rol');;
        Route::get('edit/{id}','Seguridad\RolController@edit')->name('seguridad.roles.edit')->middleware('permission:crud_rol');;
        Route::put('update/{id}', 'Seguridad\RolController@update')->name('seguridad.roles.update')->middleware('permission:crud_rol');;
        Route::get('getRoles','Seguridad\RolController@getRoles')->name('getRoles')->middleware('permission:crud_rol');;
        Route::get('destroy/{id}', 'Seguridad\RolController@destroy')->name('seguridad.roles.destroy')->middleware('permission:crud_rol');;
        Route::post('store', 'Seguridad\RolController@store')->name('seguridad.roles.store')->middleware('permission:crud_rol');;
    });

    // Permisos 
    Route::prefix('seguridad/permissions')->group(function() {
        Route::get('index', 'Seguridad\PermissionsController@index')->name('seguridad.permissions.index')->middleware('permission:crud_permiso');;
        Route::get('create','Seguridad\PermissionsController@create')->name('seguridad.permissions.create')->middleware('permission:crud_permiso');
        Route::get('edit/{id}','Seguridad\PermissionsController@edit')->name('seguridad.permissions.edit')->middleware('permission:crud_permiso');
        Route::put('update/{id}', 'Seguridad\PermissionsController@update')->name('seguridad.permissions.update')->middleware('permission:crud_permiso');
        Route::get('getPermissions','Seguridad\PermissionsController@getPermissions')->name('getPermissions')->middleware('permission:crud_permiso');
        Route::get('getPermisosxRol/{$id}','Seguridad\PermissionsController@getPermisosxRol')->name('getPermisosxRol')->middleware('permission:crud_permiso');
        Route::get('destroy/{id}', 'Seguridad\PermissionsController@destroy')->name('seguridad.permissions.destroy')->middleware('permission:crud_permiso');
        Route::post('store', 'Seguridad\PermissionsController@store')->name('seguridad.permissions.store')->middleware('permission:crud_permiso');
    });
});