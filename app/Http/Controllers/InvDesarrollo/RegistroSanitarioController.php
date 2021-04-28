<?php

namespace App\Http\Controllers\InvDesarrollo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\InvDesarrollo\RegistroSanitario;
use App\Almacenes\Producto;
use DataTables;
use Carbon\Carbon;
use Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use DB;

class RegistroSanitarioController extends Controller
{
        public function index()
    {
        $productos = Producto::where('estado','ACTIVO')->get();
        $fecha_hoy = Carbon::now()->toDateString();
        return view('invdesarrollo.registro_sanitario.index',["productos"=>$productos,'fecha_hoy' => $fecha_hoy,]);
    }
    public function getRegistroSanitario(){
        return datatables()->query(
            DB::table('registro_sanitario')
            ->join('productos','productos.id','=','registro_sanitario.producto_id')
            ->select('registro_sanitario.*', 
            DB::raw('DATE_FORMAT(registro_sanitario.created_at, "%d/%m/%Y") as creado'),
            DB::raw('DATE_FORMAT(registro_sanitario.updated_at, "%d/%m/%Y") as actualizado'),'productos.nombre as nombre'
            )->where('registro_sanitario.estado','ACTIVO')
        )->toJson();
    }
    
    public function store(Request $request){
        
        $data = $request->all();
        $rules = [
            'producto_id' =>'',
            'fecha_inicio'=>'',
            'fecha_fin'=>'',
            'archivo_word'=>'',
            'archivo_pdf'=>'',
            'estado'=>'',
        ];
        
        $message = [
            'producto_id' =>'',
            'fecha_inicio'=>'',
            'fecha_fin'=>'',
            'archivo_word'=>'',
            'archivo_pdf'=>'',
            'estado'=>'',
        ];

        Validator::make($data, $rules, $message)->validate();

        $registro_sanitario=new RegistroSanitario;
        $registro_sanitario->producto_id = $request->get('producto_id');
        $registro_sanitario->fecha_inicio = $request->get('fecha_inicio');
        $registro_sanitario->fecha_fin = $request->get('fecha_fin');


        if($request->hasFile('archivo_word')){                
            $file = $request->file('archivo_word');
            $name = $file->getClientOriginalName();
            $registro_sanitario->archivo_word = $name;
            $registro_sanitario->ruta_archivo_word = $request->file('archivo_word')->store('public/registro_sanitario');
        }
        if($request->hasFile('archivo_pdf')){                
            $file = $request->file('archivo_pdf');
            $name = $file->getClientOriginalName();
            $registro_sanitario->archivo_pdf = $name;
            $registro_sanitario->ruta_archivo_pdf = $request->file('archivo_pdf')->store('public/registro_sanitario');
        }
        $registro_sanitario->save();

        //Registro de actividad
        $descripcion = "SE AGREGÓ EL REGISTRO SANITARIO DEL PRODUCTO CON EL NOMBRE: ". $registro_sanitario->producto->nombre;
        $gestion = "REGISTRO SANITARIO";
        crearRegistro($registro_sanitario, $descripcion , $gestion);

        Session::flash('success','Registro Sanitario creado.');
        return redirect()->route('invdesarrollo.registro_sanitario.index')->with('guardar', 'success');
    }

    public function update(Request $request){
        
        $data = $request->all();
        $rules = [
            'producto_id' =>'',
            'fecha_inicio'=>'',
            'fecha_fin'=>'',
            'archivo_word'=>'',
            'archivo_pdf'=>'',
            'estado'=>'',
            
        ];
        
        $message = [
            'producto_id' =>'',
            'fecha_inicio'=>'',
            'fecha_fin'=>'',
            'archivo_word'=>'',
            'archivo_pdf'=>'',
            'estado'=>'',
            
        ];
        Validator::make($data, $rules, $message)->validate();

        $registro_sanitario = RegistroSanitario::findOrFail($request->get('id'));
        $registro_sanitario->producto_id = $request->get('producto_id');
        $registro_sanitario->fecha_inicio = $request->get('fecha_inicio');
        $registro_sanitario->fecha_fin = $request->get('fecha_fin');
        //$registro_sanitario->archivo_word = $request->get('archivo_word');
        //$registro_sanitario->archivo_pdf = $request->get('archivo_pdf');
        
        if($request->hasFile('archivo_word')){  
            //Eliminar Archivo anterior
            Storage::delete($registro_sanitario->ruta_archivo_word);               
            //Agregar nuevo archivo              
            $file = $request->file('archivo_word');
            $name = $file->getClientOriginalName();
            $registro_sanitario->archivo_word = $name;
            $registro_sanitario->ruta_archivo_word = $request->file('archivo_word')->store('public/registro_sanitario');
        }
        if($request->hasFile('archivo_pdf')){ 
            //Eliminar Archivo anterior
            Storage::delete($registro_sanitario->ruta_archivo_pdf);               
            //Agregar nuevo archivo                
            $file = $request->file('archivo_pdf');
            $name = $file->getClientOriginalName();
            $registro_sanitario->archivo_pdf = $name;
            $registro_sanitario->ruta_archivo_pdf = $request->file('archivo_pdf')->store('public/registro_sanitario');
        }
        $registro_sanitario->update();

        //Registro de actividad
        $descripcion = "SE MODIFICÓ EL REGISTRO SANITARIO DEL PRODUCTO CON EL NOMBRE: ". $registro_sanitario->producto->nombre;
        $gestion = "REGISTRO SANITARIO";
        modificarRegistro($registro_sanitario, $descripcion , $gestion);

        Session::flash('success','Registro Sanitario modificado.');
        return redirect()->route('invdesarrollo.registro_sanitario.index')->with('modificar', 'success');
    }

    
    public function destroy($id)
    {
        
        $registro_sanitario = RegistroSanitario::findOrFail($id);
        $registro_sanitario->estado = 'ANULADO';
        $registro_sanitario->update();

        //Registro de actividad
        $descripcion = "SE ELIMINÓ EL REGISTRO SANITARIO DEL PRODUCTO CON EL NOMBRE: ". $registro_sanitario->producto->nombre;
        $gestion = "REGISTRO SANITARIO";
        eliminarRegistro($registro_sanitario, $descripcion , $gestion);

        Session::flash('success','Registro Sanitario eliminado.');
        return redirect()->route('invdesarrollo.registro_sanitario.index')->with('eliminar', 'success');

    }
}
