@extends('layout') @section('content')

@section('seguridad-active', 'active')
@section('roles-active', 'active')

<div class="row wrapper border-bottom white-bg page-heading">

    <div class="col-lg-12">
       <h2  style="text-transform:uppercase"><b>REGISTRAR NUEVO ROL</b></h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{route('home')}}">Panel de Control</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{route('seguridad.roles.index')}}">Roles</a>
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

                    <form action="{{route('seguridad.roles.store')}}" method="POST" id="enviar_roles">
                        {{csrf_field()}}

                        <div class="row">
                            <div class="col-sm-6 b-r">
                                <h4 class=""><b>Roles</b></h4>
                                <div class="row">
                                    <div class="col-md-12">
                                        <p>Registrar datos de la Roles :</p>
                                    </div>
                                </div>
                            	
                                <div class="col-md-8">
                                    <label class="required">Name(*) :</label>
                                    <input type="text" id="name" name="name" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{old('name')}}" >
                                    @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <input type="hidden" id="permisos_tabla" name="permisos_tabla[]">
                        </div>

                        <hr>
                              <div class="row">

                            <div class="col-lg-12">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <h4 class=""><b>Permisos del Rol</b></h4>
                                    </div>
                                    <div class="panel-body">


                                        <div class="row">

                                            <div class="col-md-6">
                                                <label class="required">Permisos</label>
                                                <select class="select2_form form-control"
                                                    style="text-transform: uppercase; width:100%" name="permiso_id"
                                                    id="permiso_id">
                                                    <option></option>
                                                    @foreach ($permisos as $permiso)
                                                    <option value="{{$permiso->id}}">{{$permiso->name}}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback"><b><span id="error-permiso"></span></b>
                                                </div>
                                            </div>
                                            
                                        </div>

                                        <div class="row">
                                           
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="amount">&nbsp;</label>
                                                    <a class="btn btn-block btn-warning enviar_permiso"
                                                        style='color:white;'> <i class="fa fa-plus"></i> AGREGAR</a>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>

                                        <div class="table-responsive">
                                            <table
                                                class="table dataTables-rol-detalle table-striped table-bordered table-hover"
                                                 onkeyup="return mayus(this)">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">ACCIONES</th>
                                                        <th class="text-center">id</th>
                                                        <th class="text-center">PERMISO</th>
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
                        <div class="form-group row">
                            <div class="col-md-6 text-left" style="color:#fcbc6c">
                                <i class="fa fa-exclamation-circle"></i> <small>Los campos marcados con asterisco
                                    (<label class="required"></label>) son obligatorios.</small>
                            </div>
                            <div class="col-md-6 text-right">
                                <a href="{{route('seguridad.roles.index')}}" id="btn_cancelar"
                                    class="btn btn-w-m btn-default">
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
<link href="{{ asset('Inspinia/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}"
    rel="stylesheet">
<link href="{{ asset('Inspinia/css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
<link href="{{ asset('Inspinia/css/plugins/daterangepicker/daterangepicker-bs3.css') }}" rel="stylesheet">
<link href="{{ asset('Inspinia/css/plugins/select2/select2.min.css') }}" rel="stylesheet">


<!-- DataTable -->
<link href="{{asset('Inspinia/css/plugins/dataTables/datatables.min.css')}}" rel="stylesheet">

@endpush

@push('scripts')
<!-- Data picker -->
<script src="{{ asset('Inspinia/js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>
<!-- Date range use moment.js same as full calendar plugin -->
<script src="{{ asset('Inspinia/js/plugins/fullcalendar/moment.min.js') }}"></script>
<!-- Date range picker -->
<script src="{{ asset('Inspinia/js/plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- Select2 -->
<script src="{{ asset('Inspinia/js/plugins/select2/select2.full.min.js') }}"></script>

<!-- DataTable -->
<script src="{{asset('Inspinia/js/plugins/dataTables/datatables.min.js')}}"></script>
<script src="{{asset('Inspinia/js/plugins/dataTables/dataTables.bootstrap4.min.js')}}"></script>




<script>
//Select2
$(".select2_form").select2({
    placeholder: "SELECCIONAR",
    allowClear: true,
    width: '100%',
});


$('#enviar_roles').submit(function(e) {
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
                cargarPermisos();
                this.submit();
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

//Validacion al ingresar tablas
$(".enviar_permiso").click(function() {
    limpiarErrores()
    var enviar = false;
    if ($('#permiso_id').val() == '') {
        toastr.error('Seleccione artículo.', 'Error');
        enviar = true;
        $('#permiso_id').addClass("is-invalid")
        $('#error-permiso').text('El campo Permiso es obligatorio.')
    } else {
        var existe = buscarPermiso($('#permiso_id').val())
        if (existe == true) {
            toastr.error('Permiso ya se encuentra ingresado.', 'Error');
            enviar = true;
        }
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
            text: "¿Seguro que desea agregar Artículo?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: "#1ab394",
            confirmButtonText: 'Si, Confirmar',
            cancelButtonText: "No, Cancelar",
        }).then((result) => {
            if (result.isConfirmed) {
                var Permiso = obtenerPermiso($('#permiso_id').val())
                var detalle = {
                    permiso_id: $('#permiso_id').val(),
                    name : Permiso,
                }
                console.log(Permiso,detalle)
                limpiarDetalle()
                agregarTabla(detalle);
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

//Borrar registro de permisos
$(document).on('click', '#borrar_permiso', function(event) {

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
            var table = $('.dataTables-rol-detalle').DataTable();
            table.row($(this).parents('tr')).remove().draw();

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

function limpiarErrores() {
    $('#permiso_id').removeClass("is-invalid")

}
function limpiarDetalle() {
    $('#permiso_id').val('')
    $('#permiso_id').val($('#permiso_id option:first-child').val()).trigger('change');
}

// Agregar a table de pantalla
function agregarTabla($detalle) {
    var t = $('.dataTables-rol-detalle').DataTable();
    t.row.add([
        "<a class='btn btn-danger btn-sm' id='borrar_permiso' style='color:white;' title='Eliminar'><i class='fa fa-trash'></i></a>",
        $detalle.permiso_id,
        $detalle.name,
    ]).draw(false);
    cargarPermisos()
}
function cargarPermisos() {
    var permisos = [];
    var table = $('.dataTables-rol-detalle').DataTable();
    var data = table.rows().data();
    console.log(data)
    data.each(function(value, index) {
        let fila = {
            permiso_id: value[1],
            name: value[2],
        };
        permisos.push(fila);
     });
    $('#permisos_tabla').val(JSON.stringify(permisos));
}
function buscarPermiso(id) {
    var existe = false;
    var t = $('.dataTables-rol-detalle').DataTable();
    t.rows().data().each(function(el, index) {
        if (el[1] == id) {
            existe = true
        }
    });
    return existe
}
function obtenerPermiso($id) {
    var permiso = ""
    @foreach($permisos as $permiso)
    if ("{{$permiso->id}}" == $id) {
        permiso = "{{$permiso->name}}"
    }
    @endforeach
    return permiso;
}

</script>
@endpush