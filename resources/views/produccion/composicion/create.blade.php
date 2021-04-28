@extends('layout') @section('content')
@include('produccion.composicion.edit-detalle')
@section('produccion-active', 'active')
@section('composicion-active', 'active')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
       <h2  style="text-transform:uppercase"><b>REGISTRAR NUEVA COMPOSICION DE PRODUCTO TERMINADO</b></h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">Panel de Control</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('produccion.composicion.index') }}">Productos Terminados</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Registrar</strong>
            </li>
        </ol>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                    <form action="{{ route('produccion.composicion.store') }}" method="POST" id="form_registrar_producto">
                        @csrf
                        <h4><b>Producto</b></h4>

                        <div class="row">
                            <div class="col-md-12">
                                    <p>Registrar datos de la nueva composicion del producto terminado:</p>
                            </div>
                        </div>  

                        <div class="form-group row">
                            
                            <div class="col-lg-6 col-xs-12">
                                <label class="required">Producto</label>
                                <select name="producto_id" id="producto_id" class="select2_form form-control {{ $errors->has('producto_id') ? ' is-invalid' : '' }}" style="text-transform: uppercase; width:100%" onchange="ponerMedida()">
                                    <option></option>
                                    @foreach ($productos as $producto)
                                        <option {{ old('producto_id') == $producto->id ? 'selected' : '' }} value="{{$producto->id}}">{{$producto->nombre}}</option>
                                    @endforeach
                                </select>

                            </div>

                           
                            <div class="col-lg-6 col-xs-12">
                                <label>Unidad de Medida</label>
                                <input type="text" id="medida" class="form-control {{ $errors->has('medida') ? ' is-invalid' : '' }}" value="{{old('medida')}}" maxlength="300" disabled>
                                @if ($errors->has('medida'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('medida') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <hr>
                        <div class="row">
                            <div class="col-lg-12 col-xs-12">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <h4><b>Detalle de la Composicion del Producto</b></h4>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group row">
                                                    <div class="col-lg-6 col-xs-12">
                                                        <label class="required">Artículo</label>
                                                        <select id="articulo" class="select2_form form-control {{ $errors->has('articulo') ? ' is-invalid' : '' }}">
                                                            <option></option>
                                                            @foreach($articulos as $articulo)
                                                                <option value="{{ $articulo->id }}" {{ (old('articulo') == $articulo->id ? "selected" : "") }} >{{ $articulo->getDescripcionCompleta() }}</option>
                                                            @endforeach
                                                        </select>
                                                        @if ($errors->has('articulo'))
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $errors->first('articulo') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                    <div class="col-lg-2 col-xs-12">
                                                        <label class="required">Cantidad</label>
                                                        <input type="text" id="cantidad" class="form-control {{ $errors->has('cantidad') ? ' is-invalid' : '' }}" value="{{old('cantidad')}}" maxlength="10" onkeypress="return filterFloat(event, this, true);">
                                                        @if ($errors->has('cantidad'))
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $errors->first('cantidad') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                    <div class="col-lg-2 col-xs-12">
                                                        <label>Peso</label>
                                                        <input type="text" id="peso" class="form-control {{ $errors->has('peso') ? ' is-invalid' : '' }}" value="{{old('peso')}}" maxlength="15" onkeypress="return filterFloat(event, this, true);">
                                                        @if ($errors->has('peso'))
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $errors->first('peso') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-lg-10 col-xs-12">
                                                        <label>Observación</label>
                                                        <input type="text" id="observacion" class="form-control {{ $errors->has('observacion') ? ' is-invalid' : '' }}" value="{{old('observacion')}}" maxlength="300" onkeyup="return mayus(this)">
                                                        @if ($errors->has('observacion'))
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $errors->first('observacion') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                    <div class="col-lg-2 col-xs-12">
                                                        <button type="button" id="btn_agregar_detalle" class="btn btn-warning btn-block m-t-lg"><i class="fa fa-plus-circle"></i> Agregar</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row m-t-sm">
                                            <div class="col-lg-12">
                                                <div class="table-responsive">
                                                    <table class="table dataTables-detalle-producto table-striped table-bordered table-hover"  onkeyup="return mayus(this)">
                                                        <thead>
                                                        <tr>
                                                            <th></th>
                                                            <th class="text-left">ARTÍCULO</th>
                                                            <th class="text-center">CANTIDAD</th>
                                                            <th class="text-center">PESO</th>
                                                            <th class="text-left">OBSERVACIÓN</th>
                                                            <th class="text-center">ACCIONES</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <input type="hidden" name="detalles" id="detalles" value="{{ old('detalles') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group row">
                                    <div class="col-md-6 text-left">
                                        <i class="fa fa-exclamation-circle leyenda-required"></i> <small class="leyenda-required">Los campos marcados con asterisco
                                            (<label class="required"></label>) son obligatorios.</small>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <a href="{{route('produccion.composicion.index')}}" id="btn_cancelar"
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
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@stop

@push('styles')
    <link href="{{ asset('Inspinia/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}" rel="stylesheet">
    <link href="{{ asset('Inspinia/css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
    <link href="{{ asset('Inspinia/css/plugins/daterangepicker/daterangepicker-bs3.css') }}" rel="stylesheet">
    <link href="{{asset('Inspinia/css/plugins/select2/select2.min.css')}}" rel="stylesheet">
    <link href="{{asset('Inspinia/css/plugins/dataTables/datatables.min.css')}}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{{ asset('Inspinia/js/plugins/iCheck/icheck.min.js') }}"></script>
    <script src="{{ asset('Inspinia/js/plugins/select2/select2.full.min.js') }}"></script>
    <script src="{{asset('Inspinia/js/plugins/dataTables/datatables.min.js')}}"></script>
    <script src="{{asset('Inspinia/js/plugins/dataTables/dataTables.bootstrap4.min.js')}}"></script>
    <script>
        var table;
        var detalles = [];
        var objectRowDelete, objectRowEdit;

        //Modal Eliminar
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger',
            },
            buttonsStyling: false
        })

        $(document).ready(function() {
            $(".select2_form").select2({
                placeholder: "SELECCIONAR",
                allowClear: true,
                height: '200px',
                width: '100%',
            });
            $(".select3_form").select2({
                allowClear: true,
                height: '200px',
                width: '100%',
            });
            table = $('.dataTables-detalle-producto').DataTable({
                "dom": '<"html5buttons"B>lTfgitp',
                "buttons": [{
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o"></i> Excel',
                    titleAttr: 'Excel',
                    title: 'Detalle del Producto Terminado'
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
                "responsive": true,
                "bFilter": true,
                "bInfo": false,
                "columnDefs": [
                    {
                        "targets": 0,
                        "visible": false,
                        "searchable": false
                    },
                    {
                        searchable: false,
                        targets: -1,
                        data: null,
                        defaultContent: "<button type='button' class='btn btn-sm btn-warning mr-1 btn-edit'>" +
                                                "<i class='fa fa-pencil'></i>" +
                                            "</button>" +
                                            "<button type='button' class='btn btn-sm btn-danger mr-1 btn-delete'>" +
                                                "<i class='fa fa-trash'></i>" +
                                            "</button>"
                    }
                ],
                'bAutoWidth': false,
                'aoColumns': [
                    { sWidth: '0%' },
                    { sWidth: '40%', sClass: 'text-left' },
                    { sWidth: '10%', sClass: 'text-center' },
                    { sWidth: '10%', sClass: 'text-center' },
                    { sWidth: '30%', sClass: 'text-left' },
                    { sWidth: '10%', sClass: 'text-center' },
                ],
                'data': getData(),
                "language": {
                    url: "{{asset('Spanish.json')}}"
                },
                "order": [[ 0, "desc" ]],
            });

            //Controlar Error
            $.fn.DataTable.ext.errMode = 'throw';

            $("#codigo").on("change", validarCodigo);

            $("#familia").on("change", obtenerSubFamilias);

            $("#btn_agregar_detalle").on("click", agregarDetalle);

            $("#btn_editar_detalle").on("click", editarDetalle);

            $('.dataTables-detalle-producto tbody').on('click', 'button.btn-edit', cargarDetalle);

            $('.dataTables-detalle-producto tbody').on('click', 'button.btn-delete', eliminarDetalle);

            $('#form_registrar_producto').submit(function(e) {
                e.preventDefault();
                if (detalles !== undefined && detalles.length <= 0) {
                    toastr.error('Debe ingresar los detalles del producto');
                    return false;
                }
                $("#detalles").val(JSON.stringify(detalles));

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
                        this.submit();
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        swalWithBootstrapButtons.fire(
                            'Cancelado',
                            'La Solicitud se ha cancelado.',
                            'error'
                        )
                    }
                })
            });

        });

        function getData() {
            detalles = ($("#detalles").val() === undefined || $("#detalles").val() === "") ? [] : JSON.parse($("#detalles").val());
            var data = [];
            detalles.forEach(obj => {
                data.push([
                    String(obj.articulo_id),
                    String(obj.articulo),
                    parseFloat(obj.cantidad),
                    parseFloat(obj.peso),
                    String(obj.observacion)
                ]);
            });
            return data;
        }

        function validarCodigo() {
            // Consultamos nuestra BBDD
            $.ajax({
                dataType : 'json',
                type : 'post',
                url : '{{ route('produccion.composicion.getCodigo') }}',
                data : {
                    '_token' : $('input[name=_token]').val(),
                    'codigo' : $(this).val(),
                    'id': null
                }
            }).done(function (result){
                if (result.existe) {
                    toastr.error('El código ingresado ya se encuentra registrado para un producto','Error');
                    $(this).focus();
                }
            });
        }

        function obtenerSubFamilias() {
            $.ajax({
                dataType : 'json',
                type : 'post',
                url : '{{ route('almacenes.subfamilia.getByFamilia') }}',
                data : {
                    '_token' : $('input[name=_token]').val(),
                    'familia_id' : $(this).val()
                }
            }).done(function (data){
                // Limpiamos data
                $("#sub_familia").empty();

                if (!data.error) {
                    // Mostramos la información
                    if (data.sub_familias != null) {
                        $("#sub_familia").select2({
                            data: data.sub_familias
                        }).val($('#sub_familia').find(':selected').val()).trigger('change');
                    }
                } else {
                    toastr.error(data.message, 'Mensaje de Error', {
                        "closeButton": true,
                        positionClass: 'toast-bottom-right'
                    });
                }
            });
        }

        function agregarDetalle() {

            var detalle = {
                articulo_id: $("#articulo").val(),
                articulo: $("#articulo").select2('data')[0].text,
                cantidad: parseFloat($("#cantidad").val()),
                peso: parseFloat($("#peso").val()),
                observacion: $("#observacion").val()
            };

            if (validarDetalle(detalle)) {
                table.row.add([
                    detalle.articulo_id,
                    detalle.articulo,
                    detalle.cantidad,
                    detalle.peso,
                    detalle.observacion
                ]).draw(false);
                detalles.push(detalle);
                limpiarCamposDetalle();
            }
        }

        function cargarDetalle() {
            //console.log(table.row($(this).parents("tr")).data());
            var dataRow = table.row($(this).parents("tr")).data();
            objectRowEdit = table.row($(this).parents("tr"));
            $("#articulo_editar").val(dataRow[0]).trigger("change");
            $("#cantidad_editar").val(dataRow[2]);
            $("#peso_editar").val(dataRow[3]);
            $("#observacion_editar").val(dataRow[4]);

            $('#modal_editar_detalle').modal('show');
        }

        function editarDetalle() {
            var detalle = {
                articulo_id: $("#articulo_editar").val(),
                articulo: $("#articulo_editar").select2('data')[0].text,
                cantidad: parseFloat($("#cantidad_editar").val()),
                peso: parseFloat($("#peso_editar").val()),
                observacion: $("#observacion_editar").val()
            };

            if (validarDetalle(detalle, true)) {
                var indexRow = objectRowEdit.index();
                detalles.forEach((element, index) => {
                    if(element.articulo_id === detalle.articulo_id) {
                        detalles[index] = detalle;
                    }
                });
                objectRowEdit.cell(indexRow, 0).data(detalle.articulo_id).draw(false);
                objectRowEdit.cell(indexRow, 1).data(detalle.articulo).draw(false);
                objectRowEdit.cell(indexRow, 2).data(detalle.cantidad).draw(false);
                objectRowEdit.cell(indexRow, 3).data(detalle.peso).draw(false);
                objectRowEdit.cell(indexRow, 4).data(detalle.observacion).draw(false);

                $('#modal_editar_detalle').modal('hide');
            }
        }

        function eliminarDetalle() {
            //console.log(table.row($(this).parents("tr")).data());
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

                    var dataRow = table.row($(this).parents("tr")).data();
                    objectRowDelete = table.row($(this).parents("tr"));
                    table.row($(this).parents("tr")).remove().draw();
                    var removeIndex = detalles.map(function(item) { return item.articulo_id; }).indexOf(dataRow[0]);
                    detalles.splice(removeIndex, 1);

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

        function validarDetalle(detalle, isEditar = false) {

            if (!isEditar) {
                if (detalle.articulo_id === undefined || detalle.articulo_id === null || detalle.articulo_id.length === 0
                    || detalle.articulo === undefined || detalle.articulo === null || detalle.articulo.length === 0) {
                    toastr.error('El campo Artículo es obligatorio');
                    return false;
                }
                if (detalles.find(d => d.articulo_id === detalle.articulo_id) !== undefined) {
                    toastr.error('El artículo seleccionado ya existe en el detalle del producto');
                    return false;
                }
            }

            if (detalle.cantidad === undefined || detalle.cantidad === null || Number.isNaN(detalle.cantidad)) {
                toastr.error('El campo Cantidad es obligatorio');
                return false;
            }
            if (detalle.cantidad <= 0) {
                toastr.error('La cantidad ingresada debe ser mayor a cero');
                return false;
            }
            if (detalle.peso <= 0) {
                toastr.error('El peso ingresado debe ser mayor a cero');
                return false;
            }

            return true;
        }

        function limpiarCamposDetalle() {
            $("#articulo").val("").trigger("change");
            $("#cantidad").val("");
            $("#peso").val("");
            $("#observacion").val("");
        }

        $('#modal_editar_detalle').on('hidden.bs.modal', function(e) {
            $("#articulo_editar").val("").trigger("change");
            $("#cantidad_editar").val("");
            $("#peso_editar").val("");
            $("#observacion_editar").val("");
        });

        function ponerMedida(){
            producto = $("#producto_id").val()
            var medida = ""
            @foreach($productos as $producto)
            if ("{{$producto->id}}" == producto) {
                medida = "{{$producto->medidaCompleta()}}"
            }
            @endforeach
            $("#medida").val(medida)
        }

        // no se esta usando, se debería usar si deseo escoger productos que ya tienen composición
        function cargarComposicion(){
            const producto = $("#producto_id").val()
            @foreach($productos as $producto)
                if ("{{$producto->id}}" == producto) {
                    $.ajax({
                        dataType : 'json',
                        type : 'post',
                        url : "{{ route('produccion.composicion.getTable2',':producto') }}",
                        success: function(respuesta) {
                            $.each(respuesta.data, function(inde, elemento){
                              var detalle = {
                                articulo_id: elemento.articulo_id,
                                articulo: elemento.articulo_id,
                                cantidad: elemento.cantidad,
                                peso: elemento.peso,
                                observacion: elemento.observacion
                               };
                                if (validarDetalle(detalle)) {
                                    table.row.add([
                                        detalle.articulo_id,
                                        detalle.articulo,
                                        detalle.cantidad,
                                        detalle.peso,
                                        detalle.observacion
                                    ]).draw(false);
                                    detalles.push(detalle);  
                                }
                            });
                            console.log($detalles);
                        },
                        error: function() {
                          console.log("No se ha podido obtener la información");
                        }
                    });
                }
            @endforeach
        }

    </script>
@endpush
