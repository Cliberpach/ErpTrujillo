<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Ecovalle | Sistema de Producción</title>
    <style>
    .clearfix:after {
        content: "";
        display: table;
        clear: both;
    }

    a {
        color: #5D6975;
        text-decoration: underline;
    }

    body {
        color: #001028;
        background: #FFFFFF;
        font-family: Arial, sans-serif;
        font-size: 12px;
        font-family: Arial;
    }

    header {
        padding: 10px 0;
        margin-bottom: 30px;
    }

    #logo {
        text-align: center;
        margin-bottom: 10px;
    }

    #logo img {
        width: 100px;
    }

    .title {
        border-top: 2px solid #5D6975;
        border-bottom: 2px solid #5D6975;
        font-weight: normal;
        text-align: center;
        margin: 0 0 20px 0;
        padding-top: 10px;
        background: url(dimension.png);
    }

    #empresa {
        float: left;
        text-transform: uppercase;
        font-size: 11px;
    }

    #proveedor {
        float: left;
        text-transform: uppercase;
        font-size: 11px;
    }

    #empresa span,
    #proveedor span {
        color: #5D6975;
        text-align: right;
        width: 70px;
        margin-right: 10px;
        display: inline-block;
        font-size: 0.9em;
    }

    #company {
        float: right;
        text-align: right;
    }

    #project div,
    #company div {
        white-space: nowrap;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        border-spacing: 0;
        margin-bottom: 20px;
    }

    table tr:nth-child(2n-1) td {
        background: #F5F5F5;
    }

    table th,
    table td {
        text-align: center;
    }

    table th {
        padding: 5px 20px;
        color: #5D6975;
        border-bottom: 1px solid #C1CED9;
        white-space: nowrap;
        font-weight: normal;
    }

    table .service,
    table .desc {
        text-align: center;
    }

    table td {
        padding: 20px;
        text-align: right;
    }

    table td.service,
    table td.desc {
        vertical-align: top;
    }

    table td.unit,
    table td.qty,
    table td.total {
        font-size: 1.0em;
    }

    table td.grand {
        border-top: 1px solid #5D6975;
        ;
    }

    #notices .notice {
        color: #5D6975;
        font-size: 1.2em;
    }

    footer {
        color: #5D6975;
        width: 100%;
        height: 30px;
        position: absolute;
        bottom: 0;
        border-top: 1px solid #C1CED9;
        padding: 8px 0;
        text-align: center;
    }

    @page {
        margin: 0px;
    }

    body {
        padding: 40px 30px 10px 30px;
    }

    .description-title {
        text-align: center;
        margin-bottom: 10px;
    }

    .column-left {
        float: left;
        width: 50%;
    }

    .column-right {
        float: right;
        width: 50%;
    }

    #empresa .empresa-adition {
        color: black;
        font-size: 12px;
    }
    </style>


</head>

<body>
    <header class="clearfix">
        <div class="title">
            <div id="logo">
                @if($orden->empresa->ruta_logo)
                <img src="{{ base_path() . '/storage/app/'.$orden->empresa->ruta_logo }}">
                @else
                <img src="{{asset('storage/empresas/logos/default.png')}}">
                @endif


            </div>

            <div class="description-title">
                <strong>{{$orden->empresa->razon_social}}</strong>
                <br>
                <span>RUC:{{$orden->empresa->ruc}}</span>
                <br>
            </div>

        </div>

        <div id="main">
            <div class="column-left">

                <div id="empresa">
                    <label class="empresa-adition" style="margin:10px;">DATOS SOBRE LA EMPRESA</label>
                    <div style="margin-top:5px;">
                        <div><span>RUC:</span> {{$orden->empresa->ruc}}</div>
                        <div><span>EMPRESA:</span> {{$orden->empresa->razon_social}}</div>
                        <div><span>COMERCIAL:</span> {{$orden->empresa->razon_social_abreviada}}</div>
                        <div><span>DIRECCION:</span> {{$orden->empresa->direccion_fiscal}}</div>
                        <div><span>TELEFONO:</span>
                            @if($orden->empresa->telefono)
                            {{$orden->empresa->telefono}}
                            @else
                            -
                            @endif
                        </div>
                        <div><span>CELULAR:</span>
                            @if($orden->empresa->celular)
                            {{$orden->empresa->celular}}
                            @else
                            -
                            @endif
                        </div>
                    </div>
                </div>

            </div>
            <div class="column-right">

                <div id="proveedor">
                    <label class="empresa-adition" style="margin:10px;">DATOS SOBRE EL PROVEEDOR</label>
                    <div style="margin-top:5px;">
                        @if($orden->proveedor->ruc)
                        <div><span>RUC:</span> {{$orden->proveedor->ruc}}</div>
                        @else
                        <div><span>DNI:</span> {{$orden->proveedor->dni}}</div>
                        @endif
                        <div><span>PROVEEDOR:</span>{{$orden->proveedor->descripcion}}</div>
                        <div><span>DIRECCION</span> {{$orden->proveedor->direccion}}</div>
                        <div><span>ZONA</span> {{$orden->proveedor->zona}}</div>
                        <div><span>CORREO</span> <a
                                href="mailto:{{$orden->proveedor->correo}}">{{$orden->proveedor->correo}}</a></div>
                        <div><span>TELEFONO:</span>
                            @if($orden->proveedor->telefono)
                            {{$orden->proveedor->telefono}}
                            @else
                            -
                            @endif
                        </div>
                        <div><span>CELULAR:</span>
                            @if($orden->proveedor->celular)
                            {{$orden->proveedor->celular}}
                            @else
                            -
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </header>
    <main>
        <table  onkeyup="return mayus(this)">
            <thead>
                <tr>
                    <th class="service">ARTICULO</th>
                    <th class="desc">PRESENTACION</th>
                    <th>PRECIO</th>
                    <th>CANT.</th>
                    <th>TOTAL</th>
                </tr>
            </thead>
            <tbody>
                @foreach($detalles as $detalle)
                <tr>
                    <td class="service">{{$detalle->articulo->descripcion}}</td>
                    <td class="desc">
                        @foreach($presentaciones as $presentacion)
                        @if($presentacion->descripcion == $detalle->articulo->presentacion)
                        {{$presentacion->simbolo}}
                        @endif
                        @endforeach

                    </td>
                    <td class="unit" style="text-align:center;">{{$detalle->precio}}</td>
                    <td class="qty" style="text-align:center;">{{$detalle->cantidad}}</td>
                    <td class="total subtotal" style="text-align:center;">{{$detalle->precio * $detalle->cantidad}}</td>
                </tr>
                @endforeach


                <tr>
                    <td colspan="4">SUBTOTAL</td>
                    <td class="total" style="text-align:center;">{{$moneda.'  '.$subtotal}}</td>
                </tr>
                <tr>
                    <td colspan="4">IGV {{$detalle->orden->igv}}%:</td>
                    <td class="total" style="text-align:center;">
                            {{$moneda.'  '.$igv}}
                    </td>
                </tr>
                <tr>
                    <td colspan="4" class="grand total">TOTAL</td>
   
                        <td class="grand total" style="text-align:center;">{{$moneda.'  '.$total}}</td>

                    
                </tr>
            </tbody>
        </table>
        <div id="notices">
            <div>Observación:</div>
            @if($orden->observacion)
            <div class="notice"  onkeyup="return mayus(this)">{{$orden->observacion}}.</div>
            @else
            <div class="notice">NO ESPECIFICADO</div>
            @endif
        </div>
    </main>
    <footer>

    </footer>



</body>

</html>