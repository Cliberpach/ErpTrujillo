<?php

namespace App\Http\Controllers\Mantenimiento\Actividad;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use DataTables;
use Spatie\Activitylog\Models\Activity;

class ActividadController extends Controller
{
    public function index()
    {
        return view('mantenimiento.actividades.index');
    }

    public function getActivity()
    {

        $actividades = Activity::orderBy('id', 'DESC')->get();
        $coleccion = collect([]);
        foreach($actividades as $actividad) {
            
            $coleccion->push([
                
                'usuario' => $actividad->causer->empleado->persona->nombres.' '.$actividad->causer->empleado->persona->apellido_paterno.' '.$actividad->causer->empleado->persona->apellido_materno,
                'propiedades' => $actividad->properties,
                'descripcion' => $actividad->description,
                'fecha_creacion' =>  Carbon::parse($actividad->created_at)->format( 'd/m/Y - H:i:s'),
            ]);
        }
        return DataTables::of($coleccion)->toJson();
    }
}
