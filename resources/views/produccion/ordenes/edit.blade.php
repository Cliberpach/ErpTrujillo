@extends('layout') @section('content')
@section('produccion-active', 'active')
@section('ordenes_produccion-active', 'active')

<div class="row wrapper border-bottom white-bg page-heading">

    <div class="col-lg-12">
       <h2  style="text-transform:uppercase"><b>MODIFICAR ORDEN DE PRODUCCION</b></h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{route('home')}}">Panel de Control</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{route('produccion.orden.index')}}">Ordenes</a>
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

                    <form action="{{route('produccion.orden.update',$orden->id)}}" method="POST" id="enviar_orden_produccion">
                        {{csrf_field()}}

                        <h4 class=""><b>Orden de Producción</b></h4>
                            <div class="row">
                                <div class="col-md-12">
                                    <p>Modificar datos de Orden de Producción :</p>
                                </div>
                            </div>

                            <div class="row">
                            
                                <div class="col-lg-6 col-xs-12 b-r">
                                    <div class="form-group">

                                        <input type="hidden" name="producto_id" value="{{$orden->producto_id}}">
                                        <input type="hidden" name="programacion_aprobada_id" value="{{$orden->programacion_id}}">

                                   
                                            <label class="">Producto</label>
                                            <select class="select2_form form-control {{ $errors->has('producto_id') ? ' is-invalid' : '' }}" disabled>
                                                <option selected >{{$orden->codigo_producto.' - '.$orden->descripcion_producto}}</option>
                                            </select>
                                     

                                    </div>

                                    
                                    <div class="form-group row">
                                        <div class="col-lg-6 col-xs-12">
                                            <label class='required'>Codigo</label>
                                            <input type="text" id="codigo" name="codigo" onkeyup="return mayus(this)" class="form-control {{ $errors->has('codigo') ? ' is-invalid' : '' }}" 
                                                value="{{old('codigo',$orden->codigo)}}" required>

                                            @if ($errors->has('codigo'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('codigo') }}</strong>
                                            </span>
                                            @endif
                                        </div>

                                        <div class="col-lg-6 col-xs-12">
                                            <label class='required'>Versión</label>
                                            <input type="text" id="version" name="version" onkeyup="return mayus(this)" class="form-control {{ $errors->has('version') ? ' is-invalid' : '' }}" 
                                                value="{{old('version',$orden->version)}}" required>

                                            @if ($errors->has('version'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('version') }}</strong>
                                            </span>
                                            @endif
                                        </div>


                                     
                                    </div>

                                </div>

                                <div class="col-lg-6 col-xs-12">
                                        <div class="form-group row">
                                                <div class="col-lg-6 col-xs-12">
                                                    <label class="">Cantidad Producir :</label>
                                                    <input type="number" id="cantidad_programada" name="cantidad_programada" readonly class="form-control {{ $errors->has('cantidad_programada') ? ' is-invalid' : '' }}" value="{{old('cantidad_programada',$orden->cantidad)}}" >
                                                    @if ($errors->has('cantidad_programada'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('cantidad_programada') }}</strong>
                                                    </span>
                                                    @endif
                                                </div>

                                                <div class="col-lg-6 col-xs-12" id="fecha_produccion">

                                                    <label class='required'>Fecha de Producción</label>
                                                    <div class="input-group date">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-calendar"></i>
                                                        </span>
                                                        <input type="text" id="fecha_produccion" name="fecha_produccion"
                                                            class="form-control {{ $errors->has('fecha_produccion') ? ' is-invalid' : '' }}"
                                                            value="{{old('fecha_produccion',getFechaFormato($orden->fecha_produccion, 'd/m/Y'))}}"
                                                            autocomplete="off" readonly required>

                                                        @if ($errors->has('fecha_produccion'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('fecha_produccion') }}</strong>
                                                        </span>
                                                        @endif

                                                    </div>
                                                </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-lg-6 col-xs-12">
                                                <label class='required'>Tiempo de Proceso</label>
                                                <input type="time" id="tiempo_proceso" name="tiempo_proceso" class="form-control {{ $errors->has('tiempo_proceso') ? ' is-invalid' : '' }}" 
                                                    value="{{old('tiempo_proceso', $orden->tiempo_proceso)}}" required>

                                                @if ($errors->has('tiempo_proceso'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('tiempo_proceso') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                </div>
                            
                            </div>
                     



                            <hr>
                            
                            <input type="hidden" name="productos_detalle" id="productos_detalle">

                            <div class="row">

                                <div class="col-lg-12">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading">
                                            <h4 class=""><b>Descripción de la orden de produccion</b></h4>
                                        </div>
                                        <div class="panel-body">
                                        
                                            <div class="table-responsive" >

                                                    <table class="table dataTables-ordenes table-striped table-bordered table-hover" id="orden" style="text-transform:uppercase">
                                                        <thead>
                                                        <tr>
                                                            <th class="text-center">ID</th>
                                                            <th class="text-center">CODIGO</th>
                                                            <th class="text-center">ARTICULO</th>
                                                            <th class="text-center">ALMACEN</th>
                                                            <th class="text-center">ACCIONES</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>

                                                            @foreach($productoDetalles as $articulo)

                                                              
                                                                <tr>
                                                                    <!-- ID ORDEN DETALLE -->
                                                                    <td class="text-center" >{{$articulo->id}}</td> 
                                                                    <td class="text-center">{{$articulo->articulo->codigo_fabrica}}</td>
                                                                    <td>{{$articulo->articulo->descripcion}}</td>
                                                                    <td>{{$articulo->articulo->almacen->descripcion}}</td>
                                                                    <td class="text-center">
                                                                        <div class='btn-group'>
                                                                            @if ($articulo->completado == 1)
                                                                            <a class='btn btn-success btn-sm' href="{{route('produccion.orden.detalle.lote.devolucion', 
                                                                                                                    [  
                                                                                                                        'articulo_id' => $articulo->articulo_id ,
                                                                                                                        'orden_id'=> $orden->id,
                                                                                                                        'ordenDetalle' => $articulo->id,
                                                                                                                    ]
                                                                                                                    )}}" style='color:white;' title='Devoluciones'><i class='fa fa-refresh'></i></a>
                                                                            @endif
                                                                            <a class='btn btn-warning btn-sm' href="{{route('produccion.orden.detalle.lote.edit' , 
                                                                                                                    [  
                                                                                                                        'articulo_id' => $articulo->articulo_id ,
                                                                                                                        'programacion_id'=> $orden->programacion_id,
                                                                                                                        'ordenDetalle' => $articulo->id,
                                                                                                                    ])}}" style='color:white;' title='Modificar'><i class='fa fa-edit'></i></a>
                                                                        </div>
                                                                    
                                                                    </td>
                                                                </tr>

                                                            @endforeach


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
                                <a href="{{route('produccion.orden.index')}}" id="btn_cancelar"
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
<link href="{{ asset('Inspinia/css/plugins/select2/select2.min.css') }}" rel="stylesheet">
<!-- DataTable -->
<link href="{{asset('Inspinia/css/plugins/dataTables/datatables.min.css')}}" rel="stylesheet">

<link href="{{ asset('Inspinia/css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
<link href="{{ asset('Inspinia/css/plugins/daterangepicker/daterangepicker-bs3.css') }}" rel="stylesheet">
<style>
    .sinFlete{
         background: #c32020ad !important;
         color: white !important;
    }
</style>
@endpush
@push('scripts')
<!-- Select2 -->
<script src="{{ asset('Inspinia/js/plugins/select2/select2.full.min.js') }}"></script>
<!-- DataTable -->
<script src="{{asset('Inspinia/js/plugins/dataTables/datatables.min.js')}}"></script>
<script src="{{asset('Inspinia/js/plugins/dataTables/dataTables.bootstrap4.min.js')}}"></script>
<!-- Data picker -->
<script src="{{ asset('Inspinia/js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>
<!-- Date range use moment.js same as full calendar plugin -->
<script src="{{ asset('Inspinia/js/plugins/fullcalendar/moment.min.js') }}"></script>
<!-- Date range picker -->
<script src="{{ asset('Inspinia/js/plugins/daterangepicker/daterangepicker.js') }}"></script>

<script>
//Select2
$(".select2_form").select2({
    placeholder: "SELECCIONAR",
    allowClear: true,
    width: '100%',
});

$('#fecha_produccion .input-group.date').datepicker({
    todayBtn: "linked",
    keyboardNavigation: false,
    forceParse: false,
    autoclose: true,
    language: 'es',
    format: "dd/mm/yyyy",
    startDate: "today"
})

const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
        confirmButton: 'btn btn-success',
        cancelButton: 'btn btn-danger',
    },
    buttonsStyling: false
})

$(document).ready(function() {

    $('.dataTables-ordenes').DataTable({
        "dom": 'lTfgitp',
        "bPaginate": true,
        "bLengthChange": true,
        "bFilter": true,
        "bInfo": true,
        "bAutoWidth": false,
        "language": {
            "url": "{{asset('Spanish.json')}}"
        },
    });
});


//Editar Registro --REVISAR
// $(document).on('click', '.modificar_cantidad', function(event) {
//     var table = $('.dataTables-ordenes').DataTable();
//     var data = table.row($(this).parents('tr')).data();
//     console.log(data)
//     $('#indice').val(table.row($(this).parents('tr')).index());
    
//     $('#cantidad_solicitada').val(data.cantidad_solicitada);

//     $("#cantidad_entregada").attr({ 
//         "min" : data.cantidad_solicitada,
//     });
//     $('#cantidad_entregada').val(data.cantidad_entregada);

//     $('#cantidad_correcta').val(data.cantidad_devuelta_correcta_cantidad);
//     $("#almacen_cantidad_correcta").val(data.cantidad_devuelta_correcta_almacen).trigger("change");
//     $('#observacion_correcta').val(data.observacion_correcta);

//     $('#cantidad_incorrecta').val(data.cantidad_devuelta_incorrecta_cantidad);
//     $("#almacen_cantidad_incorrecta").val(data.cantidad_devuelta_incorrecta_almacen).trigger("change");
//     $('#observacion_incorrecta').val(data.observacion_incorrecta);

//     $('#observacion').val(data.observacion);
//     $('#modal_cantidad_produccion').modal('show');
// })


//ELIMINAR REGISTRO
$(document).on('click', '.eliminar_cantidad', function(event) {
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
            var table = $('.dataTables-ordenes').DataTable();
            table.row($(this).parents('tr')).remove().draw();
        } else if (
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




$('#enviar_orden_produccion').submit(function(e) {
    e.preventDefault();
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

            // if (validarCantidades() == true) {
            //     cargarDetalles()
                this.submit()
            // }

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

function validarCantidades() {
    var existe = true;
    var t = $('.dataTables-ordenes').DataTable();
    t.rows().data().each(function(el, index) {   

        if (el.cantidad_entregada ==  '') {
            toastr.error('El Articulo '+ el.articulo +' se encuentra sin cantidad entregada. ', 'Error');
            $('.dataTables-ordenes tbody tr').eq(index).addClass('sinFlete');
            existe = false;
        }

    });
    return existe
}

// function cargarDetalles() {
//     var detalles = [];
//     var tabla = $('.dataTables-ordenes').DataTable();
//     var data = tabla.rows().data();
//     data.each(function(value, index) {
//         detalles.push(value)
//         $('#productos_detalle').val(JSON.stringify(detalles));
//     })
// }


</script>


@endpush