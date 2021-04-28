<?php

namespace App\Http\Controllers\Almacenes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Almacenes\Maquinaria_equipo;

use DataTables;
use Carbon\Carbon;
use Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use DB;

class Maquinarias_equiposController extends Controller
{
    public function index()
    {
        return view('almacenes.maquinarias_equipos.index');
    }
    public function getMaquinaria_equipo(){
        return datatables()->query(
            DB::table('maquinarias_equipos')
            ->select('maquinarias_equipos.*', 
            DB::raw('DATE_FORMAT(created_at, "%d/%m/%Y") as creado'),
            DB::raw('DATE_FORMAT(updated_at, "%d/%m/%Y") as actualizado')
            )->where('maquinarias_equipos.estado','ACTIVO')
        )->toJson();
    }
    
    public function store(Request $request){
        
        $data = $request->all();
        $rules = [
            'tipo'=>'',
            'nombre'=>'',
            'serie'=>'',
            'tipocorriente'=>'',
            'caracteristicas'=>'',
            'nombre_imagen'=>'',
            'vidautil'=>'',
           
        ];
        
        $message = [
            'tipo'=>'El campo tipo es ...',
            'nombre'=>'El campo nombre es ...',
            'serie'=>'El campo serie es ...',
            'tipocorriente'=>'El campo tipocorriente es ...',
            'caracteristicas'=>'El campo caracteristicas es ...',
            'nombre_imagen'=>'El campo nombre_imagen es ...',
            'vidautil'=>'El campo vidautil es ...',
            
        ];

        Validator::make($data, $rules, $message)->validate();
        
        //$registro_sanitario = new RegistroSanitario();
        $maquinarias_equipos=new Maquinaria_equipo;
        $maquinarias_equipos->tipo=$request->get('tipo');
        $maquinarias_equipos->nombre=$request->get('nombre');
        $maquinarias_equipos->serie=$request->get('serie');
        $maquinarias_equipos->tipocorriente=$request->get('tipocorriente');
        $maquinarias_equipos->caracteristicas=$request->get('caracteristicas');

        if($request->hasFile('nombre_imagen')){                
            $file = $request->file('nombre_imagen');
            $name = $file->getClientOriginalName();
            $maquinarias_equipos->nombre_imagen = $name;
            $maquinarias_equipos->ruta_imagen = $request->file('nombre_imagen')->store('public/maquinarias_equipos');
        }
        //$maquinarias_equipos->nombre_imagen=$request->get('nombre_imagen');
        $maquinarias_equipos->vidautil=$request->get('vidautil');
        //$maquinarias_equipos->estado=$request->get('estado');
        $maquinarias_equipos->save();


        //Registro de actividad
        $descripcion = "SE AGREGÓ LA MAQUINARIA / EQUIPO CON EL NOMBRE: ". $maquinarias_equipos->nombre;
        $gestion = "MAQUINARIA / EQUIPO";
        crearRegistro($maquinarias_equipos, $descripcion , $gestion);
        

        Session::flash('success','Maquinaria-Equipo creado.');
        return redirect()->route('almacenes.maquinaria_equipo.index')->with('guardar', 'success');
    }

    public function update(Request $request){
        
        $data = $request->all();
        $rules = [
            'tipo' =>'',
            'nombre' =>'',
            'serie' =>'',
            'tipocorriente' =>'',
            'caracteristicas' =>'',
            'nombre_imagen' =>'',
            'vidautil' =>'',
            
        ];
        
        $message = [
            'tipo' =>'El campo tipo es ...',
            'nombre' =>'El campo nombre es ...',
            'serie' =>'El campo serie es ...',
            'tipocorriente' =>'El campo tipocorriente es ...',
            'caracteristicas' =>'El campo caracteristicas es ...',
            'nombre_imagen' =>'El campo nombre_imagen es ...',
            'vidautil' =>'El campo vidautil es ...',
            
        ];
        Validator::make($data, $rules, $message)->validate();

        $maquinarias_equipos = Maquinaria_equipo::findOrFail($request->get('id'));
        $maquinarias_equipos->tipo = $request->get('tipo');
        $maquinarias_equipos->nombre = $request->get('nombre');
        $maquinarias_equipos->serie = $request->get('serie');
        $maquinarias_equipos->tipocorriente = $request->get('tipocorriente');
        $maquinarias_equipos->caracteristicas = $request->get('caracteristicas');

        if($request->hasFile('nombre_imagen')){         
            //Eliminar Archivo anterior
            Storage::delete($maquinarias_equipos->ruta_imagen);               
            //Agregar nuevo archivo       
            $file = $request->file('nombre_imagen');
            $name = $file->getClientOriginalName();
            $maquinarias_equipos->nombre_imagen = $name;
            $maquinarias_equipos->ruta_imagen = $request->file('nombre_imagen')->store('public/maquinarias_equipos');
        }
        //$maquinarias_equipos->nombre_imagen = $request->get('nombre_imagen');
        $maquinarias_equipos->vidautil = $request->get('vidautil');
        $maquinarias_equipos->update();

        //Registro de actividad
        $descripcion = "SE MODIFICÓ LA MAQUINARIA / EQUIPO CON EL NOMBRE: ". $maquinarias_equipos->nombre;
        $gestion = "MAQUINARIA / EQUIPO";
        modificarRegistro($maquinarias_equipos, $descripcion , $gestion);

        Session::flash('success','Maquinaria-Equipo modificado.');
        return redirect()->route('almacenes.maquinaria_equipo.index')->with('modificar', 'success');
    }

    
    public function destroy($id)
    {
        
        $maquinarias_equipos = Maquinaria_equipo::findOrFail($id);
        $maquinarias_equipos->estado = 'ANULADO';
        $maquinarias_equipos->update();

        //Registro de actividad
        $descripcion = "SE ELIMINÓ LA MAQUINARIA / EQUIPO CON EL NOMBRE: ".   $maquinarias_equipos->nombre;
        $gestion = "MAQUINARIA / EQUIPO";
        eliminarRegistro($maquinarias_equipos, $descripcion , $gestion);

        Session::flash('success','Maquinaria-Equipo eliminado.');
        return redirect()->route('almacenes.maquinaria_equipo.index')->with('eliminar', 'success');

    }
}