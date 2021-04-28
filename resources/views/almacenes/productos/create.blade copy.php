@extends('layout') @section('content')
@include('almacenes.productos.edit-detalle')
@section('almacenes-active', 'active')
@section('productos-active', 'active')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
       <h2  style="text-transform:uppercase"><b>REGISTRAR NUEVO PRODUCTO TERMINADO</b></h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">Panel de Control</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('almacenes.producto.index') }}">Productos Terminados</a>
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
                    <form action="{{ route('almacenes.producto.store') }}" method="POST" id="form_registrar_producto">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 col-xs-12 b-r">
                                <h4><b>Datos Generales</b></h4>
                                <div class="form-group row">
                                    <div class="col-lg-6 col-xs-12">
                                        <label class="required">Código ISO</label>
                                        <input type="text" id="codigo" name="codigo" class="form-control {{ $errors->has('codigo') ? ' is-invalid' : '' }}" value="{{old('codigo')}}" maxlength="50" onkeyup="return mayus(this)" required>
                                        @if ($errors->has('codigo'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('codigo') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="col-lg-6 col-xs-12">
                                        <label class="">Código de Barra</label>
                                        <input type="text" id="codigo_barra" class="form-control {{ $errors->has('codigo_barra') ? ' is-invalid' : '' }}" name="codigo_barra" value="{{ old('codigo_barra')}}"   onkeyup="return mayus(this)">
                                        @if ($errors->has('codigo_barra'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('codigo_barra') }}</strong>
                                            </span>
                                        @endif 
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-6 col-xs-12">
                                        <label class="required">Moneda</label>
                                        <select id="moneda" name="moneda" class="select2_form form-control {{ $errors->has('moneda') ? ' is-invalid' : '' }}" required>
                                            <option></option>
                                            @foreach(tipos_moneda() as $tipo)
                                                <option value="{{ $tipo->id }}" {{ (old('moneda') == $tipo->id ? "selected" : "") }} >{{ $tipo->descripcion }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('moneda'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('moneda') }}</strong>
                                            </span>
                                        @endif

                                    </div>
                                    <div class="col-lg-6 col-xs-12">
                                        <label class="required">Presentación</label>
                                        <select id="presentacion" name="presentacion" class="select2_form form-control {{ $errors->has('presentacion') ? ' is-invalid' : '' }}">
                                            <option></option>
                                            @foreach(presentaciones() as $presentacion)
                                                <option value="{{ $presentacion->simbolo }}" {{ (old('presentacion') == $presentacion->simbolo ? "selected" : "") }}>{{ $presentacion->descripcion }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('presentacion'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('presentacion') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>



                                <div class="form-group">
 
                                    <label class="required">Nombre</label>
                                    <input type="text" id="nombre" name="nombre" class="form-control {{ $errors->has('nombre') ? ' is-invalid' : '' }}" value="{{old('nombre')}}" maxlength="191" onkeyup="return mayus(this)" required>
                                    @if ($errors->has('nombre'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('nombre') }}</strong>
                                        </span>
                                    @endif
                                
                                </div>


                                <div class="form-group">
                                    
                                        <label class="required">Línea Comercial</label>
                                        <select id="linea_comercial" name="linea_comercial" class="select2_form form-control {{ $errors->has('linea_comercial') ? ' is-invalid' : '' }}" required value="{{old('linea_comercial')}}">
                                            <option></option>
                                            @foreach(lineas_comerciales() as $linea)
                                                <option value="{{ $linea->id }}" {{ (old('linea_comercial') == $linea->id ? "selected" : "") }} >{{ $linea->descripcion }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('linea_comercial'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('linea_comercial') }}</strong>
                                            </span>
                                        @endif

                                    
                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-6 col-xs-12">
                                        <label class="required">Categoria</label>
                                        <select id="familia" name="familia" class="select2_form form-control {{ $errors->has('familia') ? ' is-invalid' : '' }}">
                                            <option></option>
                                            @foreach($familias as $familia)
                                                <option value="{{ $familia->id }}" {{ (old('familia') == $familia->id ? "selected" : "") }} >{{ $familia->familia }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('familia'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('familia') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="col-lg-6 col-xs-12">
                                        <label class="required">Sub Categoria</label>
                                        <select id="sub_familia" name="sub_familia" class="select2_form form-control {{ $errors->has('sub_familia') ? ' is-invalid' : '' }}" disabled required >
                                            <option></option>
                                        </select>
                                        @if ($errors->has('sub_familia'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('sub_familia') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                            </div>
                            <div class="col-lg-6 col-xs-12">
                                <h4><b>Cantidades y Precios</b></h4>
                                <div class="form-group row">
                                    <div class="col-lg-6 col-xs-12">
                                        <label class="required">Stock</label>
                                        <input type="text" id="stock" name="stock" class="form-control {{ $errors->has('stock') ? ' is-invalid' : '' }}" value="{{old('stock')}}" maxlength="10" onkeypress="return isNumber(event);" required>
                                        @if ($errors->has('stock'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('stock') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="col-lg-6 col-xs-12">
                                        <label class="required">Stock mínimo</label>
                                        <input type="text" id="stock_minimo" name="stock_minimo" class="form-control {{ $errors->has('stock_minimo') ? ' is-invalid' : '' }}" value="{{old('stock_minimo')}}" maxlength="10" onkeypress="return isNumber(event);" required>
                                        @if ($errors->has('stock_minimo'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('stock_minimo') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-6 col-xs-12">
                                        <label class="required">Precio venta mínimo</label>
                                        <input type="text" id="precio_venta_minimo" name="precio_venta_minimo" class="form-control {{ $errors->has('precio_venta_minimo') ? ' is-invalid' : '' }}" value="{{old('precio_venta_minimo')}}" maxlength="15" onkeypress="return filterFloat(event, this);" required>
                                        @if ($errors->has('precio_venta_minimo'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('precio_venta_minimo') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="col-lg-6 col-xs-12">
                                        <label class="required">Precio venta máximo</label>
                                        <input type="precio_venta_maximo" id="precio_venta_maximo" name="precio_venta_maximo" class="form-control {{ $errors->has('precio_venta_maximo') ? ' is-invalid' : '' }}" value="{{old('precio_venta_maximo')}}" maxlength="15" onkeypress="return filterFloat(event, this);" required>
                                        @if ($errors->has('precio_venta_maximo'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('precio_venta_maximo') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-12 col-xs-12">
                                        <label class="required">Incluye IGV</label>
                                        <div class="row">
                                            <div class="col-sm-6 col-xs-6">
                                                <div class="radio">
                                                    <input type="radio" name="igv" id="igv_si" value="1" checked="">
                                                    <label for="igv_si">
                                                        SI
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-xs-6">
                                                <div class="radio">
                                                    <input type="radio" name="igv" id="igv_no" value="0">
                                                    <label for="igv_no">
                                                        NO
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>

                        <div class="row">

                            <div class="col-lg-12">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <h4 class=""><b>Detalle Segun el tipo de cliente</b></h4>
                                    </div>
                                    <div class="panel-body">


                                        <div class="row">

                                            <div class="col-md-6">
                                                <label class="required">Cliente</label>
                                                <select class="select2_form form-control"
                                                    style="text-transform: uppercase; width:100%" name="cliente"
                                                    id="cliente">
                                                    <option></option>
                                                    @foreach (tipo_clientes() as $cliente)
                                                    <option value="{{$cliente->descripcion}}">{{$cliente->descripcion}}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback"><b><span id="error-cliente"></span></b>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="required">Monto</label>
                                                <input type="text" id="monto" name="monto" class="form-control" pattern="^[0-9]+(.[0-9]+)?$">
                                                <div class="invalid-feedback"><b><span id="error-monto"></span></b></div>
                                            </div>

                                            <div class="col-md-3">
                                                <label class="">&nbsp;</label>
                                                <a class="btn btn-block btn-warning enviar_cliente" style='color:white;'> <i class="fa fa-plus"></i> AGREGAR</a>
                                            </div>
                                        </div>

                                        <input type="hidden" id="clientes_tabla" name="clientes_tabla[]">

                                        <hr>

                                        <div class="table-responsive">
                                            <table
                                                class="table dataTables-clientes table-striped table-bordered table-hover"
                                                style="text-transform:uppercase">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">ACCIONES</th>
                                                        <th class="text-center">CLIENTE</th>
                                                        <th class="text-center">MONTO</th>

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
                        
                        <div class="hr-line-dashed"></div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group row">
                                    <div class="col-md-6 text-left">
                                        <i class="fa fa-exclamation-circle leyenda-required"></i> <small class="leyenda-required">Los campos marcados con asterisco
                                            (<label class="required"></label>) son obligatorios.</small>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <a href="{{route('almacenes.producto.index')}}" id="btn_cancelar"
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
@include('almacenes.productos.modal')
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
                    //.error('Debe ingresar los detalles del producto');
                    //return false;
                }
                //$("#detalles").val(JSON.stringify(detalles));

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


                        var existe = cantidadTipo()
            
                        if (existe == false) {
                            
                            Swal.fire({
                                title: 'Tipo de clientes',
                                text: "¿Seguro que desea agregar Producto sin ningun tipo de cliente?",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: "#1ab394",
                                confirmButtonText: 'Si, Confirmar',
                                cancelButtonText: "No, Cancelar",
                            }).then((result) => {
                                
                                if (result.isConfirmed) {
                                    cargarClientes();
                                    this.submit();
                                } else if (
                                    /* Read more about handling dismissals below */
                                    result.dismiss === Swal.DismissReason.cancel
                                ) {
                                    swalWithBootstrapButtons.fire(
                                        'Ingresar tipo de cliente',
                                        'La Solicitud se ha cancelado.',
                                        'error'
                                    )
                                }
                            })
                        }else{
                            cargarClientes();
                            this.submit();
                        }


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
                    parseInt(obj.cantidad),
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
                url : '{{ route('almacenes.producto.getCodigo') }}',
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

        @if(old('familia'))
            obtenerSubFamilias()
        @endif

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

                    $('#sub_familia').prop('disabled', false)
                    $('#sub_familia').prop('required', true)
                    console.log(data)
                    // Mostramos la información
                    if (data != null) {
                        var select = '<option value="" selected disabled >SELECCIONAR</option>'
                        for (var i = 0; i < data.length; i++)
                                select += '<option value="' + data[i].id + '">' + data[i].text+ '</option>';
                            
                        $("#sub_familia").html(select);

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
                cantidad: parseInt($("#cantidad").val()),
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
                cantidad: parseInt($("#cantidad_editar").val()),
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
            if (detalle.peso === undefined || detalle.peso === null || Number.isNaN(detalle.peso)) {
                toastr.error('El campo Peso es obligatorio');
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


    </script>

    <script>

        $('#monto').keyup(function() {
            var val = $(this).val();
            if (isNaN(val)) {
                val = val.replace(/[^0-9\.]/g, '');
                if (val.split('.').length > 2)
                    val = val.replace(/\.+$/, "");
            }
            $(this).val(val);
        });

        $('#monto_editar').keyup(function() {
            var val = $(this).val();
            if (isNaN(val)) {
                val = val.replace(/[^0-9\.]/g, '');
                if (val.split('.').length > 2)
                    val = val.replace(/\.+$/, "");
            }
            $(this).val(val);
        });
        
        
        $(document).ready(function() {

            // DataTables
            $('.dataTables-clientes').DataTable({
                "dom": 'lTfgitp',
                "bPaginate": true,
                "bLengthChange": true,
                "bFilter": true,
                "bInfo": true,
                "bAutoWidth": false,
                "language": {
                    "url": "{{asset('Spanish.json')}}"
                },

                "columnDefs": [
                    {
                        "targets": [0],
                        className: "text-center",
                        render: function(data, type, row) {
                            return "<div class='btn-group'>" +
                                "<a class='btn btn-warning btn-sm modificarDetalle' id='editar_cliente' style='color:white;' title='Modificar'><i class='fa fa-edit'></i></a>" +
                                "<a class='btn btn-danger btn-sm' id='borrar_cliente' style='color:white;' title='Eliminar'><i class='fa fa-trash'></i></a>" +
                                "</div>";
                        }
                    },
                    {
                        "targets": [1],
                        className: "text-left",
                    },
                    {
                        "targets": [2],
                        className: "text-center",
                    },

                ],

            });

        })


        //Editar Registro
        $(document).on('click', '#editar_cliente', function(event) {
            var table = $('.dataTables-clientes').DataTable();
            var data = table.row($(this).parents('tr')).data();
            $('#indice').val(table.row($(this).parents('tr')).index());
            $('#cliente_id_editar').val(data[1]).trigger('change');
            $('#monto_editar').val(data[2]);
            $('#modal_editar_cliente').modal('show');
        })

        //Borrar registro de articulos
        $(document).on('click', '#borrar_cliente', function(event) {

            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger',
                },
                buttonsStyling: false
            })

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
                    var table = $('.dataTables-clientes').DataTable();
                    table.row($(this).parents('tr')).remove().draw();
                    // sumaTotal()

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

        //Validacion al ingresar tablas
        $(".enviar_cliente").click(function() {
            limpiarErrores()
            var enviar = false;
            if ($('#cliente').val() == '') {
                toastr.error('Seleccione Cliente.', 'Error');
                enviar = true;
                $('#cliente').addClass("is-invalid")
                $('#error-cliente').text('El campo Cliente es obligatorio.')
            } else {
                var existe = buscarClientes($('#cliente').val())
                if (existe == true) {
                    toastr.error('Tipo de Cliente ya se encuentra ingresado.', 'Error');
                    enviar = true;
                }
            }

            if ($('#monto').val() == '') {

                toastr.error('Ingrese el monto del tipo de cliente.', 'Error');
                enviar = true;

                $("#monto").addClass("is-invalid");
                $('#error-monto').text('El campo Monto es obligatorio.')
            }

            if (enviar != true) {
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger',
                    },
                    buttonsStyling: false
                })

                Swal.fire({
                    title: 'Opción Agregar',
                    text: "¿Seguro que desea agregar Tipo de Cliente?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: "#1ab394",
                    confirmButtonText: 'Si, Confirmar',
                    cancelButtonText: "No, Cancelar",
                }).then((result) => {
                    if (result.isConfirmed) {

                        var detalle = {
                            cliente: $('#cliente').val(),
                            monto: $('#monto').val(),
                        }
                        limpiarDetalle()
                        agregarTabla(detalle);
                        // sumaTotal()


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

        function buscarClientes(cliente) {
            var existe = false;
            var t = $('.dataTables-clientes').DataTable();
            t.rows().data().each(function(el, index) {
                if (el[1] == cliente) {
                    existe = true
                }
            });
            return existe
        }

        
        function agregarTabla(detalle) {
            var t = $('.dataTables-clientes').DataTable();
            t.row.add([
                '',
                detalle.cliente,
                detalle.monto,

            ]).draw(false);

            cargarClientes()

        }

        function cargarClientes() {

            var clientes = [];
            var table = $('.dataTables-clientes').DataTable();
            var data = table.rows().data();
            data.each(function(value, index) {
                let fila = {
                    cliente: value[1],
                    monto: value[2],
                };

                clientes.push(fila);

            });

            $('#clientes_tabla').val(JSON.stringify(clientes));
        }

        function limpiarDetalle() {
            $('#monto').val('')
            $('#cliente').val($('#articulo_id option:first-child').val()).trigger('change');

        }

        function limpiarErrores() {
            $('#monto').removeClass("is-invalid")
            $('#error-monto').text('')

            $('#cliente').removeClass("is-invalid")
            $('#error-cliente').text('')
        }

        //Consultar si existe tipos de clientes
        function cantidadTipo() {
            var existe = true
            var table = $('.dataTables-clientes').DataTable();
            var registros = table.rows().data().length;

            if (registros == 0) {
                existe = false
            }
            return existe
        }



    </script>
@endpush
