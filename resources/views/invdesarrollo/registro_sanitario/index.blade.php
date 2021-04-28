@extends('layout') @section('content')
@include('invdesarrollo.registro_sanitario.create')
@include('invdesarrollo.registro_sanitario.edit')
@section('registro_sanitario-active', 'active')
@section('registro_sanitario-active', 'active')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10 col-md-10">
       <h2  style="text-transform:uppercase"><b>Listado de Registro Sanitario</b></h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">Panel de Control</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Registro Sanitario</strong>
            </li>

        </ol>
    </div>
    <div class="col-lg-2 col-md-2">
        <a data-toggle="modal" data-target="#modal_crear_registro_sanitario" class="btn btn-block btn-w-m btn-primary m-t-md" href="#">
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
                    <table class="table dataTables-registro_sanitario table-striped table-bordered table-hover"  style="text-transform:uppercase">
                    <thead>
                        <tr>
                            <th></th>
                            <th class="text-center">Producto</th>
							<th class="text-center">Fecha Inicio</th>
							<th class="text-center">Fecha Fin</th>
							<th class="text-center">Archivo Word</th>
							<th class="text-center">Archivo Pdf</th>
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

        $('.dataTables-registro_sanitario').DataTable({
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
            "ajax": '{{ route("getRegistroSanitario")}}',
            "columns": [
                //Tabla General
                //{data: 'id', className:"text-center", "visible":false, name:'registro_sanitario.descripcion'},
                
				{data: 'id', className:"text-center", "visible":false, name:'registro_sanitario.id'},
                {data: 'nombre', className:"text-center", name:'registro_sanitario.nombre'},
				{data: 'fecha_inicio', className:"text-center", name:'registro_sanitario.fecha_inicio'},
				{data: 'fecha_fin', className:"text-center", name:'registro_sanitario.fecha_fin'},
                {data: 'archivo_word', className:"text-center", name:'registro_sanitario.archivo_word'},
                {data: 'archivo_pdf', className:"text-center", name:'registro_sanitario.archivo_pdf'},
                {data: 'estado', className:"text-center", name:'registro_sanitario.estado'},

                {
                    data: null,
                    className:"text-center",
                    name: 'registro_sanitario.id',
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

    function obtenerData($id) {
        var table = $('.dataTables-registro_sanitario').DataTable();
        var data = table.rows().data();
        limpiarError()
        data.each(function (value, index) {
            if (value.id == $id) {
                //$('#tabla_id').val(value.id);
 				$('#id_editar').val(value.id);
                $('#producto_id_editar').val(value.producto_id);
 				$('#fecha_inicio_editar').val(value.fecha_inicio);
				$('#fecha_fin_editar').val(value.fecha_fin);
                console.log(value.archivo_word);
                console.log(value.archivo_pdf);
                //$('#archivo_word_editar').val(value.archivo_word);
                //$('#archivo_pdf_editar').val(value.archivo_pdf);
            }  
        });

        $('#modal_editar_registro_sanitario').modal('show');
    }


    //Old Modal Editar
    @if ($errors->has('ubicacion')  ||  $errors->has('descripcion') )
        $('#modal_editar_registro_sanitario').modal({ show: true });
    @endif

    function limpiarError() {
        $('#descripcion').removeClass( "is-invalid" )
        $('#error-descripcion').text('')

        $('#ubicacion').removeClass( "is-invalid" )
        $('#error-ubicacion').text('')
    }

    $('#modal_editar_registro_sanitario').on('hidden.bs.modal', function(e) { 
        limpiarError() 
    });

    //Old Modal Crear
    @if ($errors->has('ubicacion_guardar')  ||  $errors->has('descripcion_guardar') )
        $('#modal_crear_registro_sanitario').modal({ show: true });
    @endif

    function guardarError() {
        $('#descripcion_guardar').removeClass( "is-invalid" )
        $('#error-descripcion-guardar').text('')
        $('#ubicacion_guardar').removeClass( "is-invalid" )
        $('#error-ubicacion-guardar').text('')
    }

    $('#modal_crear_registro_sanitario').on('hidden.bs.modal', function(e) { 
        guardarError()
        $('#descripcion_guardar').val('')
        $('#ubicacion_guardar').val('')

    });

    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger',
        },
        buttonsStyling: false
    })


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
                var url_eliminar = '{{ route("invdesarrollo.registro_sanitario.destroy", ":id")}}';
                url_eliminar = url_eliminar.replace(':id',id);
                $(location).attr('href',url_eliminar);

                }else if (
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

    $('#editar_registro_sanitario').submit(function(e){
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
                }else if (
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

    $('#crear_registro_sanitario').submit(function(e){
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
                }else if (
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



</script>
@endpush