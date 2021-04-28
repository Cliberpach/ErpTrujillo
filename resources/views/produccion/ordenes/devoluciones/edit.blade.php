@extends('layout') @section('content')
@section('produccion-active', 'active')
@section('ordenes_produccion-active', 'active')
<div class="row wrapper border-bottom white-bg page-heading">

    <div class="col-lg-12">
       <h2  style="text-transform:uppercase"><b>DEVOLUCIONES DE LA ORDEN DE PRODUCCION - {{$orden->codigo}}</b></h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{route('home')}}">Panel de Control</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{route('produccion.orden.edit', [ 'orden' => $orden->id ])}}">Orden de Producción</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Devolución</strong>
            </li>

        </ol>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">

                <div class="ibox-content">

                    <form action="{{route('produccion.orden.detalle.lote.devolucion.update')}}" method="POST" id="enviar_orden_produccion_lote">
                        {{csrf_field()}}

                            <input type="hidden" name="productos_detalle" id="productos_detalle">

                            <div class="row">

                                <div class="col-lg-12">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading">
                                            <h4 class=""><b>Devoluciones de la Orden de Producción</b></h4>
                                        </div>
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-lg-6 col-xs-12 b-r">
                                                
                                                    <div class="form-group">
                                                        <p>Doble click para seleccionar registro Lotes:</p>
                                                    </div>
                                                    <div class="table-responsive" >

                                                        <table class="table dataTables-ordenes-detalle-lotes table-striped table-bordered table-hover" id="table_lotes" style="text-transform:uppercase">
                                                            <thead>
                                                            <tr>
                                                                <th class="text-center">ID</th>
                                                                <th class="text-center">LOTE</th>
                                                                <th class="text-center">CANTIDAD</th>
                                                                <th class="text-center">TIPO</th>
                                                                <th class="text-center"></th> 
                                                                <th class="text-center"></th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>

                                                                @foreach($ordenDetalleLotes as $ordenDetalleLote)

                                                                
                                                                    <tr>
                                                                        <!-- ID ORDEN DETALLE LOTE -->
                                                                        <td class="text-center" >{{$ordenDetalleLote->id}}</td> 
                                                                        <td class="text-center">{{$ordenDetalleLote->loteArticulo->lote}}</td>
                                                                        <td>{{$ordenDetalleLote->cantidad}}</td>
                                                                        <td>{{$ordenDetalleLote->tipo_cantidad}}</td>
                                                                        <td></td>
                                                                        <td></td>
                                                                    </tr>

                                                                @endforeach


                                                            </tbody>
                                                        </table>




                                                    </div>

                                                    <div class="form-group">
                                                        <p>Cantidades Devueltas:</p>
                                                    </div>

                                                    <div class="table-responsive" >

                                                        <table class="table dataTables-devoluciones table-striped table-bordered table-hover" style="text-transform:uppercase">
                                                            <thead>
                                                            <tr>
                                                                <th colspan="4" class="text-center">LOTES</th>
                                                                <th colspan="2" class="text-center">DEVOLUCIONES</th>
                                                            </tr>
                                                            <tr>
                                                                <th class="text-center">ID</th>
                                                                <th class="text-center">LOTE</th>
                                                                <th class="text-center">CANTIDAD</th>
                                                                <th class="text-center">TIPO</th>
                                                                <th class="text-center">DESCRIPCION</th> 
                                                                <th class="text-center">CANTIDAD</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>

                                                                @foreach($devoluciones as $devolucion)
                                                                    <tr>
                                                                        <!-- DEVOLUCIONES -->
                                                                        <td class="text-center" >{{$devolucion->orden_detalle_lote}}</td> 
                                                                        <td class="text-center">{{$devolucion->lote}}</td>
                                                                        <td>{{$devolucion->cantidad_lote}}</td>
                                                                        <td>{{$devolucion->tipo}}</td>
                                                                        <td>@if($devolucion->estado == 0) {{'MAL ESTADO'}}@else{{'BUEN ESTADO'}}@endif</td>
                                                                        <td>{{$devolucion->cantidad}}</td>
                                                                    </tr>
                                                                @endforeach


                                                            </tbody>
                                                        </table>

                                                    </div>



                                                </div>

                                                <div class="col-lg-6 col-xs-12">

                                                        <div class="form-group">
                                                            
                                                            <p>Registrar devoluciones: <span id='id_loteDetalle_texto' style=display:none; class="text-success">ID <span id='id_loteDetalle'></span></span></p>
                                                            
                                                        </div>
                                                        
                                                        <input type="hidden" name="ordenDetalleLote_id" id="ordenDetalleLote_id">
                                                        <div class="form-group row">
                                                            <input type="hidden" name="cantidad_seleccionada" id="cantidad_seleccionada">
                                                            <div class="col-lg-6 col-xs-12 b-r">
                                                                <label class='required'>Cantidad  </label> <b>( Buen estado )</b>
                                                                <input type="number" id="cantidad_buen_estado" name="cantidad_buen_estado" onkeyup="return mayus(this)"  class="form-control {{ $errors->has('codigo') ? ' is-invalid' : '' }}" 
                                                                    value="{{old('cantidad_buen_estado')}}" required readonly>
                                                                @if ($errors->has('cantidad_buen_estado'))
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $errors->first('cantidad_buen_estado') }}</strong>
                                                                </span>
                                                                @endif
                                                            </div>

                                                            <div class="col-lg-6 col-xs-12 b-r">
                                                                <label class='required'>Cantidad  </label> <b>( Mal estado )</b>
                                                                <input type="number" id="cantidad_mal_estado" name="cantidad_mal_estado" onkeyup="return mayus(this)"  class="form-control {{ $errors->has('codigo') ? ' is-invalid' : '' }}" 
                                                                    value="{{old('cantidad_mal_estado')}}" required readonly>
                                                                @if ($errors->has('cantidad_mal_estado'))
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $errors->first('cantidad_mal_estado') }}</strong>
                                                                </span>
                                                                @endif
                                                            </div>


                                                        
                                                        </div>

                                                        <div class="hr-line-dashed"></div>
                                                        <div class="form-group row">
                                                            <div class="col-md-6 text-left" style="color:#fcbc6c">
                                                                <i class="fa fa-exclamation-circle"></i> <small>Los campos marcados con asterisco
                                                                    (<label class="required"></label>) son obligatorios.</small>
                                                            </div>
                                                            <div class="col-md-6 text-right">
                                                                <a href="{{route('produccion.orden.edit', [ 'orden' => $orden->id ])}}" id="btn_cancelar"
                                                                    class="btn btn-w-m btn-default">
                                                                    <i class="fa fa-arrow-left"></i> Regresar
                                                                </a>
                                                                <button type="submit" id="btn_grabar" class="btn btn-w-m btn-primary">
                                                                    <i class="fa fa-save"></i> Grabar
                                                                </button>
                                                            </div>
                                                        </div>



                                                </div>
                                            </div>



                                        </div>
                                    </div>
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

    #table_lotes tr[data-href] {
        cursor: pointer;
    }
    #table_lotes tbody .fila_lote.selected {
        /* color: #151515 !important;*/
        font-weight: 400; 
        color: white !important;
        background-color: #18a689 !important;
        /* background-color: #CFCFCF !important; */
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

//INICIA DATATABLE ORDEN DETALLE LOTE
$(document).ready(function() {
    ordenesDetalleLotes = $('.dataTables-ordenes-detalle-lotes').DataTable({
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
                    "targets": [4], // BUEN ESTADO CANTIDAD
                    visible: false,
                },
                {
                    "targets": [5], // MAL ESTADO CANTIDAD
                    visible: false,
                },
            ],
            createdRow: function(row, data, dataIndex, cells) {
                $(row).addClass('fila_lote');
                $(row).attr('data-href', "");
            },
    });

    $('buttons-html5').removeClass('.btn-default');
    $('#table_lotes_wrapper').removeClass('');

    $('.dataTables-ordenes-detalle-lotes tbody').on( 'click', 'tr', function () {
            $('.dataTables-ordenes-detalle-lotes').DataTable().$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
    } );

    //DOBLE CLICK EN LOTES
    $ ('.dataTables-ordenes-detalle-lotes'). on ('dblclick', 'tbody td', function () {
        var data = ordenesDetalleLotes.row(this).data();
        $('#cantidad_seleccionada').val(data['2'])
        //OBTENER LOTES
        cantidadLote(data['0'])
    });


});

//INICIA DATATABLE DEVOLUCIONES
$(document).ready(function() {
    
    devoluciones = $('.dataTables-devoluciones').DataTable({
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
                    "targets": [4], // BUEN ESTADO CANTIDAD
                    className: 'text-center',
                },
                {
                    "targets": [5], // MAL ESTADO CANTIDAD
                    className: 'text-center',
                },
            ],
    });

});

//OBTENER CANTIDADES DEVUELTAS BUEN ESTADO // MAL ESTADO
function cantidadLote(lote_id) {
    $.ajax({
        dataType : 'json',
        type : 'post',
        url : '{{ route('produccion.orden.detalle.lote.devolucion.cantidad') }}',
        data : {
            '_token' : $('input[name=_token]').val(),
            'lote_id' : lote_id,
        }
    }).done(function (result){
        $.each(result, function(key,value) {
            $('#id_loteDetalle_texto').css("display","")
            $('#id_loteDetalle').text(value.detalle_lote_id)
            $('#ordenDetalleLote_id').val(value.detalle_lote_id);
            if (value.estado == '1') {
                $('#cantidad_buen_estado').prop('readonly', false);
                $('#cantidad_buen_estado').val(value.cantidad);
            }
            if (value.estado == '0') {
                $('#cantidad_mal_estado').prop('readonly', false);
                $('#cantidad_mal_estado').val(value.cantidad);
            }
        });
    });
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

//ENVIAR TODO EL FORMULARIO
$('#enviar_orden_produccion_lote').submit(function(e) {
    e.preventDefault();
    var enviar = false;   
    cantidadAcumulado = Number($('#cantidad_buen_estado').val()) + Number($('#cantidad_mal_estado').val())
    if (cantidadAcumulado > Number($('#cantidad_seleccionada').val()) ) {
        toastr.error('La Suma de las cantidades es mayor a la cantidad seleccionada.', 'Error');
        enviar = true;
    }
    if (cantidadAcumulado < 0 ) {
        toastr.error('La Suma de las cantidades es menor a 0.', 'Error');
        enviar = true;
    }

    if (cantidadAcumulado == 0 ) {
        toastr.error('La Suma de las cantidades  es 0.', 'Error');
        enviar = true;
    }

    if (enviar != true) {
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
                    this.submit()
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



</script>
@endpush