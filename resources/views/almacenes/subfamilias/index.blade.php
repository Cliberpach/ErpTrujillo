@extends('layout') @section('content')
@include('almacenes.subfamilias.create')
@include('almacenes.subfamilias.edit')
@section('almacenes-active', 'active')
@section('subfamilia-active', 'active')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10 col-md-10">
       <h2  style="text-transform:uppercase"><b>LISTADO DE SUB CATEGORIAS DEL PRODUCTO TERMINADO </b></h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">Panel de Control</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Sub Categorias</strong>
            </li>

        </ol>
    </div>
    <div class="col-lg-2 col-md-2">
        <a data-toggle="modal" data-target="#modal_sub_familia" class="btn btn-block btn-w-m btn-primary m-t-md" href="#">
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
                    <table class="table dataTables-subfamilias table-striped table-bordered table-hover"  style="text-transform:uppercase">
                    <thead>
                        <tr>
                            <th class="text-center"></th>
                            <th class="text-center"></th>
                            <th class="text-center">DESCRIPCION</th>
                            <th class="text-center">CATEGORIA</th>
                            <th class="text-center">CREADO</th>
                            <th class="text-center">ACTUALIZADO</th>
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


        $('.dataTables-subfamilias').DataTable({
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
            "ajax": '{{ route("getSub")}}',
            "columns": [
                //Caja chica
                {data: 'id', className:"text-center", "visible":false},
                {data: 'familia_id', className:"text-center", "visible":false},
                {data: 'descripcion' , className:"text-left"},
                {data: 'familia' , className:"text-left"},
                {data: 'creado', className:"text-center"},
                {data: 'actualizado', className:"text-center"},
                {
                    data: null,
                    className:"text-center",
                    render: function (data) {

                        return "<div class='btn-group'><button class='btn btn-warning btn-sm modificarDetalle' onclick='obtenerData("+data.id+")' type='button' title='Modificar'><i class='fa fa-edit'></i></button><a class='btn btn-danger btn-sm' href='#' onclick='eliminar("+data.id+")' title='Eliminar'><i class='fa fa-trash'></i></a></div>"
                    }
                }
                


            ],
            "language": {
                        "url": "{{asset('Spanish.json')}}"
            },
            "order": [],

           

        });

    });

    function obtenerData($id) {
        var table = $('.dataTables-subfamilias').DataTable();
        var data = table.rows().data();
        limpiarError()
        data.each(function (value, index) {
            if (value.id == $id) {
                $('#sub_familia_id_editar').val(value.id);
                $('#familia_id_2_editar').val(value.familia_id);
                $('#descripcion_editar').val(value.descripcion);
            }  
        });

        
        var id = $('#familia_id_2_editar').val();
       
        $.get("{{route('subfamilia.familia')}}", function (data) {
            
        if(data.length > 0){
            
            var select = '<option value="" selected disabled >SELECCIONAR</option>'
            for (var i = 0; i < data.length; i++)
                if (data[i].id == id) {
                    select += '<option value="' + data[i].id + '" selected >' + data[i].familia + '</option>';
                }else{
                    select += '<option value="' + data[i].id + '">' + data[i].familia + '</option>';
                }
  

        }else{
            toastr.error('Familias no registradas.','Error');
        }

        $("#familia_id_editar").html(select);
        $("#familia_id_editar").val(id).trigger("change");

    });

        $('#modal_subfamilia').modal('show');

        
    }

    //Old Modal Editar
    @if ($errors->has('familia_id_editar')  ||  $errors->has('descripcion_editar') )
        $('#modal_subfamilia').modal({ show: true });
    @endif

    function limpiarError() {
        $('#num_referencia_editar').removeClass( "is-invalid" )
        $('#error-num_referencia-editar').text('')

        $('#saldo_inicial_editar').removeClass( "is-invalid" )
        $('#error-saldo_inicial-editar').text('')
    }

    $('#modal_subfamilia').on('hidden.bs.modal', function(e) { 
        limpiarError() 
    });


    function guardarError() {
        $('#num_referencia').removeClass( "is-invalid" )
        $('#error-num_referencia-guardar').text('')

        $('#saldo_inicial').removeClass( "is-invalid" )
        $('#error-saldo_inicial-guardar').text('')
    }

    $('#modal_sub_familia').on('hidden.bs.modal', function(e) { 
        guardarError()
        $('#descripcion').val('')

    });

    function eliminar(id) {
        const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger',
                    },
                    buttonsStyling: false
                })
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
                var url_eliminar = '{{ route("almacenes.subfamilia.destroy", ":id")}}';
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

</script>
@endpush