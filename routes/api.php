    <?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//CLIENTES
Route::get('clientes',function ()
{
    $clientes = DB::table('clientes')
        ->select('clientes.*')->distinct()->get();

    return response()->json([
        'clientes' => $clientes,
    ]);

});

//CLIENTES REALIZARON UNA VENTA PARAMETROS
// [
//     ZONA => CENTRO,
//     DEPARTAMENTO => ANCASH,
//     MONTO => 10000.00 VALORES MAYORES A ESA VENTA
//     fecha_fin =>
//     fecha_inicio =>
//     comparacion =>
// ]

// Route::get('clientes/parametros',function (Request $request)
// {

//         $clientes = DB::table('clientes')
//                     ->when($request->get('zona'), function ($query, $request) {
//                         return $query->where('clientes.zona', $request);
//                     })
//                     ->when($request->get('departamento'), function ($query, $request) {
//                         return $query->where('clientes.departamento_id', $request);
//                     });

//         $clientes = $clientes->get();
//         $coleccion = collect([]);

//         foreach ($clientes as $cliente) {
//             $venta_monto = DB::table('cotizacion_documento')

//                         ->where('cotizacion_documento.cliente_id',$cliente->id)

//                         ->when($request->get('fecha_inicio'), function ($query, $request) {
//                             return $query->where('cotizacion_documento.fecha_documento','>=',$request);
//                         })

//                         ->when($request->get('fecha_fin'), function ($query, $request) {
//                             return $query->where('cotizacion_documento.fecha_documento','>=',$request);
//                         })

//                         ->when($request->all(), function ($query, $request) {
//                             if ( !empty($request['comparacion'])  &&  !empty($request['monto'])  ) {
//                                 return $query->where('cotizacion_documento.total', $request['comparacion'], $request['monto']);
//                             }
//                         })
//                         ->sum('cotizacion_documento.total');

//             $coleccion->push([
//                 'cliente' => $cliente,
//                 'total' => $venta_monto
//                 ]);
//         }

//         return response()->json($coleccion);
// });


//COLABORADORES
Route::get('colaboradores',function ()
{
    $colaboradores = DB::table('colaboradores')
        ->join('personas','colaboradores.persona_id','personas.id')
        ->select('colaboradores.*','personas.*')->distinct()
        ->get();

    return response()->json([
        'colaboradores' => $colaboradores,
    ]);

});

//TABLAS GENERALES
Route::get('tabla/detalles/{id}',function ($id)
{
    $detalles = DB::table('tabladetalles')
        ->select('tabladetalles.id', 'tabladetalles.descripcion','tabladetalles.simbolo')
        ->where('tabladetalles.tabla_id',$id )
        ->where('tabladetalles.estado','ACTIVO')
        ->get();

    return response()->json([
        'detalles' => $detalles,
    ]);

});

//DEPARTAMENTO 'ZONA'
Route::get('departamentos/{zona}',function ($zona)
{
    $departamentos = DB::table('departamentos')
        ->select('departamentos.id','departamentos.nombre')
        ->where('departamentos.zona',$zona)
        ->get();

    return response()->json([
        'departamentos' => $departamentos,
    ]);

});

//PRODUCTOS TERMINADOS
Route::get('productos/terminados',function ()
{
    return datatables()->query(
        DB::table('productos')
            ->join('familias', 'productos.familia_id', '=', 'familias.id')
            ->join('subfamilias', 'productos.sub_familia_id', '=', 'subfamilias.id')
            ->join('tabladetalles as lineas_comerciales', 'productos.linea_comercial', '=', 'lineas_comerciales.id')
            ->join('tabladetalles as medidas', 'productos.medida', '=', 'medidas.id')
        ->select('productos.*',
                'familias.familia as categoria_pt' ,
                'subfamilias.descripcion as sub_categoria_pt',
                'lineas_comerciales.descripcion as lineaComercialDescripcion',
                'medidas.descripcion as medidaDescripcion',
                'medidas.simbolo as medidaSimbolo'
                )
        ->where('productos.estado','ACTIVO'))
        ->toJson();
});

// CLIENTES PARAMETROS PARAMETROS
// [
//     tipoCliente => id (tabladetalles_id),
//     tipo => FISICA / VIRTUAL, (cadena)
//     NEGOCIO => MARKET / BIOTIENDA
//     COD_PRODUCTO => 204820
//     ZONA => CENTRO,
//     DEPARTAMENTO => ANCASH,
//     MONTO => 10000.00 VALORES MAYORES A ESA VENTA
//     fecha_fin =>
//     fecha_inicio =>
//     comparacion =>
// ]
Route::get('clientes/venta/parametros',function (Request $request)
{

    $clientes = DB::table('clientes')
                ->when($request->get('tipoCliente'), function ($query, $request) {
                    return $query->where('clientes.tabladetalles_id', $request);
                })
                ->leftJoin('cliente_tiendas', 'cliente_tiendas.cliente_id', '=', 'clientes.id')
                ->when($request->get('tipo'), function ($query, $request) {
                    return $query->where('cliente_tiendas.tipo_tienda', $request);
                })
                ->when($request->get('negocio'), function ($query, $request) {
                    return $query->where('cliente_tiendas.tipo_negocio', $request);
                })
                ->when($request->get('zona'), function ($query, $request) {
                    return $query->where('clientes.zona', $request);
                })
                ->when($request->get('departamento'), function ($query, $request) {
                    return $query->where('clientes.departamento_id', $request);
                })
                ->select(
                    'clientes.id',
                    'clientes.tipo_documento',
                    'clientes.documento',
                    'clientes.correo_electronico',
                    'clientes.telefono_movil',
                    'clientes.nombre',
                    'cliente_tiendas.tipo_tienda',
                    'cliente_tiendas.tipo_negocio',
                    'clientes.facebook',
                    'clientes.instagram',
                    'clientes.web',
                    'clientes.tabladetalles_id as tipoCliente',
                    'clientes.departamento_id as departamentoCliente',
                    'clientes.zona'
                );

        $clientes = $clientes->get();
        $coleccion = collect([]);

        foreach ($clientes as $cliente) {
            $ventas = DB::table('cotizacion_documento')
                    ->join('cotizacion_documento_detalles', 'cotizacion_documento.id', '=', 'cotizacion_documento_detalles.id')
                    ->select('cotizacion_documento_detalles.codigo_producto')->distinct()
                    ->where('cotizacion_documento.cliente_id',$cliente->id)
                    ->where('cotizacion_documento_detalles.estado','ACTIVO')
                    ->when($request->get('producto'), function ($query, $request) {
                        return $query->where('cotizacion_documento_detalles.codigo_producto', $request);
                    })->get();

            $venta_monto = DB::table('cotizacion_documento')

                    ->where('cotizacion_documento.cliente_id',$cliente->id)
                    ->when($request->get('fecha_inicio'), function ($query, $request) {
                        return $query->where('cotizacion_documento.fecha_documento','>=',$request);
                    })
                    ->when($request->get('fecha_fin'), function ($query, $request) {
                        return $query->where('cotizacion_documento.fecha_documento','<=',$request);
                    })
                    ->when($request->all(), function ($query, $request) {
                        if ( !empty($request['comparacion'])  &&  !empty($request['monto'])  ) {
                            return $query->where('cotizacion_documento.total', $request['comparacion'], $request['monto']);
                        }
                    })
                    ->sum('cotizacion_documento.total');

            $coleccion->push([
                'cliente' => $cliente,
                'producto' => count($ventas) > 0 ? 'SI' : 'NO',
                'total' => $venta_monto
                ]);
        }

        return DataTables::collection($coleccion)->toJson();
});

//TIPO DE DOCUMENTO Y SE ENVIA SUS TIENDAS
// [
//     tipoDocumento => RUC (CADENA),
//     documento => DNI O RUC cliente
// ]
Route::get('clientes/tienda',function (Request $request)
{
    $clientes = DB::table('clientes')
                ->when($request->get('tipoDocumento'), function ($query, $request) {
                    return $query->where('clientes.tipo_documento', $request);
                })
                // ->leftJoin('cliente_tiendas', 'cliente_tiendas.cliente_id', '=', 'clientes.id')
                ->when($request->get('documento'), function ($query, $request) {
                    return $query->where('clientes.documento', $request);
                })
                ->select(
                    'clientes.id',
                    'clientes.tipo_documento',
                    'clientes.documento',
                    'clientes.nombre',
                    'clientes.correo_electronico',
                    'clientes.telefono_movil',
                    'clientes.facebook',
                    'clientes.instagram',
                    'clientes.web'
                );

        $clientes = $clientes->get();
        $coleccion = collect([]);

        foreach ($clientes as $cliente) {
            $tiendas = DB::table('cliente_tiendas')
                    ->select(
                        'cliente_tiendas.nombre',
                        'cliente_tiendas.tipo_tienda',
                        'cliente_tiendas.tipo_negocio',
                        'cliente_tiendas.direccion'
                    )
                    ->where('cliente_tiendas.cliente_id',$cliente->id)
                    ->where('cliente_tiendas.estado','ACTIVO')
                    ->get();

            $coleccion->push([
                'cliente' => $cliente,
                'tiendas' => $tiendas,
                ]);
        }

        return DataTables::collection($coleccion)->toJson();
});

//BUSQUEDA CLIENTE Y DOCUMENTO
// [
//     cliente => nombre
// ]
Route::get('clientes/documentos',function (Request $request)
{
    $clientes = DB::table('clientes')
                ->when($request->get('cliente'), function ($query, $request) {
                    return $query->where('nombre', 'like', '%' .$request. '%');
                })
                ->where('clientes.estado','ACTIVO')
                ->select(
                    'clientes.id',
                    'clientes.nombre',
                    'clientes.tipo_documento',
                    'clientes.documento'
                )->get();

    return DataTables::collection($clientes)->toJson();
});


// BUESQUEDA DE ZONAS
Route::get('zonas/departamentos',function ()
{
    $departamentos = DB::table('departamentos')
                ->select(
                    'departamentos.id',
                    'departamentos.nombre'
                )->get();

    return DataTables::collection($departamentos)->toJson();
});

// [
//     departamento => 01
// ]

Route::get('zonas/provincias',function (Request $request)
{
    $provincias = DB::table('provincias')
                ->when($request->get('departamento'), function ($query, $request) {
                    return $query->where('provincias.departamento_id', $request);
                })
                ->select(
                    'provincias.id',
                    'provincias.nombre'
                )->get();

    return DataTables::collection($provincias)->toJson();
});

// [
//     provincia => 01
// ]
Route::get('zonas/distritos',function (Request $request)
{
    $distritos = DB::table('distritos')
                ->when($request->get('provincia'), function ($query, $request) {
                    return $query->where('distritos.provincia_id', $request);
                })
                ->select(
                    'distritos.id',
                    'distritos.nombre',
                    'distritos.nombre_legal'
                )->get();

    return DataTables::collection($distritos)->toJson();
});
Route::get('mapa/peru',function(){
    $file = database_path("data\mapa\peru.json");
    $json = file_get_contents($file);

    return json_decode($json,true);
});




