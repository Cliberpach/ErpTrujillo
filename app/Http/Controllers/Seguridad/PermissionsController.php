<?php

namespace App\Http\Controllers\Seguridad;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Spatie\Permission\Models\Permission;
use DataTables;
use Carbon\Carbon;
use Session;
use Illuminate\Support\Facades\Validator;
use DB;

class PermissionsController extends Controller
{
    public function index()
    {
        return view('seguridad.permissions.index');
    }
    public function getPermissions(){
        return datatables()->query(
            DB::table('permissions')
            ->select('permissions.*', 
            DB::raw('DATE_FORMAT(created_at, "%d/%m/%Y") as creado'),
            DB::raw('DATE_FORMAT(updated_at, "%d/%m/%Y") as actualizado')
            )
        )->toJson();
    }

    public function getPermisosxRol($id){
        return datatables()->query(
            DB::table('permissions')
                ->join('role_has_permissions','role_has_permissions.permission_id','=','permissions.id')
                ->where('role_has_permissions.role_id',$id)
            ->select('permissions.*', 
            DB::raw('DATE_FORMAT(created_at, "%d/%m/%Y") as creado'),
            DB::raw('DATE_FORMAT(updated_at, "%d/%m/%Y") as actualizado')
            )
        )->toJson();
    }

     public function create(){
        return view('seguridad.permissions.create');
    }
    public function edit($id){
        $permissions = Permission::findOrFail($id);
        return view('seguridad.permissions.edit',[
            'permissions' => $permissions
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
        
        //$registro_sanitario = new RegistroSanitario();
        $permissions=new Permission;
        $permissions->name=strtolower($request->get('name'));  // se va a manejar en minusculas
        $permissions->guard_name='web';
        $permissions->save();

        Session::flash('success','Permiso creado.');
        return redirect()->route('seguridad.permissions.index')->with('guardar', 'success');
    }

    public function update(Request $request, $id){
        
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

        $permissions = Permission::findOrFail($id);
        $permissions->name = strtolower($request->get('name'));
        $permissions->guard_name='web';
        $permissions->update();

        Session::flash('success','Permiso modificado.');
        return redirect()->route('seguridad.permissions.index')->with('modificar', 'success');
    }

    
    public function destroy($id)
    {
        
        $permissions = Permission::findOrFail($id);
        //$permissions->estado = 'ANULADO';
        $permissions->delete();

        Session::flash('success','Permiso eliminado.');
        return redirect()->route('seguridad.permissions.index')->with('eliminar', 'success');

    }
}