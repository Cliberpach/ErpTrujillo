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
                                      
                      		<div class="col-md-6">
                      			<div class="form-group">
                      				<label>Productos(*)</label>
                      				<select name="producto_id" class="form-control">
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
                      		</div>

                          <div class="col-md-4" id="fecha_creacion" style="display:none">
                            <label>Fecha Creacion</label>
                            <div class="input-group date">
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </span>
                                <input type="text" id="fecha_creacion" name="fecha_creacion"
                                    class="form-control {{ $errors->has('fecha_creacion') ? ' is-invalid' : '' }}"
                                    value="{{old('fecha_creacion',$programacion_produccion->fecha_creacion)}}"
                                    autocomplete="off" readonly required>
                                @if ($errors->has('fecha_creacion'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('fecha_creacion') }}</strong>
                                </span>
                                @endif
                            </div>
                          </div>
                          <div class="col-md-4" id="fecha_produccion">
                            <label>Fecha Produccion</label>
                            <div class="input-group date">
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </span>
                                <input type="text" id="fecha_produccion" name="fecha_produccion"
                                    class="form-control {{ $errors->has('fecha_produccion') ? ' is-invalid' : '' }}"
                                    value="{{old('fecha_produccion',$programacion_produccion->fecha_produccion)}}"
                                    autocomplete="off" readonly required>
                                @if ($errors->has('fecha_produccion'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('fecha_produccion') }}</strong>
                                </span>
                                @endif
                            </div>
                          </div>
                          <div class="col-md-4" id="fecha_termino" style="display:none">
                              <label>Fecha Termino</label>
                              <div class="input-group date">
                                  <span class="input-group-addon">
                                      <i class="fa fa-calendar"></i>
                                  </span>
                                  <input type="text" id="fecha_termino" name="fecha_termino"
                                      class="form-control {{ $errors->has('fecha_termino') ? ' is-invalid' : '' }}"
                                      value="{{old('fecha_termino',$programacion_produccion->fecha_termino)}}"
                                      autocomplete="off" readonly required>
                                  @if ($errors->has('fecha_termino'))
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $errors->first('fecha_termino') }}</strong>
                                  </span>
                                  @endif
                              </div>
                          </div>
                          <div class="col-md-4">
                              <label class="required">Cantidad Programada :</label>
                              <input type="text" id="cantidad_programada" name="cantidad_programada" class="form-control {{ $errors->has('cantidad_programada') ? ' is-invalid' : '' }}" value="{{old('cantidad_programada',$programacion_produccion->cantidad_programada)}}" >
                              @if ($errors->has('cantidad_programada'))
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $errors->first('cantidad_programada') }}</strong>
                              </span>
                              @endif
                          </div>
                          
                          <div class="col-md-4" style="display:none">
                              <label class="required">Cantidad Producida :</label>
                              <input type="text" id="cantidad_producida" name="cantidad_producida" class="form-control {{ $errors->has('cantidad_producida') ? ' is-invalid' : '' }}" value="{{old('cantidad_producida',$programacion_produccion->cantidad_producida)}}" >
                              @if ($errors->has('cantidad_producida'))
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $errors->first('cantidad_producida') }}</strong>
                              </span>
                              @endif
                          </div>
                              
                          <div class="col-md-8">
                            <label>Observación:</label>
                            <textarea type="text" placeholder="Observacion"
                                class="form-control {{ $errors->has('observacion') ? ' is-invalid' : '' }}"
                                name="observacion" id="observacion"  onkeyup="return mayus(this)"
                                value="{{old('observacion',$programacion_produccion->observacion)}}">{{old('observacion',$programacion_produccion->observacion)}}</textarea>
                            @if ($errors->has('observacion'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('observacion') }}</strong>
                            </span>
                            @endif
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

$('#fecha_creacion .input-group.date').datepicker({
    todayBtn: "linked",
    keyboardNavigation: false,
    forceParse: false,
    autoclose: true,
    language: 'es',
    format: "dd/mm/yyyy",
    //startDate: "today"
})
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
function validarFecha() {
    var enviar = false
    //var articulos = registrosArticulos()

    // No cumple correctamente la validación
    // if ($('#fecha').val() == '') {
    //     toastr.error('Ingrese Fecha de Emisión de la programacion_produccion.', 'Error');
    //     $("#fecha").focus();
    //     enviar = true;
    // }

    // if (articulos == 0) {
    //     toastr.error('Ingrese al menos 1  Artículo.', 'Error');
    //     enviar = true;
    // }
    return enviar
}

$('#enviar_programacion_produccion').submit(function(e) {
    e.preventDefault();
    var correcto = validarFecha()

    if (correcto == false) {
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
    }

})


</script>
@endpush