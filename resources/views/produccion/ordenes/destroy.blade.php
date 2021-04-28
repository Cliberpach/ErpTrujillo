<div class="modal inmodal" id="modal_observacion_anular" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" onclick="limpiar()" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <i class="fa fa-cogs modal-icon"></i>
                <h4 class="modal-title">Orden de Producción</h4>
                <small class="font-bold">Ingresar la observación acerca de la anulación del registro.</small>
            </div>
            <div class="modal-body">
                <form role="form" action="{{route('produccion.orden.cancel')}}" method="POST" id="orden_observar">
                    {{csrf_field()}}
                    <input type="hidden" name="orden_id" id="orden_id">
                    <div class="form-group">
                        
                        <label class="required">Observación</label>
                        <textarea type="text" id="observacion" required  onkeyup="return mayus(this)" name="observacion" class="form-control" 
                        value="{{old('observacion')}}" ></textarea>
                        
                    </div>

            </div>


            <div class="modal-footer">
                <div class="col-md-6 text-left" style="color:#fcbc6c">
                    <i class="fa fa-exclamation-circle"></i> <small>Los campos marcados con asterisco (<label
                            class="required"></label>) son obligatorios.</small>
                </div>
                <div class="col-md-6 text-right">
                    <button type=submit class="btn btn-primary btn-sm"><i class="fa fa-save"></i>
                        Guardar</button>
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

//MODAL ELIMINAR

$('#orden_observar').submit(function(e) {
    e.preventDefault();

    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            container: 'my-swal',
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger',
        },
        buttonsStyling: false
    })

    Swal.fire({
        customClass: {
            container: 'my-swal'
        },
        title: 'Opción Anular',
        text: "¿Seguro que desea anular el registro?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: "#1ab394",
        confirmButtonText: 'Si, Confirmar',
        cancelButtonText: "No, Cancelar",
    }).then((result) => {
        if (result.isConfirmed) {
            //Ruta Eliminar
            this.submit()
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


})


function limpiar() {
    $('#orden_id').val('');
    $('#observacion').val('')
    $('#modal_observacion_anular').modal('hide');
}

$('#modal_observacion_anular').on('hidden.bs.modal', function(e) {
    limpiar()
});
</script>
@endpush