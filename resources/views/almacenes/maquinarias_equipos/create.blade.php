<div class="modal inmodal" id="modal_crear_maquinaria_equipo" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <i class="fa fa-cogs modal-icon"></i>
                <h4 class="modal-title">Maquinarias & Equipos</h4>
                <small class="font-bold">Crear nuevo reg de Maquinaria - Equipo.</small>
            </div>
            <div class="modal-body">
                <form role="form" action="{{route('almacenes.maquinaria_equipo.store')}}" method="POST" id="crear_maquinaria_equipo" enctype="multipart/form-data">  
                    {{ csrf_field() }} {{method_field('POST')}}

                    <div class="form-group">
                        <label class="required">Tipo :</label>
                        <select id="tipo" name="tipo" class="select2_form form-control {{ $errors->has('tipo') ? ' is-invalid' : '' }}">
                            <option></option>
                            @foreach(tipos_maq_eq() as $tipo_maq_eq)
                                <option value="{{ $tipo_maq_eq->simbolo }}" {{ (old('tipo') == $tipo_maq_eq->simbolo ? "selected" : "") }}>{{ $tipo_maq_eq->descripcion }}</option>
                            @endforeach
                        </select>
                    </div>
                   <div class="form-group">
                        <label class="required">Nombre :</label> 
                        <input type="text" class="form-control {{ $errors->has('nombre') ? ' is-invalid' : '' }}" name="nombre" id="nombre" value="{{old('nombre')}}" onkeyup="return mayus(this)"> 

                        @if ($errors->has('nombre'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('nombre') }}</strong>
                        </span>
                        @endif
                    </div>

                   <div class="form-group">
                        <label>Serie:</label> 
                        <input type="text" class="form-control {{ $errors->has('serie') ? ' is-invalid' : '' }}" name="serie" id="serie" value="{{old('serie')}}" onkeyup="return mayus(this)"> 

                        @if ($errors->has('serie'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('serie') }}</strong>
                        </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label>Tipocorriente :</label>
                        <select id="tipocorriente" name="tipocorriente" class="select2_form form-control {{ $errors->has('tipocorriente') ? ' is-invalid' : '' }}">
                            <option></option>
                            <option value="MONOFASICO" {{ (old('tipocorriente') == "MONOFASICO" ? "selected" : "") }}>MONOFASICO</option>
                            <option value="TRIFASICO" {{ (old('tipocorriente') == "TRIFASICO" ? "selected" : "") }}>TRIFASICO</option>
                        </select>
                    </div>

                   <div class="form-group">
                        <label>Caracteristicas:</label> 
                        <input type="text" class="form-control {{ $errors->has('caracteristicas') ? ' is-invalid' : '' }}" name="caracteristicas" id="caracteristicas" value="{{old('caracteristicas')}}" onkeyup="return mayus(this)"> 

                        @if ($errors->has('caracteristicas'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('caracteristicas') }}</strong>
                        </span>
                        @endif
                    </div>

                   <div class="form-group">
                        <label>Nombre Imagen:</label> 
                        <input type="file" class="form-control {{ $errors->has('nombre_imagen') ? ' is-invalid' : '' }}" name="nombre_imagen" id="nombre_imagen" value="{{old('nombre_imagen')}}" onkeyup="return mayus(this)"> 

                        @if ($errors->has('nombre_imagen'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('nombre_imagen') }}</strong>
                        </span>
                        @endif
                    </div>

                   <div class="form-group">
                        <label>Vidautil:</label> 
                        <input type="text" class="form-control {{ $errors->has('vidautil') ? ' is-invalid' : '' }}" name="vidautil" id="vidautil" value="{{old('vidautil')}}" onkeyup="return mayus(this)"> 

                        @if ($errors->has('vidautil'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('vidautil') }}</strong>
                        </span>
                        @endif
                    </div>

            </div>    
                    <div class="modal-footer">
                        <div class="col-md-6 text-left" style="color:#fcbc6c">
                            <i class="fa fa-exclamation-circle"></i> <small>Los campos marcados con asterisco (<label class="required"></label>) son obligatorios.</small>
                        </div>
                        <div class="col-md-6 text-right">
                            <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-save"></i> Guardar</button>
                            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>
                        </div>
                    </div>
                
                </form>
        </div>
    </div>
</div>
@push('styles')
    <link href="{{ asset('Inspinia/css/plugins/select2/select2.min.css') }}" rel="stylesheet">
@endpush
@push('scripts')
<!-- Select2 -->
<script src="{{ asset('Inspinia/js/plugins/select2/select2.full.min.js') }}"></script>
<script>
        $(document).ready(function() {
            $(".select2_form").select2({
                placeholder: "SELECCIONAR",
                allowClear: true,
                height: '200px',
                width: '100%',
            });
        });
</script>
@endpush