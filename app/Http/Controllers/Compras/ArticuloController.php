<?php

namespace App\Http\Controllers\Compras;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use Carbon\Carbon;
use App\Compras\Articulo;
use App\Compras\Categoria;
use App\Almacenes\Almacen;
use Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use DB;
use Illuminate\Validation\Rule;

class ArticuloController extends Controller
{
    public function index()
    {
        return view('compras.articulos.index');
    }

    public function getArticles(){
        return datatables()->query(
            DB::table('articulos')
            ->join('categorias', 'articulos.categoria_id', '=', 'categorias.id')
            ->select('articulos.*','categorias.descripcion as categoria')
            ->where('articulos.estado','ACTIVO')
        )->toJson();
    }

    public function create()
    {
        $categorias = Categoria::where('estado','ACTIVO')->get();
        $almacenes = Almacen::where('estado','ACTIVO')->get();
        $presentaciones = presentaciones();
        
        return view('compras.articulos.create',[
            'categorias' => $categorias,
            'presentaciones' => $presentaciones,
            'almacenes' => $almacenes,
        ]);
    }

    public function edit($id)
    {
        $articulo = Articulo::findOrFail($id);
        $categorias = Categoria::where('estado','ACTIVO')->get();
        $almacenes = Almacen::where('estado','ACTIVO')->get();
        $presentaciones = presentaciones();
        
        return view('compras.articulos.edit',[
            'categorias' => $categorias,
            'presentaciones' => $presentaciones,
            'almacenes' => $almacenes,
            'articulo' => $articulo,
        ]);
    }

    public function store(Request $request){

        $data = $request->all();

        $rules = [
            'descripcion' => 'required',
            'codigo_fabrica' => ['required',Rule::unique('articulos','codigo_fabrica')->where(function ($query) {
                $query->whereIn('estado',["ACTIVO"]);
            })],
            'codigo_barra' => ['nullable',Rule::unique('articulos','codigo_barra')->where(function ($query) {
                $query->whereIn('estado',["ACTIVO"]);
            })],
            'categoria' => 'required',
            'presentacion' => 'required',
            'almacen' => 'required',
            'stock' => 'nullable|integer',
            'stock_min' => 'required|integer',
            'precio_compra' => 'required|numeric',
            'unidad' => 'required',

        ];
        
        $message = [
            'codigo_fabrica.required' => 'El campo Código de Fábrica es obligatorio.',
            'codigo_fabrica.unique' => 'El campo Código de Fábrica debe de ser único.',
            'codigo_barra.unique' => 'El campo Código de Barra debe de ser único.',
            'descripcion.required' => 'El campo Descripción es obligatorio.',
            'categoria.required'=> 'El campo Categoria es obligatorio.',
            'presentacion.required'=> 'El campo Presentación es obligatorio.',
            'almacen.required'=>'El campo Almacen es obligatorio.',
            'stock.integer' => 'El campo Stock debe ser Entero.',
            'unidad.integer' => 'El campo Unidad de Medida es obligatorio.',

            'stock_min.integer' => 'El campo Stock Min. debe ser Entero.',
            'stock_min.required' => 'El campo Stock Min. es obligatorio.',

            'precio_compra.required' => 'El campo Precio de Compra es obligatorio.',
            'precio_compra.numeric' => 'El campo Precio de Compra debe ser Numeric.',
        ];

        Validator::make($data, $rules, $message)->validate();
        

        $articulo = new Articulo();
        $articulo->descripcion = $request->get('descripcion');
        $articulo->codigo_fabrica = $request->get('codigo_fabrica');
        $articulo->categoria_id = $request->get('categoria');
        $articulo->almacen_id = $request->get('almacen');
        $articulo->presentacion = $request->get('presentacion');
        $articulo->stock = $request->get('stock');
        $articulo->stock_min = $request->get('stock_min');
        $articulo->precio_compra = $request->get('precio_compra');
        $articulo->codigo_barra = $request->get('codigo_barra');
        $articulo->unidad_medida = $request->get('unidad');
        $articulo->save();

        //Registro de actividad
        $descripcion = "SE AGREGÓ EL ARTICULO CON LA DESCRIPCION: ". $articulo->descripcion;
        $gestion = "ARTICULO";
        crearRegistro($articulo, $descripcion , $gestion);

        Session::flash('success','Artículo creada.');
        return redirect()->route('compras.articulo.index')->with('guardar', 'success');
    }

    public function update(Request $request, $id){
        $data = $request->all();

        $rules = [
            'descripcion' => 'required',
            'codigo_fabrica' => ['required',Rule::unique('articulos','codigo_fabrica')->where(function ($query) {
                $query->whereIn('estado',["ACTIVO"]);
            })->ignore($id)],
            'codigo_barra' => ['nullable',Rule::unique('articulos','codigo_barra')->where(function ($query) {
                $query->whereIn('estado',["ACTIVO"]);
            })->ignore($id)],
            'categoria' => 'required',
            'presentacion' => 'required',
            'almacen' => 'required',
            'stock' => 'nullable|integer',
            'stock_min' => 'required|integer',
            'precio_compra' => 'required|numeric',
            'unidad' => 'required',

        ];
        
        $message = [
            'descripcion.required' => 'El campo Descripción es obligatorio.',
            
            'codigo_fabrica.required' => 'El campo Código de Fábrica es obligatorio.',
            'codigo_fabrica.unique' => 'El campo Código de Fábrica debe de ser único.',
            'codigo_barra.unique' => 'El campo Código de Barra debe de ser único.',

            'categoria.required'=> 'El campo Categoria es obligatorio.',
            'presentacion.required'=> 'El campo Presentación es obligatorio.',
            'almacen.required'=>'El campo Almacen es obligatorio.',
            'stock.integer' => 'El campo Stock debe ser Entero.',

            'unidad.integer' => 'El campo Unidad de Medida es obligatorio.',

            'stock_min.integer' => 'El campo Stock Min. debe ser Entero.',
            'stock_min.required' => 'El campo Stock Min. es obligatorio.',
            

            'precio_compra.required' => 'El campo Precio de Compra es obligatorio.',
            'precio_compra.numeric' => 'El campo Precio de Compra debe ser Numeric.',
        ];

        Validator::make($data, $rules, $message)->validate();
        
        $articulo = Articulo::findOrFail($id);
        $articulo->descripcion = $request->get('descripcion');
        $articulo->codigo_fabrica = $request->get('codigo_fabrica');
        $articulo->categoria_id = $request->get('categoria');
        $articulo->almacen_id = $request->get('almacen');
        $articulo->presentacion = $request->get('presentacion');
        $articulo->stock = $request->get('stock');
        $articulo->stock_min = $request->get('stock_min');
        $articulo->precio_compra = $request->get('precio_compra');
        $articulo->codigo_barra = $request->get('codigo_barra');
        $articulo->unidad_medida = $request->get('unidad');
        $articulo->update();

        //Registro de actividad
        $descripcion = "SE MODIFICÓ EL ARTICULO CON LA DESCRIPCION: ". $articulo->descripcion;
        $gestion = "ARTICULO";
        modificarRegistro($articulo, $descripcion , $gestion);

        Session::flash('success','Artículo modificada.');
        return redirect()->route('compras.articulo.index')->with('modificar', 'success');

    }

    public function destroy($id)
    {
        
        $articulo = Articulo::findOrFail($id);
        $articulo->estado = 'ANULADO';
        $articulo->update();

        //Registro de actividad
        $descripcion = "SE ELIMINÓ EL ARTICULO CON LA DESCRIPCION: ". $articulo->descripcion;
        $gestion = "ARTICULO";
        eliminarRegistro($articulo, $descripcion , $gestion);

        Session::flash('success','Artículo eliminado.');
        return redirect()->route('compras.articulo.index')->with('eliminar', 'success');

    }

    public function show($id)
    {
        $articulo = Articulo::findOrFail($id);
        return view('compras.articulos.show', [
            'articulo' => $articulo 
        ]);

    }

    public function getArticle($id)
    {
        $articulo = Articulo::findOrFail($id);
        return $articulo;
    }



}
