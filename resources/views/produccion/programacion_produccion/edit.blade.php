@extends('layout') @section('content')

@section('produccion-active', 'active')
@section('programacion_produccion-active', 'active')

<div class="row wrapper border-bottom white-bg page-heading">

    <div class="col-lg-12">
       <h2  style="text-transform:uppercase"><b>MODIFICAR NUEVA Programacion Produccion</b></h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{route('home')}}">Panel de Control</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{route('produccion.programacion_produccion.index')}}">Programacion Produccion</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Modificar</strong>
            </li>

        </ol>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">

                <div class="ibox-content">

                    <form action="{{route('produccion.programacion_produccion.update', $programacion_produccion->id)}}" method="POST" id="enviar_programacion_produccion">
                         @csrf @method('PUT')
                         <h4 class=""><b>Programacion Produccion</b></h4>
                            <div class="row">
                                <div class="col-md-12">
                                    <p>Modificar datos de la Programacion Produccion:</p>
                                </div>
                            </div>
                        <div class="row">

                            <div class="col-lg-6 col-xs-12">
                                <div class="form-group ">
                                    <label class='required'>Productos</label>
                      				<select name="producto_id" class="select2_form form-control {{ $errors->has('producto_id') ? ' is-invalid' : '' }}">

                                        <option></option>
                                        @foreach ($productos as $producto)
                                        <option value="{{$producto->id}}"  @if($producto->id == $programacion_produccion->producto_id ) {{'selected'}} @endif > {{$producto->nombre}}
                                        </option>
                                        @endforeach

                      				</select>
                                </div>

                                <div class="form-group row">
                                        <div class="col-lg-4 col-xs-12">
                                            <label class="required">Cantidad Producir :</label>
                                            <input type="number" id="cantidad_programada" name="cantidad_programada" step="0.001" min="0" class="form-control {{ $errors->has('cantidad_programada') ? ' is-invalid' : '' }}" value="{{old('cantidad_programada',$programacion_produccion->cantidad_programada)}}" required >
                                            @if ($errors->has('cantidad_programada'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('cantidad_programada') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                </div>

                            </div>
                            <div class="col-lg-6 col-xs-12">

                                    <div class="form-group row">
                                        <div class="col-lg-6 col-xs-12" id="fecha_produccion">
                                            <label class='required'>Fecha de Producción</label>
                                            <div class="input-group date">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </span>
                                                <input type="text" id="fecha_produccion" name="fecha_produccion"
                                                    class="form-control {{ $errors->has('fecha_produccion') ? ' is-invalid' : '' }}"
                                                    value="{{old('fecha_produccion', getFechaFormato($programacion_produccion->fecha_produccion , 'd/m/Y'))}}"
                                                    autocomplete="off" readonly required>
                                                @if ($errors->has('fecha_produccion'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('fecha_produccion') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-xs-12">

                                            <label>Fecha de Termino</label>
                                            <div class="input-group date">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </span>
                                                <input type="text" id="fecha_termino" name="fecha_termino"
                                                    class="form-control {{ $errors->has('fecha_termino') ? ' is-invalid' : '' }}"
                                                    value="{{old('fecha_termino', getFechaFormato($programacion_produccion->fecha_termino, 'd/m/Y'))}}"
                                                    autocomplete="off" readonly>
                                                @if ($errors->has('fecha_termino'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('fecha_termino') }}</strong>
                                                </span>
                                                @endif
                                            </div>

                                        </div>
                                    </div>

                                    <div class="form-group ">
                                   
                                        <label>Observación:</label>
                                        <textarea type="text" class="form-control {{ $errors->has('observacion') ? ' is-invalid' : '' }}"
                                            name="observacion" id="observacion"  onkeyup="return mayus(this)"
                                            value="{{old('observacion',$programacion_produccion->observacion)}}">{{old('observacion',$programacion_produccion->observacion)}}</textarea>
                                            @if ($errors->has('observacion'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('observacion') }}</strong>
                                            </span>
                                            @endif                                        

                                    </div>

                            </div>

                        </div>

                        <div class="hr-line-dashed"></div>
                        <div class="form-group row">

                            <div class="col-md-6 text-left" style="color:#fcbc6c">
                                <i class="fa fa-exclamation-circle"></i> <small>Los campos marcados con asterisco
                                    (<label class="required"></label>) son obligatorios.</small>
                            </div>

                            <div class="col-md-6 text-right">
                                <a href="{{route('produccion.programacion_produccion.index')}}" id="btn_cancelar"
                                    class="btn btn-w-m btn-default">
                                    <i class="fa fa-arrow-left"></i> Regresar
                                </a>
                                <button type="submit" id="btn_grabar" class="btn btn-w-m btn-primary">
                                    <i class="fa fa-save"></i> Grabar
                                </button>
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

$('#fecha_produccion .input-group.date').datepicker({
    todayBtn: "linked",
    keyboardNavigation: false,
    forceParse: false,
    autoclose: true,
    language: 'es',
    format: "dd/mm/yyyy",
    //startDate: "today"
})
$('#fecha_termino .input-group.date').datepicker({
    todayBtn: "linked",
    keyboardNavigation: false,
    forceParse: false,
    autoclose: true,
    language: 'es',
    format: "dd/mm/yyyy",
    //startDate: "today"
})

$('#cantidad_programada').keyup(function() {
    var val = $(this).val();
    if (isNaN(val)) {
        val = val.replace(/[^0-9\.]/g, '');
        if (val.split('.').length > 2)
            val = val.replace(/\.+$/, "");
    }
    $(this).val(val);
});

$('#enviar_programacion_produccion').submit(function(e) {
    e.preventDefault();
    
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger',
        },
        buttonsStyling: false
    })

    Swal.fire({
        title: 'Opción Guardar',
        text: "¿Seguro que desea guardar cambios?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: "#1ab394",
        confirmButtonText: 'Si, Confirmar',
        cancelButtonText: "No, Cancelar",
    }).then((result) => {
        if (result.isConfirmed) {
            
            this.submit();
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
   

})


</script>
@endpush