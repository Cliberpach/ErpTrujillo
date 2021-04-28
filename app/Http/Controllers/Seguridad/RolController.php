<?php

namespace App\Http\Controllers\Seguridad;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\Seguridad\Role_has_permissions;
use DataTables;
use Carbon\Carbon;
use Session;
use Illuminate\Support\Facades\Validator;
use DB;

class RolController extends Controller
{
    public function index()
    {
        return view('seguridad.roles.index');
    }
    public function getRoles(){
        return datatables()->query(
            DB::table('roles')
            ->select('roles.*', 
            DB::raw('DATE_FORMAT(created_at, "%d/%m/%Y") as creado'),
            DB::raw('DATE_FORMAT(updated_at, "%d/%m/%Y") as actualizado')
            )
        )->toJson();
    }


    public function create(){
        $permisos = Permission::all();
        return view('seguridad.roles.create',[
            'permisos' => $permisos,
        ]);
    }
    public function edit($id){
        $roles = Role::findOrFail($id); //aqui
        $permisos = Permission::all();
        $detalles = Role_has_permissions::where('role_id',$id)->get(); 
        return view('seguridad.roles.edit',[
            'roles' => $roles,
            'permisos' => $permisos,
            'detalles' => $detalles
        ]);
    }
    public function store(Request $request){
        
        $data = $request->all();
        
        $rules = [
            'name'=>'',
            'guard_name'=>'',
            
        ];
        
        $message = [
            'name'=>'El campo name es ...',
            'guard_name'=>'El campo guard_name es ...',
            
        ];

        //Validator::make($data, $rules, $message)->validate();
        $rol = Role::create(['name' => $request->get('name')]);

        //Llenado de los permisos
        $permisosJSON = $request->get('permisos_tabla');
        if($permisosJSON)
            $permisotabla = json_decode($permisosJSON[0]);
        else
            $permisotabla=[];    

        // Agrega los permisos x rol
        if($permisotabla) {
            foreach ($permisotabla as $permiso) {
                $rol->givePermissionTo([
                    $permiso->name,
                ]);
            }
        }

        Session::flash('success','Roles creado.');
        return redirect()->route('seguridad.roles.index')->with('guardar', 'success');
    }

    public function update(Request $request,$id){
        
        $data = $request->all();
        $rules = [
            'name' =>'',
            'guard_name' =>'',
            
        ];
        
        $message = [
            'name' =>'El campo name es ...',
            'guard_name' =>'El campo guard_name es ...',
            
        ];
        //Validator::make($data, $rules, $message)->validate();

        $rol = Role::findOrFail($id);
        $rol->name = $request->get('name');
        $rol->guard_name='web';
        $rol->update();
        
        //Llenado de los permisos
        $permisosJSON = $request->get('permisos_tabla');
        $permisotabla = json_decode($permisosJSON[0]);

        // Elmina los permisos
        DB::table('role_has_permissions')->where('role_id', $rol->id)->delete();

        // Agrega los permisos x rol
        if($permisotabla) {
            foreach ($permisotabla as $permiso) {
                $rol->givePermissionTo([
                    $permiso->permiso_id,
                ]);
            }
        }   
        Session::flash('success','Roles modificado.');
        return redirect()->route('seguridad.roles.index')->with('modificar', 'success');
    }

    
    public function destroy($id)
    {
        
        $roles = Role::findOrFail($id);
     
        $roles->delete();

        Session::flash('success','Roles eliminado.');
        return redirect()->route('seguridad.roles.index')->with('eliminar', 'success');

    }
}