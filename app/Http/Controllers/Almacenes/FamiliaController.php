<?php

namespace App\Http\Controllers\Almacenes;

use App\Almacenes\Familia;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DataTables;
use Carbon\Carbon;
use Session;
use Illuminate\Support\Facades\Validator;

class FamiliaController extends Controller
{

    public function index()
    {
        
        return view('almacenes.familias.index');
    }
        public function getfamilia(){
            $familias = Familia::where('estado','ACTIVO')->orderBy('id','DESC')->get();
            $coleccion = collect([]);
            foreach($familias as $familia){
                $coleccion->push([
                    'id' => $familia->id,
                    'familia' => $familia->familia,
                    'fecha_creacion' =>  Carbon::parse($familia->created_at)->format( 'd/m/Y'),
                    'fecha_actualizacion' =>  Carbon::parse($familia->updated_at)->format( 'd/m/Y'),
                    'estado' => $familia->estado,
                ]);
            }
            return DataTables::of($coleccion)->toJson();
    }

    public function store(Request $request){
        
        $data = $request->all();

        $rules = [
            'familia_guardar' => 'required',
            
        ];
        
        $message = [
            'familia_guardar.required' => 'El campo Categoria es obligatorio.',
            
        ];

        Validator::make($data, $rules, $message)->validate();

        $familia = new Familia();
        $familia->familia = $request->get('familia_guardar');
        $familia->save();

        //Registro de actividad
        $descripcion = "SE AGREGÓ LA CATEGORIA CON EL NOMBRE: ". $familia->familia;
        $gestion = "CATEGORIA PT";
        crearRegistro($familia, $descripcion , $gestion);

        Session::flash('success','Categoria creada.');
        return redirect()->route('almacenes.familias.index')->with('guardar', 'success');
    }

    public function update(Request $request){
       
        $data = $request->all();

        $rules = [
            'tabla_id' => 'required',
            'familia' => 'required',
            
        ];
        
        $message = [
            'familia.required' => 'El campo Categoria es obligatorio.',
            
        ];

        Validator::make($data, $rules, $message)->validate();
        
        $familia = Familia::findOrFail( $request->get('tabla_id'));
        $familia->familia = $request->get('familia');
        $familia->update();

        //Registro de actividad
        $descripcion = "SE MODIFICÓ LA CATEGORIA CON EL NOMBRE: ". $familia->familia;
        $gestion = "CATEGORIA PT";
        modificarRegistro($familia, $descripcion , $gestion);

        Session::flash('success','Categoria modificada.');
        return redirect()->route('almacenes.familias.index')->with('modificar', 'success');
    }

    
    public function destroy($id)
    {
        
        $familia = Familia::findOrFail($id);
        $familia->estado = 'ANULADO';
        $familia->update();

        //Registro de actividad
        $descripcion = "SE ELIMINÓ LA CATEGORIA CON EL NOMBRE: ". $familia->familia;
        $gestion = "CATEGORIA PT";
        eliminarRegistro($familia, $descripcion , $gestion);

        Session::flash('success','Familia eliminado.');
        return redirect()->route('almacenes.familias.index')->with('eliminar', 'success');

    }

    public function exist(Request $request)
    {
        
        $data = $request->all();
        $familia = $data['familia'];
        $id = $data['id'];
        $categoria = null;

        if ($familia && $id) { // edit
            $categoria = Familia::where([
                                    ['familia', $data['familia']],
                                    ['id', '<>', $data['id']]
                                ])->where('estado','!=','ANULADO')->first();
        } else if ($familia && !$id) { // create
            $categoria = Familia::where('familia', $data['familia'])->where('estado','!=','ANULADO')->first();
        }

        $result = ['existe' => ($categoria) ? true : false];

        return response()->json($result);

    }
}


