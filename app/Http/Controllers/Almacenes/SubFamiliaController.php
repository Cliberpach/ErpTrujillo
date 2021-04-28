<?php

namespace App\Http\Controllers\Almacenes;

use App\Http\Controllers\Controller;
use App\Almacenes\Familia;
use App\Almacenes\SubFamilia;
use Illuminate\Http\Request;
use DB;
use DataTables;
use Carbon\Carbon;
use Session;
use Illuminate\Support\Facades\Validator;

class SubFamiliaController extends Controller
{
 
    public function index()
    {
        $familias = Familia::where('estado','ACTIVO')->get();
        return view('almacenes.subfamilias.index',[
            'familias' => $familias
        ]);
    }

    public function getSub(){

        $subfamilias = DB::table('subfamilias')
        ->join('familias','subfamilias.familia_id','=','familias.id')
        ->select('familias.familia as nombre_familia','familias.id as familia_id','subfamilias.*')
        ->where('subfamilias.estado','!=',"ANULADO")
        ->orderby('subfamilias.id','DESC')
        ->get();
        $coleccion = collect([]);
        foreach($subfamilias as $subfamilia){
            $coleccion->push([
                'id' => $subfamilia->id,
                'familia_id' => $subfamilia->familia_id,
                'familia' => $subfamilia->nombre_familia,
                'descripcion' => $subfamilia->descripcion,
                'creado' =>  Carbon::parse($subfamilia->created_at)->format( 'd/m/Y'),
                'actualizado' =>  Carbon::parse($subfamilia->updated_at)->format( 'd/m/Y'),
                'estado' => $subfamilia->estado,
            ]);
        }
        return DataTables::of($coleccion)->toJson();
    }

    public function store(Request $request){
        $data = $request->all();

        $rules = [
            'descripcion' => 'required',
            'familia_id' => 'required',
        ];
        
        $message = [
            'descripcion.required' => 'El campo Descripción es obligatorio.',
            'familia_id.required' => 'El campo Familia es obligatorio.',
        ];

        Validator::make($data, $rules, $message)->validate();

        $subfamilia = new SubFamilia();
        $subfamilia->descripcion = $request->get('descripcion');
        $subfamilia->familia_id = $request->get('familia_id');
        $subfamilia->save();


        //Registro de actividad
        $descripcion = "SE AGREGÓ LA SUB CATEGORIA CON EL NOMBRE: ". $subfamilia->descripcion;
        $gestion = "SUB CATEGORIA PT";
        crearRegistro($subfamilia, $descripcion , $gestion);
      

        Session::flash('success','Sub categoria creada.');
        return redirect()->route('almacenes.subfamilia.index')->with('guardar', 'success');
    }

    public function update(Request $request){
        
        $data = $request->all();

        $rules = [
            'familia_id_editar' => 'required',
            'descripcion_editar' => 'required',
        ];
        
        $message = [
            'descripcion_editar.required' => 'El campo Descripción es obligatorio.',
        ];

        Validator::make($data, $rules, $message)->validate();
        
        $subfamilia = SubFamilia::findOrFail($request->get('sub_familia_id_editar'));
        $subfamilia->descripcion = $request->get('descripcion_editar');
        $subfamilia->familia_id = $request->get('familia_id_editar');
        $subfamilia->update();

        //Registro de actividad
        $descripcion = "SE MODIFICÓ LA SUB CATEGORIA CON EL NOMBRE: ". $subfamilia->descripcion;
        $gestion = "SUB CATEGORIA PT";
        modificarRegistro($subfamilia, $descripcion , $gestion);

        Session::flash('success','Sub categoria modificada.');
        return redirect()->route('almacenes.subfamilia.index')->with('modificar', 'success');
    }

    
    public function destroy($id)
    {
        
        $subfamilia = SubFamilia::findOrFail($id);
        $subfamilia->estado = 'ANULADO';
        $subfamilia->update();

        //Registro de actividad
        $descripcion = "SE ELIMINÓ LA SUB CATEGORIA CON EL NOMBRE: ". $subfamilia->descripcion;
        $gestion = "SUB CATEGORIA PT";
        eliminarRegistro($subfamilia, $descripcion , $gestion);

        Session::flash('success','Sub categoria eliminada.');
        return redirect()->route('almacenes.subfamilia.index')->with('eliminar', 'success');

    }

    public function getFamilia(){

        $familias = DB::table('familias')   
        ->select('familias.*')
        ->where('familias.estado','!=',"ANULADO")
        ->get();

        return $familias;
    }

    public function getByFamilia(Request $request)
    {
        
        $error = false;
        $message = "";
        $data= null;
        $collection = collect([]);

        if (!is_null($request->familia_id)) {
         
            $sub = SubFamilia::where('familia_id',$request->familia_id)->where('estado','!=','ANULADO')->get();
            

            foreach ($sub as $sub_familia) {
                $collection->push([
                    'id' => $sub_familia->id,
                    'text' => $sub_familia->descripcion
                ]);
            }

            return $collection;
        } else {
            $error = true;
            $message = "Error interno del servidor";
        }
    }


    public function getBySubFamilia($id)
    {
        $sub = SubFamilia::where('familia_id',$id)->where('estado','!=','ANULADO')->get();
        return $sub;
    }


    public function exist(Request $request)
    {
        // dd($request);
        $data = $request->all();
        $familia = $data['familia'];
        $familia2 = $data['familia_2'];
        $id = $data['id'];
        $categoria = null;

        if ($familia && $id && $familia2) { // edit
            $categoria = SubFamilia::where([
                                    ['descripcion', $data['familia']],
                                    ['familia_id', $data['familia_2']],
                                    ['id', '<>', $data['id']]
                                ])->where('estado','!=','ANULADO')->first();
        } else if ($familia && $familia2  && !$id) { // create
            $categoria = SubFamilia::where('descripcion', $data['familia'])->where('familia_id', $data['familia_2'])->where('estado','!=','ANULADO')->first();
        }

        $result = ['existe' => ($categoria) ? true : false];

        return response()->json($result);

    }

}
