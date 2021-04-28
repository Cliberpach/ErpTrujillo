<?php

namespace App\Http\Controllers\InvDesarrollo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\InvDesarrollo\Prototipo;
use App\InvDesarrollo\Detalle_prototipo;
use App\Almacenes\Producto;

use DataTables;
use Carbon\Carbon;
use Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input; 
use DB;

class PrototipoController extends Controller
{
       public function index()
    {
        return view('invdesarrollo.prototipos.index');
    }
    public function getPrototipo(){
        $prototipos =  DB::table('prototipos')
            ->where('prototipos.estado','!=','ANULADO')   
            ->get();

        $coleccion = collect([]);
        foreach($prototipos as $prototipo){
            $coleccion->push([
                'id' => $prototipo->id,
                'producto' => $prototipo->producto,
                'fecha_registro' => Carbon::parse($prototipo->fecha_registro)->format( 'd/m/Y'),
                'fecha_inicio' => Carbon::parse($prototipo->fecha_inicio)->format( 'd/m/Y'),
                'fecha_fin' => Carbon::parse($prototipo->fecha_fin)->format( 'd/m/Y'),
                'registro' =>  $prototipo->registro,
                'imagen' =>  $prototipo->imagen,
                'archivo_word' =>  $prototipo->archivo_word,
                'usuario_id' => $prototipo->usuario_id,
                'estado' => $prototipo->estado,
            ]);
        }
  
        return DataTables::of($coleccion)->toJson();
    }

    public function create()
    {
        $fecha_hoy = Carbon::now()->toDateString();
        $prototipos = Prototipo::where('estado','ACTIVO')->get();

        return view('invdesarrollo.prototipos.create',[
            'prototipos' => $prototipos, 
            'fecha_hoy' => $fecha_hoy,
        ]);
    }
    public function edit($id)
    {
        $detalles = Detalle_prototipo::where('prototipo_id',$id)->get();        
        $prototipo = Prototipo::findOrFail($id);
        $fecha_hoy = Carbon::now()->toDateString();

        return view('invdesarrollo.prototipos.edit',[
            'prototipo' => $prototipo,
            'fecha_hoy' => $fecha_hoy, 
            'detalles' => $detalles,
        ]);
    }
    public function store(Request $request){
        
        $data = $request->all();
        $rules = [
            'producto'=>'',
            'fecha_registro'=>'',
            'fecha_inicio'=>'',
            'fecha_fin'=>'',
            'registro'=>'',
            'imagen'=>'image|mimetypes:image/jpeg,image/png,image/jpg|max:40000',
            'archivo_word'=>'',
        ];
        
        $message = [
            'producto'=>'',
            'fecha_registro'=>'',
            'fecha_inicio'=>'',
            'fecha_fin'=>'',
            'registro'=>'',
            'imagen'=>'',
            'archivo_word'=>'',
        ];

        Validator::make($data, $rules, $message)->validate();
 
        $prototipo=new Prototipo;
        $prototipo->producto = $request->get('producto');
        $prototipo->fecha_registro = Carbon::createFromFormat('d/m/Y', $request->get('fecha_registro'))->format('Y-m-d');
        $prototipo->fecha_inicio = Carbon::createFromFormat('d/m/Y', $request->get('fecha_inicio'))->format('Y-m-d');
        $prototipo->fecha_fin = Carbon::createFromFormat('d/m/Y', $request->get('fecha_fin'))->format('Y-m-d');
        $prototipo->registro = $request->get('registro');
        //$prototipo->imagen = $request->get('imagen');
        //$prototipo->archivo_word = $request->get('archivo_word');

        if($request->hasFile('imagen')){                
            $file = $request->file('imagen');
            $name = $file->getClientOriginalName();
            $prototipo->imagen = $name;
            $prototipo->ruta_imagen = $request->file('imagen')->store('public/prototipos');
        }
        if($request->hasFile('archivo_word')){                
            $file = $request->file('archivo_word');
            $name = $file->getClientOriginalName();
            $prototipo->archivo_word = $name;
            $prototipo->ruta_archivo_word = $request->file('archivo_word')->store('public/prototipos');
        }
        $prototipo->usuario_id = auth()->user()->id;
        $prototipo->save();

        //Llenado del detalle
        $articulosJSON = $request->get('articulos_tabla');
        $articulotabla = json_decode($articulosJSON[0]);

        foreach ($articulotabla as $detalle) {
            Detalle_prototipo::create([
                'prototipo_id' => $prototipo->id,
                'nombre_articulo' => $detalle->nombre_articulo,
                'cantidad' => $detalle->cantidad,
                'observacion'=> $detalle->observacion,
            ]);
        }

        //Registro de actividad
        $descripcion = "SE AGREGÓ EL PROTOTIPO DEL PRODUCTO CON EL NOMBRE: ". $prototipo->producto;
        $gestion = "PROTOTIPO";
        crearRegistro( $prototipo , $descripcion , $gestion);

        Session::flash('success','Prototipo creado.');
        return redirect()->route('invdesarrollo.prototipo.index')->with('guardar', 'success');
    }

    public function update(Request $request, $id){
        
        $data = $request->all();
        $rules = [
            'producto'=>'',
            'fecha_registro'=>'',
            'fecha_inicio'=>'',
            'fecha_fin'=>'',
            'registro'=>'',
            'imagen'=>'',
            'archivo_word'=>'',
            
        ];
        
        $message = [
            'producto'=>'',
            'fecha_registro'=>'',
            'fecha_inicio'=>'',
            'fecha_fin'=>'',
            'registro'=>'',
            'imagen'=>'',
            'archivo_word'=>'',
            
        ];

        Validator::make($data, $rules, $message)->validate();

        $prototipo = Prototipo::findOrFail($id);
        $prototipo->producto = $request->get('producto');
        $prototipo->fecha_registro = Carbon::createFromFormat('d/m/Y', $request->get('fecha_registro'))->format('Y-m-d');
        $prototipo->fecha_inicio = Carbon::createFromFormat('d/m/Y', $request->get('fecha_inicio'))->format('Y-m-d');
        $prototipo->fecha_fin = Carbon::createFromFormat('d/m/Y', $request->get('fecha_fin'))->format('Y-m-d');
        $prototipo->registro = $request->get('registro');
        //$prototipos->imagen = $request->get('imagen');
        //$prototipos->archivo_word = $request->get('archivo_word');
        
        if($request->hasFile('imagen')){   
            //Eliminar Archivo anterior
            Storage::delete($prototipo->ruta_imagen);               
            //Agregar nuevo archivo
            $file = $request->file('imagen');
            $name = $file->getClientOriginalName();
            $prototipo->imagen = $name;
            $prototipo->ruta_imagen = $request->file('imagen')->store('public/prototipos');
        }
        if($request->hasFile('archivo_word')){ 
            //Eliminar Archivo anterior
            Storage::delete($prototipo->ruta_archivo_word);               
            //Agregar nuevo archivo               
            $file = $request->file('archivo_word');
            $name = $file->getClientOriginalName();
            $prototipo->archivo_word = $name;
            $prototipo->ruta_archivo_word = $request->file('archivo_word')->store('public/prototipos');
        }
        $prototipo->usuario_id = auth()->user()->id;
        $prototipo->save();

        $articulosJSON = $request->get('articulos_tabla');
        $articulotabla = json_decode($articulosJSON[0]);

        
        if ($articulotabla) {
            $Detalle_prototipos = Detalle_prototipo::where('prototipo_id', $prototipo->id)->get();
            foreach ($Detalle_prototipos as $Detalle_prototipo) {
                $Detalle_prototipo->delete();
            }
            foreach ($articulotabla as $detalle) {
                Detalle_prototipo::create([
                    'prototipo_id' => $prototipo->id,
                    'nombre_articulo' => $detalle->nombre_articulo,
                    'cantidad' => $detalle->cantidad,
                    'observacion'=> $detalle->observacion,
                ]);
            }
        }

        //Registro de actividad
        $descripcion = "SE MODIFICÓ EL PROTOTIPO DEL PRODUCTO CON EL NOMBRE: ". $prototipo->producto;
        $gestion = "PROTOTIPO";
        modificarRegistro( $prototipo, $descripcion , $gestion);

        Session::flash('success','Prototipo modificado.');
        return redirect()->route('invdesarrollo.prototipo.index')->with('modificar', 'success');
    }

    
    public function destroy($id)
    {
        
        $prototipos = Prototipo::findOrFail($id);
        $prototipos->estado = 'ANULADO';
        $prototipos->update();

        //Registro de actividad
        $descripcion = "SE ELIMINÓ EL PROTOTIPO DEL PRODUCTO CON EL NOMBRE: ". $prototipos->producto;
        $gestion = "PROTOTIPO";
        eliminarRegistro( $prototipos , $descripcion , $gestion);

        Session::flash('success','Prototipo eliminado.');
        return redirect()->route('invdesarrollo.prototipo.index')->with('eliminar', 'success');

    }

    public function show($id)
    {
        $prototipo = Prototipo::findOrFail($id);
        $detalles = Detalle_prototipo::where('prototipo_id',$id)->get(); 
        return view('invdesarrollo.prototipos.show', [
            'prototipo' => $prototipo,
            'detalles' => $detalles,
            'prototipo' => $prototipo, 
        ]);
    }

    public function report($id)
    {
        $prototipo = Prototipo::findOrFail($id);
        $detalles = Detalle_prototipo::where('prototipo_id',$id)->get();
        $paper_size = array(0,0,360,360);
        $pdf = PDF::loadview('invdesarrollo.prototipos.reportes.detalle',[
            'prototipo' => $prototipo,
            'detalles' => $detalles,
            'prototipos' => $prototipos, 
            ])->setPaper('a4')->setWarnings(false);
        return $pdf->stream();
    }
}
