@extends('layout') @section('content')
@section('produccion-active', 'active')
@section('ordenes_produccion-active', 'active')
<div class="row wrapper border-bottom white-bg page-heading">

    <div class="col-lg-12">
       <h2  style="text-transform:uppercase"><b>MODIFICAR DETALLE DE LA ORDEN DE PRODUCCION</b></h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{route('home')}}">Panel de Control</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{route('produccion.programacion_produccion.index')}}">Ordenes</a>
            </li>
            
            <li class="breadcrumb-item">
                <a href="{{route('produccion.orden.edit' , [ 'orden' => $ordenDetalle->orden->id ])}}">Orden de Produccion</a>
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

                    <form action="{{route('produccion.orden.detalle.lote.update')}}" method="POST" id="enviar_orden_produccion_lote">
                        {{csrf_field()}}

                            <h4 class=""><b>Orden de Producción</b></h4>

                            <input type="hidden" id='asegurarCierre' value="@if ($cantidadProducciones->count() > 0 ) {{'2'}} @else {{'1'}} @endif">
                            <input type="hidden" id='asegurarCierreExcedida' value="@if ($cantidadExcedidas->count() > 0 ) {{'2'}} @else {{'1'}} @endif">
                            <div class="row">
                            
                                <div class="col-lg-6 col-xs-12 b-r">
                                    <div class="form-group">

                                        <input type="hidden" name="producto_id" value="@if ($ordenDetalle) {{$ordenDetalle->orden->producto_id}} @endif">
                                        <input type="hidden" name="programacion_aprobada_id" value="@if ($ordenDetalle) {{$ordenDetalle->orden->programacion_id}} @endif">
                                        <input type="hidden" name="articulo_id" value="@if ($ordenDetalle) {{$ordenDetalle->articulo_id}} @endif"> 
                                        <!-- ORDEN DETALLE ID-->
                                        <input type="hidden" id="ordenDetalle_id" name="ordenDetalle_id" @if ($ordenDetalle)  value="{{old('ordenDetalle_id', $ordenDetalle->id)}}" @else value="{{old('ordenDetalle_id')}}" @endif>
                                   
                                            <label class="">Artículo</label>
                                            <select class="select2_form form-control {{ $errors->has('producto_id') ? ' is-invalid' : '' }}" disabled>
                                                <option selected >{{$articulo->codigo_fabrica.' - '.$articulo->descripcion}}</option>
                                            </select>
                                     

                                    </div>
                                </div>

                                <div class="col-lg-6 col-xs-12">
                                        @if ($ordenDetalle)
                                         <input type="hidden" id="cantidadProduccion" name="cantidadProduccion" readonly class="form-control {{ $errors->has('cantidadProduccion') ? ' is-invalid' : '' }}" value="{{old('cantidadProduccion', $ordenDetalle->cantidad_produccion )}}" >
                                        @endif
                                        <div class="form-group row">
                                                <div class="col-lg-6 col-xs-12">
                                                    <label class="">Cantidad de Producción</label>
                                                    <input type="text" id="cantidadProduccionCompleta" name="cantidadProduccionCompleta" readonly class="form-control {{ $errors->has('cantidadProduccionCompleta') ? ' is-invalid' : '' }}" 
                                                        @if ($ordenDetalle)  value="{{old('cantidadProduccionCompleta',number_format ($ordenDetalle->cantidad_produccion,2))}}" @else value="{{old('cantidadProduccionCompleta')}}" @endif>
                                                    @if ($errors->has('cantidad_programada'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('cantidad_programada') }}</strong>
                                                    </span>
                                                    @endif
                                                </div>

                                                <div class="col-lg-6 col-xs-12" >
                                                    <label class="required">Cantidad de Excedida</label>
                                                    <input type="number" id="cantidadExcedida" name="cantidadExcedida" class="form-control {{ $errors->has('cantidadExcedida') ? ' is-invalid' : '' }}" 
                                                    @if ($ordenDetalle->cantidad_excedida == 0 ) value="{{old('cantidadExcedida', 3)}}" @else  value="{{old('cantidadExcedida', number_format ($ordenDetalle->cantidad_excedida,2))}}" @endif required>
                                                    @if ($errors->has('cantidadExcedida'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('cantidadExcedida') }}</strong>
                                                    </span>
                                                    @endif
                                                </div>
                                        </div>
                                </div>
                            
                            </div>
                            <hr>

                            <div class="row">
                                <div class="col-lg-6 col-xs-12 b-r">
                                    <p>Cantidades de Producción :</p>

                                    <div class="row">

                                        <div class="col-lg-12">
                                                                                            
                                            <div class="table-responsive" >
                                                    <input type="hidden" id="cantidadProduccionLote" name="cantidadProduccionLote" value="{{old('cantidadProduccionLote')}}">
                                                    <table class="table dataTables-lotes-produccion table-striped table-bordered table-hover" id="orden" style="text-transform:uppercase">
                                                        <thead>

                                                            <tr>
                                                                <th></th>
                                                                <th class="text-center">ID</th>
                                                                <th class="text-center">LOTE</th>
                                                                <th class="text-center">FECHA VENCE.</th>
                                                                <th class="text-center">CANTIDAD</th>
                                                            
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if ($cantidadProducciones->count() > 0)
                                                                @foreach ($cantidadProducciones as $loteProduccion)
                                                                <tr>
                                                                    <td>{{$loteProduccion->orden_produccion_detalle_id}} </td>
                                                                    <td>{{$loteProduccion->lote_articulo_id}} </td>
                                                                    <td>{{$loteProduccion->loteArticulo->lote}}</td>
                                                                    <td>{{ Carbon\Carbon::parse($loteProduccion->loteArticulo->fecha_vencimiento)->format('d/m/y') }}</td>
                                                                    <td>{{$loteProduccion->cantidad}}</td>
                                                                </tr>
                                                                @endforeach
                                                            
                                                            @else
                                                                @foreach ($lotes as $lote)
                                                                <tr>
                                                                    <td>{{$lote->orden_produccion_detalle_id}} </td>
                                                                    <td>{{$lote->lote_articulo_id}} </td>
                                                                    <td>{{$lote->lote}}</td>
                                                                    <td>{{Carbon\Carbon::parse($lote->fecha_vencimiento)->format('d/m/y')}}</td>
                                                                    <td>{{number_format($lote->cantidad,2)}}</td>
                                                                </tr>
                                                                @endforeach
                                                            @endif
                                                        </tbody>
                                                    </table>




                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <div class="col-lg-6 col-xs-12 b-r">
                                    <p>Seleccionar Lote para la cantidad Excedida :</p>
                                    <div class="row">
                                            <div class="col-lg-8 col-xs-12">
                                                <label class="required">Lote Artículo:</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="lote_articulo_excedida" readonly> 
                                                    <span class="input-group-append"> 
                                                        <button type="button" class="btn btn-primary"@if ($ordenDetalle) onclick="buscarCantidadProduccion({{$ordenDetalle->articulo_id}},2)" @endif><i class='fa fa-search'></i> Buscar
                                                        </button>
                                                    </span>
                                                </div>
                                                <div class="invalid-feedback"><b><span id="error-lote_articulo_excedida"></span></b></div>
                                            </div>

                                            <div class="col-lg-4 col-xs-12">
                                                <label class="required">Cantidad:</label>
                                                <input type="number" class="form-control" id="cantidad_excedida_ingreso" disabled> 
                                                <div class="invalid-feedback"><b><span id="error-cantidad_excedida_ingreso"></span></b></div>
                                            </div>
                                    </div>
                                    <hr>
                                    <div class="form-group row">
                                        <div class="col-lg-12">
                                            <p>Datos seleccionados:</p>
                                        </div>
                                        <input type="hidden" class="form-control" id="lote_articulo_excedida_id"> 
                                        <div class="col-lg-4 col-xs-12">
                                            <label class="required">Lote:</label>
                                            <input type="text" class="form-control" id="lote_cantidad_excedida" readonly> 
                                            <div class="invalid-feedback"><b><span id="error-cantidad_produccion_lote_cantidad_excedida"></span></b></div>
                                        </div>
                                        <div class="col-lg-4 col-xs-12">
                                            <label class="required">Fecha de Vencimiento:</label>
                                            <input type="text" class="form-control" id="fecha_vencimiento_cantidad_excedida" readonly>
                                            <div class="invalid-feedback"><b><span id="error-fecha_vencimiento_cantidad_excedida"></span></b></div> 
                                        </div>
                                        <div class="col-lg-4 col-xs-12">
                                            <label class="" for="amount">&nbsp;</label>
                                            <a class="btn btn-block btn-warning agregar_cantidad_produccion" style='color:white;'> <i class="fa fa-plus"></i> AGREGAR</a>
                                        </div>
                                        
                                    </div>
                                    <hr>
                                    <div class="row">

                                        <div class="col-lg-12">
                                                                                            
                                            <div class="table-responsive" >
                                                    <input type="hidden" id="cantidadExcedidaLote" name="cantidadExcedidaLote" value="{{old('cantidadExcedidaLote')}}">
                                                    <table class="table dataTables-lotes-excedidos table-striped table-bordered table-hover" id="orden" style="text-transform:uppercase">
                                                        <thead>
                                                            <tr>
                                                                <th></th>
                                                                <th class="text-center">LOTE</th>
                                                                <th class="text-center">FECHA VENCE.</th>
                                                                <th class="text-center">CANTIDAD</th>
                                                                <th class="text-center">ACCIONES</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                            @foreach ($cantidadExcedidas as $loteExcedida)
                                                            <tr>
                                                                <td>{{$loteExcedida->lote_articulo_id}} </td>
                                                                <td>{{$loteExcedida->loteArticulo->lote}}</td>
                                                                <td> {{ Carbon\Carbon::parse($loteExcedida->loteArticulo->fecha_vencimiento)->format('d/m/y') }}</td>
                                                                <td>{{$loteExcedida->cantidad}}</td>
                                                                <td></td>
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
                            
                                <a href="{{route('produccion.orden.edit' , [ 'orden' => $ordenDetalle->orden->id ])}}" id="btn_cancelar"
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
@include('produccion.ordenes.detallesLotes.modalCantidadProduccion')
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
    #orden_wrapper{
        padding-right:0px;
        padding-left:0px;
    }
</style>
@endpush

@push('scripts')
<!-- Select2 -->
<script src="{{ asset('Inspinia/js/plugins/select2/select2.full.min.js') }}"></script>
<!-- DataTable -->
<script src="{{asset('Inspinia/js/plugins/dataTables/datatables.min.js')}}"></script>
<script src="{{asset('Inspinia/js/plugins/dataTables/dataTables.bootstrap4.min.js')}}"></script>
<script>

const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
        confirmButton: 'btn btn-success',
        cancelButton: 'btn btn-danger',
    },
    buttonsStyling: false
})

//INICIA DATATABLE LOTES PRODUCCION
$(document).ready(function() {
    // DATATABLE LOTES PRODUCCION
    lotesProduccion = $('.dataTables-lotes-produccion').DataTable({
        "dom": 'lTfgitp',
        "bPaginate": false,
        "bLengthChange": false,
        "bFilter": false,
        "bInfo": false,
        "bAutoWidth": false,
        "language": {
            "url": "{{asset('Spanish.json')}}"
        },
        "columnDefs": [
            {
                "targets": 0,
                "visible": false,
            },
            {
                "targets":  [1],
                className: 'text-center',
            },
            {
                "targets": [2],
                className: 'text-center',
            },
            {
                "targets": [3],
                className: 'text-center',
            },
            {
                "targets": [4],
                className: 'text-center',
            },
        ]
    });

    lotesExcedidos = $('.dataTables-lotes-excedidos').DataTable({
        "dom": 'lTfgitp',
        "bPaginate": false,
        "bLengthChange": false,
        "bFilter": false,
        "bInfo": false,
        "bAutoWidth": false,
        "language": {
            "url": "{{asset('Spanish.json')}}"
        },
        "columnDefs": [
            {
                "targets": 0,
                "visible": false,
            },
            {
                "targets": [1],
                className: 'text-center',
            },
            {
                "targets": [2],
                className: 'text-center',
            },
            {
                "targets": [3],
                className: 'text-center',
            },
            {
                searchable: false,
                className: 'text-center',
                "targets": [4],
                data: null,

                render: function(data, type, row) {

                        return  "<div class='btn-group'>" +
                                "<a class='btn btn-sm btn-danger borrar_cantidad_excedida' style='color:white'>"+"<i class='fa fa-trash'></i>"+"</a>"+ 
                                "</div>";
                }
                
            },
        ]
    });
});

//CANTIDAD DE PRODUCCION
function buscarCantidadProduccion(articulo_id,condicion) {
    if (articulo_id) {
        obtenerLotesArticulos(articulo_id ,condicion)
        $('#CantidadProduccion').modal('show');    
    }
}
//AGREGAR MAXIMO AL INPUT SEGUN LA CANTIDAD ELEGIDA
$('#cantidad_produccion_ingreso').on('input', function() {
    this.value = this.value.replace(/[^0-9]/g, '');
    let max= parseFloat(this.max);
    let valor = parseFloat(this.value);
    if(valor>max){
        toastr.error('La cantidad ingresada supera al stock del Lote Max('+max+').', 'Error');
        this.value = max;
    }
});

//AGREGAR REGISTRO (CANTIDAD PRODUCCION)
$(document).on('click', '.agregar_cantidad_produccion', function(event) {
    limpiarCantidadProduccion()
    var enviar = false
    if ( cantidadLoteproduccion($('#cantidad_produccion_ingreso').val()) > $('#cantidadProduccion').val() && 
        $('#condicion_modal').val() == '1' ) {
        toastr.error('La cantidad ingresada supera a la cantidad de producción', 'Error');
        enviar = true;
    }
    if (buscarLoteProduccion($('#lote_articulo_id').val()) != false && $('#condicion_modal').val() == '1' ) {
        toastr.error('Lote en cantidad de produccion existente.', 'Error');
        enviar = true;
    }

    if (buscarLoteExcedida($('#lote_articulo_excedida_id').val()) != false && $('#condicion_modal').val() == '2' ) {
        toastr.error('Lote en cantidad de excedida existente.', 'Error');
        enviar = true;
    }

    if ($('#cantidad_produccion_ingreso').val() == '' && $('#condicion_modal').val() == '1' ) {
        toastr.error('Ingrese cantidad del artículo.', 'Error');
        enviar = true;
        $("#cantidad_produccion_ingreso").addClass("is-invalid");
        $('#error-cantidad_produccion_ingreso').text('El campo Cantidad es obligatorio.')
    }

    if ($('#fecha_vencimiento_cantidad_produccion').val() == '' && $('#condicion_modal').val() == '1') {
        toastr.error('Ingrese la Fecha de vencimiento del lote.', 'Error');
        enviar = true;
        $("#fecha_vencimiento_cantidad_produccion").addClass("is-invalid");
        $('#error-fecha_vencimiento_cantidad_produccion').text('El campo Fecha de Vencimiento es obligatorio.')
    }

    if ($('#lote_cantidad_produccion').val() == '' && $('#condicion_modal').val() == '1') {
        toastr.error('Ingrese el lote del artículo.', 'Error');
        enviar = true;
        $("#lote_cantidad_produccion").addClass("is-invalid");
        $('#error-cantidad_produccion_lote_cantidad_produccion').text('El campo Lote es obligatorio.')
    }

    if ( cantidadLoteexcedida($('#cantidad_excedida_ingreso').val()) > $('#cantidadExcedida').val() && 
        $('#condicion_modal').val() == '2' ) {
        toastr.error('La cantidad ingresada supera a la cantidad excedida', 'Error');
        enviar = true;
    }

    if ($('#cantidad_excedida_ingreso').val() == '' && $('#condicion_modal').val() == '2') {
        toastr.error('Ingrese cantidad del artículo.', 'Error');
        enviar = true;
        $("#cantidad_excedida_ingreso").addClass("is-invalid");
        $('#error-cantidad_excedida_ingreso').text('El campo Cantidad es obligatorio.')
    }

    if ($('#fecha_vencimiento_cantidad_excedida').val() == '' && $('#condicion_modal').val() == '2') {
        toastr.error('Ingrese la Fecha de vencimiento del lote.', 'Error');
        enviar = true;
        $("#fecha_vencimiento_cantidad_excedida").addClass("is-invalid");
        $('#error-fecha_vencimiento_cantidad_excedida').text('El campo Fecha de Vencimiento es obligatorio.')
    }

    if ($('#lote_cantidad_excedida').val() == '' && $('#condicion_modal').val() == '2') {
        toastr.error('Ingrese el lote del artículo.', 'Error');
        enviar = true;
        $("#lote_cantidad_excedida").addClass("is-invalid");
        $('#error-cantidad_produccion_lote_cantidad_excedida').text('El campo Lote es obligatorio.')
    }

    if (enviar != true) {
            Swal.fire({
            title: 'Opción Agregar',
            text: "¿Seguro que desea agregar Lote?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: "#1ab394",
            confirmButtonText: 'Si, Confirmar',
            cancelButtonText: "No, Cancelar",
        }).then((result) => {
            if (result.isConfirmed) {
                if ($('#condicion_modal').val() == '1') {
                    var detalle = {
                        fecha_vencimiento: $('#fecha_vencimiento_cantidad_produccion').val(),
                        cantidad: $('#cantidad_produccion_ingreso').val(),
                        lote: $('#lote_cantidad_produccion').val(),
                        lote_id : $('#lote_articulo_id').val(),
                    }
                }

                if ($('#condicion_modal').val() == '2') {
                    var detalle = {
                        fecha_vencimiento: $('#fecha_vencimiento_cantidad_excedida').val(),
                        cantidad: $('#cantidad_excedida_ingreso').val(),
                        lote: $('#lote_cantidad_excedida').val(),
                        lote_id : $('#lote_articulo_excedida_id').val(),
                    }
                }

                agregarLotesProduccion(detalle)
                if ($('#condicion_modal').val() == '1') {
                    $('#fecha_vencimiento_cantidad_produccion').val(''),
                    $('#cantidad_produccion_ingreso').val(''),
                    $('#lote_cantidad_produccion').val(''),
                    $('#lote_articulo_id').val(''),
                    $('#lote_articulo').val(''),
                    $('#cantidad_produccion_ingreso').prop('disabled' , true)
                }

                if ($('#condicion_modal').val() == '2') {
                    $('#fecha_vencimiento_cantidad_excedida').val(''),
                    $('#cantidad_excedida_ingreso').val(''),
                    $('#lote_cantidad_excedida').val(''),
                    $('#lote_articulo_excedida_id').val(''),
                    $('#lote_articulo_excedida').val(''),
                    $('#cantidad_excedida_ingreso').prop('disabled' , true)   
                }
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

});

//BORRAR REGISTRO (CANTIDAD PRODUCCION)
$(document).on('click', '.borrar_cantidad_produccion', function(event) {
    Swal.fire({
        title: 'Opción Eliminar',
        text: "¿Seguro que desea eliminar Lote?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: "#1ab394",
        confirmButtonText: 'Si, Confirmar',
        cancelButtonText: "No, Cancelar",
    }).then((result) => {
        if (result.isConfirmed) {
            var data = lotesProduccion.row($(this).parents('tr')).data();
            var detalle = {
                lote_id: data[0],
                cantidad: data[3],
            }
            //DEVOLVER LA CANTIDAD LOGICA
            cambiarCantidad(detalle,0)
            lotesProduccion.row($(this).parents('tr')).remove().draw();
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

//BORRAR REGISTRO (CANTIDAD EXCEDIDA)
$(document).on('click', '.borrar_cantidad_excedida', function(event) {
    Swal.fire({
        title: 'Opción Eliminar',
        text: "¿Seguro que desea eliminar Lote?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: "#1ab394",
        confirmButtonText: 'Si, Confirmar',
        cancelButtonText: "No, Cancelar",
    }).then((result) => {
        if (result.isConfirmed) {
            var data = lotesExcedidos.row($(this).parents('tr')).data();
            var detalle = {
                lote_id: data[0],
                cantidad: data[3],
            }
            //DEVOLVER LA CANTIDAD LOGICA
            cambiarCantidad(detalle,0)
            lotesExcedidos.row($(this).parents('tr')).remove().draw();
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

//BUSCAR LOTE (CANTIDAD PRODUCCION)
function buscarLoteProduccion(id) {
    var existe = false;
    lotesProduccion.rows().data().each(function(el, index) {
        if (el[0] == id) {
            existe = true
        }
    });
    return existe
}

//BUSCAR LOTE (CANTIDAD EXCEDIDA)
function buscarLoteExcedida(id) {
    var existe = false;
    lotesExcedidos.rows().data().each(function(el, index) {
        if (el[0] == id) {
            existe = true
        }
    });
    return existe
}

//AGREGAR A TABLA CANTIDAD DE PRODUCCION
function agregarLotesProduccion(detalle) {
    //AGREGAR EN TABLA DETALLE
    
    if ($('#condicion_modal').val() == '1') {
        lotesProduccion.row.add([
                detalle.lote_id,
                detalle.lote,
                detalle.fecha_vencimiento,
                detalle.cantidad,
                ''
            ]).draw(false);
    }

    if ($('#condicion_modal').val() == '2') {
        lotesExcedidos.row.add([
                detalle.lote_id,
                detalle.lote,
                detalle.fecha_vencimiento,
                detalle.cantidad,
                ''
            ]).draw(false);
    }

    
    cambiarCantidad(detalle,1)
    //DESCONTAR EN LOTE ARTICULO
}

//CAMBIAR LA CANTIDAD LOGICA DEL LOTE ARTICULO
//CONDICION : 1 -> DISMINUIR EL LOTE ARTICULO
//CONDICION : 0 -> AUMENTAR EL LOTE ARTICULO (DEVOLVER LA CANTIDAD LOGICA)
function cambiarCantidad(detalle,condicion) {
    $.ajax({
        dataType : 'json',
        type : 'post',
        url : '{{ route('produccion.orden.detalle.lote.articulos.cantidad') }}',
        data : {
            '_token' : $('input[name=_token]').val(),
            'lote_id' : detalle.lote_id,
            'cantidad' : detalle.cantidad,
            'condicion' : condicion,
        }
    }).done(function (result){
        alert('REVISAR')
        console.log(result)
    });
}

//LIMPIAR CANTIDAD DE PRODUCCION (LOTE ARTICULO)
function limpiarCantidadProduccion() {
    $('#cantidad_produccion_ingreso').removeClass("is-invalid")
    $('#error-cantidad_produccion_ingreso').text('')

    $('#lote_cantidad_produccion').removeClass("is-invalid")
    $('#error-cantidad_produccion_lote_cantidad_produccion').text('')

    $('#fecha_vencimiento_cantidad_produccion').removeClass("is-invalid")
    $('#error-fecha_vencimiento_cantidad_produccion').text('')
}

//CARGAR A VARIABLE CANTIDAD DE PRODUCCION
function cantidadProduccion() {
    var cantidadProduccion = [];
    var data = lotesProduccion.rows().data();
    data.each(function(value, index) {
        let produccion = {
            orden_produccion_detalle_id: value[0],
            lote_id: value[1],
            cantidad: value[4],
        };
        cantidadProduccion.push(produccion);
    });
    $('#cantidadProduccionLote').val(JSON.stringify(cantidadProduccion));
}

//CARGAR A VARIABLE CANTIDAD DE EXCEDIDA
function cantidadExcedida() {
    var cantidadExcedida = [];
    var data = lotesExcedidos.rows().data();
    data.each(function(value, index) {
        let excedida = {
            lote_id: value[0],
            cantidad: value[3],
        };

        cantidadExcedida.push(excedida);

    });

    $('#cantidadExcedidaLote').val(JSON.stringify(cantidadExcedida));
}

//ENVIAR TODO EL FORMULARIO
$('#enviar_orden_produccion_lote').submit(function(e) {
    e.preventDefault();        
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
            var enviar = true 
            //CARGAR REGISTROS TABLAS A VARIABLE
            
            if (cantidadLoteproduccion(0) != $('#cantidadProduccion').val() ) {
                toastr.error('Las cantidades de los lotes (LOTE CANTIDAD DE PRODUCCION), no es igual a la de cantidad de producción', 'Error');
                enviar = false;
            }
            if (cantidadLoteexcedida(0) != $('#cantidadExcedida').val() ) {
                toastr.error('Las cantidades de los lotes (LOTE CANTIDAD EXCEDIDA), no es igual a la cantidad de excedida', 'Error');
                enviar = false;
            }
            if (enviar == true) {
                cantidadProduccion()
                cantidadExcedida()
                $('#asegurarCierre').val('2')
                this.submit()
            }

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

//SUMAR TOTAL DE CANTIDADES LOTE DE PRODUCCION
function cantidadLoteproduccion(cantidadProduccion) {
    var cantidad = 0;
    lotesProduccion.rows().data().each(function(el, index) {
        cantidad = Number(el[4]) + cantidad
    });
   return Number(cantidad) + Number(cantidadProduccion);
}

//SUMAR TOTAL DE CANTIDADES LOTE DE PRODUCCION
function cantidadLoteexcedida(cantidadExcedida2) {
    var cantidad = 0;
    lotesExcedidos.rows().data().each(function(el, index) {
        cantidad = Number(el[3]) + cantidad
    });
   return Number(cantidad) + Number(cantidadExcedida2);
}

//DEVOLVER CANTIDADES A LOS LOTES
function devolverCantidades() {
    //CARGAR CANTIDAD EXCEDIDA PARA DEVOLVER LOTE ARTICULO
    cantidadProduccion()
    $.ajax({
        dataType : 'json',
        type : 'post',
        url : '{{ route('produccion.orden.detalle.lote.articulos.devolver.cantidades') }}',
        data : {
            '_token' : $('input[name=_token]').val(),
            'cantidades' :  $('#cantidadProduccionLote').val(),
        }
    }).done(function (result){
        alert('DEVOLUCION REALIZADA')
        console.log(result)
    });
}

function devolverCantidadesExcedida() {
    //CARGAR CANTIDAD EXCEDIDA PARA DEVOLVER LOTE ARTICULO
    cantidadExcedida()
    $.ajax({
        dataType : 'json',
        type : 'post',
        url : '{{ route('produccion.orden.detalle.lote.articulos.devolver.cantidades') }}',
        data : {
            '_token' : $('input[name=_token]').val(),
            'cantidades' :  $('#cantidadExcedidaLote').val(),
        }
    }).done(function (result){
        alert('DEVOLUCION REALIZADA')
        console.log(result)
    });
}

</script>

<script>
    window.onbeforeunload = function () { 
        //DEVOLVER CANTIDADES 
        if($('#asegurarCierre').val() != 2 ) {devolverCantidades()}
        if($('#asegurarCierreExcedida').val() != 2 ) {devolverCantidadesExcedida()}
        
    };

</script>
@endpush