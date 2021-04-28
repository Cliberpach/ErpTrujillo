<?php

namespace App\Http\Controllers\Mantenimiento\Vendedor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mantenimiento\Vendedor\Vendedor;
use App\Mantenimiento\Colaborador\Colaborador;
use App\Mantenimiento\Persona\Persona;
use Carbon\Carbon;
use DataTables;
use Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class VendedorController extends Controller
{
    public function index()
    {
        return view('mantenimiento.vendedores.index');
    }

    public function getTable()
    {
        $vendedores = Vendedor::where('estado','ACTIVO')->get();
        $coleccion = collect([]);
        foreach($vendedores as $vendedor){
            $coleccion->push([
                'id' => $vendedor->id,
                'documento' => $vendedor->empleado->persona->getDocumento(),
                'apellidos_nombres' => $vendedor->empleado->persona->getApellidosYNombres(),
                'telefono_movil' => $vendedor->empleado->persona->telefono_movil,
                'area' => $vendedor->empleado->area,
                'zona' => $vendedor->zona
            ]);
        }
        return DataTables::of($coleccion)->toJson();
    }

    public function create()
    {
        return view('mantenimiento.vendedores.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        DB::transaction(function () use ($request) {

            $persona = new Persona();
            $persona->tipo_documento = $request->get('tipo_documento');
            $persona->documento = $request->get('documento');
            $persona->codigo_verificacion = $request->get('codigo_verificacion');
            $persona->nombres = $request->get('nombres');
            $persona->apellido_paterno = $request->get('apellido_paterno');
            $persona->apellido_materno = $request->get('apellido_materno');
            $persona->fecha_nacimiento = Carbon::createFromFormat('d/m/Y', $request->get('fecha_nacimiento'))->format('Y-m-d') ;
            $persona->sexo = $request->get('sexo');
            $persona->estado_civil = $request->get('estado_civil');
            $persona->departamento_id = str_pad($request->get('departamento'), 2, "0", STR_PAD_LEFT);
            $persona->provincia_id = str_pad($request->get('provincia'), 4, "0", STR_PAD_LEFT);
            $persona->distrito_id = str_pad($request->get('distrito'), 6, "0", STR_PAD_LEFT);
            $persona->direccion = $request->get('direccion');
            $persona->correo_electronico = $request->get('correo_electronico');
            $persona->telefono_movil = $request->get('telefono_movil');
            $persona->telefono_fijo = $request->get('telefono_fijo');
            $persona->estado_documento = $request->get('estado_documento');
            $persona->save();

            $Colaborador= new Colaborador();
            $Colaborador->persona_id = $persona->id;
            $Colaborador->area = $request->get('area');
            $Colaborador->profesion = $request->get('profesion');
            $Colaborador->cargo = $request->get('cargo');
            $Colaborador->telefono_referencia = $request->get('telefono_referencia');
            $Colaborador->contacto_referencia = $request->get('contacto_referencia');
            $Colaborador->grupo_sanguineo = $request->get('grupo_sanguineo');
            $Colaborador->alergias = $request->get('alergias');
            $Colaborador->numero_hijos = $request->get('numero_hijos');
            $Colaborador->sueldo = $request->get('sueldo');
            $Colaborador->sueldo_bruto = $request->get('sueldo_bruto');
            $Colaborador->sueldo_neto = $request->get('sueldo_neto');
            $Colaborador->moneda_sueldo = $request->get('moneda_sueldo');
            $Colaborador->tipo_banco = $request->get('tipo_banco');
            $Colaborador->numero_cuenta = $request->get('numero_cuenta');

            if($request->hasFile('imagen')){
                $file = $request->file('imagen');
                $name = $file->getClientOriginalName();
                $Colaborador->nombre_imagen = $name;
                $Colaborador->ruta_imagen = $request->file('imagen')->store('public/vendedores/imagenes');
            }

            $Colaborador->fecha_inicio_actividad = Carbon::createFromFormat('d/m/Y', $request->get('fecha_inicio_actividad'))->format('Y-m-d') ;
            if (!is_null($request->get('fecha_fin_actividad'))) {
                $Colaborador->fecha_fin_actividad = Carbon::createFromFormat('d/m/Y', $request->get('fecha_fin_actividad'))->format('Y-m-d') ;
            }
            if (!is_null($request->get('fecha_inicio_planilla'))) {
                $Colaborador->fecha_inicio_planilla = Carbon::createFromFormat('d/m/Y', $request->get('fecha_inicio_planilla'))->format('Y-m-d') ;
            }
            if (!is_null($request->get('fecha_fin_planilla'))) {
                $Colaborador->fecha_fin_planilla = Carbon::createFromFormat('d/m/Y', $request->get('fecha_fin_planilla'))->format('Y-m-d') ;
            }
            $Colaborador->save();

            $vendedor = new Vendedor();
            $vendedor->colaborador_id = $Colaborador->id;
            $vendedor->zona = $request->get('zona');
            $vendedor->comision = $request->get('comision');
            $vendedor->moneda_comision = $request->get('moneda_comision');
            $vendedor->save();

            //Registro de actividad
            $descripcion = "SE AGREGÓ EL VENDEDOR CON EL NOMBRE: ". $vendedor->empleado->persona->nombres.' '.$vendedor->empleado->persona->apellido_paterno.' '.$vendedor->empleado->persona->apellido_materno;
            $gestion = "VENDEDORES";
            crearRegistro($vendedor, $descripcion , $gestion);

        });



        Session::flash('success','Vendedor creado.');
        return redirect()->route('mantenimiento.vendedor.index')->with('guardar', 'success');
    }

    public function edit($id)
    {
        $vendedor = Vendedor::findOrFail($id);
        return view('mantenimiento.vendedores.edit', [
            'vendedor' => $vendedor
        ]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $vendedor = Vendedor::findOrFail($id);

        DB::transaction(function () use ($request, $vendedor) {

            $persona =  $vendedor->empleado->persona;
            $persona->tipo_documento = $request->get('tipo_documento');
            $persona->documento = $request->get('documento');
            $persona->codigo_verificacion = $request->get('codigo_verificacion');
            $persona->nombres = $request->get('nombres');
            $persona->apellido_paterno = $request->get('apellido_paterno');
            $persona->apellido_materno = $request->get('apellido_materno');
            $persona->fecha_nacimiento = Carbon::createFromFormat('d/m/Y', $request->get('fecha_nacimiento'))->format('Y-m-d') ;
            $persona->sexo = $request->get('sexo');
            $persona->estado_civil = $request->get('estado_civil');
            $persona->departamento_id = str_pad($request->get('departamento'), 2, "0", STR_PAD_LEFT);
            $persona->provincia_id = str_pad($request->get('provincia'), 4, "0", STR_PAD_LEFT);
            $persona->distrito_id = str_pad($request->get('distrito'), 6, "0", STR_PAD_LEFT);
            $persona->direccion = $request->get('direccion');
            $persona->correo_electronico = $request->get('correo_electronico');
            $persona->telefono_movil = $request->get('telefono_movil');
            $persona->telefono_fijo = $request->get('telefono_fijo');
            $persona->estado_documento = $request->get('estado_documento');
            $persona->update();

            $empleado = $persona->empleado;
            $empleado->persona_id = $persona->id;
            $empleado->area = $request->get('area');
            $empleado->profesion = $request->get('profesion');
            $empleado->cargo = $request->get('cargo');
            $empleado->telefono_referencia = $request->get('telefono_referencia');
            $empleado->contacto_referencia = $request->get('contacto_referencia');
            $empleado->grupo_sanguineo = $request->get('grupo_sanguineo');
            $empleado->alergias = $request->get('alergias');
            $empleado->numero_hijos = $request->get('numero_hijos');
            $empleado->sueldo = $request->get('sueldo');
            $empleado->sueldo_bruto = $request->get('sueldo_bruto');
            $empleado->sueldo_neto = $request->get('sueldo_neto');
            $empleado->moneda_sueldo = $request->get('moneda_sueldo');
            $empleado->tipo_banco = $request->get('tipo_banco');
            $empleado->numero_cuenta = $request->get('numero_cuenta');

            if($request->hasFile('imagen')){
                //Eliminar Archivo anterior
                Storage::delete($vendedor->empleado->ruta_imagen);
                //Agregar nuevo archivo
                $file = $request->file('imagen');
                $name = $file->getClientOriginalName();
                $empleado->nombre_imagen = $name;
                $empleado->ruta_imagen = $request->file('imagen')->store('public/vendedores/imagenes');
            }else{
                if ($empleado->ruta_imagen) {
                    //Eliminar Archivo anterior
                    Storage::delete($empleado->ruta_imagen);
                    $empleado->nombre_imagen = '';
                    $empleado->ruta_imagen = '';
                }
            }

            $empleado->fecha_inicio_actividad = Carbon::createFromFormat('d/m/Y', $request->get('fecha_inicio_actividad'))->format('Y-m-d') ;
            if (!is_null($request->get('fecha_fin_actividad'))) {
                $empleado->fecha_fin_actividad = Carbon::createFromFormat('d/m/Y', $request->get('fecha_fin_actividad'))->format('Y-m-d') ;
            }
            if (!is_null($request->get('fecha_inicio_planilla'))) {
                $empleado->fecha_inicio_planilla = Carbon::createFromFormat('d/m/Y', $request->get('fecha_inicio_planilla'))->format('Y-m-d') ;
            }
            if (!is_null($request->get('fecha_fin_planilla'))) {
                $empleado->fecha_fin_planilla = Carbon::createFromFormat('d/m/Y', $request->get('fecha_fin_planilla'))->format('Y-m-d') ;
            }
            $empleado->update();

            $vendedor->colaborador_id = $vendedor->empleado->id;
            $vendedor->zona = $request->get('zona');
            $vendedor->comision = $request->get('comision');
            $vendedor->moneda_comision = $request->get('moneda_comision');
            $vendedor->update();

            //Registro de actividad
            $descripcion = "SE MODIFICÓ EL VENDEDOR CON EL NOMBRE: ".$vendedor->empleado->persona->nombres.' '.$vendedor->empleado->persona->apellido_paterno.' '.$vendedor->empleado->persona->apellido_materno;
            $gestion = "VENDEDORES";
            modificarRegistro($vendedor, $descripcion , $gestion);

        });



        Session::flash('success','Vendedor modificado.');
        return redirect()->route('mantenimiento.vendedor.index')->with('modificar', 'success');
    }

    public function show($id)
    {
        $vendedor = Vendedor::findOrFail($id);
        return view('mantenimiento.vendedores.show', [
            'vendedor' => $vendedor
        ]);
    }

    public function destroy($id)
    {
        DB::transaction(function() use ($id) {

            $vendedor = Vendedor::findOrFail($id);
            $vendedor->estado = 'ANULADO';
            $vendedor->update();

            $empleado = $vendedor->empleado;
            $empleado->estado = 'ANULADO';
            $empleado->update();

            $persona = $vendedor->empleado->persona;
            $persona->estado = 'ANULADO';
            $persona->update();

            //Registro de actividad
            $descripcion = "SE ELIMINÓ EL VENDEDOR CON EL NOMBRE: ". $vendedor->empleado->persona->nombres.' '.$vendedor->empleado->persona->apellido_paterno.' '.$vendedor->empleado->persona->apellido_materno;
            $gestion = "VENDEDORES";
            eliminarRegistro($vendedor, $descripcion , $gestion);

        });


        

        Session::flash('success','Vendedor eliminado.');
        return redirect()->route('mantenimiento.vendedor.index')->with('eliminar', 'success');
    }

    public function getDni(Request $request)
    {
        $data = $request->all();
        $existe = false;
        $igualPersona = false;
        if (!is_null($data['tipo_documento']) && !is_null($data['documento'])) {
            if (!is_null($data['id'])) {
                $persona = Persona::findOrFail($data['id']);
                if ($persona->tipo_documento == $data['tipo_documento'] && $persona->documento == $data['documento']) {
                    $igualPersona = true;
                } else {
                    $persona = Persona::where([
                        ['tipo_documento', '=', $data['tipo_documento']],
                        ['documento', $data['documento']],
                        ['estado', 'ACTIVO']
                    ])->first();
                }
            } else {
                $persona = Persona::where([
                    ['tipo_documento', '=', $data['tipo_documento']],
                    ['documento', $data['documento']],
                    ['estado', 'ACTIVO']
                ])->first();
            }

            if (!is_null($persona) && !is_null($persona->empleado->vendedor)) {
                $existe = true;
            }
        }

        $result = [
            'existe' => $existe,
            'igual_persona' => $igualPersona
        ];

        return response()->json($result);
    }
}
