<div class="modal inmodal" id="modal_sub_familia" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <i class="fa fa-cogs modal-icon"></i>
                <h4 class="modal-title">Sub Categoria</h4>
                <small class="font-bold">Crear nueva sub categoria.</small>
            </div>
            <div class="modal-body">
                <form role="form" action="{{route('almacenes.subfamilia.store')}}" method="POST" id="crear_subfamilia">
                    {{ csrf_field() }} {{method_field('POST')}}



                    <div class="form-group">
                        
                        <label class="required">Descripción:</label>
                        <input type="text" class="form-control {{ $errors->has('descripcion') ? ' is-invalid' : '' }}" id="descripcion" name="descripcion" value="{{old('descripcion')}}" onkeyup="return mayus(this)" required>
                        
                        @if ($errors->has('descripcion'))
                        <span class="invalid-feedback" role="alert">
                            <strong id="error-saldo_inicial-guardar">{{ $errors->first('descripcion') }}</strong>
                        </span>
                        @endif
                    
                    </div>

                    <div class="form-group">
                        <label class="required">Categoria:</label> 
                        <select class="form-control {{ $errors->has('familia_id') ? ' is-invalid' : '' }}" style="text-transform: uppercase; width:100%" value="{{old('familia_id')}}" name="familia_id" id="familia_id" required>
                            <option></option>
                        </select>

                        @if ($errors->has('familia_id'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('familia_id') }}</strong>
                            </span>
                        @endif
                    </div>

                    
            </div>
                
                    <div class="modal-footer">
                        <div class="col-md-6 text-left" style="color:#fcbc6c">
                            <i class="fa fa-exclamation-circle"></i> <small>Los campos marcados con asterisco (<label class="required"></label>) son obligatorios.</small>
                        </div>
                        <div class="col-md-6 text-right">
                            <a class="btn btn-primary btn-sm" style="color:white;" onclick="crearFormulario()"><i class="fa fa-save"></i> Guardar</a>
                            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>
                        </div>
                    </div>
                
                </form>
        </div>
    </div>
</div>

@push('styles')
<link href="{{asset('Inspinia/css/plugins/select2/select2.min.css')}}" rel="stylesheet">
@endpush 
@push('scripts')
<!-- Select2 -->
<script src="{{asset('Inspinia/js/plugins/select2/select2.full.min.js')}}"></script>

<script>

    //Select2
    $(".select2_form").select2({
        placeholder: "SELECCIONAR",
        allowClear: true,
        height: '200px',
        width: '100%',
    });

    $('#familia_id').select2({
        placeholder: "SELECCIONAR",
        allowClear: true,
        height: '200px',
        width: '100%',
	    ajax: {
			url: "{{route('subfamilia.familia')}}",
            dataType: 'json',
            type: 'GET',
            
            processResults: function (data) {
  
                return {
					results: $.map(data, function (item) {
						return {
                            id: item.id,
                            text: item.familia
                            }
						})
					}
				}
				
            },
	});

    
    function crearFormulario() {
        const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger',
                    },
                    buttonsStyling: false
                })
        Swal.fire({
                customClass: {
                    container: 'my-swal'
                },
                title: 'Opción Guardar',
                text: "¿Seguro que desea guardar cambios?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: "#1ab394",
                confirmButtonText: 'Si, Confirmar',
                cancelButtonText: "No, Cancelar",
                }).then((result) => {
                if (result.isConfirmed) {
                        // this.submit();

                        $.ajax({
                            dataType : 'json',
                            type : 'post',
                            url : '{{ route('almacenes.subfamilia.exist') }}',
                            data : {
                                '_token' : $('input[name=_token]').val(),
                                'familia' : $('#descripcion').val(),
                                'familia_2' : $('#familia_id').val(),
                                'id':  null
                            }
                        }).done(function (result){
                            console.log(result)
                            if (result.existe == true) {
                                toastr.error('La Sub categoria ya se encuentra registrada','Error');
                                $(this).focus();
                                
                            }else{
                                // this.submit();
                                var url = $('#crear_subfamilia').attr('id');
                                var enviar = '#'+url;
                                $(enviar).submit();
                            }
                        });


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



</script>

@endpush