@extends('layout') @section('content')

@section('compras-active', 'active')
@section('articulo-active', 'active')
<div class="row wrapper border-bottom white-bg page-heading">
    
    <div class="col-lg-12">
       <h2  style="text-transform:uppercase"><b>REGISTRAR NUEVO ARTÍCULO</b></h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{route('home')}}">Panel de Control</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{route('compras.articulo.index')}}">Artículos</a>
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

                     <form action="{{route('compras.articulo.store')}}" method="POST" id="enviar_articulo">
                        {{csrf_field()}}
              
                        <div class="row">
                            <div class="col-sm-6 b-r"><h4 class=""><b>Artículo</b></h4>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <p>Registrar datos del nuevo artículo:</p>
                                        </div>
                                    </div>                                        


                                    <div class="form-group row">
                                        <div class="col-md-6">

                                            <label class="required">Código de Fábrica: </label>                                                     
                                            <input type="text" id="codigo_fabrica" class="form-control {{ $errors->has('codigo_fabrica') ? ' is-invalid' : '' }}" name="codigo_fabrica" value="{{ old('codigo_fabrica')}}"   onkeyup="return mayus(this)" required>

                                            @if ($errors->has('codigo_fabrica'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('codigo_fabrica') }}</strong>
                                                </span>
                                            @endif
                                        
                                        
                                        </div> 

                                        <div class="col-md-6">
                                            <label class="">Código de Barra: </label>                                                     
                                            <input type="text" id="codigo_barra" class="form-control {{ $errors->has('codigo_barra') ? ' is-invalid' : '' }}" name="codigo_barra" value="{{ old('codigo_barra')}}"   onkeyup="return mayus(this)">

                                            @if ($errors->has('codigo_barra'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('codigo_barra') }}</strong>
                                                </span>
                                            @endif 
                                        </div>   
                                        
                                    </div>

                                    <div class="form-group">

                                        <label class="required">Descripción: </label>                                                     
                                        <input type="text" id="descripcion" class="form-control {{ $errors->has('descripcion') ? ' is-invalid' : '' }}" name="descripcion" value="{{ old('descripcion')}}"   onkeyup="return mayus(this)" required>

                                        @if ($errors->has('descripcion'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('descripcion') }}</strong>
                                            </span>
                                        @endif 
                                           
                                        
                                    </div>



                                    <div class="form-group row" >
                                        <div class="col-md-6">
                                            <label class="required">Categoría: </label> 
                                        
                                            <select class="select2_form form-control {{ $errors->has('categoria') ? ' is-invalid' : '' }}" style="text-transform: uppercase; width:100%" value="{{old('categoria')}}" name="categoria" id="categoria" required>
                                                <option></option>
                                                @foreach ($categorias as $categoria)   
                                                    <option value="{{$categoria->id}}" @if(old('categoria') == $categoria->id ) {{'selected'}} @endif style="text-transform: uppercase;">{{$categoria->descripcion}}</option>
                                                @endforeach
                                            </select>

                                            @if ($errors->has('categoria'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('categoria') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <div class="col-md-6">
                                            <label class="required">Presentación: </label> 
                                        
                                            <select class="select2_form form-control {{ $errors->has('presentacion') ? ' is-invalid' : '' }}" style="text-transform: uppercase; width:100%" value="{{old('presentacion')}}" name="presentacion" id="presentacion" required>
                                                <option></option>
                                                @foreach ($presentaciones as $presentacion)   
                                                    <option value="{{$presentacion->descripcion}}" @if(old('presentacion') == $presentacion->descripcion ) {{'selected'}} @endif style="text-transform: uppercase;">{{$presentacion->descripcion}}</option>
                                                @endforeach
                                            </select>

                                            @if ($errors->has('presentacion'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('presentacion') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        
                                    </div>

                                    <div class="form-group row" >
                                        <div class="col-lg-6 col-xs-12">
                                            <label class="required">Unidad de Medida: </label> 
                                        
                                            <select class="select2_form form-control {{ $errors->has('unidad') ? ' is-invalid' : '' }}" style="text-transform: uppercase; width:100%" value="{{old('unidad')}}" name="unidad" id="unidad" required>
                                                <option></option>
                                                @foreach (unidad_medida() as $medida)   
                                                    <option value="{{$medida->id}}" @if(old('unidad') == $medida->id ) {{'selected'}} @endif style="text-transform: uppercase;">{{$medida->simbolo.' - '.$medida->descripcion}}</option>
                                                @endforeach
                                            </select>

                                            @if ($errors->has('unidad'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('unidad') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                      

                                        
                                    </div>


                                            
                                
                            </div>

                            <div class="col-sm-6">
                                    <div class="form-group">
                                        
                                        <label class="required">Almacén: </label> 
                                    
                                        <select class="select2_form form-control {{ $errors->has('almacen') ? ' is-invalid' : '' }}" style="text-transform: uppercase; width:100%" value="{{old('almacen')}}" name="almacen" id="almacen" required>
                                            <option></option>
                                            @foreach ($almacenes as $almacen)   
                                                <option value="{{$almacen->id}}" @if(old('almacen') == $almacen->id ) {{'selected'}} @endif style="text-transform: uppercase;">{{$almacen->descripcion}}</option>
                                            @endforeach
                                        </select>

                                        @if ($errors->has('almacen'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('almacen') }}</strong>
                                            </span>
                                        @endif
                                        
                                        
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <label class="">Stock:</label> 
                                            <input type="text" class="form-control {{ $errors->has('stock') ? ' is-invalid' : '' }}" name="stock" id="stock"  onkeyup="return mayus(this)" value="{{old('stock')}}" disabled>
                                            @if ($errors->has('stock'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('stock') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            <label class="required">Stock Min.:</label> 
                                            <input type="text" placeholder="" class="form-control {{ $errors->has('stock_min') ? ' is-invalid' : '' }}" name="stock_min" id="stock_min"  onkeyup="return mayus(this)" value="{{old('stock_min')}}" required>
                                            @if ($errors->has('stock_min'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('stock_min') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                    </div> 

                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <label class="required">Precio de Compra:</label> 
                                            <input type="text" placeholder="" class="form-control {{ $errors->has('precio_compra') ? ' is-invalid' : '' }}" name="precio_compra" id="precio_compra"  onkeyup="return mayus(this)" value="{{old('precio_compra')}}" required>
                                            @if ($errors->has('precio_compra'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('precio_compra') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                    </div> 


                            </div>



                        </div>


                      
                    
                    
                    <div class="hr-line-dashed"></div>
                    <div class="form-group row">
                        
                        <div class="col-md-6 text-left" style="color:#fcbc6c">
                            <i class="fa fa-exclamation-circle"></i> <small>Los campos marcados con asterisco (<label class="required"></label>) son obligatorios.</small>
                        </div>

                         <div class="col-md-6 text-right">
                            <a  href="{{route('compras.articulo.index')}}"  id="btn_cancelar" class="btn btn-w-m btn-default">
                                <i class="fa fa-arrow-left"></i> Regresar
                            </a>
                            <button type="submit" id="btn_grabar" class="btn btn-w-m btn-primary">
                                <i class="fa fa-save"></i> Grabar
                            </button>
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


<link href="{{asset('Inspinia/css/plugins/select2/select2.min.css')}}" rel="stylesheet">

<style>
    .logo {
        width: 200px;
        height: 200px;
        border-radius: 10%;
    }
    </style>
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

    //Input decimal
    $('#precio_compra').keyup(function(){
        var val = $(this).val();
        if(isNaN(val)){
            val = val.replace(/[^0-9\.]/g,'');
            if(val.split('.').length>2) 
                val =val.replace(/\.+$/,"");
        }
        $(this).val(val); 
    });
    // Solo campos enteros
    $('#stock').on('input', function () { 
        this.value = this.value.replace(/[^0-9]/g,'');
    });

    $('#stock_min').on('input', function () { 
        this.value = this.value.replace(/[^0-9]/g,'');
    });


    $('#enviar_articulo').submit(function(e){
        e.preventDefault();
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger',
            },
            buttonsStyling: false
        })

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
    })








</script>
@endpush