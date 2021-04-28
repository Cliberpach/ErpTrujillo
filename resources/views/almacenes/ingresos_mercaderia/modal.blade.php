<div class="modal inmodal" id="modal_editar_ingreso_mercaderia" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" onclick="limpiar()" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <i class="fa fa-cogs modal-icon"></i>
                <h4 class="modal-title">Detalle</h4>
                <small class="font-bold">Modificar Detalle.</small>
            </div>
            <div class="modal-body">
                <form role="form" id="">
                    <input type="hidden" id="editar_id_articulo">
                    <input type="hidden" id="indice">
                                        
                    <div class="form-group">
                        <label class="required">Peso Bruto</label>
                        <input type="text" id="peso_bruto_editar" class="form-control">
                        <div class="invalid-feedback"><b><span id="error-peso_bruto_editar"></span></b></div>
                    </div>

                    <div class="form-group">
                        <label class="required">Peso Neto</label>
                        <input type="text" id="peso_neto_editar" class="form-control">
                        <div class="invalid-feedback"><b><span id="error-peso_neto_editar"></span></b></div>
                    </div>

                     <div class="form-group">
                        <label class="required">Observación</label>
                        <textarea type="text" id="observacion_editar" class="form-control">
                        
                        </textarea>
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
    var table = $('.dataTables-ingreso_mercaderia-detalle').DataTable();
    table.row(i).remove().draw();
   
    var detalle = {
        peso_bruto: $('#peso_bruto_editar').val(),
        peso_neto: $('#peso_neto_editar').val(),
        observacion: $('#observacion_editar').val(),
    }
    agregarTabla(detalle);

}


function limpiar() {
    $('#peso_bruto_editar').removeClass("is-invalid")
    $('#error-peso_bruto_editar').text('')

    $("#peso_neto_editar").removeClass("is-invalid");
    $('#error-peso_netoa_editar').text('')

    $("#observacion_editar").removeClass("is-invalid");
    $('#error-observacion_editar').text('')

    $('#modal_editar_ingreso_mercaderia').modal('hide');
}

$('#modal_editar_ingreso_mercaderia').on('hidden.bs.modal', function(e) {
    limpiar()
});
</script>
@endpush