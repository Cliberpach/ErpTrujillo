<?php

namespace App\Http\Controllers\Seguridad;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use DataTables;
use Carbon\Carbon;
use App\Mantenimiento\Colaborador\Colaborador;
use Session;
use Illuminate\Support\Facades\Validator;
use App\User;
use Illuminate\Support\Facades\Storage;

use App\Seguridad\Roles;

class UsuarioController extends Controller
{
    public function index()
    {
        return view('seguridad.usuarios.index');
    }

    public function getUsers(){
        $usuarios = DB::table('users')
        ->join('colaboradores','users.colaborador_id','=','colaboradores.id')
        ->join('personas','colaboradores.persona_id','=','personas.id')
        ->select('users.*','personas.apellido_materno','personas.apellido_paterno','personas.nombres',DB::raw('CONCAT(personas.apellido_materno,\' \',personas.apellido_paterno,\' \',personas.nombres) AS nombre_completo'))
        ->where('users.estado','!=',"ANULADO")
        ->orderBy('users.id','DESC')
        ->get();
        return DataTables::of($usuarios)->toJson();
    }

    public function create(){
        $roles = DB::table('roles')->get();
        return view('seguridad.usuarios.create',[
            'roles' => $roles
        ]);
    }

    public function edit($id){
        $roles = DB::table('roles')->get();
        $rol_usuario=DB::table('model_has_roles')
            ->where('model_id', $id)
            ->where('model_type','App\User')
            ->pluck('role_id')
            ->first();
        $usuario = User::findOrFail($id);
        //dd($rol_usuario);
        return view('seguridad.usuarios.edit',[
            'usuario' => $usuario,
            'roles' => $roles,
            'rol_usuario' => $rol_usuario
        ]);
    }

    public function getEmployee(){

        $colaboradores = DB::table('colaboradores')
        ->join('personas','colaboradores.id','=','personas.id')
        ->select('colaboradores.id as colaborador_id', 'personas.*')
        ->where('colaboradores.estado','!=',"ANULADO")
        ->get();

 
        $coleccion = collect([]);
        foreach($colaboradores as $colaborador){
            if (DB::table('users')->where('colaborador_id', $colaborador->colaborador_id)->where('estado','ACTIVO')->exists() == false) {
                $coleccion->push([
                    'id' => $colaborador->colaborador_id,
                    'apellido_materno' => $colaborador->apellido_materno,
                    'apellido_paterno' => $colaborador->apellido_paterno,
                    'nombres' => $colaborador->nombres,
                ]);

             }
        };

        return $coleccion;
    }

    public function getEmployeeedit($id){

        $colaboradores = DB::table('colaboradores')
        ->join('personas','colaboradores.id','=','personas.id')
        ->select('colaboradores.id as colaborador_id', 'personas.*')
        ->where('colaboradores.estado','!=',"ANULADO")
        ->get();

 
        $coleccion = collect([]);
        foreach($colaboradores as $colaborador){
            if (
                DB::table('users')
                    ->where('colaborador_id', $colaborador->colaborador_id)
                    ->where('estado','ACTIVO')
                    ->exists() == false || 
                    $colaborador->id == $id) {
                $coleccion->push([
                    'id' => $colaborador->colaborador_id,
                    'apellido_materno' => $colaborador->apellido_materno,
                    'apellido_paterno' => $colaborador->apellido_paterno,
                    'nombres' => $colaborador->nombres,
                ]);

             }

        };
    

        return $coleccion;
    }

    public function store(Request $request){
        
        $data = $request->all();
        $rules = [
            'empleado_id' => 'required',
            'usuario' => 'required',
            'correo' => 'required|unique:users,email',
            'password' => 'required|confirmed',
            'logo' => 'image|mimetypes:image/jpeg,image/png,image/jpg|max:40000',
            'file' => '',
        ];

        $message = [
            'empleado_id.required' => 'El campo Colaborador es obligatorio.',

            'logo.image' => 'El campo Imagen no contiene el formato imagen.',
            'logo.max' => 'El tamaño máximo del Imagen para cargar es de 40 MB.',
            'usuario.required' => 'El campo Usuario es obligatorio.',
            'correo.required' => 'El campo Correo es obligatorio.',
            'correo.unique' => 'El campo Correo debe de ser único.',
            'password.required' => 'El campo Contraseña es obligatorio.',
            'password.confirmed' => 'Las contraseñas no coinciden.'
        ];

        Validator::make($data, $rules, $message)->validate();



        $usuario = new User();
        $usuario->usuario = $data['usuario'];
        $usuario->colaborador_id = $data['empleado_id'];
        $usuario->email = $data['correo'];
        $usuario->password = bcrypt($data['password']);

        if($request->hasFile('logo')){                
            $file = $request->file('logo');
            $name = $file->getClientOriginalName();
            $usuario->nombre_imagen = $name;
            $usuario->ruta_imagen = $request->file('logo')->store('public/usuarios');
        }

        $usuario->save();

        // Asignación de Rol
        // Elmina roles anteriores
        DB::table('model_has_roles')->where('model_id', $usuario->id)->where('model_type','App\User')->delete();
        $rol=$request->get('rol_id');
        if($rol)
            $usuario->assignRole($rol);

        //Registro de actividad
        $descripcion = "SE AGREGÓ EL USUARIO CON EL CORREO: ". $usuario->email;
        $gestion = "USUARIOS";
        crearRegistro($usuario, $descripcion , $gestion);

        Session::flash('success','Usuario creado.');
        return redirect()->route('seguridad.usuario.index')->with('guardar','success');


    }

    public function update(Request $request, $id){
        
        $data = $request->all();
        $rules = [
            'empleado_id' => 'required',
            'usuario' => 'required',
            'correo' => 'required|unique:users,email,' . $id,
            'logo' => 'image|mimetypes:image/jpeg,image/png,image/jpg|max:40000',
            'file' => '',
        ];

        $message = [
            'empleado_id.required' => 'El campo Empleado es obligatorio.',
            'logo.image' => 'El campo Imagen no contiene el formato imagen.',
            'logo.max' => 'El tamaño máximo del Imagen para cargar es de 40 MB.',
            'usuario.required' => 'El campo Usuario es obligatorio.',
            'correo.required' => 'El campo Correo es obligatorio.',
            'correo.unique' => 'El campo Correo debe de ser único.',
        ];

        Validator::make($data, $rules, $message)->validate();

        $usuario = User::findOrFail($id);
        $usuario->usuario = $data['usuario'];
        $usuario->colaborador_id = $data['empleado_id'];
        $usuario->email = $data['correo'];
        // $usuario->password = bcrypt($data['password']);

        if ($request->has('cambiar_contraseña')) {
            $usuario->password = bcrypt($data['password']);
        }

        if($request->hasFile('logo')){
            //Eliminar Archivo anterior
            Storage::delete($usuario->ruta_imagen);               
            //Agregar nuevo archivo                
            $file = $request->file('logo');
            $name = $file->getClientOriginalName();
            $usuario->nombre_imagen = $name;
            $usuario->ruta_imagen = $request->file('logo')->store('public/usuarios');
        }
        $usuario->update();


        // Asignación de Rol
        // Elmina roles anteriores
        DB::table('model_has_roles')->where('model_id', $usuario->id)->where('model_type','App\User')->delete();
        $rol=$request->get('rol_id');
        if($rol)
            $usuario->assignRole($rol);

        //Registro de actividad
        $descripcion = "SE MODIFICÓ EL USUARIO CON EL CORREO: ". $usuario->email;
        $gestion = "USUARIOS";
        modificarRegistro($usuario, $descripcion , $gestion);

        Session::flash('success','Usuario modificado.');
        return redirect()->route('seguridad.usuario.index')->with('modificar','success');


    }

    public function destroy($id)
    {
        
        $usuario = User::findOrFail($id);
        $usuario->estado = 'ANULADO';
        $usuario->update();

        //Registro de actividad
        $descripcion = "SE ELIMINÓ EL USUARIO CON EL CORREO: ". $usuario->email;
        $gestion = "USUARIOS";
        eliminarRegistro($usuario, $descripcion , $gestion);

        if ( auth()->user()->estado == 'ACTIVO') {
            Session::flash('success','Usuario eliminado.');
            return redirect()->route('seguridad.usuario.index')->with('eliminar', 'success');
            
        }else{
            return redirect()->route('logout')->with('usuario_eliminado','error');
        }



    }

}
