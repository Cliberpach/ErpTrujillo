@extends('layout') @section('content')
@section('produccion-active', 'active')
@section('composicion-active', 'active')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8 col-xs-12">
       <h2  style="text-transform:uppercase"><b>DETALLE DEL PRODUCTO TERMINADO: #{{ $producto->id }}</b></h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">Panel de Control</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('produccion.composicion.index') }}">Productos Terminados</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Detalle</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-4 col-xs-12">
        <div class="title-action">
            <a href="{{route('produccion.composicion.edit', $producto->id)}}" class="btn btn-warning btn-sm"><i
                class="fa fa-edit"></i> Editar
            </a>
        </div>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-lg-8 col-xs-12">
                            <h4><b><i class="fa fa-caret-right"></i> Datos Generales</b></h4>
                            <div class="form-group row">
                                <div class="col-lg-4 col-xs-12">
                                    <label><strong>CÓDIGO ISO</strong></label>
                                    <p>{{ $producto->codigo }}</p>
                                </div>
                                <div class="col-lg-8 col-xs-12">
                                    <label> <strong>NOMBRE</strong> </label>
                                    <p>{{ $producto->nombre }}</p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-4 col-xs-12">
                                    <label> <strong>FAMILIA</strong></label>
                                    <p>{{ $producto->familia->familia }}</p>
                                </div>
                                <div class="col-lg-4 col-xs-12">
                                    <label> <strong>SUB FAMILIA</strong></label>
                                    <p>{{ $producto->sub_familia->descripcion }}</p>
                                </div>
                                <div class="col-lg-4 col-xs-12">
                                    <label><strong>PRESENTACIÓN</strong></label>
                                    <p>{{ $producto->presentacion }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-lg-12 col-xs-12">
                            <div class="table-responsive">
                                <table class="table invoice-table table table-bordered"  onkeyup="return mayus(this)">
                                    <thead>
                                    <tr>
                                        <th class=>ARTÍCULO</th>
                                        <th class="text-center">CANTIDAD</th>
                                        <th class="text-center">PESO</th>
                                        <th class="text-center">OBSERVACIÓN</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($producto->detalles as $detalle)
                                        <tr>
                                            <td>
                                                <div><strong>{{ $detalle->articulo->getDescripcionCompleta() }}</strong></div>
                                            </td>
                                            <td class="text-center">{{ $detalle->cantidad }}</td>
                                            <td class="text-center">{{ $detalle->peso }} ({{ $detalle->articulo->presentacion }})</td>
                                            <td class="text-left">{{ ($detalle->observacion) ? $detalle->observacion : '-' }}</td>

                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
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
