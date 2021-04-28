<?php

namespace App\Http\Controllers\Compras;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Compras\Categoria;
use DataTables;
use Carbon\Carbon;
use Session;
use Illuminate\Support\Facades\Validator;

class CategoriaController extends Controller
{
    public function index()
    {
        return view('compras.categorias.index');
    }
    public function getCategory(){
        $categorias = Categoria::where('estado','ACTIVO')->get();
        $coleccion = collect([]);
        foreach($categorias as $categoria){
            $coleccion->push([
                'id' => $categoria->id,
                'descripcion' => $categoria->descripcion,
                'fecha_creacion' =>  Carbon::parse($categoria->created_at)->format( 'd/m/Y'),
                'fecha_actualizacion' =>  Carbon::parse($categoria->updated_at)->format( 'd/m/Y'),
                'estado' => $categoria->estado,
            ]);
        }
        return DataTables::of($coleccion)->toJson();
    }

    public function store(Request $request){
        
        $data = $request->all();

        $rules = [
            'descripcion_guardar' => 'required',
        ];
        
        $message = [
            'descripcion_guardar.required' => 'El campo Descripción es obligatorio.',
        ];

        Validator::make($data, $rules, $message)->validate();

        $categoria = new Categoria();
        $categoria->descripcion = $request->get('descripcion_guardar');
        $categoria->save();

        //Registro de actividad
        $descripcion = "SE AGREGÓ LA CATEGORIA CON LA DESCRIPCION: ". $categoria->descripcion;
        $gestion = "CATEGORIA";
        crearRegistro($categoria, $descripcion , $gestion);

        Session::flash('success','Categoria creada.');
        return redirect()->route('compras.categoria.index')->with('guardar', 'success');
    }

    public function update(Request $request){
        
        $data = $request->all();

        $rules = [
            'tabla_id' => 'required',
            'descripcion' => 'required',
        ];
        
        $message = [
            'descripcion.required' => 'El campo Descripción es obligatorio.',
        ];

        Validator::make($data, $rules, $message)->validate();
        
        $categoria = Categoria::findOrFail($request->get('tabla_id'));
        $categoria->descripcion = $request->get('descripcion');
        $categoria->update();

        //Registro de actividad
        $descripcion = "SE MODIFICÓ LA CATEGORIA CON LA DESCRIPCION: ". $categoria->descripcion;
        $gestion = "CATEGORIA";
        modificarRegistro($categoria, $descripcion , $gestion);

        Session::flash('success','Categoria modificado.');
        return redirect()->route('compras.categoria.index')->with('modificar', 'success');
    }

    
    public function destroy($id)
    {
        
        $categoria = Categoria::findOrFail($id);
        $categoria->estado = 'ANULADO';
        $categoria->update();

        //Registro de actividad
        $descripcion = "SE ELIMINÓ LA CATEGORIA CON LA DESCRIPCION: ". $categoria->descripcion;
        $gestion = "CATEGORIA";
        eliminarRegistro($categoria, $descripcion , $gestion);

        Session::flash('success','Categoria eliminado.');
        return redirect()->route('compras.categoria.index')->with('eliminar', 'success');

    }

}
