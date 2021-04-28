<div class="modal inmodal" id="modal_editar_linea_produccion" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" onclick="limpiar()" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <i class="fa fa-cogs modal-icon"></i>
                <h4 class="modal-title">Maquinaria-Equipo</h4>
                <small class="font-bold">Modificar Maquinaria-Equipo.</small>
            </div>
            <div class="modal-body">
                <form role="form" id="">
                    <input type="hidden" id="editar_id_articulo">
                    <input type="hidden" id="indice">
                    <div class="form-group">
                        <label class="required">Maquinaria-Equipo</label>
                        <select class="select2_form form-control" style="text-transform: uppercase; width:100%"
                            name="articulo_editar_id" id="articulo_id_editar" disabled>
                            <option></option>
                            @foreach ($maquinarias_equipos $maquinaria_equipo)
                                <option value="{{$maquinaria_equipo->id}}">{{$maquinaria_equipo->nombre}}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback"><b><span id="error-articulo_id_editar"></span></b></div>

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
    var table = $('.dataTables-linea_produccion-detalle').DataTable();
    table.row(i).remove().draw();
    var nombre_maquinaria_equipo = obtenerMaquinariaEquipo($('#maquinaria_equipo_editar').val())
    var detalle = {
        maquinaria_equipo_id: $('#maquinaria_equipo_id_editar').val(),
        nombre: nombre_maquinaria_equipo,
     }
    agregarTabla(detalle);
}


function limpiar() {
    $('#maquinaria_equipo_id_editar').removeClass("is-invalid")
    $('#error-maquinaria_equipo_id_editar').text('')

    $('#modal_editar_linea_produccion').modal('hide');
}

$('#modal_editar_linea_produccion').on('hidden.bs.modal', function(e) {
    limpiar()
});
</script>
@endpush