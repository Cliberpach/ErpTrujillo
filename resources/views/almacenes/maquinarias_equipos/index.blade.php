@extends('layout') @section('content')
@include('almacenes.maquinarias_equipos.create')
@include('almacenes.maquinarias_equipos.edit')
@section('almacenes-active', 'active')
@section('maquinaria_equipo-active', 'active')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10 col-md-10">
       <h2  style="text-transform:uppercase"><b>Listado de Maquinarias & Equipos</b></h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">Panel de Control</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Maquinarias & Equipos</strong>
            </li>

        </ol>
    </div>
    <div class="col-lg-2 col-md-2">
        <a data-toggle="modal" data-target="#modal_crear_maquinaria_equipo" class="btn btn-block btn-w-m btn-primary m-t-md" href="#">
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
                    <table class="table dataTables-maquinarias_equipos table-striped table-bordered table-hover"  style="text-transform:uppercase">
                    <thead>
                        <tr>
							<th class="text-center">Tipo</th>
							<th class="text-center">Nombre</th>
							<th class="text-center">Serie</th>
							<th class="text-center">Tipocorriente</th>
							<th class="text-center">Caracteristicas</th>
							<th class="text-center">Nombre Imagen</th>
							<th class="text-center">Vidautil</th>
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


@stop
@push('styles')
<!-- DataTable -->
<link href="{{asset('Inspinia/css/plugins/dataTables/datatables.min.css')}}" rel="stylesheet">

<style>
    .my-swal {
        z-index: 3000 !important;
    }
</style>
@endpush 

@push('scripts')
<!-- DataTable -->
<script src="{{asset('Inspinia/js/plugins/dataTables/datatables.min.js')}}"></script>
<script src="{{asset('Inspinia/js/plugins/dataTables/dataTables.bootstrap4.min.js')}}"></script>

<script>

    $(document).ready(function() {


        $('.dataTables-maquinarias_equipos').DataTable({
            "dom": '<"html5buttons"B>lTfgitp',
            "buttons": [
                {
                    extend:    'excelHtml5',
                    text:      '<i class="fa fa-file-excel-o"></i> Excel',
                    titleAttr: 'Excel',
                    title: 'Tablas Generales'
                },

                {   
                    titleAttr: 'Imprimir',
                    extend: 'print',
                    text:      '<i class="fa fa-print"></i> Imprimir',
                    customize: function (win){
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
            "processing":true,
            "serverSide":true,
            "ajax": '{{ route("getMaquinaria_equipo")}}',
            "columns": [
                //Tabla General
                //{data: 'id', className:"text-center", "visible":false, name:'maquinarias_equipos.id'},
                
				//{data: 'id', className:"text-center", name:'maquinarias_equipos.id'},
				{data: 'tipo', className:"text-center", name:'maquinarias_equipos.tipo'},
				{data: 'nombre', className:"text-center", name:'maquinarias_equipos.nombre'},
				{data: 'serie', className:"text-center", name:'maquinarias_equipos.serie'},
				{data: 'tipocorriente', className:"text-center", name:'maquinarias_equipos.tipocorriente'},
				{data: 'caracteristicas', className:"text-center", name:'maquinarias_equipos.caracteristicas'},
				{data: 'nombre_imagen', className:"text-center", name:'maquinarias_equipos.nombre_imagen'},
				{data: 'vidautil', className:"text-center", name:'maquinarias_equipos.vidautil'},
				{data: 'estado', className:"text-center", name:'maquinarias_equipos.estado'},

                {
                    data: null,
                    className:"text-center",
                    name: 'maquinarias_equipos.id',
                    render: function (data) {
                        
                        return "<div class='btn-group'><button class='btn btn-warning btn-sm modificarDetalle' onclick='obtenerData("+data.id+")' type='button' title='Modificar'><i class='fa fa-edit'></i></button><a class='btn btn-danger btn-sm' href='#' onclick='eliminar("+data.id+")' title='Eliminar'><i class='fa fa-trash'></i></a></div>"
                    }
                }

            ],
            "language": {
                        "url": "{{asset('Spanish.json')}}"
            },
            "order": [[ 0, "desc" ]],

           

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


    function obtenerData($id) {
        var table = $('.dataTables-maquinarias_equipos').DataTable();
        var data = table.rows().data();
        limpiarError()
        data.each(function (value, index) {
            if (value.id == $id) {
                
				$('#id_editar').val(value.id);
				$('#tipo_editar').val(value.tipo);
				$('#nombre_editar').val(value.nombre);
				$('#serie_editar').val(value.serie);
				$('#tipocorriente_editar').val(value.tipocorriente);
				$('#caracteristicas_editar').val(value.caracteristicas);
				//$('#nombre_imagen_editar').val(value.nombre_imagen);
				$('#vidautil_editar').val(value.vidautil);
				$('#estado_editar').val(value.estado);
            }  
        });
        $('#modal_editar_maquinaria_equipo').modal('show');

    }

    function limpiarError() {
        $('#tipo').removeClass( "is-invalid" )
        $('#error-tipo').text('')

        $('#nombre').removeClass( "is-invalid" )
        $('#error-nombre').text('')
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
                var url_eliminar = '{{ route("almacenes.maquinaria_equipo.destroy", ":id")}}'; //Ruta Eliminar
                url_eliminar = url_eliminar.replace(':id',id);
                $(location).attr('href',url_eliminar);
            }else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire(
                    'Cancelado',
                    'La Solicitud se ha cancelado.',
                    'error'
                )
            }
       })
    }
    
    $('#editar_maquinaria_equipo').submit(function(e){
        e.preventDefault();
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                container: 'my-swal',
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger',
            },
            buttonsStyling: false
        })

        Swal.fire({
            customClass: {
                container: 'my-swal'
            },
            title: 'Opción Modificar',
            text: "¿Seguro que desea modificar los cambios?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: "#1ab394",
            confirmButtonText: 'Si, Confirmar',
            cancelButtonText: "No, Cancelar",
        }).then((result) => {
            if (result.isConfirmed) {
                    this.submit();
            }else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire(
                    'Cancelado',
                    'La Solicitud se ha cancelado.',
                    'error'
                )
            }
        })
    })

    $('#crear_maquinaria_equipo').submit(function(e){
        e.preventDefault();
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                container: 'my-swal',
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger',
            },
            buttonsStyling: false
        })

        Swal.fire({
            customClass: {
                container: 'my-swal'
            },
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
            }else if (result.dismiss === Swal.DismissReason.cancel) {
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