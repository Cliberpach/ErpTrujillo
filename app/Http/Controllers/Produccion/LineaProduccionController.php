<?php

namespace App\Http\Controllers\Produccion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Produccion\Linea_produccion;
use App\Produccion\Detalle_linea_produccion;
use App\Almacenes\Maquinaria_equipo;

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

class LineaProduccionController extends Controller
{
    public function index()
    {
        return view('produccion.lineas_produccion.index');
    }

    public function getLineaProduccion(){


        $lineas_produccion =  DB::table('lineas_produccion')
            ->where('lineas_produccion.estado','!=','ANULADO')   
            //->select('lineas_produccion.*'','maquinarias_equipos.nombre'')         
            ->get();

        $coleccion = collect([]);
        foreach($lineas_produccion as $linea_produccion){
            $coleccion->push([
                'id' => $linea_produccion->id,
                'nombre_linea' => $linea_produccion->nombre_linea,
                'cantidad_personal' => $linea_produccion->cantidad_personal,
                'nombre_imagen' => $linea_produccion->nombre_imagen,
                'archivo_word' => $linea_produccion->archivo_word,
                'estado' => $linea_produccion->estado,
            ]);
        }
       
        return DataTables::of($coleccion)->toJson();
    }

    public function create()
    {
        $maquinarias_equipos = Maquinaria_equipo::where('estado','ACTIVO')->get();
        return view('produccion.lineas_produccion.create',[
            'maquinarias_equipos' => $maquinarias_equipos, 
        ]);
    }

    
    public function edit($id)
    {
        $detalles = Detalle_linea_produccion::where('linea_produccion_id',$id)->get();        
        $linea_produccion = Linea_produccion::findOrFail($id);
        $maquinarias_equipos = Maquinaria_equipo::where('estado','ACTIVO')->get();
        return view('produccion.lineas_produccion.edit',[
            'linea_produccion' => $linea_produccion,
            'detalles' => $detalles,
            'maquinarias_equipos' => $maquinarias_equipos, 
        ]);
    }

    public function store(Request $request){
        $data = $request->all();
        $rules = [
            'nombre_linea'=>'required',
            'cantidad_personal'=>'required',
            'nombre_imagen'=>'max:191',
            'archivo_word'=>'max:191',
        ];
        $message = [
            'nombre_linea'=>'Nombre de Linea es Obligatorio',
            'cantidad_personal.required'=>'Cantidad de Personal es obligatorio',
            'nombre_imagen'=>'Tamaño Maximo 191',
            'archivo_word'=>'Tamaño Maximo 191',
        ];
        Validator::make($data, $rules, $message)->validate();

        $linea_produccion = new Linea_produccion();        
        $linea_produccion->nombre_linea=$request->get('nombre_linea');
        $linea_produccion->cantidad_personal=$request->get('cantidad_personal');
        $linea_produccion->nombre_imagen=$request->get('nombre_imagen');
        $linea_produccion->archivo_word=$request->get('archivo_word');
        //$linea_produccion->usuario_id = auth()->user()->id;
        if($request->hasFile('nombre_imagen')){                
            $file = $request->file('nombre_imagen');
            $name = $file->getClientOriginalName();
            $linea_produccion->nombre_imagen = $name;
            $linea_produccion->ruta_imagen = $request->file('nombre_imagen')->store('public/linea_produccion');
        }
        if($request->hasFile('archivo_word')){                
            $file = $request->file('archivo_word');
            $name = $file->getClientOriginalName();
            $linea_produccion->archivo_word = $name;
            $linea_produccion->ruta_archivo_word = $request->file('archivo_word')->store('public/linea_produccion');
        }
        $linea_produccion->save();


        //Llenado de los maquinas-equipos
        $maquinarias_equiposJSON = $request->get('maquinarias_equipos_tabla');
        $maquinaria_equipotabla = json_decode($maquinarias_equiposJSON[0]);

        foreach ($maquinaria_equipotabla as $maquinaria_equipo) {
            Detalle_linea_produccion::create([
                'linea_produccion_id' => $linea_produccion->id,
                'maquinaria_equipo_id' => $maquinaria_equipo->maquinaria_equipo_id,
            ]);
        }

        //Registro de actividad
        $descripcion = "SE MODIFICÓ LA LINEA DE PRODUCCION CON EL NOMBRE: ". $linea_produccion->nombre_linea;
        $gestion = "LINEA DE PRODUCCION";
        crearRegistro($linea_produccion, $descripcion , $gestion);

        Session::flash('success','Linea de Produccion creada.');
        return redirect()->route('produccion.linea_produccion.index')->with('guardar', 'success');
    }

    public function update(Request $request, $id){
        $data = $request->all();
        $rules = [
            'nombre_linea'=>'required',
            'cantidad_personal'=>'required',
            'nombre_imagen'=>'max:191',
            'archivo_word'=>'max:191',
        ];
        
        $message = [
            'nombre_linea'=>'Nombre de Linea es Obligatorio',
            'cantidad_personal.required'=>'Cantidad de Personal es obligatorio',
            'nombre_imagen'=>'Tamaño Maximo 191',
            'archivo_word'=>'Tamaño Maximo 191',
        ];

        Validator::make($data, $rules, $message)->validate();

        $linea_produccion = Linea_produccion::findOrFail($id);        
        $linea_produccion->nombre_linea=$request->get('nombre_linea');
        $linea_produccion->cantidad_personal=$request->get('cantidad_personal');
        $linea_produccion->nombre_imagen=$request->get('nombre_imagen');
        $linea_produccion->archivo_word=$request->get('archivo_word');
        //$linea_produccion->usuario_id = auth()->user()->id;
         if($request->hasFile('nombre_imagen')){   
            //Eliminar Archivo anterior
            Storage::delete($linea_produccion->ruta_imagen);               
            //Agregar nuevo archivo             
            $file = $request->file('nombre_imagen');
            $name = $file->getClientOriginalName();
            $linea_produccion->nombre_imagen = $name;
            $linea_produccion->ruta_imagen = $request->file('nombre_imagen')->store('public/linea_produccion');
        }
        if($request->hasFile('archivo_word')){     
            //Eliminar Archivo anterior
            Storage::delete($linea_produccion->ruta_archivo_word);               
            //Agregar nuevo archivo           
            $file = $request->file('archivo_word');
            $name = $file->getClientOriginalName();
            $linea_produccion->archivo_word = $name;
            $linea_produccion->ruta_archivo_word = $request->file('archivo_word')->store('public/linea_produccion');
        }
        $linea_produccion->save();

        //Llenado de los maquinarias-equipos
        $maquinarias_equiposJSON = $request->get('maquinarias_equipos_tabla');
        //dd($maquinarias_equiposJSON);
        $maquinaria_equipotabla = json_decode($maquinarias_equiposJSON[0]);

        
        if ($maquinaria_equipotabla) {
            $Detalle_lineas_produccion = Detalle_linea_produccion::where('linea_produccion_id', $linea_produccion->id)->get();
            foreach ($Detalle_lineas_produccion as $Detalle_linea_produccion) {
                $Detalle_linea_produccion->delete();
            }
            foreach ($maquinaria_equipotabla as $maquinaria_equipo) {
                Detalle_linea_produccion::create([
                    'linea_produccion_id' => $linea_produccion->id,
                    'maquinaria_equipo_id' => $maquinaria_equipo->maquinaria_equipo_id,
                ]);
            }
        }

        //Registro de actividad
        $descripcion = "SE MODIFICÓ LA LINEA DE PRODUCCION CON EL NOMBRE: ". $linea_produccion->nombre_linea;
        $gestion = "LINEA DE PRODUCCION";
        modificarRegistro($linea_produccion, $descripcion , $gestion);
        
        Session::flash('success','Linea de Produccion modificada.');
        return redirect()->route('produccion.linea_produccion.index')->with('modificar', 'success');
    }

    public function destroy($id)
    {
        
        $linea_produccion = Linea_produccion::findOrFail($id);
        $linea_produccion->estado = 'ANULADA';
        $linea_produccion->update();

        //Registro de actividad
        $descripcion = "SE ELIMINÓ LA LINEA DE PRODUCCION CON EL NOMBRE: ". $linea_produccion->nombre_linea;
        $gestion = "LINEA DE PRODUCCION";
        eliminarRegistro($linea_produccion, $descripcion , $gestion);

        Session::flash('success','Linea de Produccion eliminada.');
        return redirect()->route('produccion.linea_produccion.index')->with('eliminar', 'success');

    }

    public function show($id)
    {
        $linea_produccion = Linea_produccion::findOrFail($id);
        $detalles = Detalle_linea_produccion::where('linea_produccion_id',$id)->get(); 
        $maquinarias_equipos = Maquinaria_equipo::where('estado','ACTIVO')->get();
        return view('produccion.lineas_produccion.show', [
            'linea_produccion' => $linea_produccion,
            'detalles' => $detalles,
            'maquinarias_equipos' => $maquinarias_equipos, 
        ]);
    }

    public function report($id)
    {
        $linea_produccion = Linea_produccion::findOrFail($id);
        $detalles = Detalle_linea_produccion::where('linea_produccion_id',$id)->get();
        $maquinarias_equipos = Maquinaria_equipo::where('estado','ACTIVO')->get();
        $paper_size = array(0,0,360,360);
        $pdf = PDF::loadview('produccion.lineas_produccion.reportes.detalle',[
            'linea_produccion' => $linea_produccion,
            'detalles' => $detalles,
            'maquinarias_equipos' => $maquinarias_equipos, 
            ])->setPaper('a4')->setWarnings(false);
        return $pdf->stream();
    }
}
