@extends('layout') @section('content')

@section('invdesarrollo-active', 'active')
@section('guia-active', 'active')

<div class="row wrapper border-bottom white-bg page-heading">

    <div class="col-lg-12">
       <h2  style="text-transform:uppercase"><b>Detalle de la Guia Interna: # {{$guia->id}}</b></h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{route('home')}}">Panel de Control</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{route('invdesarrollo.guia.index')}}">Guias Internas</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Detalle</strong>
            </li>

        </ol>
    </div>
    <div class="col-lg-4">
        <div class="title-action">
            <a href="{{route('invdesarrollo.guia.edit', $guia->id)}}" class="btn btn-warning btn-sm"><i
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
                            <h4 class=""><b>Guia Interna</b></h4>
                            <div class="row">
                                <div class="col-md-12">
                                    <p>Mostrar datos de la guia interna:</p>
                                </div>
                            </div>

                            <div class="form-group row">

                                <div class="col-lg-6 col-xs-12" id="prototipo">
                                    <label">Productos : </label>
                                     <select
                                        class="select2_form form-control {{ $errors->has('prototipo_id') ? ' is-invalid' : '' }}"
                                        style="text-transform: uppercase; width:100%" value="{{old('prototipo_id',$guia->prototipo_id)}}"
                                        name="prototipo_id" id="prototipo_id" disabled>
                                        <option></option>
                                        @foreach ($prototipos as $prototipo)
                                        <option value="{{$prototipo->id}}" @if(old('prototipo_id',$guia->prototipo_id)==$prototipo->id)
                                                 {{'selected'}} @endif >{{$prototipo->producto}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-6 col-xs-12">
                                    <label>Fecha de Emisión</label>
                                    <div class="input-group date">
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                        <input type="text" id="fecha" name="fecha"
                                            class="form-control {{ $errors->has('fecha') ? ' is-invalid' : '' }}"
                                            value="{{old('fecha',getFechaFormato($guia->fecha, 'd/m/Y'))}}"
                                            autocomplete="off" disabled>
                                        @if ($errors->has('fecha'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('fecha') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Unidades a Producir :</label>
                                    <input type="number" id="unidades_a_producir" name="unidades_a_producir" class="form-control {{ $errors->has('unidades_a_producir') ? ' is-invalid' : '' }}" value="{{old('unidades_a_producir',$guia->unidades_a_producir)}}"  disabled>
                                    @if ($errors->has('unidades_a_producir'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('unidades_a_producir') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    <label>Area Responsable 1 :</label>
                                    <input type="text" id="area_responsable1" name="area_responsable1" class="form-control {{ $errors->has('area_responsable1') ? ' is-invalid' : '' }}" value="{{old('area_responsable1',$guia->area_responsable1)}}" disabled>
                                    @if ($errors->has('area_responsable1'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('area_responsable1') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    <label>Area Responsable 2 :</label>
                                    <input type="text" id="area_responsable2" name="area_responsable2" class="form-control {{ $errors->has('area_responsable2') ? ' is-invalid' : '' }}" value="{{old('area_responsable2',$guia->area_responsable2)}}" disabled>
                                    @if ($errors->has('area_responsable2'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('area_responsable2') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                
                                
                            </div>
                            <div class="form-group">
                                <label>Observación:</label>
                                <textarea type="text" placeholder=""
                                    class="form-control {{ $errors->has('observacion') ? ' is-invalid' : '' }}"
                                    name="observacion" id="observacion"  onkeyup="return mayus(this)" disabled 
                                    value="{{old('observacion',$guia->observacion)}}">{{old('observacion', $guia->observacion)}}</textarea>
                                @if ($errors->has('observacion'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('observacion') }}</strong>
                                </span>
                                @endif


                            </div>

                            <input type="hidden" id="articulos_tabla" name="articulos_tabla[]">

                        </div>

                    </div>

                    <hr>


                    <div class="table-responsive">
                        <table
                            class="table dataTables-guia-detalle table-striped table-bordered table-hover"
                             onkeyup="return mayus(this)">
                            <thead>
                                <tr>
                                    <th class="text-center">ARTICULO</th>
                                    <th class="text-center">CANTIDAD SOLICITADA</th>
                                    <th class="text-center">CANTIDAD ENTREGADA</th>
                                    <th class="text-center">CANTIDAD DEVUELTA</th>
                                    <th class="text-center">OBSERVACION</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($detalles as $detalle)
                                <tr>
                                    <td class="text-left">
                                        <div><strong>{{$detalle->articulo->descripcion}}</strong></div>
                                    </td>
                                    <td class="text-center">{{$detalle->cantidad_solicitada}}</td>
                                    <td class="text-center">{{$detalle->cantidad_entregada}}</td>
                                    <td class="text-center">{{$detalle->cantidad_devuelta}}</td>
                                    <td class="text-center">{{$detalle->observacion}}</td>
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
            window.location.href = "{{route('invdesarrollo.guia.reporte', $guia->id)}}"
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
            window.location.href = "{{route('invdesarrollo.guia.email', $guia->id)}}"
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