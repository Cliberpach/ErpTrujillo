<div class="modal inmodal" id="modal_cantidad_produccion" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button"  onclick="limpiar()" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <i class="fa fa-cogs modal-icon"></i>
                <h4 class="modal-title">Cant. Producción</h4>
                <small class="font-bold">Ingresar datos importantes de la orden de producción</small>
            </div>
            <form action="" method="POST"  id="cantidad_produccion">
            
            <div class="modal-body">

                <input type="hidden" id="indice">
                <!-- <input type="hidden" id="cantidad_solicitada"> -->

                <div class="form-group row">

                    <div class="col-lg-6 col-xs-12 b-r">
               
                        <div class="form-group">
                            <label class="">Cantidad Solicitada</label>
                            <input type="number" placeholder='0.00' id="cantidad_solicitada"  name="cantidad_solicitada" class="form-control" readonly>
                        </div>
                  
                    </div>

                    <div class="col-lg-6 col-xs-12 b-r">
                        <div class="form-group">
                            <label class="">Cantidad Entregada</label>
                            <input type="number" placeholder='0.00' id="cantidad_entregada" step="0.001"  name="cantidad_entregada" class="form-control">
                        </div>
                    </div>
                    
                </div>
                <hr>
                <div class="form-group row">
                    <div class="col-lg-6 col-xs-12 b-r">
                        <div class="form-group">
                            <label class=""><i class='fa fa-check'></i> Cant. Correctas (Devueltas)</label>
                            <input type="number" id="cantidad_correcta" step="0.001" min="0"  placeholder='0.00' name="cantidad_correcta" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="">Almacen</label>
                            <select id="almacen_cantidad_correcta" name="almacen_cantidad_correcta" class="select2_form form-control">
                                <option></option>
                                @foreach($almacenes as $almacen)
                                    <option value="{{ $almacen->id }}">{{ $almacen->descripcion }}</option>
                                @endforeach
        
                            </select>
                        </div>
                        <div class="form-group">
                            <label >Observación</label>
                            <textarea type="text" id="observacion_correcta" onkeyup="return mayus(this)" name="observacion_correcta" class="form-control" ></textarea>
                        </div>
                    </div>

                    <div class="col-lg-6 col-xs-12">
                        <div class="form-group">
                            <label class=""><i class='fa fa-times'></i> Cant. Incorrectas (Devueltas)</label>
                            <input type="number" id="cantidad_incorrecta"  step="0.001" min="0"  placeholder='0.00' name="cantidad_incorrecta" class="form-control">
                        </div>

                        <div class="form-group">
                            <label class="">Almacen</label>
                            <select id="almacen_cantidad_incorrecta" name="almacen_cantidad_incorrecta" class="select2_form form-control">
                                <option></option>
                                @foreach($almacenes as $almacen)
                                    <option value="{{ $almacen->id }}">{{ $almacen->descripcion }}</option>
                                @endforeach
        
                            </select>
                        </div>

                        <div class="form-group">
                            <label >Observación</label>
                            <textarea type="text" id="observacion_incorrecta" onkeyup="return mayus(this)" name="observacion_incorrecta" class="form-control" ></textarea>
                        </div>

                    </div>
                </div>

            </div>

            <div class="modal-footer">
                <div class="col-md-6 text-left">
                    <i class="fa fa-exclamation-circle leyenda-required"></i> <small class="leyenda-required">Los campos marcados con asterisco (<label class="required"></label>) son obligatorios.</small>
                </div>
                <div class="col-md-6 text-right">
                    <button type ="button" id="btn_editar_detalle" class="btn btn-primary btn-sm"><i class="fa fa-save"></i> Guardar</button>
                    <button type="button"  onclick="limpiar()" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>
                </div>
            </div>

            </form>

        </div>
    </div>
</div>

@push('scripts')
<script>

$('#cantidad_entregada , #cantidad_correcta , #cantidad_incorrecta').keyup(function() {
    var val = $(this).val();
    if (isNaN(val)) {
        val = val.replace(/[^0-9\.]/g, '');
        if (val.split('.').length > 2)
            val = val.replace(/\.+$/, "");
    }
    $(this).val(val);
});

function evaluarCantidad() {
    var correcto = true
    var cantidad_entregada = $('#cantidad_entregada').val()
    if (cantidad_entregada == '') {
        toastr.error('Ingrese cantidad entregada.', 'Error');
        $("#cantidad_entregada" ).focus();
        $('#cantidad_incorrecta').val('')
        $('#cantidad_correcta').val('')
        correcto = false
    }else{
        var cantidad = Number(cantidad_entregada) - Number($('#cantidad_solicitada').val()) 
        if (cantidad < 0)  {
            toastr.error('Cantidada entregada es menor a la cantidad solicitada.', 'Error');
            $("#cantidad_entregada" ).focus();
            correcto = false
        }else{
            var suma_devuelvo = Number($('#cantidad_incorrecta').val()) + Number($('#cantidad_correcta').val())
            if (suma_devuelvo > cantidad_entregada)  {
                toastr.error('La suma de las cant. devultas es mayor con la cant. entregada.', 'Error');
                $("#cantidad_entregada" ).focus();
                correcto = false
            }else{
                correcto = true
            }
        }
    }

    return correcto
}

function evaluarIngreso() {

    var correcto = true
   
    if ($('#cantidad_correcta').val() != '' && $('#almacen_cantidad_correcta').val() == '' ) {
        toastr.error('Usted debe de ingresar el almacen y cantidad correcta (devuelta)', 'Error');
        correcto = false
    }

    if ($('#cantidad_correcta').val() == '' && $('#almacen_cantidad_correcta').val() != '' ) {
        toastr.error('Usted debe de ingresar el almacen y cantidad correcta (devuelta)', 'Error');
        correcto = false
    }

    if ($('#cantidad_incorrecta').val() != '' && $('#almacen_cantidad_incorrecta').val() == '' ) {
        toastr.error('Usted debe de ingresar el almacen y cantidad incorrecta (devuelta)', 'Error');
        correcto = false
    }

    if ($('#cantidad_incorrecta').val() == '' && $('#almacen_cantidad_incorrecta').val() != '' ) {
        toastr.error('Usted debe de ingresar el almacen y cantidad incorrecta (devuelta)', 'Error');
        correcto = false
    }
    
    return correcto
}


$('#btn_editar_detalle').click(function() {

    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger',
        },
        buttonsStyling: false
    })

    if (evaluarCantidad() == true && evaluarIngreso() == true) {
        
        Swal.fire({
            customClass: {
                container: 'my-swal'
            },
            title: 'Opción Agregar',
            text: "¿Seguro que desea agregar las cantidades?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: "#1ab394",
            confirmButtonText: 'Si, Confirmar',
            cancelButtonText: "No, Cancelar",
        }).then((result) => {
            if (result.isConfirmed) {
                obtenerDatos()
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

function obtenerDatos() {
    var tabla = $('.dataTables-ordenes').DataTable();
    var indice = $('#indice').val();
    var data = tabla.row(indice).data()
    var articulo_producto = {
        id : data.id,
        articulo : data.articulo,
        
        cantidad_devuelta_correcta_almacen : $('#almacen_cantidad_correcta').val(),
        cantidad_devuelta_correcta_cantidad : $('#cantidad_correcta').val(),
        cantidad_devuelta_correcta_completa : $('#cantidad_correcta').val() +' - '+ $("#almacen_cantidad_correcta option:selected").text(),
        observacion_correcta :  $('#observacion_correcta').val(),

        cantidad_devuelta_incorrecta_almacen : $('#almacen_cantidad_incorrecta').val(),
        cantidad_devuelta_incorrecta_cantidad :  $('#cantidad_incorrecta').val(),
        cantidad_devuelta_incorrecta_completa :  $('#cantidad_incorrecta').val() +' - '+ $("#almacen_cantidad_incorrecta option:selected").text(),
        observacion_incorrecta :  $('#observacion_incorrecta').val(),

        cantidad_entregada : $('#cantidad_entregada').val(),
        cantidad_solicitada : data.cantidad_solicitada,
        cantidad_solicitada_completa :  data.cantidad_solicitada_completa,
    }
    tabla.row(indice).remove().draw();
    tabla.row.add(articulo_producto).draw(false);
    $('#modal_cantidad_produccion ').modal('hide');
}


function limpiar() {
    $("#modal_cantidad_produccion select").val("").trigger("change");
    $("#modal_cantidad_produccion input[type=text] , #modal_cantidad_produccion input[type=number]").each(function() { this.value = '' });
    $('#observacion').val('');
    $('#modal_cantidad_produccion ').modal('hide');
}

$('#modal_cantidad_produccion').on('hidden.bs.modal', function(e) {
    limpiar()
});




</script>




@endpush