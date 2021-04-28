@extends('layout') @section('content')

@section('almacenes-active', 'active')
@section('ingreso_mercaderia-active', 'active')

<div class="row wrapper border-bottom white-bg page-heading">

    <div class="col-lg-12">
       <h2  style="text-transform:uppercase"><b>REGISTRAR NUEVOS INGRESOS DE MERCADERIA</b></h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{route('home')}}">Panel de Control</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{route('almacenes.ingreso_mercaderia.index')}}">Ingresos de Mercaderia</a>
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

                    <form action="{{route('almacenes.ingreso_mercaderia.store')}}" method="POST" id="enviar_ingresos_mercaderia">
                        {{csrf_field()}}

                        <div class="row">
                            <div class="col-sm-6 b-r">
                                <h4 class=""><b>Ingresos de Mercaderia</b></h4>
                                <div class="row">
                                    <div class="col-md-12">
                                        <p>Registrar datos de la Ingresos Mercaderia :</p>
                                    </div>
                                </div>
                            	<div class="form-group row">
                                    <div class="col-sm-6">
                                        <label class="required">Factura :</label>
                                        <input type="text" id="factura" name="factura" class="form-control {{ $errors->has('factura') ? ' is-invalid' : '' }}" value="{{old('factura')}}" >
                                        @if ($errors->has('factura'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('factura') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    
                                    <div class="col-sm-6"  id="fecha_ingreso">
                                        <label>Fecha de Ingreso</label>
                                        <div class="input-group date">
                                            <span class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </span>
                                            <input type="text" id="fecha_ingreso" name="fecha_ingreso"
                                                class="form-control {{ $errors->has('fecha') ? ' is-invalid' : '' }}"
                                                value="{{old('fecha_ingreso',getFechaFormato($fecha_hoy, 'd/m/Y'))}}"
                                                autocomplete="off" readonly required>
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
                                        <label class="required">Articulo</label>
                                        <select name="articulo_id" id="articulo_id" class="form-control">
                                            <option value="">Seleccionar Articulo</option>
                                            @foreach ($articulos as $articulo)
                                                <option {{ old('articulo_id') == $articulo->id ? 'selected' : '' }} value="{{$articulo->id}}">{{$articulo->descripcion}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                   
                                    <div class="col-sm-4">
                                        <label>Lote :</label>
                                        <input type="text" id="lote" name="lote" class="form-control {{ $errors->has('lote') ? ' is-invalid' : '' }}" value="{{old('lote')}}" >
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
                                   <div class="col-sm-6" id="fecha_produccion">
                                        <label>Fecha de Producción</label>
                                        <div class="input-group date">
                                            <span class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </span>
                                            <input type="text" id="fecha_produccion" name="fecha_produccion"
                                                class="form-control {{ $errors->has('fecha_produccion') ? ' is-invalid' : '' }}"
                                                value="{{old('fecha_produccion',getFechaFormato($fecha_hoy, 'd/m/Y'))}}"
                                                autocomplete="off" readonly required>
                                            @if ($errors->has('fecha_produccion'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('fecha_produccion') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                
                                    <div class="col-sm-6"  id="fecha_vencimiento">
                                        <label>Fecha de Vencimiento</label>
                                        <div class="input-group date">
                                            <span class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </span>
                                            <input type="text" id="fecha_vencimiento" name="fecha_vencimiento"
                                                class="form-control {{ $errors->has('fecha_vencimiento') ? ' is-invalid' : '' }}"
                                                value="{{old('fecha_vencimiento',getFechaFormato($fecha_hoy, 'd/m/Y'))}}"
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
                                        <label class="required">Proveedor</label>
                                        <select name="proveedor_id" id="proveedor_id" class="form-control">
                                            <option value="">Seleccionar Proveedor</option>
                                            @foreach ($proveedores as $proveedor)
                                                <option {{ old('proveedor_id') == $proveedor->id ? 'selected' : '' }} value="{{$proveedor->id}}">{{$proveedor->descripcion}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                  
                                    <div class="col-sm-4">
                                        <label>Peso Embalaje Dscto :</label>
                                        <input type="number" id="peso_embalaje_dscto" name="peso_embalaje_dscto" class="form-control {{ $errors->has('peso_embalaje_dscto') ? ' is-invalid' : '' }}" value="{{old('peso_embalaje_dscto')}}" >
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
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <h4 class=""><b>Detalle de la Ingresos Mercaderia</b></h4>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row">
                                        	<div class="col-sm-3">
                                                <label class="col-form-label">Peso Bruto</label>
                                                <input type="number" id="peso_bruto" class="form-control">
                                                <div class="invalid-feedback"><b><span id="error-peso_bruto"></span></b>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <label class="col-form-label">Peso Neto</label>
                                                <input type="number" id="peso_neto" class="form-control">
                                                <div class="invalid-feedback"><b><span id="error-peso_neto"></span></b>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                               <label>Observación:</label>
                                                <textarea type="text" placeholder=""
                                                    class="form-control {{ $errors->has('observacion') ? ' is-invalid' : '' }}"
                                                    name="observacion" id="observacion"  onkeyup="return mayus(this)"
                                                    value="{{old('observacion')}}">{{old('observacion')}}</textarea>
                                                @if ($errors->has('observacion'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('observacion') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                            
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label" for="amount">&nbsp;</label>
                                                <a class="btn btn-block btn-warning enviar_detalle"
                                                    style='color:white;'> <i class="fa fa-plus"></i> AGREGAR</a>
                                            </div>
                                        </div>
                                        <hr>

                                        <div class="table-responsive">
                                            <table
                                                class="table dataTables-ingreso_mercaderia-detalle table-striped table-bordered table-hover"
                                                 onkeyup="return mayus(this)">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th class="text-center">ACCIONES</th>
                                                        <th class="text-center">Peso Bruto</th>
                    									<th class="text-center">Peso Neto</th>
                    									<th class="text-center">Observacion</th>
                    									
                                                    </tr>
                                                </thead>
                                                <tbody>

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
                                <a href="{{route('almacenes.ingreso_mercaderia.index')}}" id="btn_cancelar"
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
@include('almacenes.ingresos_mercaderia.modal')
@stop

@push('styles')
<link href="{{ asset('Inspinia/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}"
    rel="stylesheet">
<link href="{{ asset('Inspinia/css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
<link href="{{ asset('Inspinia/css/plugins/daterangepicker/daterangepicker-bs3.css') }}" rel="stylesheet">
<link href="{{ asset('Inspinia/css/plugins/select2/select2.min.css') }}" rel="stylesheet">


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




<script>
//Select2
$(".select2_form").select2({
    placeholder: "SELECCIONAR",
    allowClear: true,
    width: '100%',
});

$('#fecha_ingreso .input-group.date').datepicker({
    todayBtn: "linked",
    keyboardNavigation: false,
    forceParse: false,
    autoclose: true,
    language: 'es',
    format: "dd/mm/yyyy",
})
$('#fecha_produccion .input-group.date').datepicker({
    todayBtn: "linked",
    keyboardNavigation: false,
    forceParse: false,
    autoclose: true,
    language: 'es',
    format: "dd/mm/yyyy",

})
$('#fecha_vencimiento .input-group.date').datepicker({
    todayBtn: "linked",
    keyboardNavigation: false,
    forceParse: false,
    autoclose: true,
    language: 'es',
    format: "dd/mm/yyyy",
})

function validarFecha() {
    var enviar = false
    var articulos = registrosArticulos()

    // if ($('#fecha').val() == '') {
    //     toastr.error('Ingrese Fecha de Emisión de la Ingresos Mercaderia.', 'Error');
    //     $("#fecha").focus();
    //     enviar = true;
    // }

    if (articulos == 0) {
        toastr.error('Ingrese al menos 1  Artículo.', 'Error');
        enviar = true;
    }
    return enviar
}

$('#enviar_ingreso_mercaderia').submit(function(e) {
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


$(document).ready(function() {

    // DataTables
    $('.dataTables-ingreso_mercaderia-detalle').DataTable({
        "dom": '<"html5buttons"B>lTfgitp',
        "buttons": [
            // {
            //     extend: 'excelHtml5',
            //     text: '<i class="fa fa-file-excel-o"></i> Excel',
            //     titleAttr: 'Excel',
            //     title: 'Detalle de Ingresos Mercaderia'
            // },
            // {
            //     titleAttr: 'Imprimir',
            //     extend: 'print',
            //     text: '<i class="fa fa-print"></i> Imprimir',
            //     customize: function(win) {
            //         $(win.document.body).addClass('white-bg');
            //         $(win.document.body).css('font-size', '10px');
            //         $(win.document.body).find('table')
            //             .addClass('compact')
            //             .css('font-size', 'inherit');
            //     }
            // }
        ],
        "bPaginate": true,
        "bLengthChange": true,
        "bFilter": true,
        "bInfo": true,
        "bAutoWidth": false,
        "language": {
            "url": "{{asset('Spanish.json')}}"
        },

        "columnDefs": [{
                "targets": [0],
                "visible": false,
                "searchable": false
            },
            {

                "targets": [1],
                className: "text-center",
                render: function(data, type, row) {
                    return "<div class='btn-group'>" +
                        "<a class='btn btn-warning btn-sm modificarDetalle' id='editar_detalle' style='color:white;' title='Modificar'><i class='fa fa-edit'></i></a>" +
                        "<a class='btn btn-danger btn-sm' id='borrar_detalle' style='color:white;' title='Eliminar'><i class='fa fa-trash'></i></a>" +
                        "</div>";
                }
            },
            {
                "targets": [2],
            },
            {
                "targets": [3],
                className: "text-center",
            },
            {
                "targets": [4],
                className: "text-center",
            },

        ],

    });

})

//Borrar registro de articulos
$(document).on('click', '#borrar_detalle', function(event) {

    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger',
        },
        buttonsStyling: false
    })

    Swal.fire({
        title: 'Opción Eliminar',
        text: "¿Seguro que desea eliminar Artículo?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: "#1ab394",
        confirmButtonText: 'Si, Confirmar',
        cancelButtonText: "No, Cancelar",
    }).then((result) => {
        if (result.isConfirmed) {
            var table = $('.dataTables-ingresos_mercaderia-detalle').DataTable();
            table.row($(this).parents('tr')).remove().draw();

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



});


//Validacion al ingresar tablas
$(".enviar_detalle").click(function() {
    limpiarErrores()
    var enviar = false;
    // if ($('#articulo_id').val() == '') {
    //     toastr.error('Seleccione artículo.', 'Error');
    //     enviar = true;
    //     $('#articulo_id').addClass("is-invalid")
    //     $('#error-articulo').text('El campo Artículo es obligatorio.')
    // } else {
    //     var existe = buscarArticulo($('#articulo_id').val())
    //     if (existe == true) {
    //         toastr.error('Artículo ya se encuentra ingresado.', 'Error');
    //         enviar = true;
    //     }
    // }
    
    if (enviar != true) {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger',
            },
            buttonsStyling: false
        })

        Swal.fire({
            title: 'Opción Agregar',
            text: "¿Seguro que desea agregar Artículo?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: "#1ab394",
            confirmButtonText: 'Si, Confirmar',
            cancelButtonText: "No, Cancelar",
        }).then((result) => {
            if (result.isConfirmed) {

                var detalle = {
                	peso_bruto: $('#peso_bruto').val(),
                    peso_neto: $('#peso_neto').val(),
                    observacion: $('#observacion').val(),
                   
                }
                limpiarDetalle()
                agregarTabla(detalle);

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

function limpiarDetalle() {
	$('#peso_bruto').val('')
    $('#peso_neto').val('')
    $('#observacion').val('')
    //$('#articulo_id').val($('#articulo_id option:first-child').val()).trigger('change');
}

function limpiarErrores() {
	$('#peso_bruto').removeClass("is-invalid")
    $('#error-peso_bruto').text('')
    $('#peso_neto').removeClass("is-invalid")
    $('#error-peso_neto').text('')
    $('#observacion').removeClass("is-invalid")
    $('#error-observacion').text('')
  
}

function agregarTabla($detalle) {
    var t = $('.dataTables-ingreso_mercaderia-detalle').DataTable();
    t.row.add([
        '','',
    	$detalle.peso_bruto,
    	$detalle.peso_neto,
    	$detalle.observacion,
    ]).draw(false);
    cargarDetalle()
}

function buscarArticulo(id) {
    var existe = false;
    var t = $('.dataTables-ingreso_mercaderia-detalle').DataTable();
    t.rows().data().each(function(el, index) {
        if (el[0] == id) {
            existe = true
        }
    });
    return existe
}

function cargarDetalle() {
    var articulos = [];
    var table = $('.dataTables-ingreso_mercaderia-detalle').DataTable();
    var data = table.rows().data();
    data.each(function(value, index) {
        let fila = {
            peso_bruto: value[2],
            peso_neto: value[3],
            observacion: value[4],
        };

        articulos.push(fila);

    });
    $('#articulos_tabla').val(JSON.stringify(articulos))
}

function registrosArticulos() {
    var table = $('.dataTables-ingreso_mercaderia-detalle').DataTable();
    var registros = table.rows().data().length;
    return registros
}

</script>
@endpush