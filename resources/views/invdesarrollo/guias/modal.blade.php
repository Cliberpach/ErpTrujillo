<div class="modal inmodal" id="modal_editar_guia" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" onclick="limpiar()" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <i class="fa fa-cogs modal-icon"></i>
                <h4 class="modal-title">Artículo</h4>
                <small class="font-bold">Modificar Artículo.</small>
            </div>
            <div class="modal-body">
                <form role="form" id="">
                    <input type="hidden" id="editar_id_articulo">
                    <input type="hidden" id="indice">
                    <div class="form-group">
                        <label class="required">Artículo</label>
                        <select class="select2_form form-control" style="text-transform: uppercase; width:100%"
                            name="articulo_editar_id" id="articulo_id_editar" disabled>
                            <option></option>
                            @foreach ($articulos as $articulo)
                            <option value="{{$articulo->id}}">{{$articulo->descripcion}}
                            </option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback"><b><span id="error-articulo_id_editar"></span></b></div>

                    </div>

                    
                    <div class="form-group">
                        <label class="required">Cantidad Solicitada</label>
                        <input type="text" id="cantidad_solicitada_editar" class="form-control">
                        <div class="invalid-feedback"><b><span id="error-cantidad_solicitada_editar"></span></b></div>
                    </div>

                    <div class="form-group">
                        <label class="required">Cantidad Entregada</label>
                        <input type="text" id="cantidad_entregada_editar" class="form-control">
                        <div class="invalid-feedback"><b><span id="error-cantidad_entregada_editar"></span></b></div>
                    </div>

                    <div class="form-group">
                        <label class="required">Cantidad Devuelta</label>
                        <input type="text" id="cantidad_devuelta_editar" class="form-control">
                        <div class="invalid-feedback"><b><span id="error-cantidad_devuelta_editar"></span></b></div>
                    </div>

                     <div class="form-group">
                        <label class="required">Observación</label>
                        <input type="text" id="observacion2_editar" class="form-control">
                        <div class="invalid-feedback"><b><span id="error-observacion2_editar"></span></b></div>
                    </div>

            </div>


            <div class="modal-footer">
                <div class="col-md-6 text-left" style="color:#fcbc6c">
                    <i class="fa fa-exclamation-circle"></i> <small>Los campos marcados con asterisco (<label
                            class="required"></label>) son obligatorios.</small>
                </div>
                <div class="col-md-6 text-right">
                    <a class="btn btn-primary btn-sm editarRegistro" style="color:white"><i class="fa fa-save"></i>
                        Guardar</a>
                    <button type="button" onclick="limpiar()" class="btn btn-danger btn-sm" data-dismiss="modal"><i
                            class="fa fa-times"></i>
                        Cancelar</button>
                </div>
            </div>

            </form>
        </div>
    </div>
</div>


@push('scripts')
<script>
//Validacion al ingresar tablas
$(".editarRegistro").click(function() {
    // limpiarErrores()
    var enviar = false;

    if ($('#cantidad_editar').val() == '') {
        toastr.error('Ingrese cantidad del artículo.', 'Error');
        enviar = true;

        $("#cantidad_editar").addClass("is-invalid");
        $('#error-cantidad_editar').text('El campo Cantidad es obligatorio.')
    }

    if (enviar != true) {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger',
                container: 'my-swal',
            },
            buttonsStyling: false
        })

        Swal.fire({
            customClass: {
                container: 'my-swal'
            },
            title: 'Opción Agregar',
            text: "¿Seguro que desea agregar Artículo?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: "#1ab394",
            confirmButtonText: 'Si, Confirmar',
            cancelButtonText: "No, Cancelar",
        }).then((result) => {
            if (result.isConfirmed) {
                actualizarTabla($('#indice').val())
                limpiar()

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

function actualizarTabla(i) {
    var table = $('.dataTables-guia-detalle').DataTable();
    table.row(i).remove().draw();
    var descripcion_articulo = obtenerArticulo($('#articulo_id_editar').val())
    var presentacion_articulo = obtenerPresentacion($('#presentacion_editar').val())
    var detalle = {
        articulo_id: $('#articulo_id_editar').val(),
        descripcion: descripcion_articulo,
        cantidad_solicitada: $('#cantidad_solicitada_editar').val(),
        cantidad_entregada: $('#cantidad_entregada_editar').val(),
        cantidad_devuelta: $('#cantidad_devuelta_editar').val(),
        observacion: $('#observacion2_editar').val(),
    }
    agregarTabla(detalle);

}


function limpiar() {
    $('#cantidad_solicitada_editar').removeClass("is-invalid")
    $('#error-cantidad_solicitada_editar').text('')

    $("#cantidad_entregada_editar").removeClass("is-invalid");
    $('#error-cantidad_entregada_editar').text('')

    $("#cantidad_devuelta_editar").removeClass("is-invalid");
    $('#error-cantidad_devuelta_editar').text('')

    $("#observacion2_editar").removeClass("is-invalid");
    $('#error-observacion2_editar').text('')

    $('#modal_editar_guia').modal('hide');
}

$('#modal_editar_guia').on('hidden.bs.modal', function(e) {
    limpiar()
});
</script>
@endpush