@extends('layout') @section('content')

@section('produccion-active', 'active')
@section('programacion_produccion-active', 'active')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10 col-md-10">
       <h2  style="text-transform:uppercase"><b>Listado de Programacion de Produccion</b></h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{route('home')}}">Panel de Control</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Programacion Produccion</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2 col-md-2">
        <a class="btn btn-block btn-w-m btn-primary m-t-md" href="{{route('produccion.programacion_produccion.create')}}">
            <i class="fa fa-plus-square"></i> Añadir nuevo
        </a>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-content">
                    <div class="table-responsive">
                    
                        <table class="table dataTables-programacion_produccion table-striped table-bordered table-hover"
                        style="text-transform:uppercase">
                            <thead>
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th class="text-center">Productos</th>
                                    <!-- <th class="text-center" style="display:none">Fecha Creacion</th> -->
                                    <th class="text-center">Cantidad Producir</th>
                                    <th class="text-center">Fecha Producción</th>
                                    <th class="text-center">Fecha Termino</th>
                                    <!-- <th class="text-center">Cantidad Programada</th> -->
                                    <th class="text-center">Observacion</th>
                                    <!-- <th class="text-center" style="display:none">Usuario Id</th> -->
                                    <th class="text-center">Estado</th>
                                    <th class="text-center">ACCIONES</th>
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

@include('produccion.programacion_produccion.modal')
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
    $('.dataTables-programacion_produccion').DataTable({
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
        "ajax": "{{ route('getProgramacionProduccion')}}",
        "columns": [
            //programacion_produccion INTERNA
            { data: 'id',className: "text-center", sWidth: '5%',},
            { data: 'producto',className: "text-left", sWidth: '30%'},
            // { data: 'fecha_creacion',className: "text-center", "visible":false},
            // { data: 'fecha_produccion',className: "text-center"},
            { data: 'cantidad_programada',className: "text-center"},
            { data: 'fecha_programada',className: "text-center"},
            { data: 'fecha_termino',className: "text-center"},
            { data: 'observacion',className: "text-center"},
            {
                data: null,
                className: "text-center",
                render: function(data) {
                    switch (data.estado) {
                        case "VIGENTE":
                            return "<span class='badge badge-warning' d-block>" + data.estado +
                                "</span>";
                            break;
                        case "ANULADO":
                            return "<span class='badge badge-danger' d-block>" + data.estado +
                                "</span>";
                            break;
                        case "PRODUCCION":
                            return "<span class='badge badge-primary' d-block>" + data.estado +
                                "</span>";
                            break;
                        default:
                            return "<span class='badge badge-success' d-block>" + data.estado +
                                "</span>";
                    }
                },
            },
            {
                data: null,
                className: "text-center",
                render: function(data) {
                    //Ruta Detalle
                    var url_detalle = '{{ route("produccion.programacion_produccion.show", ":id")}}';
                    url_detalle = url_detalle.replace(':id', data.id);

                    //Ruta Modificar
                    var url_editar = '{{ route("produccion.programacion_produccion.edit", ":id")}}';
                    url_editar = url_editar.replace(':id', data.id);

                    if (data.estado == 'VIGENTE') {
                        
                        return "<div class='btn-group' style='text-transform:capitalize;'><button data-toggle='dropdown' class='btn btn-primary btn-sm  dropdown-toggle'><i class='fa fa-bars'></i></button><ul class='dropdown-menu'>" +                        
                            "<li><a class='dropdown-item' href='" + url_editar +
                            "' title='Modificar' ><b><i class='fa fa-edit'></i> Modificar</a></b></li>" +    
                            "<li><a class='dropdown-item' href='" + url_detalle +
                            "' title='Detalle'><b><i class='fa fa-eye'></i> Detalle</a></b></li>" +
                            "<li><a class='dropdown-item' onclick='eliminar(" + data.id +
                            ")' title='Eliminar'><b><i class='fa fa-trash'></i> Eliminar</a></b></li>" +
                            "<li class='dropdown-divider'></li>" +
                            "<li><a class='dropdown-item' onclick='produccion(" + data.id +
                            ")' title='Producir'><b><i class='fa fa-line-chart'></i> Producción</a></b></li>" +

                        "</ul></div>"

                    }else{
                        return "<div class='btn-group' style='text-transform:capitalize;'><button data-toggle='dropdown' class='btn btn-primary btn-sm  dropdown-toggle'><i class='fa fa-bars'></i></button><ul class='dropdown-menu'>" +                        
                         
                            "<li><a class='dropdown-item' href='" + url_detalle + "' title='Detalle'><b><i class='fa fa-eye'></i> Detalle</a></b></li>" +
                            "<li><a class='dropdown-item' onclick='eliminar(" + data.id + ")' title='Eliminar'><b><i class='fa fa-trash'></i> Eliminar</a></b></li>" +

                        "</ul></div>"
                    }




                }
            }

        ],
        "language": {
            "url": "{{asset('Spanish.json')}}"
        },
        "order": [
            [0, "desc"]
        ],
    });

});

//Controlar Error
$.fn.DataTable.ext.errMode = 'throw';

const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger',
            },
            buttonsStyling: false
        })


function eliminar(id) {
    $('#programacion_id').val(id)
    $('#modal_observacion_anular').modal('show');
}

function produccion(id){
    Swal.fire({
        customClass: {
            container: 'my-swal'
        },
        title: 'Opción Producción',
        text: "¿Seguro que desea enviar el registro a producción?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: "#1ab394",
        confirmButtonText: 'Si, Confirmar',
        cancelButtonText: "No, Cancelar",
    }).then((result) => {
        if (result.isConfirmed) {
            //Ruta a produccion
            var url = '{{ route("produccion.programacion_produccion.produccion", ":id")}}';
            url = url.replace(':id', id);
            $(location).attr('href',url);
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