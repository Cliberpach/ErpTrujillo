<div class="modal inmodal" id="modal_conformidad_show" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" onclick="limpiarModallote()" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <i class="fa fa-cogs modal-icon"></i>
                <h4 class="modal-title">Conformidad del producto terminado</h4>
                <small class="font-bold"></small>
            </div>

            <form action="{{route('produccion.lote.update')}}" method="POST" id="form_conformidad_show">
                @csrf
                <div class="modal-body">
        
                    <div class="form-group row">

                        <div class="col-lg-6 col-xs-12 b-r">
                            <div class="form-group">
                                <span><b> Datos de la orden de produccion: </b></span>
                            </div>

                            <div class="form-group">
                                <label>N° de Orden de Producción</label>
                                <input type="text" name="n_produccion" id="n_produccion_show" class="form-control {{ $errors->has('n_produccion') ? ' is-invalid' : '' }}" value="{{old('n_produccion')}}" disabled>
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
                                        <input type="text" id="fecha_vencimiento_show" name="fecha_vencimiento" class="form-control {{ $errors->has('fecha_vencimiento') ? ' is-invalid' : '' }}" autocomplete="off" disabled >
                                        @if ($errors->has('fecha_vencimiento'))
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('fecha_vencimiento') }}</strong>
                                        </span>
                                        @endif
                                    </div>

                                </div>

                                <div class="col-lg-6 col-xs-12">
                                    <label class="">Cantidad</label>

                                    <input type="number" id="cantidad_show" name="cantidad" class="form-control {{ $errors->has('cantidad') ? ' is-invalid' : '' }}" value="{{old('cantidad')}}" readonly>
                                    @if ($errors->has('cantidad'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('cantidad') }}</strong>
                                    </span>
                                    @endif
                   

                                </div>
                            </div>

                            <div class="form-group">
                                <label class="">Codigo Producto</label>
                                <input type="text" name="codigo_producto" id="codigo_producto_show" class="form-control {{ $errors->has('codigo_producto') ? ' is-invalid' : '' }}" value="{{old('codigo_producto')}}" required readonly>
                                @if ($errors->has('codigo_producto'))
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('codigo_producto') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label class="">Descripción del Producto</label>
                                <input type="text" name="producto" id="producto_show" class="form-control {{ $errors->has('producto') ? ' is-invalid' : '' }}" value="{{old('producto')}}" readonly>
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
                                <label class="">Lote de Produccion</label>
                                <input type="number" name="lote_producto" id="lote_producto_show" class="form-control {{ $errors->has('lote_producto') ? ' is-invalid' : '' }}" value="{{old('lote_producto')}}" readonly>
                                @if ($errors->has('lote_producto'))
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('lote_producto') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-6 col-xs-12" id="fecha_entrega">
                                    <label class="">Fecha de Entrega</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                        <input type="text" id="fecha_entrega_show" name="fecha_entrega" class="form-control {{ $errors->has('fecha_atencion') ? ' is-invalid' : '' }}" value="{{old('fecha_entrega')}}" autocomplete="off"  readonly>
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
                                <textarea name="observacion" id="observacion_show" class="form-control {{ $errors->has('observacion') ? ' is-invalid' : '' }}" value="{{old('observacion')}}" cols="30" rows="4" readonly>{{old('observacion')}}</textarea>
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
                                    <input type="checkbox" name="confirmacion_almacen" id="confirmacion_almacen_show" disabled>
                                </div>
                        </div>
                        <div class="col-lg-6 col-xs-12 ">

                                <div class="form-group">
                                    <label class="">Confirmación de Producción: &nbsp</label>
                                    <input type="checkbox" name="confirmacion_produccion" id='confirmacion_produccion_show' disabled >
                                </div>

                        </div>


                    </div>
                </div>

                <div class="modal-footer">

                    <div class="col-md-6 text-right">
                        <button type="button"  onclick="limpiarModallote()" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>
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



    function limpiarModallote() {
        //CERRAR MODAL
        $('#modal_conformidad').modal('hide');
    }


</script>
@endpush