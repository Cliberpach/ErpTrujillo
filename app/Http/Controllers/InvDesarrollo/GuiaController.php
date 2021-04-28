<?php

namespace App\Http\Controllers\InvDesarrollo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\InvDesarrollo\Guia;
use App\InvDesarrollo\Detalle_guia;
use App\Almacenes\Producto;
use App\InvDesarrollo\Prototipo;
// use App\InvDesarrollo\Enviado;
// use App\Mantenimiento\Empresa\Empresa;
use App\Compras\Articulo;
use DataTables;
use Carbon\Carbon;
use Session;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use PDF;
use Illuminate\Support\Facades\Mail;
//use App\Mail\GuiaCompra;
use Illuminate\Support\Facades\Auth;
use DB;

class GuiaController extends Controller
{
    public function index()
    {
        return view('invdesarrollo.guias.index');
    }

    public function getGuia(){

        $guias =  DB::table('guias')
            ->join('prototipos','prototipos.id','=','guias.prototipo_id')
            ->where('guias.estado','!=','ANULADO')   
            ->select('guias.*','prototipos.producto')         
            ->get();

        $coleccion = collect([]);
        foreach($guias as $guia){
            //$Detalle_guias = Detalle_guia::where('Guia_id',$guia->id)->get(); 

            $coleccion->push([
                'id' => $guia->id,
                'producto' => $guia->producto,
                'unidades_a_producir' => $guia->unidades_a_producir,
                'area_responsable1' => $guia->area_responsable1,
                'area_responsable2' => $guia->area_responsable2,
                'fecha' =>  Carbon::parse($guia->fecha)->format( 'd/m/Y'),
                'observacion' => $guia->observacion,
                'usuario_id' => $guia->usuario_id,
                'estado' => $guia->estado,
            ]);
        }
  
        return DataTables::of($coleccion)->toJson();
    }

    public function create()
    {
        $articulos = Articulo::where('estado','ACTIVO')->get();
        $fecha_hoy = Carbon::now()->toDateString();
        $prototipos = Prototipo::where('estado','ACTIVO')->get();
        $presentaciones =  presentaciones();

        return view('invdesarrollo.guias.create',[
            'articulos' => $articulos, 
            'prototipos' => $prototipos, 
            'fecha_hoy' => $fecha_hoy,
            'presentaciones'  => $presentaciones, 
        ]);
    }

    
    public function edit($id)
    {
        $detalles = Detalle_guia::where('Guia_id',$id)->get();     
        $guia = Guia::findOrFail($id);
        $prototipos = Prototipo::where('estado','ACTIVO')->get();
        $articulos = Articulo::where('estado','ACTIVO')->get();
        $fecha_hoy = Carbon::now()->toDateString();
        $presentaciones =  presentaciones();

        return view('invdesarrollo.guias.edit',[
            'guia' => $guia,
            'articulos' => $articulos, 
            'fecha_hoy' => $fecha_hoy, 
            'detalles' => $detalles,
            'prototipos' => $prototipos, 
            'presentaciones'  => $presentaciones, 
        ]);
    }

    public function store(Request $request){
        $data = $request->all();
        $rules = [
            'prototipo_id'=>'required',
            'unidades_a_producir'=>'required',
            'area_responsable1'=>'max:191',
            'area_responsable2'=>'max:191',
            'fecha'=>'',
            'observacion'=>'max:191',
        ];
        $message = [
            'prototipo_id.required'=>'Producto es Obligatorio',
            'unidades_a_producir.required'=>'Unidades a producir es obligatorio',
            'area_responsable1'=>'Tamaño Maximo 191',
            'area_responsable2'=>'Tamaño Maximo 191',
            'fecha'=>'',
            'observacion'=>'Tamaño Maximo 191',
        ];
        Validator::make($data, $rules, $message)->validate();

        $guia = new Guia();        
        $guia->prototipo_id=$request->get('prototipo_id');
        $guia->unidades_a_producir=$request->get('unidades_a_producir');
        $guia->area_responsable1=$request->get('area_responsable1');
        $guia->area_responsable2=$request->get('area_responsable2');
        $guia->fecha=Carbon::createFromFormat('d/m/Y', $request->get('fecha'))->format('Y-m-d');
        $guia->observacion=$request->get('observacion');
        //$guia->usuario_id=$request->get('usuario_id');
        $guia->usuario_id = auth()->user()->id;
        $guia->save();


        //Llenado de los articulos
        $articulosJSON = $request->get('articulos_tabla');
        $articulotabla = json_decode($articulosJSON[0]);

        foreach ($articulotabla as $articulo) {
            Detalle_guia::create([
                'guia_id' => $guia->id,
                'articulo_id' => $articulo->articulo_id,
                'cantidad_solicitada' => $articulo->cantidad_solicitada,
                'cantidad_entregada' => $articulo->cantidad_entregada,
                'cantidad_devuelta' => $articulo->cantidad_devuelta,
                'observacion'=> $articulo->observacion,
            ]);
        }

        //Registro de actividad
        $descripcion = "SE AGREGÓ LA GUIA INTERNA DEL PROTOTIPO CON EL NOMBRE: ". $guia->prototipo->producto;
        $gestion = "GUIA INTERNA";
        crearRegistro($guia, $descripcion , $gestion);

        Session::flash('success','Guia Interna creada.');
        return redirect()->route('invdesarrollo.guia.index')->with('guardar', 'success');
    }

    public function update(Request $request, $id){
        $data = $request->all();
        $rules = [
            'prototipo_id'=>'required',
            'unidades_a_producir'=>'required',
            'area_responsable1'=>'max:191',
            'area_responsable2'=>'max:191',
            'fecha'=>'',
            'observacion'=>'max:191',
        ];
        $message = [
            'prototipo_id.required'=>'Producto es Obligatorio',
            'unidades_a_producir.required'=>'Unidades a producir es obligatorio',
            'area_responsable1'=>'Tamaño Maximo 191',
            'area_responsable2'=>'Tamaño Maximo 191',
            'fecha'=>'',
            'observacion'=>'Tamaño Maximo 191',
        ];
        Validator::make($data, $rules, $message)->validate();

        $guia = Guia::findOrFail($id);        
        $guia->prototipo_id=$request->get('prototipo_id');
        $guia->unidades_a_producir=$request->get('unidades_a_producir');
        $guia->area_responsable1=$request->get('area_responsable1');
        $guia->area_responsable2=$request->get('area_responsable2');
        //dd('*'.$request->get('fecha').'*');
        //$guia->fecha=Carbon::createFromFormat('d/m/Y', $request->get('fecha'))->format('Y-m-d');
        $guia->observacion=$request->get('observacion');
        // $guia->usuario_id=$request->get('usuario_id');
        $guia->usuario_id = auth()->user()->id;
        $guia->save();

        $articulosJSON = $request->get('articulos_tabla');
        $articulotabla = json_decode($articulosJSON[0]);

        if ($articulotabla) {
            $Detalle_guias = Detalle_guia::where('Guia_id', $guia->id)->get();
            foreach ($Detalle_guias as $Detalle_guia) {
                $Detalle_guia->delete();
            }
            foreach ($articulotabla as $articulo) {
                Detalle_guia::create([
                    'guia_id' => $guia->id,
                    'articulo_id' => $articulo->articulo_id,
                    'cantidad_solicitada' => $articulo->cantidad_solicitada,
                    'cantidad_entregada' => $articulo->cantidad_entregada,
                    'cantidad_devuelta' => $articulo->cantidad_devuelta,
                    'observacion' => $articulo->observacion,
                ]);
            }
        }

        //Registro de actividad
        $descripcion = "SE MODIFICÓ LA GUIA INTERNA DEL PROTOTIPO CON EL NOMBRE: ". $guia->prototipo->producto;
        $gestion = "GUIA INTERNA";
        modificarRegistro($guia, $descripcion , $gestion);
        
        Session::flash('success','Guia Interna modificada.');
        return redirect()->route('invdesarrollo.guia.index')->with('modificar', 'success');
    }

    public function destroy($id)
    {
        
        $guia = Guia::findOrFail($id);
        $guia->estado = 'ANULADA';
        $guia->update();

        //Registro de actividad
        $descripcion = "SE ELIMINÓ LA GUIA INTERNA DEL PRODUCTO CON EL NOMBRE: ". $guia->producto->nombre;
        $gestion = "GUIA INTERNA";
        eliminarRegistro($guia, $descripcion , $gestion);

        Session::flash('success','Guia Interna eliminada.');
        return redirect()->route('invdesarrollo.guia.index')->with('eliminar', 'success');

    }

    public function show($id)
    {
        $guia = Guia::findOrFail($id);
        $detalles = Detalle_guia::where('guia_id',$id)->get(); 
        $prototipos = Prototipo::where('estado','ACTIVO')->get();
        return view('invdesarrollo.guias.show', [
            'guia' => $guia,
            'detalles' => $detalles,
            'prototipos' => $prototipos, 
        ]);
    }

    public function report($id)
    {
        $guia = Guia::findOrFail($id);
        $detalles = Detalle_guia::where('guia_id',$id)->get();
        $prototipos = Prototipo::where('estado','ACTIVO')->get();
        $paper_size = array(0,0,360,360);
        $pdf = PDF::loadview('invdesarrollo.guias.reportes.detalle',[
            'guia' => $guia,
            'detalles' => $detalles,
            'prototipos' => $prototipos, 
            ])->setPaper('a4')->setWarnings(false);
        //dd($pdf);
        //$pdf= new Dompdf();
        //$pdf->loadHtml('hello world');
        return $pdf->stream();
    }
}
