@extends('layout') @section('content')

@section('produccion-active', 'active')
@section('programacion_produccion-active', 'active')

<div class="row wrapper border-bottom white-bg page-heading">

    
            <div class="col-lg-9">
                <h2  style="text-transform:uppercase"><b>DETALLE PROGRAMACION DE PRODUCCIÓN</b></h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{route('home')}}">Panel de Control</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{route('produccion.programacion_produccion.index')}}">Programacion de Produccion</a>
                    </li>
                    <li class="breadcrumb-item active">
                        <strong>Detalle</strong>
                    </li>

                </ol>
            
            </div>
        




</div>

<div class="wrapper wrapper-content animated fadeInRight">

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">

                <div class="ibox-content">

                    
                         <h4 class=""><b>Programacion Produccion</b></h4>
                            <div class="row">
                                <div class="col-md-12">
                                    <p>Mostrar datos de la Programacion de Produccion:</p>
                                </div>
                            </div>
                        <div class="row">

                            <div class="col-lg-6">

                                <div class="form-group">
                      				<label >Productos</label>
                      				<select name="producto_id" class="form-control" disabled>
                                          <option value="">Seleccionar Productos</option>
                      					@foreach ($productos as $producto)
                                              <option 
                      							@if ($producto->id==$programacion_produccion->producto_id)
                                                      selected
                      							@endif
                      							value="{{$producto->id}}"> {{$producto->nombre}}
                      						</option>
                      					@endforeach
                      				</select>
                      			</div>

                                <div class="form-group row">
                                        <div class="col-md-4">
                                            <label class="required">Cantidad Programada :</label>
                                            <input type="text" id="cantidad_programada" name="cantidad_programada" class="form-control {{ $errors->has('cantidad_programada') ? ' is-invalid' : '' }}" value="{{old('cantidad_programada',$programacion_produccion->cantidad_programada)}}" disabled>
                                            @if ($errors->has('cantidad_programada'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('cantidad_programada') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                          
                                </div>



                            </div>

                            <div class="col-lg-6">

                                <div class="form-group row">

                                        <div class="col-md-6" id="fecha_produccion">
                                            <label>Fecha Produccion</label>
                                            <div class="input-group date">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </span>
                                                <input type="text" id="fecha_produccion" name="fecha_produccion"
                                                    class="form-control {{ $errors->has('fecha_produccion') ? ' is-invalid' : '' }}"
                                                    value="{{old('fecha_produccion',$programacion_produccion->fecha_produccion)}}"
                                                    autocomplete="off" disabled>
                                                @if ($errors->has('fecha_produccion'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('fecha_produccion') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-6" id="fecha_termino">
                                            <label>Fecha Termino</label>
                                            <div class="input-group date">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </span>
                                                <input type="text" id="fecha_termino" name="fecha_termino"
                                                    class="form-control {{ $errors->has('fecha_termino') ? ' is-invalid' : '' }}"
                                                    value="{{old('fecha_termino', getFechaFormato($programacion_produccion->fecha_termino, 'd/m/Y'))}}"
                                                    autocomplete="off" disabled>
                                                @if ($errors->has('fecha_termino'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('fecha_termino') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>


                                </div>

                                <div class="form-group">
                                    <label>Observación:</label>
                                    <textarea type="text" placeholder="Observacion"
                                        class="form-control {{ $errors->has('observacion') ? ' is-invalid' : '' }}"
                                        name="observacion" id="observacion"  onkeyup="return mayus(this)"
                                        value="{{old('observacion',$programacion_produccion->observacion)}}" disabled>{{old('observacion',$programacion_produccion->observacion)}}</textarea>
                                    @if ($errors->has('observacion'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('observacion') }}</strong>
                                    </span>
                                    @endif
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
<link href="{{ asset('Inspinia/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}"
    rel="stylesheet">
<link href="{{ asset('Inspinia/css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
<link href="{{ asset('Inspinia/css/plugins/daterangepicker/daterangepicker-bs3.css') }}" rel="stylesheet">
<link href="{{ asset('Inspinia/css/plugins/select2/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('Inspinia/css/plugins/steps/jquery.steps.css') }}" rel="stylesheet">

<!-- DataTable -->
<link href="{{asset('Inspinia/css/plugins/dataTables/datatables.min.css')}}" rel="stylesheet">

@endpush

@push('scripts')
<!-- Data picker -->
<script src="{{ asset('Inspinia/js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>
<!-- Date range use moment.js same as full calendar plugin -->
<script src="{{ asset('Inspinia/js/plugins/fullcalendar/moment.min.js') }}"></script>
<!-- Date range picker -->
<script src="{{ asset('Inspinia/js/plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- Select2 -->
<script src="{{ asset('Inspinia/js/plugins/select2/select2.full.min.js') }}"></script>

<!-- DataTable -->
<script src="{{asset('Inspinia/js/plugins/dataTables/datatables.min.js')}}"></script>
<script src="{{asset('Inspinia/js/plugins/dataTables/dataTables.bootstrap4.min.js')}}"></script>

<!-- Chosen -->
<script src="{{asset('Inspinia/js/plugins/chosen/chosen.jquery.js')}}"></script>

<script>
//Select2
$(".select2_form").select2({
    placeholder: "SELECCIONAR",
    allowClear: true,
    height: '200px',
    width: '100%',
});

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
            window.location.href = "{{route('produccion.programacion_produccion.reporte', $programacion_produccion->id)}}"
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
            window.location.href = "{{route('produccion.programacion_produccion.email', $programacion_produccion->id)}}"
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