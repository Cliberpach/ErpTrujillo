@extends('layout') @section('content')
@section('compras-active', 'active')
@section('articulo-active', 'active')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-12">
       <h2  style="text-transform:uppercase"><b>Detalle del Artículo: {{$articulo->descripcion}}</b></h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">Panel de Control</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{route('compras.articulo.index')}}">Artículos</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Detalle</strong>
            </li>
        </ol>
    </div>
</div>
<div class="row">
            <div class="col-lg-9">
                <div class="wrapper wrapper-content animated fadeInUp">
                    <div class="ibox">
                        <div class="ibox-content">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="">
                                        <a href="{{route('compras.articulo.edit',$articulo->id)}}" class="btn btn-warning btn-xs float-right"><i class='fa fa-edit'></i>Editar Artículo</a>
                                       <h2  style="text-transform:uppercase">{{$articulo->descripcion}}</h2>
                                    </div>
                                    <p  onkeyup="return mayus(this)"><strong><i class="fa fa-caret-right"></i> Información general del Artículo:</strong></p>

                                </div>
                            </div>

                            <div class="row"  onkeyup="return mayus(this)">

                                <div class="col-md-6 b-r">

                                    <div class="row">
                                        <div class="col-md-6">
                                            <label><strong>Código de Fábrica: </strong></label>
                                            <p class="text-navy">{{$articulo->codigo_fabrica}}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <label><strong>Código de Barra: </strong></label> 
                                                @if($articulo->codigo_barra)
                                                    <p>{{$articulo->codigo_barra}}</p>
                                                @else
                                                    <p>-</p>
                                                @endif
                                        </div>
                                        
                                    </div>

                                    <div class="form-group">
                                        <label><strong>Descripción: </strong></label>
                                        <p >{{$articulo->descripcion}}</p>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <label><strong>Categoria: </strong></label>
                                            <p >{{$articulo->categoria->descripcion}}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <label><strong>Presentación: </strong></label> 
                                            <p>{{$articulo->presentacion}}</p>
                                        </div>
                                        
                                    </div>
                        
                                </div>

                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label><strong>Stock: </strong></label> 
                                            @if($articulo->stock)
                                                <p>{{$articulo->stock}}</p>
                                            @else
                                                <p>-</p>
                                            @endif
                                            
                                        </div>
                                        <div class="col-md-6">
                                            <label><strong>Stock Min.: </strong></label> 
                                            <p>{{$articulo->stock_min}}</p>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <label><strong>Precio de Compra: </strong></label>
                                            <p >{{$articulo->precio_compra}}</p>
                                        </div>
                                    </div>


                                </div>


       
                                
                            </div>


                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="wrapper wrapper-content project-manager"  onkeyup="return mayus(this)">
                    <h4>Registro</h4>
                    <p><b>Información del registro:<b></p>
                    <p class="text-center">
                        <i class="fa fa-tag big-icon"></i>
                        
                    </p>
                    <hr>
                    <div class="row">
                                <div class="col-lg-12">
                                    <dl class="row mb-0">
                                        <div class="col-sm-4 text-sm-left"><dt>CREADO:</dt> </div>
                                        <div class="col-sm-8 text-sm-right"><dd class="mb-1">  {{ Carbon\Carbon::parse($articulo->created_at)->format('d/m/y - G:i:s') }}</dd> </div>
                                    </dl>
                                    <dl class="row mb-0">
                                        <div class="col-sm-4 text-sm-left"><dt>ACTUALIZADO:</dt> </div>
                                        <div class="col-sm-8 text-sm-right"> <dd class="mb-1">  {{ Carbon\Carbon::parse($articulo->updated_at)->format('d/m/y - G:i:s') }}</dd></div>
                                    </dl>

                                </div>
                    </div>
                </div>
            </div>


        </div>
@stop
