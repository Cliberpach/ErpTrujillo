<div class="modal inmodal" id="modal_conformidad_edit" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" onclick="limpiarModalEditar()" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <i class="fa fa-cogs modal-icon"></i>
                <h4 class="modal-title">Conformidad del producto terminado</h4>
                <small class="font-bold"></small>
            </div>

            <form action="{{route('produccion.lote.update')}}" method="POST" id="form_conformidad_edit">
                @csrf
                <div class="modal-body">
            
                    <input type="hidden" name="orden_produccion" id="orden_produccion_edit" value="{{old('orden_produccion')}}" >
                    <input type="hidden" name="lote_id" id="lote_id" value="{{old('lote_id')}}" >
                    <div class="form-group row">

                        <div class="col-lg-6 col-xs-12 b-r">
                            <div class="form-group">
                                <span><b> Datos de la orden de produccion: </b></span>
                            </div>

                            <div class="form-group">
                                <label>N° de Orden de Producción</label>
                                <input type="text" name="n_produccion" id="n_produccion_edit" class="form-control {{ $errors->has('n_produccion') ? ' is-invalid' : '' }}" value="{{old('n_produccion')}}" required readonly>
                                @if ($errors->has('n_produccion'))
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('n_produccion') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-6 col-xs-12" id="fecha_vencimiento_campo">
                                    <label class="">Fecha de Vencimiento</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                        <input type="text" id="fecha_vencimiento_edit" name="fecha_vencimiento" class="form-control {{ $errors->has('fecha_vencimiento') ? ' is-invalid' : '' }}" autocomplete="off" disabled >
                                        @if ($errors->has('fecha_vencimiento'))
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('fecha_vencimiento') }}</strong>
                                        </span>
                                        @endif
                                    </div>

                                </div>

                                <div class="col-lg-6 col-xs-12">
                                    <label class="required">Cantidad</label>

                                    <input type="number" id="cantidad_edit" name="cantidad" class="form-control {{ $errors->has('cantidad') ? ' is-invalid' : '' }}" value="{{old('cantidad')}}" required>
                                    @if ($errors->has('cantidad'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('cantidad') }}</strong>
                                    </span>
                                    @endif
                   

                                </div>
                            </div>

                            <div class="form-group">
                                <label class="">Codigo Producto</label>
                                <input type="text" name="codigo_producto" id="codigo_producto_edit" class="form-control {{ $errors->has('codigo_producto') ? ' is-invalid' : '' }}" value="{{old('codigo_producto')}}" required readonly>
                                @if ($errors->has('codigo_producto'))
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('codigo_producto') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label class="">Descripción del Producto</label>
                                <input type="text" name="producto" id="producto_edit" class="form-control {{ $errors->has('producto') ? ' is-invalid' : '' }}" value="{{old('producto')}}" required readonly>
                                @if ($errors->has('producto'))
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('producto') }}</strong>
                                </span>
                                @endif
                            </div>

                            
                        </div>
                        <div class="col-lg-6 col-xs-12">
                            <div class="form-group">
                                <span><b> Registrar conformidad de la orden de produccion: </b></span>
                            </div>
                            <div class="form-group">
                                <label class="required">Lote de Produccion</label>
                                <input type="number" name="lote_producto" id="lote_producto_edit" class="form-control {{ $errors->has('lote_producto') ? ' is-invalid' : '' }}" value="{{old('lote_producto')}}" required>
                                @if ($errors->has('lote_producto'))
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('lote_producto') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-6 col-xs-12" id="fecha_entrega">
                                    <label class="required">Fecha de Entrega</label>
                                    <div class="input-group date">
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                        <input type="text" id="fecha_entrega_edit" name="fecha_entrega" class="form-control {{ $errors->has('fecha_atencion') ? ' is-invalid' : '' }}" value="{{old('fecha_entrega')}}" autocomplete="off" required readonly>
                                        @if ($errors->has('fecha_entrega'))
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('fecha_entrega') }}</strong>
                                        </span>
                                        @endif
                                    </div>

                                </div>
                            </div>
                            <div class="form-group">
                                <label class="">Observación</label>
                                <textarea name="observacion" id="observacion_edit" class="form-control {{ $errors->has('observacion') ? ' is-invalid' : '' }}" value="{{old('observacion')}}" cols="30" rows="4">{{old('observacion')}}</textarea>
                                @if ($errors->has('observacion'))
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('observacion') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group ">
                        <span><b> Datos de Confirmación: </b></span>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-xs-12 ">
                                <div class="form-group">
                                    <label class="">Confirmación de Almacen: &nbsp</label>
                                    <input type="checkbox" name="confirmacion_almacen" id="confirmacion_almacen_edit">
                                </div>
                        </div>
                        <div class="col-lg-6 col-xs-12 ">

                                <div class="form-group">
                                    <label class="">Confirmación de Producción: &nbsp</label>
                                    <input type="checkbox" name="confirmacion_produccion" id='confirmacion_produccion_edit'>
                                </div>

                        </div>


                    </div>
                </div>

                <div class="modal-footer">
                    <div class="col-md-6 text-left">
                        <i class="fa fa-exclamation-circle leyenda-required"></i> <small class="leyenda-required">Los campos marcados con asterisco (<label class="required"></label>) son obligatorios.</small>
                    </div>
                    <div class="col-md-6 text-right">
                        <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-save"></i> Guardar</button>
                        <button type="button"  onclick="limpiarModalEditar()" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>

@push('styles')
<!-- DataTable -->
<link href="{{ asset('Inspinia/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}" rel="stylesheet">
<link href="{{ asset('Inspinia/css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
<link href="{{ asset('Inspinia/css/plugins/daterangepicker/daterangepicker-bs3.css') }}" rel="stylesheet">
<link href="{{asset('Inspinia/css/plugins/select2/select2.min.css')}}" rel="stylesheet">
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
<script src="{{ asset('Inspinia/js/plugins/iCheck/icheck.min.js') }}"></script>
<script src="{{ asset('Inspinia/js/plugins/select2/select2.full.min.js') }}"></script>
<script src="{{asset('Inspinia/js/plugins/dataTables/datatables.min.js')}}"></script>
<script src="{{asset('Inspinia/js/plugins/dataTables/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{ asset('Inspinia/js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('Inspinia/js/plugins/fullcalendar/moment.min.js') }}"></script>
<script src="{{ asset('Inspinia/js/plugins/daterangepicker/daterangepicker.js') }}"></script>
<script>


    function obtenerLotesproductos(tipo_cliente) {


        
        
    }

    $(document).ready(function() {
        $('.input-group.date').datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            autoclose: true,
            language: 'es',
            format: "dd/mm/yyyy"
        });
    })


    $('#form_conformidad_edit').submit(function(e) {
        e.preventDefault();
        
            Swal.fire({
                customClass: {
                    container: 'my-swal'
                },
                title: 'Opción Confirmación',
                text: "¿Seguro que desea Confirmar la orden de producción?",
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
        
    })

function ingresarProducto(producto) {
    //LIMPIAR ERRORES AL INGRESAR PRODUCTO LOTE
    limpiarErrores()
    //HABILITAR CAMPOS DEL PRODUCTO
    $('#precio').prop('disabled' , false)
    $('#cantidad').prop('disabled' , false)
    $('#btn_agregar_detalle').prop('disabled' , false)
    //INGRESAR DATOS DEL PRODUCTO A LOS CAMPOS
    $('#precio').val(evaluarPrecioigv(producto))
    $('#cantidad').val(producto.cantidad)
    $('#producto_unidad').val(producto.unidad_producto)
    $('#producto_id').val(producto.id)
    $('#producto_lote').val(producto.nombre+' - '+ producto.codigo)
    //AGREGAR LIMITE A LA CANTIDAD SEGUN EL LOTE SELECCIONADO
    $("#cantidad").attr({ 
        "max" : producto.cantidad,
        "min" : 1,
    });
    $("#precio").attr({ 
        "min" : 1,
    });
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

function limpiarModalEditar() {
    $('#lote_producto_edit').val('');
    $('#fecha_entrega_edit').val('');
    $('#observacion_edit').val('');
    $('#confirmacion_almacen_edit').prop('checked', false);
    $('#confirmacion_produccion_edit').prop('checked', false);
    //CERRAR MODAL
    $('#modal_conformidad').modal('hide');
}


</script>
@endpush