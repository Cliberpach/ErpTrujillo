<?php

namespace App\Http\Controllers\Produccion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Produccion\Programacion_produccion;
use App\Almacenes\Producto;
use App\Almacenes\ProductoDetalle;

use DataTables;
use Carbon\Carbon;
use Session;
use Illuminate\Support\Facades\Validator;
use DB;

class Programacion_produccionController extends Controller
{
    public function index()
    {
        return view('produccion.programacion_produccion.index');
    }

    public function getProgramacionProduccion(){
        $produccion = Programacion_produccion::select('programacion_produccion.*')->orderBy('id', 'desc')->get();
        $coleccion = collect([]);
        foreach($produccion as $producto) {
            $coleccion->push([
                'id' => $producto->id,
                'producto' => $producto->producto->nombre,
                'fecha_termino'=> ($producto->fecha_termino)?Carbon::parse($producto->fecha_termino)->format( 'd/m/Y'):'-',
                'fecha_programada'=> Carbon::parse($producto->fecha_produccion)->format( 'd/m/Y'),
                'cantidad_programada' => $producto->cantidad_programada,
                'observacion' => $producto->observacion,
                'estado' => $producto->estado,
            ]);
        }
        return DataTables::of($coleccion)->toJson();
    }

    public function create()
    {
        $fecha_hoy = Carbon::now()->toDateString();
        // $productos = Producto::where('estado','ACTIVO')->get();


        $productos = ProductoDetalle::where('estado','ACTIVO')->distinct()->get(['producto_id']);
        return view('produccion.programacion_produccion.create',[
            'productos' => $productos, 
            'fecha_hoy' => $fecha_hoy,
        ]);
    }

    public function edit($id)
    {
        $programacion_produccion = Programacion_produccion::findOrFail($id);
        $productos = Producto::where('estado','ACTIVO')->get();
        $fecha_hoy = Carbon::now()->toDateString();

        return view('produccion.programacion_produccion.edit',[
            'programacion_produccion' => $programacion_produccion,
            'productos' => $productos, 
            'fecha_hoy' => $fecha_hoy, 
        ]);
    }
    
    public function show($id)
    {
        $programacion_produccion = Programacion_produccion::findOrFail($id);
        $productos = Producto::where('estado','ACTIVO')->get();
 
        return view('produccion.programacion_produccion.show',[
            'programacion_produccion' => $programacion_produccion,
            'productos' => $productos, 
        ]);
    }
    public function store(Request $request){
    

        $data = $request->all();
        $rules = [
            'producto_id' => 'required',
            // 'fecha_creacion'=>'',
            'fecha_produccion' => 'required',
            // 'fecha_termino'=>'',
            // 'cantidad_programada'=>'',
            'cantidad_programada'=>'required',
            'observacion' => 'nullable',
            // // 'usuario_id'=>'',
            // 'estado'=>'',
            
        ];
        
        $message = [
            'required.producto_id'=>'El campo Producto es obligatorio',
            // 'fecha_creacion'=>'El campo fecha_creacion es ...',
            'required.fecha_produccion'=>'El campo Fecha de Producción es obligatorio',
            // 'fecha_termino'=>'El campo fecha_termino es ...',
            // 'cantidad_programada'=>'El campo cantidad_programada es ...',
            'cantidad_programada'=>'El campo Cantidad Producir es obligatorio',
            // 'observacion'=>'El campo observacion es ...',
            // 'usuario_id'=>'El campo usuario_id es ...',
            // 'estado'=>'El campo estado es ...',
            
        ];

        Validator::make($data, $rules, $message)->validate();
    
        $programacion_produccion=new Programacion_produccion;
        $programacion_produccion->producto_id = $request->get('producto_id');
        // $programacion_produccion->fecha_creacion = Carbon::createFromFormat('d/m/Y', $request->get('fecha_creacion'))->format('Y-m-d');
        $programacion_produccion->fecha_produccion = Carbon::createFromFormat('d/m/Y', $request->get('fecha_produccion'))->format('Y-m-d');
        $programacion_produccion->fecha_termino = ($request->get('fecha_termino')=='-') ? null : Carbon::createFromFormat('d/m/Y', $request->get('fecha_termino'))->format('Y-m-d');
        $programacion_produccion->cantidad_programada=$request->get('cantidad_programada');
        // $programacion_produccion->cantidad_producida=$request->get('cantidad_producida');
        $programacion_produccion->observacion=$request->get('observacion');
        // $programacion_produccion->usuario_id = auth()->user()->id;
        $programacion_produccion->save();

        //Registro de actividad
        $descripcion = "SE AGREGÓ LA PROGRAMACION DE PRODUCCION DEL PRODUCTO CON EL NOMBRE: ". $programacion_produccion->producto->nombre;
        $gestion = "PROGRAMACION DE PRODUCCION";
        crearRegistro($programacion_produccion, $descripcion , $gestion);

        Session::flash('success','Programacion de produccion creado.');
        return redirect()->route('produccion.programacion_produccion.index')->with('guardar', 'success');
    }

    public function update(Request $request, $id){
        $data = $request->all();
        $rules = [
            'producto_id' => 'required',
            // 'fecha_creacion'=>'',
            'fecha_produccion' => 'required',
            // 'fecha_termino'=>'',
            // 'cantidad_programada'=>'',
            'cantidad_programada'=>'required',
            'observacion' => 'nullable',
            // // 'usuario_id'=>'',
            // 'estado'=>'',
            
        ];
        
        $message = [
            'required.producto_id'=>'El campo Producto es obligatorio',
            // 'fecha_creacion'=>'El campo fecha_creacion es ...',
            'required.fecha_produccion'=>'El campo Fecha de Producción es obligatorio',
            // 'fecha_termino'=>'El campo fecha_termino es ...',
            // 'cantidad_programada'=>'El campo cantidad_programada es ...',
            'cantidad_programada'=>'El campo Cantidad Producir es obligatorio',
            // 'observacion'=>'El campo observacion es ...',
            // 'usuario_id'=>'El campo usuario_id es ...',
            // 'estado'=>'El campo estado es ...',
            
        ];

        Validator::make($data, $rules, $message)->validate();

        $programacion_produccion = Programacion_produccion::findOrFail($id);
        $programacion_produccion->producto_id = $request->get('producto_id');
        $programacion_produccion->fecha_produccion = Carbon::createFromFormat('d/m/Y', $request->get('fecha_produccion'))->format('Y-m-d');
        $programacion_produccion->fecha_termino = ($request->get('fecha_termino')=='-') ? null : Carbon::createFromFormat('d/m/Y', $request->get('fecha_termino'))->format('Y-m-d');
        $programacion_produccion->cantidad_programada=$request->get('cantidad_programada');
        $programacion_produccion->observacion = $request->get('observacion');
        // $programacion_produccion->usuario_id = auth()->user()->id;

        $programacion_produccion->update();

        //Registro de actividad
        $descripcion = "SE MODIFICÓ LA PROGRAMACION DE PRODUCCION DEL PRODUCTO CON EL NOMBRE: ". $programacion_produccion->producto->nombre;
        $gestion = "PROGRAMACION DE PRODUCCION";
        modificarRegistro($programacion_produccion, $descripcion , $gestion);

        Session::flash('success','Programacion_produccion modificado.');
        return redirect()->route('produccion.programacion_produccion.index')->with('modificar', 'success');
    }

    
    public function destroy(Request $request)
    {
        $programacion_produccion = Programacion_produccion::findOrFail($request->get('programacion_id'));
        $programacion_produccion->estado = 'ANULADO';
        $programacion_produccion->observacion = $request->get('observacion');
        $programacion_produccion->update();

        //Registro de actividad
        $descripcion = "SE ELIMINÓ LA PROGRAMACION DE PRODUCCION DEL PRODUCTO CON EL NOMBRE: ". $programacion_produccion->producto->nombre;
        $gestion = "PROGRAMACION DE PRODUCCION";
        eliminarRegistro($programacion_produccion, $descripcion , $gestion);

        Session::flash('success','Programacion de Produccion eliminado.');
        return redirect()->route('produccion.programacion_produccion.index')->with('eliminar', 'success');

    }
    
    public function approved()
    {
        return view('produccion.aprobada.index');
    }
    public function getApproved(){
        $produccion = Programacion_produccion::select('programacion_produccion.*')
                    ->where('estado','PRODUCCION')
                    ->orWhere('estado','ANULADO')
                    ->orderBy('id', 'desc')->get();
        $coleccion = collect([]);
        foreach($produccion as $producto) {
            $coleccion->push([
                'id' => $producto->id,
                'producto' => $producto->producto->nombre,
                'fecha_termino'=> ($producto->fecha_termino)?Carbon::parse($producto->fecha_termino)->format( 'd/m/Y'):'-',
                'fecha_programada'=> Carbon::parse($producto->fecha_produccion)->format( 'd/m/Y'),
                'cantidad_programada' => $producto->cantidad_programada,
                'observacion' => $producto->observacion,
                'estado' => $producto->estado,
                'produccion' => $producto->produccion,
            ]);
        }
        return DataTables::of($coleccion)->toJson();
    }


    public function production($id)
    {
        $programacion_produccion = Programacion_produccion::findOrFail($id);
        $programacion_produccion->estado = 'PRODUCCION';
        $programacion_produccion->update();

        //Registro de actividad
        $descripcion = "SE ENVIÓ A ORDENES DE PRODUCCION LA PROGRAMACION DE PRODUCCION DEL PRODUCTO CON EL NOMBRE: ". $programacion_produccion->producto->nombre;
        $gestion = "PROGRAMACION DE PRODUCCION - ORDENES DE PRODUCCION";
        crearRegistro($programacion_produccion, $descripcion , $gestion);

        Session::flash('success','Programacion de Produccion enviado a Producciones aprobadas.');
        return redirect()->route('produccion.programacion_produccion.index');

    }
}