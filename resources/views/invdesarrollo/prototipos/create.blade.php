@extends('layout') @section('content')

@section('invdesarrollo-active', 'active')
@section('prototipos-active', 'active')

<div class="row wrapper border-bottom white-bg page-heading">

    <div class="col-lg-12">
       <h2  style="text-transform:uppercase"><b>REGISTRAR NUEVO PROTOTIPO</b></h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{route('home')}}">Panel de Control</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{route('invdesarrollo.prototipo.index')}}">Prototipos</a>
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

                    <form action="{{route('invdesarrollo.prototipo.store')}}" method="POST" id="enviar_prototipo" enctype="multipart/form-data">
                        {{csrf_field()}}

                        <div class="row">
                            <div class="col-sm-6 b-r">
                                <div class="form-group">
                                    <label>Producto :</label>
                                    <input type="text" id="producto" name="producto" class="form-control {{ $errors->has('producto') ? ' is-invalid' : '' }}" value="{{old('producto')}}" >
                                    @if ($errors->has('producto'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('producto') }}</strong>
                                    </span>
                                    @endif
                                </div>

                               <div class="form-group" id="fecha">
                                    <label>Fecha Registro:</label> 
                                    <div class="input-group date">
                                          <span class="input-group-addon">
                                              <i class="fa fa-calendar"></i>
                                          </span>
                                          <input type="text" id="fecha_registro" name="fecha_registro"
                                              class="form-control {{ $errors->has('fecha_registro') ? ' is-invalid' : '' }}"
                                              value="{{old('fecha_registro')}}"
                                              autocomplete="off" readonly required>
                                          @if ($errors->has('fecha_registro'))
                                          <span class="invalid-feedback" role="alert">
                                              <strong>{{ $errors->first('fecha_registro') }}</strong>
                                          </span>
                                          @endif
                                      </div>
                                </div>

                               <div class="form-group" id="fecha">
                                    <label>Fecha Inicio:</label> 
                                    <div class="input-group date">
                                          <span class="input-group-addon">
                                              <i class="fa fa-calendar"></i>
                                          </span>
                                          <input type="text" id="fecha_inicio" name="fecha_inicio"
                                              class="form-control {{ $errors->has('fecha_inicio') ? ' is-invalid' : '' }}"
                                              value="{{old('fecha_inicio')}}"
                                              autocomplete="off" readonly required>
                                          @if ($errors->has('fecha_inicio'))
                                          <span class="invalid-feedback" role="alert">
                                              <strong>{{ $errors->first('fecha_inicio') }}</strong>
                                          </span>
                                          @endif
                                      </div>
                                </div>

                               <div class="form-group" id="fecha">
                                    <label>Fecha Fin:</label> 
                                    <div class="input-group date">
                                          <span class="input-group-addon">
                                              <i class="fa fa-calendar"></i>
                                          </span>
                                          <input type="text" id="fecha_fin" name="fecha_fin"
                                              class="form-control {{ $errors->has('fecha_fin') ? ' is-invalid' : '' }}"
                                              value="{{old('fecha_fin')}}"
                                              autocomplete="off" readonly required>
                                          @if ($errors->has('fecha_fin'))
                                          <span class="invalid-feedback" role="alert">
                                              <strong>{{ $errors->first('fecha_fin') }}</strong>
                                          </span>
                                          @endif
                                      </div>
                                </div>
                             </div>
                             <div class="col-sm-6">
                               <div class="form-group">
                                    <label>Registro:</label> 
                                    <input type="text" class="form-control {{ $errors->has('registro') ? ' is-invalid' : '' }}" name="registro" id="registro" value="{{old('registro')}}" onkeyup="return mayus(this)">

                                    @if ($errors->has('registro'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong id="error-registro-guardar">{{ $errors->first('registro') }}</strong>
                                    </span>
                                    @endif
                                </div>

                               <div class="form-group">
                                    <div class="custom1-file">
                                    <label>Imagen:</label> 
                                    <input type="file" class="form-control custom1-file-input {{ $errors->has('imagen') ? ' is-invalid' : '' }}" name="imagen" id="imagen" value="{{old('imagen')}}" onkeyup="return mayus(this)" accept="image/*">

                                    @if ($errors->has('imagen'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong id="error-imagen-guardar">{{ $errors->first('imagen') }}</strong>
                                    </span>
                                    @endif
                                    </div>
                                </div>

                                
                               <div class="form-group">
                                    <div class="custom2-file">
                                    <label>Archivo Word:</label> 
                                    <input type="file" class="form-control custom2-file-input {{ $errors->has('archivo_word') ? ' is-invalid' : '' }}" name="archivo_word" id="archivo_word" value="{{old('archivo_word')}}" onkeyup="return mayus(this)" accept=".doc,.docx">

                                    @if ($errors->has('archivo_word'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong id="error-archivo_word-guardar">{{ $errors->first('archivo_word') }}</strong>
                                    </span>
                                    @endif
                                    </div>
                                </div>
                                <input type="hidden" id="articulos_tabla" name="articulos_tabla[]">
                            </div>
                        </div>
                        <hr>
                       
                        
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <h4 class=""><b>Detalle de la Prototipos</b></h4>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row">
                                           <div class="col-md-4">
                                                <label class="required">Nombre Articulo :</label>
                                                <input type="text" id="nombre_articulo" name="nombre_articulo" class="form-control {{ $errors->has('nombre_articulo') ? ' is-invalid' : '' }}" value="{{old('nombre_articulo')}}" >
                                                @if ($errors->has('nombre_articulo'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('nombre_articulo') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                            <div class="col-md-2">
                                                <label>Cantidad :</label>
                                                <input type="number" id="cantidad" name="cantidad" class="form-control {{$errors->has('cantidad') ? ' is-invalid' : '' }}" value="{{old('cantidad')}}">                                            
                                                @if ($errors->has('cantidad'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('cantidad') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                            <div class="col-md-6">
                                                <label>Observación :</label>
                                                <textarea type="text" id="observacion" name="observacion" class="form-control {{ $errors->has('observacion') ? ' is-invalid' : '' }}" value="{{old('observacion')}}" ></textarea>
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
                                                class="table dataTables-prototipos-detalle table-striped table-bordered table-hover"
                                                 onkeyup="return mayus(this)">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th class="text-center">ACCIONES</th>
                    									<th class="text-center">Nombre Articulo</th>
                    									<th class="text-center">Cantidad</th>
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
@include('invdesarrollo.prototipos.modal')
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

function validarFecha() {
    var enviar = false
    var articulos = registrosArticulos()

    // if ($('#fecha').val() == '') {
    //     toastr.error('Ingrese Fecha de Emisión de la Prototipos.', 'Error');
    //     $("#fecha").focus();
    //     enviar = true;
    // }

    if (articulos == 0) {
        toastr.error('Ingrese al menos 1  Artículo.', 'Error');
        enviar = true;
    }
    return enviar
}

$('#enviar_prototipo').submit(function(e) {
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
    $('.dataTables-prototipos-detalle').DataTable({
        "dom": '<"html5buttons"B>lTfgitp',
        "buttons": [
            // {
            //     extend: 'excelHtml5',
            //     text: '<i class="fa fa-file-excel-o"></i> Excel',
            //     titleAttr: 'Excel',
            //     title: 'Detalle de Prototipos'
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

    $('.custom1-file-input').on('change', function() {
        var fileInput = document.getElementById('imagen');
        console.log(fileInput);
        var filePath = fileInput.value;
        var allowedExtensions = /(.jpg|.jpeg|.png)$/i;

        if(!allowedExtensions.exec(filePath)){
            toastr.error('Extensión inválida, formatos admitidos (.jpg . jpeg . png)','Error');
        }
    });

    $('.custom2-file-input').on('change', function() {
        var fileInput = document.getElementById('archivo_word');
        var filePath = fileInput.value;
        var allowedExtensions = /(.doc|.docx)$/i;

        if(!allowedExtensions.exec(filePath)){
            toastr.error('Extensión inválida, formatos admitidos (.doc .docx)','Error');
        }
    });
})

//Editar Registro --REVISAR
$(document).on('click', '#editar_detalle', function(event) {
    var table = $('.dataTables-prototipos-detalle').DataTable();
    var data = table.row($(this).parents('tr')).data();

    $('#indice').val(table.row($(this).parents('tr')).index());
    $('#articulo_nombre_editar').val(data[0]).trigger('change');
    $('#cantidad_editar').val(data[1]);
    $('#observacion_editar').val(data[2]);
    $('#modal_editar_prototipo').modal('show');
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
            var table = $('.dataTables-prototipos-detalle').DataTable();
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
                    nombre_articulo: $('#nombre_articulo').val(),
                    cantidad: $('#cantidad').val(),
                    observacion: $('#observacion').val(),
                    created_at: $('#created_at').val(),
                    updated_at: $('#updated_at').val(),
                    
                }
                limpiarDetalle()
                agregarTabla(detalle);
                // calcularDato($('#dato').val())  // se usa para campos calculados
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
    $('#nombre_articulo').val('')
    $('#cantidad').val('')
    $('#observacion').val('')
 
    //$('#articulo_id').val($('#articulo_id option:first-child').val()).trigger('change');
}

function limpiarErrores() {
    $('#nombre_articulo').removeClass("is-invalid")
    $('#error-nombre_articulo').text('')
    $('#cantidad').removeClass("is-invalid")
    $('#error-cantidad').text('')
    $('#observacion').removeClass("is-invalid")
    $('#error-observacion').text('')
   
}

function agregarTabla($detalle) {
    var t = $('.dataTables-prototipos-detalle').DataTable();
    t.row.add([
        '','',
    	$detalle.nombre_articulo,
        $detalle.cantidad,
        $detalle.observacion,
    ]).draw(false);
    cargarArticulos();   //Se usa para cargar los articulos cuando hay detalle
}


function cargarArticulos() {
    var articulos = [];
    var table = $('.dataTables-prototipos-detalle').DataTable();
    var data = table.rows().data();
    data.each(function(value, index) {
        let fila = {
            nombre_articulo: value[2],
            cantidad: value[3],
            observacion: value[4],
        };
        articulos.push(fila);
    });
    console.log(articulos);
    $('#articulos_tabla').val(JSON.stringify(articulos));
}

function registrosArticulos() {
    var table = $('.dataTables-prototipos-detalle').DataTable();
    var registros = table.rows().data().length;
    return registros
}

</script>
@endpush