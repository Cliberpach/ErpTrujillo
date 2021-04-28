@extends('layout') @section('content')

@section('seguridad-active', 'active')
@section('usuarios-active', 'active')
<div class="row wrapper border-bottom white-bg page-heading">
    
    <div class="col-lg-12">
       <h2  style="text-transform:uppercase"><b>REGISTRAR NUEVO USUARIO</b></h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{route('home')}}">Panel de Control</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{route('seguridad.usuario.index')}}">Usuarios</a>
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

                     <form action="{{route('seguridad.usuario.store')}}" method="POST" id="enviar_usuario" enctype="multipart/form-data">
                        {{csrf_field()}}
              
                        <div class="row">
                            <div class="col-sm-6 b-r"><h4 class=""><b>Usuario</b></h4>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <p>Registrar datos del nuevo usuario:</p>
                                        </div>
                                    </div>                                        
                                    
                                    <div class="form-group" >
                                        
                                        <label class="required">Colaborador: </label> 
                                    
                                        <select class="form-control {{ $errors->has('empleado_id') ? ' is-invalid' : '' }}" style="text-transform: uppercase; width:100%" value="{{old('empleado_id')}}" name="empleado_id" id="empleado_id" required onchange="obtenerEmpleado(this)">
                                            <option></option>
                                        </select>

                                        @if ($errors->has('empleado_id'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('empleado_id') }}</strong>
                                            </span>
                                        @endif
                                     
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-4">

                                            <label class="required">Usuario: </label>                                                     
                                            <input type="text" id="usuario" class="form-control {{ $errors->has('usuario') ? ' is-invalid' : '' }}" name="usuario" value="{{ old('usuario')}}"  required onkeyup="return mayus(this)">

                                            @if ($errors->has('usuario'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('usuario') }}</strong>
                                                </span>
                                            @endif
                                        
                                        
                                        </div> 

                                        <div class="col-md-8">
                                            <label class="required">Correo electrónico: </label>                                                     
                                            <input type="email" id="correo" class="form-control {{ $errors->has('correo') ? ' is-invalid' : '' }}" name="correo" value="{{ old('correo')}}"  onkeyup="return mayus(this)" required>

                                            @if ($errors->has('correo'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('correo') }}</strong>
                                                </span>
                                            @endif 
                                        </div>   
                                        
                                    </div>
                                    <div class="form-group" >
                                        
                                        <label> Rol: </label> 
                                    
                                        <select class="select2_form form-control {{ $errors->has('rol_id') ? ' is-invalid' : '' }}" style="text-transform: uppercase; width:100%" value="{{old('rol_id')}}" name="rol_id" id="rol_id">
                                        <option></option>
                                            @foreach ($roles as $rol)
                                            <option value="{{$rol->id}}" @if(old('rol_id')==$rol->id )
                                                 @endif >{{$rol->name}}</option>
                                            @endforeach

                                        </select>

                                        @if ($errors->has('rol_id'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('rol_id') }}</strong>
                                            </span>
                                        @endif
                                     
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <label class="required">
                                                Contraseña:
                                            </label>
                                            <input type="password" id="password"
                                                    class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}"
                                                    name="password" value="{{ old('password')}}" onkeyup="return mayus(this)">
                                            @if ($errors->has('password'))
                                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            <label class="required">
                                                Confirmar contraseña:
                                            </label>
                                            <input type="password" id="password_confirmation"
                                                    class="form-control {{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}"
                                                    name="password_confirmation" onkeyup="return mayus(this)"
                                                    value="{{ old('password_confirmation')}}">
                                        </div>
                                    </div>


                            
                                            
                                
                            </div>

                            <div class="col-sm-6">



                                    
                                    <div class="form-group row">
                                            <div class="col-md-12">
                                                    <label>
                                                        Imagen: 
                                                    </label>
                                                    <div class="custom-file">
                                                        <input type="file" name="logo" id="logo"
                                                            class="custom-file-input {{ $errors->has('logo') ? ' is-invalid' : '' }}"
                                                            accept="image/*">

                                                        <label for="logo" id="logo_txt"
                                                            class="custom-file-label selected {{ $errors->has('ruta') ? ' is-invalid' : '' }}">Seleccionar</label>

                                                        @if ($errors->has('logo'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('logo') }}</strong>
                                                        </span>
                                                        @endif

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group row justify-content-center">
                                                <div class="col-6 align-content-center">
                                                    <div class="row justify-content-end">
                                                        <a href="javascript:void(0);" id="limpiar_logo">
                                                            <span class="badge badge-danger">x</span>
                                                        </a>
                                                    </div>
                                                    <div class="row justify-content-center">
                                                        <p>

                                                                <img class="logo"
                                                                     src="{{asset('storage/usuarios/default.jpg')}}"
                                                                     alt="">
                                                                <input id="url_imagen" name="url_imagen" type="hidden"
                                                                       value="">
                                                            
                                                        </p>
                                                    </div>
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
                            <a  href="{{route('seguridad.usuario.index')}}"  id="btn_cancelar" class="btn btn-w-m btn-default">
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
        border-radius: 50%;
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

    $('#empleado_id').select2({
        placeholder: "SELECCIONAR",
        allowClear: true,
        height: '200px',
        width: '100%',
	    ajax: {
			url: "{{route('seguridad.usuario.getEmployee')}}",
            dataType: 'json',
            type: 'GET',
            
            processResults: function (data) {
                console.log(data)
                return {
					results: $.map(data, function (item) {
						return {
                            id: item.id,
                            text: item.nombres+' '+item.apellido_paterno+' '+item.apellido_materno
                            }
						})
					}
				}
				
            },
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


    $('#enviar_usuario').submit(function(e){
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
<script>

    /* Limpiar imagen */
    $('#limpiar_logo').click(function() {
        $('.logo').attr("src", "{{asset('storage/usuarios/default.jpg')}}")
        var fileName = "Seleccionar"
        $('.custom-file-label').addClass("selected").html(fileName);
        $('#logo').val('')
    })

    $('.custom-file-input').on('change', function() {
        var fileInput = document.getElementById('logo');
        var filePath = fileInput.value;
        var allowedExtensions = /(.jpg|.jpeg|.png)$/i;
        $imagenPrevisualizacion = document.querySelector(".logo");

        if (allowedExtensions.exec(filePath)) {
            var userFile = document.getElementById('logo');
            userFile.src = URL.createObjectURL(event.target.files[0]);
            var data = userFile.src;
            $imagenPrevisualizacion.src = data
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
        } else {
            toastr.error('Extensión inválida, formatos admitidos (.jpg . jpeg . png)', 'Error');
            $('.logo').attr("src", "{{asset('storage/usuarios/default.jpg')}}")
        }
    });

    function obtenerEmpleado(id) {
        var url = '{{ route("seguridad.usuario.getEmployee.edit", ":id")}}';
        url = url.replace(':id', id);

        $.get(url, function(data, status){
            for (var i = 0; i < data.length; i++){
                if (data[i].id == $("#empleado_id").val() ) {
                    var usuario =  String(data[i].nombres).charAt(0) +''+ data[i].apellido_paterno;
                    $('#usuario').val(usuario)
                }
            }

        });
    }
</script>

@endpush