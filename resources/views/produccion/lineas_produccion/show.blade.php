@extends('layout') @section('content')

@section('produccion-active', 'active')
@section('linea_produccion-active', 'active')

<div class="row wrapper border-bottom white-bg page-heading">

    <div class="col-lg-12">
       <h2  style="text-transform:uppercase"><b>Detalle de la Linea de Producción: # {{$linea_produccion->id}}</b></h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{route('home')}}">Panel de Control</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{route('produccion.linea_produccion.index')}}">Lineas de Producción</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Detalle</strong>
            </li>

        </ol>
    </div>
    <div class="col-lg-4">
        <div class="title-action">
            <a href="{{route('produccion.linea_produccion.edit', $linea_produccion->id)}}" class="btn btn-warning btn-sm"><i
                    class="fa fa-edit"></i> Editar</a>
            <a href="#" onclick="generarReporte()" class="btn btn-danger btn-sm"><i class="fa fa-file-pdf-o "></i>
                Reporte </a>
            <a href="#" onclick="enviarReporte()" class="btn btn-primary btn-sm"><i class="fa fa-send "></i> Enviar </a>
        </div>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">

                <div class="ibox-content">

                
                    <div class="row">
                        <div class="col-sm-6 b-r">
                            <h4 class=""><b>Linea de Producción</b></h4>
                            <div class="row">
                                <div class="col-md-12">
                                    <p>Mostrar datos de la linea produccion :</p>
                                </div>
                            </div>

 
                            <div class="form-group">
                                <label>Nombre de Linea :</label>
                                <input type="text" id="nombre_linea" name="nombre_linea" class="form-control {{ $errors->has('nombre_linea') ? ' is-invalid' : '' }}" value="{{old('nombre_lineacantidad_personal',$linea_produccion->nombre_linea)}}" disabled>
                                @if ($errors->has('nombre_linea'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('nombre_linea') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label class="required">Cantidad de Personal :</label>
                                <input type="number" id="cantidad_personal" name="cantidad_personal" class="form-control {{ $errors->has('cantidad_personal') ? ' is-invalid' : '' }}" value="{{old('cantidad_personal',$linea_produccion->cantidad_personal)}}" disabled>
                                @if ($errors->has('cantidad_personal'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('cantidad_personal') }}</strong>
                                    </span>
                                @endif
                            </div>

                        </div>

                        <div class="col-sm-6">
                            <div class="form-group row">
                                <label>Flujo de Proceso (imagen) :</label>
                                <input type="file" id="nombre_imagen" name="nombre_imagen" class="form-control {{ $errors->has('nombre_imagen') ? ' is-invalid' : '' }}" value="{{old('nombre_imagen',$linea_produccion->nombre_imagen)}}" disabled>
                                @if ($errors->has('nombre_imagen'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('nombre_imagen') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Flujo de Proceso (archivo word) :</label>
                                    <input type="file" id="archivo_word" name="archivo_word" class="form-control {{ $errors->has('archivo_word') ? ' is-invalid' : '' }}" value="{{old('archivo_word',$linea_produccion->archivo_word)}}" disabled>
                                    @if ($errors->has('archivo_word'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('archivo_word') }}</strong>
                                    </span>
                                    @endif
                            </div>
                            <input type="hidden" id="maquinarias_equipos_tabla" name="maquinarias_equipos_tabla[]">

                        </div>

                    </div>

                    <hr>


                    <div class="table-responsive">
                        <table
                            class="table dataTables-linea_produccion-detalle table-striped table-bordered table-hover"
                             onkeyup="return mayus(this)">
                            <thead>
                                <tr>
                                    <th class="text-center">MAQUINARIA - EQUIPO</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($detalles as $detalle)
                                <tr>
                                    <td class="text-left">
                                        <div><strong>{{$detalle->maquinaria_equipo->nombre}}</strong></div>
                                    </td>
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
@stop

<!-- @push('styles')
<link href="{{ asset('Inspinia/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}"
    rel="stylesheet">
<link href="{{ asset('Inspinia/css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
<link href="{{ asset('Inspinia/css/plugins/daterangepicker/daterangepicker-bs3.css') }}" rel="stylesheet">
<link href="{{ asset('Inspinia/css/plugins/select2/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('Inspinia/css/plugins/steps/jquery.steps.css') }}" rel="stylesheet">

<link href="{{asset('Inspinia/css/plugins/dataTables/datatables.min.css')}}" rel="stylesheet">

@endpush -->

@push('scripts')
<!-- Data picker -->

<!-- <script src="{{ asset('Inspinia/js/plugins/fullcalendar/moment.min.js') }}"></script>
<script src="{{ asset('Inspinia/js/plugins/daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('Inspinia/js/plugins/select2/select2.full.min.js') }}"></script>

<script src="{{asset('Inspinia/js/plugins/dataTables/datatables.min.js')}}"></script>
<script src="{{asset('Inspinia/js/plugins/dataTables/dataTables.bootstrap4.min.js')}}"></script>

<script src="{{asset('Inspinia/js/plugins/chosen/chosen.jquery.js')}}"></script>  -->

<script>


function generarReporte() {
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger',
        },
        buttonsStyling: false
    })

    Swal.fire({
        title: "Opción Reporte",
        text: "¿Seguro que desea generar reporte?",
        showCancelButton: true,
        icon: 'info',
        confirmButtonColor: "#1ab394",
        confirmButtonText: 'Si, Confirmar',
        cancelButtonText: "No, Cancelar",
        // showLoaderOnConfirm: true,
    }).then((result) => {
        if (result.value) {
            window.location.href = "{{route('produccion.linea_produccion.reporte', $linea_produccion->id)}}"
            Swal.fire({
                title: '¡Cargando!',
                type: 'info',
                text: 'Generando Reporte',
                showConfirmButton: false,
                onBeforeOpen: () => {
                    Swal.showLoading()
                }
            })

        } else if (
            /* Read more about handling dismissals below */
            result.dismiss === Swal.DismissReason.cancel
        ) {
            swalWithBootstrapButtons.fire(
                'Cancelado',
                'La Solicitud se ha cancelado.',
                'error'
            )
        }
    })

}
</script>
<script>
function enviarReporte() {
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger',
        },
        buttonsStyling: false
    })

    Swal.fire({
        title: "Opción Reporte",
        text: "¿Seguro que desea enviar reporte por correo?",
        showCancelButton: true,
        icon: 'info',
        confirmButtonColor: "#1ab394",
        confirmButtonText: 'Si, Confirmar',
        cancelButtonText: "No, Cancelar",
        // showLoaderOnConfirm: true,
    }).then((result) => {
        if (result.value) {
            window.location.href = "{{route('produccion.linea_produccion.email', $linea_produccion->id)}}"
            Swal.fire({
                title: '¡Enviando!',
                type: 'info',
                text: 'El Reporte se esta enviando al correo: ',
                showConfirmButton: false,
                onBeforeOpen: () => {
                    Swal.showLoading()
                }
            })

        } else if (
            /* Read more about handling dismissals below */
            result.dismiss === Swal.DismissReason.cancel
        ) {
            swalWithBootstrapButtons.fire(
                'Cancelado',
                'La Solicitud se ha cancelado.',
                'error'
            )
        }
    })

}
</script>

@endpush