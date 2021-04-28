<div class="modal inmodal" id="CantidadProduccion" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" onclick="limpiarModallote()" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <i class="fa fa-cogs modal-icon"></i>
                <h4 class="modal-title"></h4>
                <small class="font-bold"></small>
            </div>
            <input type="hidden" id="condicion_modal">
            <div class="modal-body">
                <div class="form-group m-l">
                    <span><b>Instrucciones:</b> Doble click en el registro del producto a vender.</span>
                </div>
                <div class="form-group">
                    <div class="table-responsive m-t">
                        <table class="table dataTables-lotes table-bordered" style="width:100%; text-transform:uppercase;" id="table_lotes">
                            <thead>
                            <tr>
                                <th class="text-center"></th>
                                <th class="text-center">LOTE</th>
                                <th class="text-center">FECHA VENCIMIENTO</th>
                                <th class="text-center">CANTIDAD</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>

                        </table>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <div class="col-md-6 text-left">
                    <i class="fa fa-exclamation-circle leyenda-required"></i> <small class="leyenda-required">Seleccionar el lote del producto a vender.</small>
                </div>
                <div class="col-md-6 text-right">
                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>
                </div>
            </div>

        </div>
    </div>
</div>

@push('styles')
<!-- DataTable -->
<link href="{{asset('Inspinia/css/plugins/dataTables/datatables.min.css')}}" rel="stylesheet">
<style>

    @media (min-width: 992px){
        .modal-lg {
            max-width: 1200px;
        }
    }

    #table_lotes div.dataTables_wrapper div.dataTables_filter{
        text-align: left !important;
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

    #modal_lote  div.dataTables_wrapper div.dataTables_filter{
        text-align:left !important;
    }


    @media only screen and (max-width: 992px) {

        #table_tabla_registro_filter{
            text-align:left;
        }

        #table_lotes_filter{
            text-align: left;
        }
        #table_lotes  div.dataTables_wrapper div.dataTables_paginate ul.pagination {
            float:left;
            margin: 10px 0;
            white-space: nowrap;
        }

    }

    @media only screen and (min-width: 428px) and (max-width: 1190px) {
        /* Para tables: */
        #modal_lote div.dataTables_filter input { 
            width: 175% !important;
            display: inline-block !important;
        }
    }

    @media only screen and (max-width: 428px) {
        /* Para celular: */
        #modal_lote  div.dataTables_filter input { 
            width: 100% !important;
            display: inline-block !important;
        }
    }

    @media only screen and (min-width: 1190px) {

        #modal_lote div.dataTables_filter input { 
            width: 363% !important;
            display: inline-block !important;
        }
    }
</style>
@endpush

@push('scripts')
<!-- DataTable -->
<script src="{{asset('Inspinia/js/plugins/dataTables/datatables.min.js')}}"></script>
<script>


function obtenerLotesArticulos(articulo_id , condicion) {
    // CONDICION - LOTE
    // 1 -> DATATABLE LOTE - CANTIDAD DE PRODUCCION
    // 2 -> DATATABLE LOTE - CANTIDAD DE EXCEDIDA
    $('#condicion_modal').val(condicion)
    //RUTA LOTES ARTICULOS
    var url = '{{ route("produccion.orden.detalle.lote.articulos", ":id")}}';
    url = url.replace(':id', articulo_id);
    //ELIMINAR EL DATATABLE PARA VOLVER A INSTANCIARLO
    $(".dataTables-lotes").dataTable().fnDestroy();
    //INSTANCIAR DATATABLE
    lotes = $('.dataTables-lotes').DataTable({
        "dom": 
                "<'row'<'col-sm-12 col-md-12 col-lg-12'f>>" +
                "<'row'<'col-sm-12'tr>>"+ 
                "<'row justify-content-between'<'col information-content p-0'i><''p>>",

        "bPaginate": true,
        "serverSide":true,
        "processing":true,
        "ajax": url,
        "columns": [
            {data: 'id', className: "text-center", name:"lote_articulos.id" ,visible: false},
            {data: 'lote', className: "text-center", name:"lote_articulos.lote" },
            {data: 'fecha_venci', className: "text-center", name:"lote_articulos.fecha_vencimiento" },
            {data: 'cantidad_logica', className: "text-center", name:"lote_articulos.cantidad_logica" },
        ],
        "bLengthChange": true,
        "bFilter": true,
        "order": [],
        "bInfo": true,
        "bAutoWidth": false,
        "language": {
                    "url": "{{asset('Spanish.json')}}"
        },
        createdRow: function(row, data, dataIndex, cells) {
            $(row).addClass('fila_lote');
            $(row).attr('data-href', "");
        },


    });
}

$(document).ready(function() {
   
    $('buttons-html5').removeClass('.btn-default');
    $('#table_lotes_wrapper').removeClass('');

    $('.dataTables-lotes tbody').on( 'click', 'tr', function () {
            $('.dataTables-lotes').DataTable().$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
    } );

    //DOBLE CLICK EN LOTES
    $ ('.dataTables-lotes'). on ('dblclick', 'tbody td', function () {
        var data = lotes.row(this).data();
        ingresarLoteArticulo(data)
    });

})

function ingresarLoteArticulo(loteArticulo) {
    //LIMPIAR ERRORES AL INGRESAR LOTE ARTICULO
    // limpiarErrores()
    
    var condicion_modal = $('#condicion_modal').val()
    if (condicion_modal == '1') {
        //HABILITAR CAMPO CANTIDAD
        $('#cantidad_produccion_ingreso').prop('disabled' , false)
        //AGREGAR LIMITE A LA CANTIDAD SEGUN EL LOTE SELECCIONADO
        $("#cantidad_produccion_ingreso").attr({ 
            "max" : loteArticulo.cantidad_logica,
            "min" : 1,
        });
        //INGRESAR DATOS DEL LOTE A LOS CAMPOS
        $('#fecha_vencimiento_cantidad_produccion').val(loteArticulo.fecha_venci)
        $('#cantidad_produccion_ingreso').val(loteArticulo.cantidad_logica)
        $('#lote_cantidad_produccion').val(loteArticulo.lote)
        //ID LOTE ARTICULO
        $('#lote_articulo_id').val(loteArticulo.id)
        $('#lote_articulo').val(loteArticulo.descripcion_articulo+' - '+ loteArticulo.lote)

    }
    if (condicion_modal == '2') {
        //HABILITAR CAMPO CANTIDAD
        $('#cantidad_excedida_ingreso').prop('disabled' , false)
        
        $('#lote_articulo_excedida_id').val(loteArticulo.id)
        $('#lote_articulo_excedida').val(loteArticulo.descripcion_articulo+' - '+ loteArticulo.lote)

        //INGRESAR DATOS DEL LOTE A LOS CAMPOS
        $('#fecha_vencimiento_cantidad_excedida').val(loteArticulo.fecha_venci)
        $('#cantidad_excedida_ingreso').val(loteArticulo.cantidad_logica)
        $('#lote_cantidad_excedida').val(loteArticulo.lote)
    }

    //LIMPIAR MODAL
    limpiarModallote()
}

function evaluarPrecioigv(producto) {
    if ( producto.moneda == 4 ) {
        //PRODUCTO SIN IGV
        if ( producto.igv == '0' ) {
            var precio = Number(producto.precio_venta * 0.18) + Number(producto.precio_venta)
            return Number(precio).toFixed(2)
        }else{
            //PRODUCTO CON IGV
            var precio = producto.precio_venta
            return Number(precio).toFixed(2)
        }                        
    }else{
        toastr.error('Precio registrado diferente a Soles (S/.).', 'Error');
        return 0.00
    }
}

function limpiarModallote() {
    //ACTUALIZAR DATATABLE
    $('.dataTables-lotes').DataTable().ajax.reload();
    //CERRAR MODAL
    $('#CantidadProduccion').modal('hide');
}
//AL ABRIR EL MODAL SE DEBE DE ACTUALIZAR EL DATATABLE 
$('#modal_lote').on('show.bs.modal', function(e) {
    //ACTUALIZAR DATATABLE
    $('.dataTables-lotes').DataTable().ajax.reload();
});


</script>
@endpush