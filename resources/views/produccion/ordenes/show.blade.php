@extends('layout') @section('content')
@section('produccion-active', 'active')
@section('ordenes_produccion-active', 'active')

<div class="row wrapper border-bottom white-bg page-heading">

    <div class="col-lg-12">
       <h2  style="text-transform:uppercase"><b>ORDEN DE PRODUCCION  # {{$orden->id}}</b></h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{route('home')}}">Panel de Control</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{route('produccion.orden.index')}}">Orden de Produccion</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Registrar</strong>
            </li>

        </ol>
    </div>



</div>

<div class="wrapper wrapper-content animated fadeInRight">

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">

                <div class="ibox-content">

                    <form action="" method="POST" id="">
                        {{csrf_field()}}

                        <h4 class=""><b>Orden de Producción</b></h4>
                            <div class="row">
                                <div class="col-md-12">
                                    <p>Registrar datos de Orden de Producción :</p>
                                </div>
                            </div>

                            <div class="row">
                            
                                <div class="col-lg-6 col-xs-12 b-r">
                                    <div class="form-group">



                                   
                                            <label class="">Producto</label>
                                            <select class="select2_form form-control {{ $errors->has('producto_id') ? ' is-invalid' : '' }}" disabled>
                                                <option selected >{{$orden->programacion->producto->codigo.' - '.$orden->programacion->producto->nombre}}</option>
                                            </select>
                                     

                                    </div>
                                </div>

                                <div class="col-lg-6 col-xs-12">
                                        <div class="form-group row">
                                                <div class="col-lg-6 col-xs-12">
                                                    <label class="">Cantidad Producir :</label>
                                                    <input type="number" id="cantidad_programada" name="cantidad_programada" readonly class="form-control {{ $errors->has('cantidad_programada') ? ' is-invalid' : '' }}" value="{{old('cantidad_programada',$orden->programacion->cantidad_programada)}}" >
                                                    @if ($errors->has('cantidad_programada'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('cantidad_programada') }}</strong>
                                                    </span>
                                                    @endif
                                                </div>

                                                <div class="col-lg-6 col-xs-12" id="">

                                                    <label class='required'>Fecha de Producción</label>
                                                    <div class="input-group date">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-calendar"></i>
                                                        </span>
                                                        <input type="text" id="fecha_produccion" name="fecha_produccion"
                                                            class="form-control {{ $errors->has('fecha_produccion') ? ' is-invalid' : '' }}"
                                                            value="{{old('fecha_produccion',getFechaFormato($orden->fecha_orden, 'd/m/Y'))}}"
                                                            autocomplete="off" readonly required>

                                                        @if ($errors->has('fecha_produccion'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('fecha_produccion') }}</strong>
                                                        </span>
                                                        @endif

                                                    </div>
                                                </div>
                                        </div>
                                </div>
                            
                            </div>
                     



                            <hr>
                            
                            <input type="hidden" name="productos_detalle" id="productos_detalle">

                            <div class="row">

                                <div class="col-lg-12">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading">
                                            <h4 class=""><b>Detalle de la orden de produccion</b></h4>
                                        </div>
                                        <div class="panel-body">
                                        
                                            <div class="table-responsive" >

                                                    <table class="table dataTables-ordenes table-striped table-bordered table-hover" id="orden" style="text-transform:uppercase">
                                                        <thead>
                                                        <tr>
                                    
                                                            <th colspan="1" class="text-center"></th>
                                                            <th colspan="2" class="text-center">CANTIDADES</th>
                                                            <th colspan="4" class="text-center">CANT. DEVUELTAS</th>
                                                            <th colspan="1" class="text-center"></th>
                                                         

                                                        </tr>
                                                        <tr>
                                                           
                                                            <th class="text-center">ARTICULO</th>
                                                            <th class="text-center">SOLICITADO</th>
                                                            <th class="text-center">ENTREGADO</th>
                                                            <th class="text-center"><i class="fa fa-check"></i></th>
                                                            <th class="text-center">OBS.</th>
                                                            <th class="text-center"><i class="fa fa-times"></i></th>
                                                            <th class="text-center">OBS.</th>
                                                            <th class="text-center">OPERACION</th>
                                                            
                                                
                                                        </tr>
                                                        </thead>
                                                        <tbody>

                                                            @foreach ($detalles as $detalle)
                                                            <tr>

                                                                    <td class="text-left">{{$detalle->productoDetalle->articulo->codigo_fabrica.' - '.$detalle->productoDetalle->articulo->descripcion}}</td>
                                                                    <td class="text-center">{{number_format($detalle->cantidad_solicitada,2)}}</td>
                                                                    <td class="text-center">{{number_format($detalle->cantidad_entregada,2)}}</td>
                                                                    @if ($detalle->cantidad_devuelta_correcta)
                                                                    <td class="text-center">{{ number_format($detalle->cantidad_devuelta_correcta,2) .' - '. $detalle->almacenCorrecto->descripcion}} </td>
                                                                    @else
                                                                    <td class="text-center"> - </td>
                                                                    @endif
                                                                    <td class="text-center">{{ ($detalle->observacion_correcta) ? $detalle->observacion_correcta : '-'  }}</td>
                                                                    @if ($detalle->cantidad_devuelta_incorrecta)
                                                                        <td class="text-center">{{ number_format($detalle->cantidad_devuelta_incorrecta,2).' - '.($detalle->almacenIncorrecto) ? $detalle->almacenIncorrecto->descripcion : ''  }}</td>
                                                                    @else
                                                                    <td class="text-center"> - </td>
                                                                    @endif
                                                                   
                                                                    <td class="text-center">{{ ($detalle->observacion_incorrecta) ? $detalle->observacion_incorrecta : '-'  }}</td>
                                                                    <td class="text-center">{{  $detalle->operacion }}</td>
                                                                    
                                                            </tr>
                                                            @endforeach


                                                        </tbody>
                                                    </table>




                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                    </form>
                </div>
            </div>
        </div>

    </div>

</div>

@stop
@push('styles')
<link href="{{ asset('Inspinia/css/plugins/select2/select2.min.css') }}" rel="stylesheet">
<!-- DataTable -->
<link href="{{asset('Inspinia/css/plugins/dataTables/datatables.min.css')}}" rel="stylesheet">

<link href="{{ asset('Inspinia/css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
<link href="{{ asset('Inspinia/css/plugins/daterangepicker/daterangepicker-bs3.css') }}" rel="stylesheet">

@endpush
@push('scripts')
<!-- Select2 -->
<script src="{{ asset('Inspinia/js/plugins/select2/select2.full.min.js') }}"></script>
<!-- DataTable -->
<script src="{{asset('Inspinia/js/plugins/dataTables/datatables.min.js')}}"></script>
<script src="{{asset('Inspinia/js/plugins/dataTables/dataTables.bootstrap4.min.js')}}"></script>
<!-- Data picker -->
<script src="{{ asset('Inspinia/js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>
<!-- Date range use moment.js same as full calendar plugin -->
<script src="{{ asset('Inspinia/js/plugins/fullcalendar/moment.min.js') }}"></script>
<!-- Date range picker -->
<script src="{{ asset('Inspinia/js/plugins/daterangepicker/daterangepicker.js') }}"></script>

<script>
//Select2
$(".select2_form").select2({
    placeholder: "SELECCIONAR",
    allowClear: true,
    width: '100%',
});

$('#fecha_produccion .input-group.date').datepicker({
    todayBtn: "linked",
    keyboardNavigation: false,
    forceParse: false,
    autoclose: true,
    language: 'es',
    format: "dd/mm/yyyy",
    startDate: "today"
})

const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
        confirmButton: 'btn btn-success',
        cancelButton: 'btn btn-danger',
    },
    buttonsStyling: false
})

$(document).ready(function() {
    // DataTables Orden

    $('.dataTables-ordenes').DataTable({
        "dom": 'lTfgitp',
        "bPaginate": true,
        "bLengthChange": true,
        "bFilter": true,
        "bInfo": true,
        "bAutoWidth": false,
        "language": {
            "url": "{{asset('Spanish.json')}}"
        },

        "columns": [
            {
                //ARTICULO
                "targets": [0],
                "className": "text-left",
              
            },
            {
                //CANTIDAD_SOLICITADA COMPLETADA
                "targets": [1],
                "className":"text-center",
               
            },
            {
                //CANTIDAD_ENTREGADA
                "targets": [2],
                className: "text-center",
              
            },
            {
                 //CANTIDAD_DEVUELTA_CORRECTA (COMPLETA)
                "targets": [3],
                className: "text-center",
               
            },
            {
                 //CANTIDAD_DEVUELTA_INCORRECTA (COMPLETA)
                "targets": [4],
                className: "text-center",
               
            },
            {
                 //OPERACION
                "targets": [5],
                className: "text-center",
              
            },  
            {
                 //OBSERVACION
                "targets": [6],
                className: "text-center",
              
            }, 
            {
                 //OBSERVACION
                "targets": [7],
                className: "text-center",
              
            },            

        ],

    });
});











</script>


@endpush