@extends('layout') @section('content')

@section('produccion-active', 'active')
@section('linea_produccion-active', 'active')

<div class="row wrapper border-bottom white-bg page-heading">

    <div class="col-lg-12">
       <h2  style="text-transform:uppercase"><b>MODIFICAR NUEVA LINEA DE PRODUCCION</b></h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{route('home')}}">Panel de Control</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{route('produccion.linea_produccion.index')}}">Lineas de produccion</a>
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

                    <form action="{{route('produccion.linea_produccion.update', $linea_produccion->id)}}" method="POST" id="enviar_linea_produccion">
                         @csrf @method('PUT')

                        <div class="row">
                            <div class="col-sm-6 b-r">
                                <h4 class=""><b>Lineas de Producción</b></h4>
                                <div class="row">
                                    <div class="col-md-12">
                                        <p>Modificar datos de la Linea de Producción:</p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="required">Nombre de Linea :</label>
                                    <input type="text" id="nombre_linea" name="nombre_linea" class="form-control {{ $errors->has('nombre_linea') ? ' is-invalid' : '' }}" value="{{old('nombre_linea',$linea_produccion->nombre_linea)}}" >
                                    @if ($errors->has('nombre_linea'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('nombre_linea') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label class="required">Cantidad de Personal :</label>
                                    <input type="number" id="cantidad_personal" name="cantidad_personal" class="form-control {{ $errors->has('cantidad_personal') ? ' is-invalid' : '' }}" value="{{old('cantidad_personal',$linea_produccion->cantidad_personal)}}" >
                                    @if ($errors->has('cantidad_personal'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('cantidad_personal') }}</strong>
                                        </span>
                                    @endif
                                </div>

                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
        
                                    <label>Flujo de Proceso (imagen) :</label>
                                    <input type="file" id="nombre_imagen" name="nombre_imagen" class="form-control {{ $errors->has('nombre_imagen') ? ' is-invalid' : '' }}" value="{{old('nombre_imagen',$linea_produccion->nombre_imagen)}}" >
                                    @if ($errors->has('nombre_imagen'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('nombre_imagen') }}</strong>
                                        </span>
                                    @endif
                                    
                                </div>
                                <div class="form-group">
                                    <label>Flujo de Proceso (archivo word) :</label>
                                    <input type="file" id="archivo_word" name="archivo_word" class="form-control {{ $errors->has('archivo_word') ? ' is-invalid' : '' }}" value="{{old('archivo_word',$linea_produccion->archivo_word)}}" >
                                    @if ($errors->has('archivo_word'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('archivo_word') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <input type="hidden" id="maquinarias_equipos_tabla" name="maquinarias_equipos_tabla[]">

                            </div>

                        </div>

                        <hr>

                        <div class="row">

                            <div class="col-lg-12">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <h4 class=""><b>Detalle de la Linea de Producción</b></h4>
                                    </div>
                                    <div class="panel-body">


                                        <div class="row">

                                            <div class="col-md-6">
                                                <label>Maquinaria Equipo</label>
                                                <select class="select2_form form-control"
                                                    style="text-transform: uppercase; width:100%" name="maquinaria_equipo_id"
                                                    id="maquinaria_equipo_id" ">
                                                    <option></option>
                                                    @foreach ($maquinarias_equipos as $maquinaria_equipo)
                                                    <option value="{{$maquinaria_equipo->id}}">{{$maquinaria_equipo->nombre}}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback"><b><span id="error-maquinaria_equipo"></span></b>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="amount">&nbsp;</label>
                                                    <a class="btn btn-block btn-warning enviar_maquinaria_equipo"
                                                        style='color:white;'> <i class="fa fa-plus"></i> AGREGAR</a>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>

                                        <div class="table-responsive">
                                            <table
                                                class="table dataTables-linea_produccion-detalle table-striped table-bordered table-hover"
                                                 onkeyup="return mayus(this)">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th class="text-center">ACCIONES</th>
                                                        <th class="text-center">MAQUINA-EQUIPO</th>
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
                                <a href="{{route('produccion.linea_produccion.index')}}" id="btn_cancelar"
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

$('#fecha .input-group.date').datepicker({
    todayBtn: "linked",
    keyboardNavigation: false,
    forceParse: false,
    autoclose: true,
    language: 'es',
    format: "dd/mm/yyyy",
    //startDate: "today"
})


$('#cantidad_personal').on('input', function() {
     this.value = this.value.replace(/[^0-9]/g, '');
});


$('#enviar_linea_produccion').submit(function(e) {
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


$(document).ready(function() {
    // DataTables
    $('.dataTables-linea_produccion-detalle').DataTable({
        "dom": '<"html5buttons"B>lTfgitp',
        "buttons": [
        // {
        //         extend: 'excelHtml5',
        //         text: '<i class="fa fa-file-excel-o"></i> Excel',
        //         titleAttr: 'Excel',
        //         title: 'Detalle de linea_produccion Interna'
        //     },
        //     {
        //         titleAttr: 'Imprimir',
        //         extend: 'print',
        //         text: '<i class="fa fa-print"></i> Imprimir',
        //         customize: function(win) {
        //             $(win.document.body).addClass('white-bg');
        //             $(win.document.body).css('font-size', '10px');
        //             $(win.document.body).find('table')
        //                 .addClass('compact')
        //                 .css('font-size', 'inherit');
        //         }
        //     }
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
                        "<a class='btn btn-warning btn-sm modificarDetalle' id='editar_maquinaria_equipo' style='color:white;' title='Modificar'><i class='fa fa-edit'></i></a>" +
                        "<a class='btn btn-danger btn-sm' id='borrar_maquinaria_equipo' style='color:white;' title='Eliminar'><i class='fa fa-trash'></i></a>" +
                        "</div>";
                }
            },
            {
                "targets": [2],
            },
        ],

    });
    obtenerTabla()
   
})

function obtenerTabla() {
    var t = $('.dataTables-linea_produccion-detalle').DataTable();
    @foreach($detalles as $detalle)

    t.row.add([
        "{{$detalle->maquinaria_equipo->id}}",
        '',
        "{{$detalle->maquinaria_equipo->nombre}}",
        "{{$detalle->cantidad_personal}}",
    ]).draw(false);
    @endforeach
}

//Editar Registro --REVISAR parece que no se usa
$(document).on('click', '#editar_maquinaria_equipo', function(event) {
    var table = $('.dataTables-linea_produccion-detalle').DataTable();
    var data = table.row($(this).parents('tr')).data();

    $('#indice').val(table.row($(this).parents('tr')).index());
    $('#maquinaria_equipo_id_editar').val(data[0]).trigger('change');
    $('#modal_editar_linea_produccion').modal('show');
})

//Borrar registro de maquinaria_equipos
$(document).on('click', '#borrar_maquinaria_equipo', function(event) {

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
            var table = $('.dataTables-linea_produccion-detalle').DataTable();
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
$(".enviar_maquinaria_equipo").click(function() {
    limpiarErrores()
    var enviar = false;
    if ($('#maquinaria_equipo_id').val() == '') {
        toastr.error('Seleccione Maquinaria Equipo.', 'Error');
        enviar = true;
        $('#maquinaria_equipo_id').addClass("is-invalid")
        $('#error-maquinaria_equipo').text('El campo Maquinaria-Equipo es obligatorio.')
    } else {
        var existe = buscarMaquinariaEquipo($('#maquinaria_equipo_id').val())
        if (existe == true) {
            toastr.error('Maquinaria Equipo ya se encuentra ingresado.', 'Error');
            enviar = true;
        }
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
                var nombre_maquinaria_equipo = obtenerMaquinariaEquipo($('#maquinaria_equipo_id').val())
                //console.log(nombre_maquinaria_equipo)
                var detalle = {
                    maquinaria_equipo_id: $('#maquinaria_equipo_id').val(),
                    nombre: nombre_maquinaria_equipo,
                }
                limpiarDetalle()
                //console.log(detalle)
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
    // $('#cantidad_devuelta').val('')
    $('#maquinaria_equipo_id').val($('#maquinaria_equipo_id option:first-child').val()).trigger('change');
}

function limpiarErrores() {
    $('#cantidad_personal').removeClass("is-invalid")
    $('#error-cantidad_personal').text('')

    $('#maquinaria_equipo_id').removeClass("is-invalid")
    $('#error-maquinaria_equipo').text('')
}

function agregarTabla($detalle) {

    var t = $('.dataTables-linea_produccion-detalle').DataTable();
    t.row.add([
        '',
        $detalle.maquinaria_equipo_id,
        $detalle.nombre,
    ]).draw(false);
    cargarmaquinaria_equipos()
}

function obtenerMaquinariaEquipo($id) {
    var maquinaria_equipo = ""
    @foreach($maquinarias_equipos as $maquinaria_equipo)
    if ("{{$maquinaria_equipo->id}}" == $id) {
        maquinaria_equipo = "{{$maquinaria_equipo->nombre}}"
    }
    @endforeach
    return maquinaria_equipo;
}

function nombreMaquinariaEquipo($nombre) {
    var maquinaria_equipo = ""
    @foreach($maquinarias_equipos as $maquinaria_equipo)
    if ("{{$maquinaria_equipo->nombre}}" == $nombre) {
        maquinaria_equipo = "{{$maquinaria_equipo->simbolo}}"
    }
    @endforeach
    return maquinaria_equipo;
}

function buscarMaquinariaEquipo(id) {
    var existe = false;
    var t = $('.dataTables-linea_produccion-detalle').DataTable();
    t.rows().data().each(function(el, index) {
        if (el[0] == id) {
            existe = true
        }
    });
    return existe
}

function cargarmaquinaria_equipos() {
    var maquinarias_equipos = [];
    var table = $('.dataTables-linea_produccion-detalle').DataTable();
    var data = table.rows().data();
    data.each(function(value, index) {
        let fila = {
            maquinaria_equipo_id: value[1],
            nombre: value[2],
        };
        maquinarias_equipos.push(fila);
    });
    console.log(maquinarias_equipos);
    $('#maquinarias_equipos_tabla').val(JSON.stringify(maquinarias_equipos));
}


function registrosmaquinaria_equipos() {
    var table = $('.dataTables-linea_produccion-detalle').DataTable();
    var registros = table.rows().data().length;
    return registros
}


</script>
@endpush