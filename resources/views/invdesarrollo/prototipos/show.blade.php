@extends('layout') @section('content')

@section('invdesarrollo-active', 'active')
@section('prototipo-active', 'active')

<div class="row wrapper border-bottom white-bg page-heading">

    <div class="col-lg-12">
       <h2  style="text-transform:uppercase"><b>Detalle de Prototipo : # {{$prototipo->id}}</b></h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{route('home')}}">Panel de Control</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{route('invdesarrollo.prototipo.index')}}">Prototipos</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Detalle</strong>
            </li>

        </ol>
    </div>
    <div class="col-lg-4">
        <div class="title-action">
            <a href="{{route('invdesarrollo.prototipo.edit', $prototipo->id)}}" class="btn btn-warning btn-sm"><i
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
                           
                                
                                  <div class="form-group">
                                      <label>Producto :</label>
                                      <input type="text" id="producto" name="producto" class="form-control {{ $errors->has('producto') ? ' is-invalid' : '' }}" value="{{old('producto',$prototipo->producto)}}" disabled>
                                      @if ($errors->has('producto'))
                                      <span class="invalid-feedback" role="alert">
                                          <strong>{{ $errors->first('producto') }}</strong>
                                      </span>
                                      @endif
                                  </div>

                                 <div class="form-group">
                                      <label>Fecha Registro:</label> 
                                      <input type="date" class="form-control {{ $errors->has('fecha_registro') ? ' is-invalid' : '' }}" name="fecha_registro" id="fecha_registro" value="{{old('fecha_registro',$prototipo->fecha_registro)}}" onkeyup="return mayus(this)" disabled>

                                      @if ($errors->has('fecha_registro'))
                                      <span class="invalid-feedback" role="alert">
                                          <strong id="error-fecha_registro-guardar">{{ $errors->first('fecha_registro') }}</strong>
                                      </span>
                                      @endif
                                  </div>

                                 <div class="form-group">
                                      <label>Fecha Inicio:</label> 
                                      <input type="date" class="form-control {{ $errors->has('fecha_inicio') ? ' is-invalid' : '' }}" name="fecha_inicio" id="fecha_inicio" value="{{old('fecha_inicio',$prototipo->fecha_inicio)}}" onkeyup="return mayus(this)" disabled>

                                      @if ($errors->has('fecha_inicio'))
                                      <span class="invalid-feedback" role="alert">
                                          <strong id="error-fecha_inicio-guardar">{{ $errors->first('fecha_inicio') }}</strong>
                                      </span>
                                      @endif
                                  </div>

                                 <div class="form-group">
                                      <label>Fecha Fin:</label> 
                                      <input type="date" class="form-control {{ $errors->has('fecha_fin') ? ' is-invalid' : '' }}" name="fecha_fin" id="fecha_fin" value="{{old('fecha_fin',$prototipo->fecha_fin)}}" onkeyup="return mayus(this)" disabled>

                                      @if ($errors->has('fecha_fin'))
                                      <span class="invalid-feedback" role="alert">
                                          <strong id="error-fecha_fin-guardar">{{ $errors->first('fecha_fin') }}</strong>
                                      </span>
                                      @endif
                                  </div>
                                </div>
                                <div class="col-sm-6">
                                   <div class="form-group">
                                        <label>Registro:</label> 
                                        <input type="text" class="form-control {{ $errors->has('registro') ? ' is-invalid' : '' }}" name="registro" id="registro" value="{{old('registro',$prototipo->registro)}}" onkeyup="return mayus(this)" disabled>

                                        @if ($errors->has('registro'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong id="error-registro-guardar">{{ $errors->first('registro') }}</strong>
                                        </span>
                                        @endif
                                    </div>

                                   <div class="form-group">
                                        <label>Imagen:</label> 
                                        <input type="file" class="form-control {{ $errors->has('imagen') ? ' is-invalid' : '' }}" name="imagen" id="imagen" value="{{old('imagen',$prototipo->imagen)}}" onkeyup="return mayus(this)" disabled>

                                        @if ($errors->has('imagen'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('imagen') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    
                              
                                     <div class="form-group">
                                          <label>Archivo Word:</label> 
                                        <input type="file" class="form-control {{ $errors->has('archivo_word') ? ' is-invalid' : '' }}" name="archivo_word" id="archivo_word" value="{{old('ruta_archivo_word',$prototipo->ruta_archivo_word)}}" onkeyup="return mayus(this)" disabled>

                                        @if ($errors->has('archivo_word'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong id="error-archivo_word-guardar">{{ $errors->first('archivo_word') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <input type="hidden" id="articulos_tabla" name="articulos_tabla[]">
                                  </div>
                        </div>
                        <hr>

                        <div class="row">

                            <div class="col-lg-12">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <h4 class=""><b>Detalle de Prototipo</b></h4>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row">
                                            
                                           
                                        </div>
                                        <hr>

                                        <div class="table-responsive">
                                            <table
                                                class="table dataTables-prototipo-detalle table-striped table-bordered table-hover"
                                                 onkeyup="return mayus(this)">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">Nombre Articulo</th>
                                                        <th class="text-center">Cantidad</th>
                                                        <th class="text-center">Observacion</th>
                                                        
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($detalles as $detalle)
                                                    <tr>
                                                        <td class="text-center">{{$detalle->nombre_articulo}}</td>
                                                        <td class="text-center">{{$detalle->cantidad}}</td>
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
                        <div class="hr-line-dashed"></div>
                        <div class="form-group row">

                            <div class="col-md-6 text-left" style="color:#fcbc6c">
                                <i class="fa fa-exclamation-circle"></i> <small>Los campos marcados con asterisco
                                    (<label class="required"></label>) son obligatorios.</small>
                            </div>

                            <div class="col-md-6 text-right">
                                <a href="{{route('invdesarrollo.prototipo.index')}}" id="btn_cancelar"
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
            window.location.href = "{{route('invdesarrollo.prototipo.reporte', $prototipo->id)}}"
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
            window.location.href = "{{route('invdesarrollo.prototipo.email', $prototipo->id)}}"
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