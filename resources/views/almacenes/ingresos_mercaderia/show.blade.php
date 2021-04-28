@extends('layout') @section('content')

@section('almacenes-active', 'active')
@section('ingreso_mercaderia-active', 'active')

<div class="row wrapper border-bottom white-bg page-heading">

    <div class="col-lg-12">
       <h2  style="text-transform:uppercase"><b>Detalle de Ingreso de Mercaderia: # {{$ingreso_mercaderia->id}}</b></h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{route('home')}}">Panel de Control</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{route('almacenes.ingreso_mercaderia.index')}}">Ingreso de Mercaderias</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Detalle</strong>
            </li>

        </ol>
    </div>
    <div class="col-lg-4">
        <div class="title-action">
            <a href="{{route('almacenes.ingreso_mercaderia.edit', $ingreso_mercaderia->id)}}" class="btn btn-warning btn-sm"><i
                    class="fa fa-edit"></i> Editar</a>
            <a href="#" onclick="generarReporte()" class="btn btn-danger btn-sm" style="display:none;"><i class="fa fa-file-pdf-o "></i>
                Reporte </a>
            <a href="#" onclick="enviarReporte()" class="btn btn-primary btn-sm" style="display:none;"><i class="fa fa-send "></i> Enviar </a>
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
                                    <p>Modificar datos de la ingreso_mercaderia interna:</p>
                                </div>
                            </div>

                            <div class="form-group row">

                                <div class="col-sm-6">
                                    <label class="required">Factura :</label>
                                    <input type="text" id="factura" name="factura" class="form-control {{ $errors->has('factura') ? ' is-invalid' : '' }}" value="{{old('factura',$ingreso_mercaderia->factura)}}" disabled>
                                    @if ($errors->has('factura'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('factura') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-sm-6">
                                    <label>Fecha de Ingreso</label>
                                    <div class="input-group date">
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                        <input type="text" id="fecha_ingreso" name="fecha_ingreso"
                                            class="form-control {{ $errors->has('fecha_ingreso') ? ' is-invalid' : '' }}"
                                            value="{{old('fecha_ingreso',getFechaFormato($ingreso_mercaderia->fecha_ingreso, 'd/m/Y'))}}"
                                            autocomplete="off" readonly required >
                                        @if ($errors->has('fecha_ingreso'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('fecha_ingreso') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                               <div class="col-sm-8">
                                    <label>Articulo</label>
                                    <select name="articulo_id" id="articulo_id" class="form-control" disabled>
                                        <option value="">Seleccionar Articulo</option>
                                        @foreach ($articulos as $articulo)
                                            <option {{ old('articulo_id',$ingreso_mercaderia->articulo_id) == $articulo->id ? 'selected' : '' }} value="{{$articulo->id}}">{{$articulo->descripcion}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                   
                                <div class="col-sm-4">
                                    <label>Lote :</label>
                                    <input type="text" id="lote" name="lote" class="form-control {{ $errors->has('lote') ? ' is-invalid' : '' }}" value="{{old('lote',$ingreso_mercaderia->lote)}}" disabled>
                                    @if ($errors->has('lote'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('lote') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group row">
                               <div class="col-sm-6">
                                    <label>Fecha de Producción</label>
                                    <div class="input-group date">
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                        <input type="text" id="fecha_produccion" name="fecha_produccion"
                                            class="form-control {{ $errors->has('fecha_produccion') ? ' is-invalid' : '' }}"
                                            value="{{old('fecha_produccion',getFechaFormato($ingreso_mercaderia->fecha_produccion, 'd/m/Y'))}}"
                                            autocomplete="off" readonly required>
                                        @if ($errors->has('fecha_produccion'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('fecha_produccion') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="col-sm-6">
                                    <label>Fecha de Vencimiento</label>
                                    <div class="input-group date">
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                        <input type="text" id="fecha_vencimiento" name="fecha_vencimiento"
                                            class="form-control {{ $errors->has('fecha_vencimiento') ? ' is-invalid' : '' }}"
                                            value="{{old('fecha_vencimiento',getFechaFormato($ingreso_mercaderia->fecha_vencimiento, 'd/m/Y'))}}"
                                            autocomplete="off" readonly required>
                                        @if ($errors->has('fecha_vencimiento'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('fecha_vencimiento') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                                
                            <div class="form-group row">
                                <div class="col-sm-8">
                                    <label>Proveedor</label>
                                    <select name="proveedor_id" id="proveedor_id" class="form-control" disabled>
                                        <option value="">Seleccionar Proveedor</option>
                                        @foreach ($proveedores as $proveedor)
                                            <option {{ old('proveedor_id',$ingreso_mercaderia->proveedor_id) == $proveedor->id ? 'selected' : '' }} value="{{$proveedor->id}}">{{$proveedor->descripcion}}</option>
                                        @endforeach
                                    </select>
                                </div>
                              
                                <div class="col-sm-4">
                                    <label class="required">Peso Embalaje Dscto :</label>
                                    <input type="number" id="peso_embalaje_dscto" name="peso_embalaje_dscto" class="form-control {{ $errors->has('peso_embalaje_dscto') ? ' is-invalid' : '' }}" value="{{$ingreso_mercaderia->peso_embalaje_dscto}}" disabled>
                                    @if ($errors->has('peso_embalaje_dscto'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('peso_embalaje_dscto') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <input type="hidden" id="articulos_tabla" name="articulos_tabla[]">
                    </div>
                    <hr>


                    <div class="table-responsive">
                        <table
                            class="table dataTables-ingreso_mercaderia-detalle table-striped table-bordered table-hover"
                             onkeyup="return mayus(this)">
                            <thead>
                                <tr>
                                    <th class="text-center">PESO BRUTO</th>
                                    <th class="text-center">PESO NETO</th>
                                    <th class="text-center">OBSERVACION</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($detalles as $detalle)
                                <tr>
                                    <td class="text-center">{{$detalle->peso_bruto}}</td>
                                    <td class="text-center">{{$detalle->peso_neto}}</td>
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
            window.location.href = "{{route('almacenes.ingreso_mercaderia.reporte', $ingreso_mercaderia->id)}}"
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
            window.location.href = "{{route('almacenes.ingreso_mercaderia.email', $ingreso_mercaderia->id)}}"
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