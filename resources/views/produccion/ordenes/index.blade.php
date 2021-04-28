@extends('layout') @section('content')
@section('produccion-active', 'active')
@section('ordenes_produccion-active', 'active')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10 col-md-10">
       <h2  style="text-transform:uppercase"><b>Listado de Ordenes de Produccion</b></h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{route('home')}}">Panel de Control</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Ordenes de Produccion</strong>
            </li>
        </ol>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table dataTables-ordenes table-striped table-bordered table-hover"
                        style="text-transform:uppercase">
                            <thead>
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th class="text-center">Productos</th>
                                    <th class="text-center">Programacion de Produccion</th>
                                    <th class="text-center">Cantidad Produccida</th>
                                    <th class="text-center">Fecha de Producción</th>
                                    <th class="text-center">Observacion</th>
                                    <th class="text-center">PRODUCCION</th>
                                    <th class="text-center">ESTADO</th>
                                    <th class="text-center">Acciones</th>
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
</div>

@include('produccion.ordenes.destroy')
@include('produccion.lotes.create')
@include('produccion.lotes.edit')
@include('produccion.lotes.show')
@stop

@push('styles')
<!-- DataTable -->
<link href="{{asset('Inspinia/css/plugins/dataTables/datatables.min.css')}}" rel="stylesheet">
@endpush

@push('scripts')
<!-- DataTable -->
<script src="{{asset('Inspinia/js/plugins/dataTables/datatables.min.js')}}"></script>
<script src="{{asset('Inspinia/js/plugins/dataTables/dataTables.bootstrap4.min.js')}}"></script>

<script>
$(document).ready(function() {

    // DataTables
    $('.dataTables-ordenes').DataTable({
        "dom": '<"html5buttons"B>lTfgitp',
        "buttons": [{
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o"></i> Excel',
                titleAttr: 'Excel',
                title: 'Tablas Generales'
            },
            {
                titleAttr: 'Imprimir',
                extend: 'print',
                text: '<i class="fa fa-print"></i> Imprimir',
                customize: function(win) {
                    $(win.document.body).addClass('white-bg');
                    $(win.document.body).css('font-size', '10px');
                    $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size', 'inherit');
                }
            }
        ],
        "bPaginate": true,
        "bLengthChange": true,
        "bFilter": true,
        "bInfo": true,
        "bAutoWidth": false,
        "processing": true,
        "ajax": "{{ route('produccion.aprobado.getOrdenes')}}",
        "columns": [
            //programacion_produccion INTERNA
            { data: 'id',className: "text-center", sWidth: '5%',},
            { data: 'producto',className: "text-left", sWidth: '25%'},
            { data: 'programacion_id',className: "text-center"},
            { data: 'cantidad_programada',className: "text-center"},
            { data: 'fecha_orden',className: "text-center"},
            { data: 'observacion',className: "text-center"},
            {
                data: null,
                className: "text-center",
                render: function(data) {
                    switch (data.produccion) {
                        case "0":
                            return "<span class='badge badge-warning' d-block>PENDIENTE</span>";
                            break;
                        case "1":
                            return "<span class='badge badge-primary' d-block>ATENDIDA</span>";
                            break;
                        default:
                            return "<span class='badge badge-danger' d-block>NULO</span>";
                    }
                },
            },
            {
                data: null,
                className: "text-center",
                render: function(data) {
                    switch (data.estado) {
                        case "ANULADO":
                            return "<span class='badge badge-danger' d-block>" + data.estado +
                                "</span>";
                            break;
                        default:
                            return "<span class='badge badge-primary' d-block>" + data.estado +
                                "</span>";
                    }
                },
            },
            {
                data: null,
                className: "text-center",
                render: function(data) {
                    //Ruta Detalle
                    var url_detalle = '{{ route("produccion.orden.show", ":id")}}';
                    url_detalle = url_detalle.replace(':id', data.id);

                    if (data.estado == 'ANULADO') {
                        return "<div class='btn-group' style='text-transform:capitalize;'><button data-toggle='dropdown' class='btn btn-primary btn-sm  dropdown-toggle'><i class='fa fa-bars'></i></button><ul class='dropdown-menu'>" +
                            "<li><a class='dropdown-item' onclick='eliminar(" + data.id +
                            ")' title='Eliminar' ><b><i class='fa fa-trash'></i> Eliminar</a></b></li>" +
                        "</ul></div>"
                    }else{
                        return "<div class='btn-group' style='text-transform:capitalize;'><button data-toggle='dropdown' class='btn btn-primary btn-sm  dropdown-toggle'><i class='fa fa-bars'></i></button><ul class='dropdown-menu'>" +
                            "<li><a class='dropdown-item' onclick='modificar(" +data.id+","+data.conformidad+","+data.editable +")' title='Editar'><b><i class='fa fa-edit'></i> Modificar </a></b></li>" +
                            "<li><a class='dropdown-item' onclick='anular(" + data.id +
                            ")' title='Anular' ><b><i class='fa fa-times'></i> Anular</a></b></li>" +
                            "<li><a class='dropdown-item' onclick='eliminar(" + data.id +
                            ")' title='Eliminar' ><b><i class='fa fa-trash'></i> Eliminar</a></b></li>" +
                            "<li class='dropdown-divider'></li>" +
                            "<li><a class='dropdown-item' onclick='conformidad(" +data.id+","+data.conformidad+","+data.editable +")' title='Conformidad'><b><i class='fa fa-check'></i> Conformidad</a></b></li>" +
                        "</ul></div>"

                    }


                }
            }
        ],
        "language": {
            "url": "{{asset('Spanish.json')}}"
        },
        "order": [],
    });

});

//Controlar Error
$.fn.DataTable.ext.errMode = 'throw';

function anular(id) {
    $('#orden_id').val(id)
    $('#modal_observacion_anular').modal('show');
}

function conformidad(id, confor , editable) {
    if (editable == '0') {
        var url = '{{ route("produccion.getOrden", ":id")}}';
        url = url.replace(':id',id);
        $.ajax({
            url: url,
            type:'get',
            success:  function (response) {
                var fecha_venci = new Date(response.fecha_produccion).toLocaleDateString()
                $("#fecha_vencimiento").val(fecha_venci);
                $("#n_produccion").val(response.programacion_id);
                $("#codigo_producto").val(response.codigo_producto);
                $("#producto").val(response.descripcion_producto);
                $("#cantidad").val(response.cantidad);
                $("#orden_produccion").val(id)
                
            },              
        });
        $('#modal_conformidad').modal('show');
    }else{
        if (confor != '2') {
            var url = '{{ route("produccion.lote.edit", ":id")}}';
            url = url.replace(':id',id);
            if (editable == '2') {
                $.ajax({
                    url: url,
                    type:'get',
                    success:  function (response) {
                        var fecha_venci = new Date(response.orden.fecha_produccion).toLocaleDateString()
                        $("#fecha_vencimiento_show").val(fecha_venci);
                        $("#n_produccion_show").val(response.orden.programacion_id);
                        $("#codigo_producto_show").val(response.orden.codigo_producto);
                        $("#producto_show").val(response.orden.descripcion_producto);
                        $("#cantidad_show").val(response.lote.cantidad);
                        $("#orden_produccion_show").val(response.orden.id);
                        $("#lote_producto_show").val(response.lote.codigo);
                        var fecha_entrega = new Date(response.lote.fecha_entrega).toLocaleDateString()
                        $("#fecha_entrega_show").val(fecha_entrega);
                        $("#observacion_show").val(response.lote.observacion);
                        if (response.lote.confor_almacen != null) {
                            $('#confirmacion_almacen_show').attr('checked', true);
                        }
                        if (response.lote.confor_produccion != null) {
                            $('#confirmacion_produccion_show').attr('checked', true);
                        }
                    },              
                });
                $('#modal_conformidad_show').modal('show');
            }else{

                $.ajax({
                    url: url,
                    type:'get',
                    success:  function (response) {
                        var fecha_venci = new Date(response.orden.fecha_produccion).toLocaleDateString()
                        $("#fecha_vencimiento_edit").val(fecha_venci);
                        $("#n_produccion_edit").val(response.orden.programacion_id);
                        $("#codigo_producto_edit").val(response.orden.codigo_producto);
                        $("#producto_edit").val(response.orden.descripcion_producto);
                        $("#cantidad_edit").val(response.lote.cantidad);
                        $("#orden_produccion_edit").val(response.orden.id);
                        $("#lote_producto_edit").val(response.lote.codigo);
                        var fecha_entrega = new Date(response.lote.fecha_entrega).toLocaleDateString()
                        $("#fecha_entrega_edit").val(fecha_entrega);
                        $("#observacion_edit").val(response.lote.observacion);
                        $("#lote_id").val(response.lote.id);
                        if (response.lote.confor_almacen != null) {
                            $('#confirmacion_almacen_edit').attr('checked', true);
                        }
                        if (response.lote.confor_produccion != null) {
                            $('#confirmacion_produccion_edit').attr('checked', true);
                        }
                    },              
                });
                $('#modal_conformidad_edit').modal('show');

            }
        }
    }
    
}

function modificar(id, confor , editable) {
    var url = "{{ route('produccion.orden.edit', [ 'orden' =>'id']) }}".replace('id', id);
    $(location).attr('href', url);
}

function modificar(id, confor , editable) {
    var url = "{{ route('produccion.orden.edit', [ 'orden' =>'id']) }}".replace('id', id);
    $(location).attr('href', url);
}

function eliminar(id) {
    Swal.fire({
        title: 'Opción Eliminar',
        text: "¿Seguro que desea eliminar registro?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: "#1ab394",
        confirmButtonText: 'Si, Confirmar',
        cancelButtonText: "No, Cancelar",
    }).then((result) => {
        if (result.isConfirmed) {
            //Ruta Eliminar
            var url_eliminar = '{{ route("produccion.orden.destroy", ":id")}}';
            url_eliminar = url_eliminar.replace(':id', id);
            $(location).attr('href', url_eliminar);

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