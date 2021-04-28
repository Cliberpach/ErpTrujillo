<?php

namespace App\Http\Controllers\Almacenes;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Almacenes\Ingreso_mercaderia;
use App\Almacenes\Detalle_ingreso_mercaderia;

use App\Compras\Articulo;
use App\Compras\Proveedor;

use DataTables;
use Carbon\Carbon;
use Session;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use PDF;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use DB;

class Ingreso_mercaderiaController extends Controller
{
    public function index()
    {
        return view('almacenes.ingresos_mercaderia.index');
    }

    public function getIngreso_mercaderia(){

        $ingresos_mercaderia =  DB::table('ingresos_mercaderia')
            ->join('articulos','articulos.id','=','ingresos_mercaderia.articulo_id')
            ->join('proveedores','proveedores.id','=','ingresos_mercaderia.proveedor_id')
            ->where('ingresos_mercaderia.estado','!=','ANULADO')   
            ->select('ingresos_mercaderia.*') //,'proveedores.producto')         
            ->get();

        $coleccion = collect([]);
        foreach($ingresos_mercaderia as $ingreso_mercaderia){
            //$Detalle_ingresos_mercaderia = Detalle_ingreso_mercaderia::where('Ingreso_mercaderia_id',$ingreso_mercaderia->id)->get(); 

            $coleccion->push([
                'id' => $ingreso_mercaderia->id,
                'factura' => $ingreso_mercaderia->factura,
                'fecha_ingreso' => Carbon::parse($ingreso_mercaderia->fecha_ingreso)->format( 'd/m/Y'),
                'articulo_id' => $ingreso_mercaderia->articulo_id,
                'lote' => $ingreso_mercaderia->lote,
                'fecha_produccion' => Carbon::parse($ingreso_mercaderia->fecha_produccion)->format( 'd/m/Y'),
                'fecha_vencimiento' => Carbon::parse($ingreso_mercaderia->fecha_vencimiento)->format( 'd/m/Y'),
                'proveedor_id' =>  $ingreso_mercaderia->proveedor_id,
                'peso_embalaje_dscto' => $ingreso_mercaderia->peso_embalaje_dscto,
                'estado' => $ingreso_mercaderia->estado,
            ]);
        }
  
        return DataTables::of($coleccion)->toJson();
    }

    public function create()
    {
        $articulos = Articulo::where('estado','ACTIVO')->get();
        $proveedores = Proveedor::where('estado','ACTIVO')->get();
        $presentaciones =  presentaciones();
        $fecha_hoy = Carbon::now()->toDateString();
       
        return view('almacenes.ingresos_mercaderia.create',[
            'articulos' => $articulos, 
            'proveedores' => $proveedores, 
            'fecha_hoy' => $fecha_hoy,
            'presentaciones'  => $presentaciones, 
        ]);
    }

    
    public function edit($id)
    {
        $detalles = Detalle_ingreso_mercaderia::where('Ingreso_mercaderia_id',$id)->get();        
        $ingreso_mercaderia = Ingreso_mercaderia::findOrFail($id);
        $proveedores = Proveedor::where('estado','ACTIVO')->get();
        $articulos = Articulo::where('estado','ACTIVO')->get();
        $fecha_hoy = Carbon::now()->toDateString();
        $presentaciones =  presentaciones();

        return view('almacenes.ingresos_mercaderia.edit',[
            'ingreso_mercaderia' => $ingreso_mercaderia,
            'articulos' => $articulos, 
            'fecha_hoy' => $fecha_hoy, 
            'detalles' => $detalles,
            'proveedores' => $proveedores, 
            'presentaciones'  => $presentaciones, 
        ]);
    }

    public function store(Request $request){
        $data = $request->all();
        $rules = [
            'factura' => '',
            'fecha_ingreso' => '',
            'articulo_id' => '',
            'lote' => '',
            'fecha_produccion' => '',
            'fecha_vencimiento' => '',
            'proveedor_id' =>  '',
            'peso_embalaje_dscto' => '',

        ];
        $message = [
            'factura' => '',
            'fecha_ingreso' => '',
            'articulo_id' => '',
            'lote' => '',
            'fecha_produccion' => '',
            'fecha_vencimiento' => '',
            'proveedor_id' =>  '',
            'peso_embalaje_dscto' => '',
        ];
        Validator::make($data, $rules, $message)->validate();

        $ingreso_mercaderia = new Ingreso_mercaderia();     
        $ingreso_mercaderia->factura=$request->get('factura');
        $ingreso_mercaderia->fecha_ingreso=Carbon::createFromFormat('d/m/Y', $request->get('fecha_ingreso'))->format('Y-m-d');   
        $ingreso_mercaderia->articulo_id=$request->get('articulo_id');
        $ingreso_mercaderia->lote=$request->get('lote');
        $ingreso_mercaderia->fecha_produccion=Carbon::createFromFormat('d/m/Y', $request->get('fecha_produccion'))->format('Y-m-d');  
        $ingreso_mercaderia->fecha_vencimiento=Carbon::createFromFormat('d/m/Y', $request->get('fecha_vencimiento'))->format('Y-m-d');  
        $ingreso_mercaderia->proveedor_id=$request->get('proveedor_id');
        $ingreso_mercaderia->peso_embalaje_dscto=$request->get('peso_embalaje_dscto');

        $ingreso_mercaderia->usuario_id = auth()->user()->id;
        $ingreso_mercaderia->save();


        //Llenado de los articulos
        $articulosJSON = $request->get('articulos_tabla');
        $articulotabla = json_decode($articulosJSON[0]);

        foreach ($articulotabla as $articulo) {
            Detalle_ingreso_mercaderia::create([
                'ingreso_mercaderia_id' => $ingreso_mercaderia->id,
                'peso_neto' => $articulo->peso_neto,
                'peso_bruto' => $articulo->peso_bruto,
                'observacion'=> $articulo->observacion,
            ]);
        }

        //Registro de actividad
        $descripcion = "SE AGREGÓ EL INGRESO MERCADERIA CON LA FACTURA: ". $ingreso_mercaderia->factura;
        $gestion = "INGRESO MERCADERIA";
        crearRegistro($ingreso_mercaderia, $descripcion , $gestion);

        Session::flash('success','Ingreso Mercaderia creada.');
        return redirect()->route('almacenes.ingreso_mercaderia.index')->with('guardar', 'success');
    }

    public function update(Request $request, $id){
        $data = $request->all();
         $rules = [
            'factura' => '',
            'fecha_ingreso' => '',
            'articulo_id' => '',
            'lote' => '',
            'fecha_produccion' => '',
            'fecha_vencimiento' => '',
            'proveedor_id' =>  '',
            'peso_embalaje_dscto' => '',

        ];
        $message = [
            'factura' => '',
            'fecha_ingreso' => '',
            'articulo_id' => '',
            'lote' => '',
            'fecha_produccion' => '',
            'fecha_vencimiento' => '',
            'proveedor_id' =>  '',
            'peso_embalaje_dscto' => '',
        ];
        Validator::make($data, $rules, $message)->validate();

        $ingreso_mercaderia = Ingreso_mercaderia::findOrFail($id);        
        $ingreso_mercaderia->factura=$request->get('factura');
        $ingreso_mercaderia->fecha_ingreso=Carbon::createFromFormat('d/m/Y', $request->get('fecha_ingreso'))->format('Y-m-d');   
        $ingreso_mercaderia->articulo_id=$request->get('articulo_id');
        $ingreso_mercaderia->lote=$request->get('lote');
        $ingreso_mercaderia->fecha_produccion=Carbon::createFromFormat('d/m/Y', $request->get('fecha_produccion'))->format('Y-m-d');  
        $ingreso_mercaderia->fecha_vencimiento=Carbon::createFromFormat('d/m/Y', $request->get('fecha_vencimiento'))->format('Y-m-d');  
        $ingreso_mercaderia->proveedor_id=$request->get('proveedor_id');
        $ingreso_mercaderia->peso_embalaje_dscto=$request->get('peso_embalaje_dscto');

        $ingreso_mercaderia->usuario_id = auth()->user()->id;
        $ingreso_mercaderia->save();

        $articulosJSON = $request->get('articulos_tabla');
        $articulotabla = json_decode($articulosJSON[0]);

        //dd($articulotabla);
        if ($articulotabla) {
            $Detalle_ingresos_mercaderia = Detalle_ingreso_mercaderia::where('Ingreso_mercaderia_id', $ingreso_mercaderia->id)->get();
            foreach ($Detalle_ingresos_mercaderia as $Detalle_ingreso_mercaderia) {
                $Detalle_ingreso_mercaderia->delete();
            }
            foreach ($articulotabla as $articulo) {
                Detalle_ingreso_mercaderia::create([
                    'ingreso_mercaderia_id' => $ingreso_mercaderia->id,
                    'peso_neto' => $articulo->peso_neto,
                    'peso_bruto' => $articulo->peso_bruto,
                    'observacion'=> $articulo->observacion,
                ]);
            }
        }

        //Registro de actividad
        $descripcion = "SE MODIFICÓ EL INGRESO MERCADERIA CON LA FACTURA: ". $ingreso_mercaderia->factura;
        $gestion = "INGRESO MERCADERIA";
        modificarRegistro($ingreso_mercaderia, $descripcion , $gestion);
        
        Session::flash('success','Ingreso Mercaderia modificada.');
        return redirect()->route('almacenes.ingreso_mercaderia.index')->with('modificar', 'success');
    }

    public function destroy($id)
    {
        
        $ingreso_mercaderia = Ingreso_mercaderia::findOrFail($id);
        $ingreso_mercaderia->estado = 'ANULADO';
        $ingreso_mercaderia->update();

        //Registro de actividad
        $descripcion = "SE ELIMINÓ EL INGRESO MERCADERIA CON LA FACTURA: ". $ingreso_mercaderia->factura;
        $gestion = "INGRESO MERCADERIA";
        eliminarRegistro($ingreso_mercaderia, $descripcion , $gestion);

        Session::flash('success','Ingreso_mercaderia eliminada.');
        return redirect()->route('almacenes.ingreso_mercaderia.index')->with('eliminar', 'success');

    }

    public function show($id)
    {
        $ingreso_mercaderia = Ingreso_mercaderia::findOrFail($id);
        $detalles = Detalle_ingreso_mercaderia::where('ingreso_mercaderia_id',$id)->get(); 
        $articulos = Articulo::where('estado','ACTIVO')->get();
        $proveedores = Proveedor::where('estado','ACTIVO')->get();
        $presentaciones =  presentaciones();
        return view('almacenes.ingresos_mercaderia.show', [
            'ingreso_mercaderia' => $ingreso_mercaderia,
            'detalles' => $detalles,
            'articulos' => $articulos, 
            'proveedores' => $proveedores, 
            'presentaciones'  => $presentaciones,  
        ]);
    }

    public function report($id)
    {
        $ingreso_mercaderia = Ingreso_mercaderia::findOrFail($id);
        $detalles = Detalle_ingreso_mercaderia::where('ingreso_mercaderia_id',$id)->get();
        $articulos = Articulo::where('estado','ACTIVO')->get();
        $proveedores = Proveedor::where('estado','ACTIVO')->get();
        $presentaciones =  presentaciones();
        $paper_size = array(0,0,360,360);
        $pdf = PDF::loadview('almacenes.ingresos_mercaderia.reportes.detalle',[
            'ingreso_mercaderia' => $ingreso_mercaderia,
            'detalles' => $detalles,
            'articulos' => $articulos, 
            'proveedores' => $proveedores, 
            'presentaciones'  => $presentaciones, 
            ])->setPaper('a4')->setWarnings(false);
        return $pdf->stream();
    }
}
