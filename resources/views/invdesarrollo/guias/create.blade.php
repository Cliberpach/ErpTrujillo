@extends('layout') @section('content')

@section('invdesarrollo-active', 'active')
@section('guia-active', 'active')

<div class="row wrapper border-bottom white-bg page-heading">

    <div class="col-lg-12">
       <h2  style="text-transform:uppercase"><b>REGISTRAR NUEVA GUIA INTERNA</b></h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{route('home')}}">Panel de Control</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{route('invdesarrollo.guia.index')}}">Guias Internas</a>
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

                    <form action="{{route('invdesarrollo.guia.store')}}" method="POST" id="enviar_guia">
                        {{csrf_field()}}

                        <div class="row">
                            <div class="col-sm-6 b-r">
                                <h4 class=""><b>Guia Interna</b></h4>
                                <div class="row">
                                    <div class="col-md-12">
                                        <p>Registrar datos de la guia interna:</p>
                                    </div>
                                </div>

                                

                                    <div class="form-group" id="prototipo">
                                        <label class="required">Producto : </label>
                                        <select
                                            class="select2_form form-control {{ $errors->has('prototipo_id') ? ' is-invalid' : '' }}"
                                            style="text-transform: uppercase; width:100%" value="{{old('prototipo_id')}}"
                                            name="prototipo_id" id="prototipo_id" required>
                                            <option></option>
                                            @foreach ($prototipos as $prototipo)
                                            <option value="{{$prototipo->id}}" @if(old('prototipo_id')==$prototipo->id )
                                                {{'selected'}} @endif >{{$prototipo->producto}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-6 col-xs-12" id="fecha">
                                        <label>Fecha de Emisión</label>
                                        <div class="input-group date">
                                            <span class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </span>
                                            <input type="text" id="fecha" name="fecha"
                                                class="form-control {{ $errors->has('fecha') ? ' is-invalid' : '' }}"
                                                value="{{old('fecha',getFechaFormato($fecha_hoy, 'd/m/Y'))}}"
                                                autocomplete="off" readonly required>
                                            @if ($errors->has('fecha'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('fecha') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>

                               
   
                            </div>

                            <div class="col-sm-6">


                                <div class="form-group row">
        

                                    <div class="col-md-4">
                                        <label class="required">Unidades a Producir :</label>
                                        <input type="number" id="unidades_a_producir" name="unidades_a_producir" class="form-control {{ $errors->has('unidades_a_producir') ? ' is-invalid' : '' }}" value="{{old('unidades_a_producir')}}" >
                                        @if ($errors->has('unidades_a_producir'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('unidades_a_producir') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="col-md-4">
                                        <label>Area Responsable 1 :</label>
                                        <input type="text" id="area_responsable1" name="area_responsable1" class="form-control {{ $errors->has('area_responsable1') ? ' is-invalid' : '' }}" value="{{old('area_responsable1')}}" >
                                        @if ($errors->has('area_responsable1'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('area_responsable1') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="col-md-4">
                                        <label>Area Responsable 2 :</label>
                                        <input type="text" id="area_responsable2" name="area_responsable2" class="form-control {{ $errors->has('area_responsable2') ? ' is-invalid' : '' }}" value="{{old('area_responsable2')}}" >
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
                                        name="observacion" id="observacion"  onkeyup="return mayus(this)"
                                        value="{{old('observacion')}}">{{old('observacion')}}</textarea>
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

                        <div class="row">

                            <div class="col-lg-12">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <h4 class=""><b>Detalle de la Guia interna</b></h4>
                                    </div>
                                    <div class="panel-body">


                                        <div class="row">

                                            <div class="col-md-6">
                                                <label>Artículo</label>
                                                <select class="select2_form form-control"
                                                    style="text-transform: uppercase; width:100%" name="articulo_id"
                                                    id="articulo_id" onchange="cargarPresentacion(this)">
                                                    <option></option>
                                                    @foreach ($articulos as $articulo)
                                                    <option value="{{$articulo->id}}">{{$articulo->descripcion}}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback"><b><span id="error-articulo"></span></b>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="">Presentación</label>
                                                <input type="text" id="presentacion" name="presentacion"
                                                    class="form-control" disabled>
                                                <div class="invalid-feedback"><b><span
                                                            id="error-presentacion"></span></b></div>
                                            </div>


                                        </div>

                                        <div class="row">
                                            <div class="col-sm-3">
                                                <label class="col-form-label">Cantidad Solicitada</label>
                                                <input type="number" id="cantidad_solicitada" class="form-control">
                                                <div class="invalid-feedback"><b><span id="error-cantidad_solicitada"></span></b>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <label class="col-form-label">Cantidad Entregada</label>
                                                <input type="number" id="cantidad_entregada" class="form-control">
                                                <div class="invalid-feedback"><b><span id="error-cantidad_entregada"></span></b>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <label class="col-form-label">Cantidad Devuelta</label>
                                                <input type="number" id="cantidad_devuelta" class="form-control">
                                                <div class="invalid-feedback"><b><span id="error-cantidad_devuelta"></span></b>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <label class="col-form-label">Observacion</label>
                                                <input type="text" id="observacion2" class="form-control">
                                                <div class="invalid-feedback"><b><span id="error-observacion2"></span></b>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="amount">&nbsp;</label>
                                                    <a class="btn btn-block btn-warning enviar_articulo"
                                                        style='color:white;'> <i class="fa fa-plus"></i> AGREGAR</a>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>

                                        <div class="table-responsive">
                                            <table
                                                class="table dataTables-guia-detalle table-striped table-bordered table-hover"
                                                 onkeyup="return mayus(this)">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th class="text-center">ACCIONES</th>
                                                        <th class="text-center">ARTICULO</th>
                                                        <th class="text-center">CANTIDAD SOLICITADA</th>
                                                        <th class="text-center">CANTIDAD ENTREGADA</th>
                                                        <th class="text-center">CANTIDAD DEVUELTA</th>
                                                        <th class="text-center">OBSERVACION</th>

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
                                <a href="{{route('invdesarrollo.guia.index')}}" id="btn_cancelar"
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
@include('invdesarrollo.guias.modal')
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

$('#fecha .input-group.date').datepicker({
    todayBtn: "linked",
    keyboardNavigation: false,
    forceParse: false,
    autoclose: true,
    language: 'es',
    format: "dd/mm/yyyy",
    startDate: "today"
})

        //sumaTotal();


// Solo campos numericos
$('#precio').keyup(function() {
    var val = $(this).val();
    if (isNaN(val)) {
        val = val.replace(/[^0-9\.]/g, '');
        if (val.split('.').length > 2)
            val = val.replace(/\.+$/, "");
    }
    $(this).val(val);
});


// $('#cantidad_solicitada').on('input', function() {
//     this.value = this.value.replace(/[^0-9]/g, '');
// });
// $('#cantidad_entregada').on('input', function() {
//     this.value = this.value.replace(/[^0-9]/g, '');
// });
// $('#cantidad_devuelta').on('input', function() {
//     this.value = this.value.replace(/[^0-9]/g, '');
// });


function validarFecha() {
    var enviar = false
    var articulos = registrosArticulos()

    // if ($('#fecha').val() == '') {
    //     toastr.error('Ingrese Fecha de Emisión de la Guia.', 'Error');
    //     $("#fecha").focus();
    //     enviar = true;
    // }

    if (articulos == 0) {
        toastr.error('Ingrese al menos 1  Artículo.', 'Error');
        enviar = true;
    }
    return enviar
}

$('#enviar_guia').submit(function(e) {
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
    $('.dataTables-guia-detalle').DataTable({
        "dom": '<"html5buttons"B>lTfgitp',
        "buttons": [
            // {
            //     extend: 'excelHtml5',
            //     text: '<i class="fa fa-file-excel-o"></i> Excel',
            //     titleAttr: 'Excel',
            //     title: 'Detalle de Guia Interna'
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
                        "<a class='btn btn-warning btn-sm modificarDetalle' id='editar_articulo' style='color:white;' title='Modificar'><i class='fa fa-edit'></i></a>" +
                        "<a class='btn btn-danger btn-sm' id='borrar_articulo' style='color:white;' title='Eliminar'><i class='fa fa-trash'></i></a>" +
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
            {
                "targets": [5],
                className: "text-center",
            },
 
        ],

    });

})

//Editar Registro --REVISAR
$(document).on('click', '#editar_articulo', function(event) {
    var table = $('.dataTables-guia-detalle').DataTable();
    var data = table.row($(this).parents('tr')).data();

    $('#indice').val(table.row($(this).parents('tr')).index());
    $('#articulo_id_editar').val(data[0]).trigger('change');
    $('#presentacion_editar').val(articuloPresentacion(data[0]));
    $('#precio_editar').val(data[4]);
    $('#cantidad_editar').val(data[5]);
    $('#modal_editar_orden').modal('show');
})

//Borrar registro de articulos
$(document).on('click', '#borrar_articulo', function(event) {

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
            var table = $('.dataTables-guia-detalle').DataTable();
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
$(".enviar_articulo").click(function() {
    limpiarErrores()
    var enviar = false;
    if ($('#articulo_id').val() == '') {
        toastr.error('Seleccione artículo.', 'Error');
        enviar = true;
        $('#articulo_id').addClass("is-invalid")
        $('#error-articulo').text('El campo Artículo es obligatorio.')
    } else {
        var existe = buscarArticulo($('#articulo_id').val())
        if (existe == true) {
            toastr.error('Artículo ya se encuentra ingresado.', 'Error');
            enviar = true;
        }
    }

    // if ($('#precio').val() == '') {

    //     toastr.error('Ingrese el precio del artículo.', 'Error');
    //     enviar = true;

    //     $("#precio").addClass("is-invalid");
    //     $('#error-precio').text('El campo Precio es obligatorio.')
    // }

    if ($('#cantidad_solicitada').val() == '') {
        toastr.error('Ingrese Cantidad Solicitada del artículo.', 'Error');
        enviar = true;

        $("#cantidad").addClass("is-invalid");
        $('#error-cantidad_solicitada').text('El campo Cantidad Solicitada es obligatorio.')
    }

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
                var descripcion_articulo = obtenerArticulo($('#articulo_id').val())
                var presentacion_articulo = obtenerPresentacion($('#presentacion').val())
                var detalle = {
                    articulo_id: $('#articulo_id').val(),
                    descripcion: descripcion_articulo,
                    cantidad_solicitada: $('#cantidad_solicitada').val(), 
                    cantidad_entregada: $('#cantidad_entregada').val(), 
                    cantidad_devuelta: $('#cantidad_devuelta').val(), 
                    observacion: $('#observacion2').val(),
                }
                limpiarDetalle()
                agregarTabla(detalle);
                // calcularIgv($('#igv').val())

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
    $('#cantidad_solicitada').val('')
    $('#cantidad_entregada').val('')    //REVISAR
    $('#cantidad_devuelta').val('')
    $('#articulo_id').val($('#articulo_id option:first-child').val()).trigger('change');
}

function limpiarErrores() {
    $('#cantidad_solicitada').removeClass("is-invalid")
    $('#error-cantidad_solicitada').text('')

    $('#cantidad_entregada').removeClass("is-invalid")
    $('#error-cantidad_entregada').text('')

    $('#cantidad_devuelta').removeClass("is-invalid")
    $('#error-cantidad_devuelta').text('')

    $('#articulo_id').removeClass("is-invalid")
    $('#error-articulo').text('')
}

function agregarTabla($detalle) {
    var t = $('.dataTables-guia-detalle').DataTable();
    t.row.add([
        '',
        $detalle.articulo_id,
        $detalle.descripcion,
        $detalle.cantidad_solicitada,
        $detalle.cantidad_entregada,
        $detalle.cantidad_devuelta,
        $detalle.observacion,
    ]).draw(false);

    cargarArticulos()

}


function obtenerArticulo($id) {
    var articulo = ""
    @foreach($articulos as $articulo)
    if ("{{$articulo->id}}" == $id) {
        articulo = "{{$articulo->descripcion}}"
    }
    @endforeach
    return articulo;
}

function obtenerPresentacion($descripcion) {
    var presentacion = ""
    @foreach($presentaciones as $presentacion)
    if ("{{$presentacion->descripcion}}" == $descripcion) {
        presentacion = "{{$presentacion->simbolo}}"
    }
    @endforeach
    return presentacion;
}

function cargarPresentacion(articulo) {
    var id = articulo.value
    var presentacion = ""
    @foreach($articulos as $articulo)
    if ("{{$articulo->id}}" == id) {
        presentacion = "{{$articulo->presentacion}}"
    }
    @endforeach
    //Añadir a input presentacion - precio de compra
    $('#presentacion').val(presentacion)
}

function buscarArticulo(id) {
    var existe = false;
    var t = $('.dataTables-guia-detalle').DataTable();
    t.rows().data().each(function(el, index) {
        if (el[0] == id) {
            existe = true
        }
    });
    return existe
}

function cargarArticulos() {
    var articulos = [];
    var table = $('.dataTables-guia-detalle').DataTable();
    var data = table.rows().data();
    data.each(function(value, index) {
        let fila = {
            articulo_id: value[1],
            descripcion: value[2],
            cantidad_solicitada: value[3],
            cantidad_entregada: value[4],
            cantidad_devuelta: value[5],
            observacion: value[6],
        };

        articulos.push(fila);

    });
    $('#articulos_tabla').val(JSON.stringify(articulos));
}

function registrosArticulos() {
    var table = $('.dataTables-guia-detalle').DataTable();
    var registros = table.rows().data().length;
    return registros
}

function articuloPresentacion(articulo) {
    var presentacion = ""
    @foreach($articulos as $articulo)
    if ("{{$articulo->id}}" == articulo) {
        presentacion = "{{$articulo->presentacion}}"
    }
    @endforeach
    return presentacion
}

function sumaTotal() {
    var t = $('.dataTables-guia-detalle').DataTable();
    var subtotal = 0;
    t.rows().data().each(function(el, index) {
        subtotal = Number(el[8]) + subtotal
    });
}

</script>
@endpush