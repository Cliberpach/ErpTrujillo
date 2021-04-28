@extends('layout')

@section('content')

@section('mantenimiento-active', 'active')
@section('vendedores-active', 'active')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10 col-md-10">
       <h2  style="text-transform:uppercase"><b>Datos del Vendedor: {{ $vendedor->empleado->persona->getApellidosYNombres() }}</b></h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">Panel de Control</a>
            </li>
            <li class="breadcrumb-item active">
                <a href="{{ route('mantenimiento.vendedor.index') }}">Vendedores</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Datos</strong>
            </li>
        </ol>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeIn">
    <div class="row">
        <div class="col-lg-8 col-xs-12">
            <div class="tabs-container">
                <ul class="nav nav-tabs" role="tablist">
                    <li><a class="nav-link active" data-toggle="tab" href="#tab-personales"> Datos Personales</a></li>
                    <li><a class="nav-link" data-toggle="tab" href="#tab-contacto"> Datos de Contacto</a></li>
                    <li><a class="nav-link" data-toggle="tab" href="#tab-laborales">Datos Laborales</a></li>
                    <li><a class="nav-link" data-toggle="tab" href="#tab-adicionales">Datos Adicionales</a></li>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" id="tab-personales" class="tab-pane active">
                        <div class="panel-body">
                            <div class="row">
                                <div class="form-group col-lg-4 col-xs-12">
                                    <label><strong>Tipo de documento</strong></label>
                                    <p>{{ $vendedor->empleado->persona->tipo_documento }}</p>
                                </div>
                                <div class="form-group col-lg-4 col-xs-12">
                                    <label><strong>Nro. Documento</strong></label>
                                    <p class="text-navy">{{ $vendedor->empleado->persona->documento }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-4 col-xs-12">
                                    <label><strong>Nombre(s)</strong></label>
                                    <p>{{ $vendedor->empleado->persona->nombres }}</p>
                                </div>
                                <div class="form-group col-lg-4 col-xs-12">
                                    <label><strong>Apellido paterno</strong></label>
                                    <p>{{ $vendedor->empleado->persona->apellido_paterno }}</p>
                                </div>
                                <div class="form-group col-lg-4 col-xs-12">
                                    <label><strong>Apellido materno</strong></label>
                                    <p>{{ $vendedor->empleado->persona->apellido_materno }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-4 col-xs-12" id="fecha_nacimiento">
                                    <label><strong>Fecha de nacimiento</strong></label>
                                    <p>{{ getFechaFormato($vendedor->empleado->persona->fecha_nacimiento, 'd/m/Y') }}</p>
                                </div>
                                <div class="form-group col-lg-4 col-xs-12">
                                    <label><strong>Sexo</strong></label>
                                    <p>{{ $vendedor->empleado->persona->getSexo() }}</p>
                                </div>
                                <div class="form-group col-lg-4 col-xs-12">
                                    <label><strong>Estado civil</strong></label>
                                    <p>{{ $vendedor->empleado->persona->getEstadoCivil() }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" id="tab-contacto" class="tab-pane">
                        <div class="panel-body">
                            <div class="row">
                                <div class="form-group col-lg-4 col-xs-12">
                                    <label><strong>Departamento</strong></label>
                                    <p>{{ $vendedor->empleado->persona->getDepartamento() }}</p>
                                </div>
                                <div class="form-group col-lg-4 col-xs-12">
                                    <label><strong>Provincia</strong></label>
                                    <p>{{ $vendedor->empleado->persona->getProvincia() }}</p>
                                </div>
                                <div class="form-group col-lg-4 col-xs-12">
                                    <label><strong>Distrito</strong></label>
                                    <p>{{ $vendedor->empleado->persona->getDistrito() }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-4 col-xs-12">
                                    <label><strong>Dirección Completa</strong></label>
                                    <p>{{ $vendedor->empleado->persona->direccion }}</p>
                                </div>
                                <div class="form-group col-lg-4 col-xs-12">
                                    <label><strong>Teléfono móvil</strong></label>
                                    <p>{{ $vendedor->empleado->persona->telefono_movil }}</p>
                                </div>
                                <div class="form-group col-lg-4 col-xs-12">
                                    <label><strong>Teléfono fijo</strong></label>
                                    <p>{{ (!empty($vendedor->empleado->persona->telefono_fijo)) ? $vendedor->empleado->persona->telefono_fijo : "-" }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" id="tab-laborales" class="tab-pane">
                        <div class="panel-body">
                            <div class="row">
                                <div class="form-group col-lg-4 col-xs-12">
                                    <label><strong>Área</strong></label>
                                    <p>{{ $vendedor->empleado->area }}</p>
                                </div>
                                <div class="form-group col-lg-4 col-xs-12">
                                    <label><strong>Profesión</strong></label>
                                    <p>{{ $vendedor->empleado->profesion }}</p>
                                </div>
                                <div class="form-group col-lg-4 col-xs-12">
                                    <label><strong>Cargo</strong></label>
                                    <p>{{ $vendedor->empleado->cargo }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-4 col-xs-12">
                                    <label><strong>Sueldo</strong></label>
                                    <p>{{ $vendedor->empleado->moneda_sueldo }} {{ $vendedor->empleado->sueldo }}</p>
                                </div>
                                <div class="form-group col-lg-4 col-xs-12">
                                    <label><strong>Sueldo bruto</strong></label>
                                    <p>{{ $vendedor->empleado->moneda_sueldo }} {{ $vendedor->empleado->sueldo_bruto }}</p>
                                </div>
                                <div class="form-group col-lg-4 col-xs-12">
                                    <label><strong>Sueldo neto</strong></label>
                                    <p>{{ $vendedor->empleado->moneda_sueldo }} {{ $vendedor->empleado->sueldo_neto }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-4 col-xs-12" id="fecha_nacimiento">
                                    <label><strong>Banco</strong></label>
                                    <p>{{ (!empty($vendedor->empleado->getBanco())) ? $vendedor->empleado->getBanco() : "-" }}</p>
                                </div>
                                <div class="form-group col-lg-4 col-xs-12">
                                    <label><strong>Número de Cuenta</strong></label>
                                    <p>{{ (!empty($vendedor->empleado->numero_cuenta)) ? $vendedor->empleado->numero_cuenta : "-" }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-4 col-xs-12">
                                    <label><strong>Zona</strong></label>
                                    <p>{{ $vendedor->zona }} </p>
                                </div>
                                <div class="form-group col-lg-4 col-xs-12">
                                    <label><strong>Comisión</strong></label>
                                    <p>{{ $vendedor->moneda_comision }} {{ $vendedor->comision }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-4 col-xs-12">
                                    <label><strong>Fecha de inicio de actividad</strong></label>
                                    <p>{{ getFechaFormato($vendedor->empleado->fecha_inicio_actividad, 'd/m/Y') }}</p>
                                </div>
                                <div class="form-group col-lg-4 col-xs-12">
                                    <label><strong>Fecha de fin de actividad</strong></label>
                                    <p>{{ getFechaFormato($vendedor->empleado->fecha_fin_actividad, 'd/m/Y') }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-4 col-xs-12">
                                    <label><strong>Fecha de inicio de planilla</strong></label>
                                    <p>{{ getFechaFormato($vendedor->empleado->fecha_inicio_planilla, 'd/m/Y') }}</p>
                                </div>
                                <div class="form-group col-lg-4 col-xs-12">
                                    <label><strong>Fecha de fin de planilla</strong></label>
                                    <p>{{ getFechaFormato($vendedor->empleado->fecha_fin_planilla, 'd/m/Y') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" id="tab-adicionales" class="tab-pane ">
                        <div class="panel-body">
                            <div class="row">
                                <div class="form-group col-lg-4 col-xs-12">
                                    <label><strong>Teléfono de referencia</strong></label>
                                    <p>{{ (!empty($vendedor->empleado->telefono_referencia)) ? $vendedor->empleado->telefono_referencia : "-" }}</p>
                                </div>
                                <div class="form-group col-lg-4 col-xs-12">
                                    <label><strong>Contacto de referencia</strong></label>
                                    <p>{{ (!empty($vendedor->empleado->contacto_referencia)) ? $vendedor->empleado->contacto_referencia : "-" }}</p>
                                </div>
                                <div class="form-group col-lg-4 col-xs-12">
                                    <label><strong>Número de hijos</strong></label>
                                    <p>{{ (!empty($vendedor->empleado->numero_hijos)) ? $vendedor->empleado->numero_hijos : "0" }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-4 col-xs-12">
                                    <label><strong>Grupo sanguíneo</strong></label>
                                    <p>{{ (!empty($vendedor->empleado->grupo_sanguineo)) ? $vendedor->empleado->grupo_sanguineo : "-" }}</p>
                                </div>
                                <div class="form-group col-lg-8 col-xs-12">
                                    <label><strong>Alergias</strong></label>
                                    <p>{{ (!empty($vendedor->empleado->alergias)) ? $vendedor->empleado->alergias : "-" }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-xs-12">
            <div class="container m-b-xl">
                <a href="{{route('mantenimiento.vendedor.edit',$vendedor->id)}}" class="btn btn-block btn-warning btn-xs float-right"><i class='fa fa-edit'></i>EDITAR VENDEDOR</a>
            </div>
            <div class="container"  onkeyup="return mayus(this)">
                <div class="text-center">
                    @if($vendedor->empleado->ruta_imagen)
                        <img  src="{{Storage::url($vendedor->empleado->ruta_imagen)}}" class="img-fluid">
                    @else
                        <img  src="{{asset('storage/empresas/logos/default.png')}}" class="img-fluid">
                    @endif
                    <div>
                        <div class="text-center m-t-md">
                            @if($vendedor->empleado->ruta_imagen)
                                <a title="{{$vendedor->empleado->nombre_imagen}}" download="{{$vendedor->empleado->nombre_imagen}}" href="{{Storage::url($vendedor->empleado->ruta_imagen)}}" class="btn btn-xs btn-block btn-primary"><i class="fa fa-download"></i> Descargar Imagen</a>
                            @else
                                <a title="Imagen por defecto" download="Imagen por defecto" href="{{asset('storage/empresas/logos/default.png')}}" class="btn btn-xs btn-block btn-primary"><i class="fa fa-download"></i> Descargar Imagen</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @stop

        @push('styles')
            <link href="{{ asset('Inspinia/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}" rel="stylesheet">
    @endpush

    @push('scripts')
        <!-- iCheck -->
            <script src="{{ asset('Inspinia/js/plugins/iCheck/icheck.min.js') }}"></script>
@endpush
