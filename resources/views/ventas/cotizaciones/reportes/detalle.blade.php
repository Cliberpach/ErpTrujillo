<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Ecovalle | Sistema de Producción</title>
    <link rel="stylesheet" href="{{asset('css/informe.css')}}" />   
    <link rel="icon" href="{{asset('img/ecologo.ico')}}" /> 
  </head>
  <body>
    <header class="clearfix">
    
        <div>
            <div id="logo">
                @if($cotizacion->empresa->ruta_logo)
                <img src="{{ base_path() . '/storage/app/'.$cotizacion->empresa->ruta_logo }}">
                @else
                <img src="{{asset('storage/empresas/logos/default.png')}}">
                @endif
            </div>
            
            <div id="company">
                <h2 class="name">{{$cotizacion->empresa->razon_social}}</h2>
                <div>RUC:{{$cotizacion->empresa->ruc}}</div>
                <div>{{$cotizacion->empresa->direccion_fiscal}}</div>
            </div>
      </div>
    
    </header>

    <main>
      <div id="details" class="clearfix">




        <div id="invoice">
            
          <table cellspacing="0" cellpadding="0" id="tabla-orden">
            <thead>
                <tr>
                    <th colspan="2" class="text-center">COTIZACION</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <th class="datos-orden-titulo">
                        N°:
                    </th>

                    <th class="datos-orden">
                        CO - {{$cotizacion->id}}
                    </th>

                </tr>
                <tr>
                    <th class="datos-orden-titulo">
                        FECHA DOCUMENTO:
                    </th>

                    <th class="datos-orden">
                        {{ Carbon\Carbon::parse($cotizacion->fecha_documento)->format('d/m/y') }}
                    </th>

                </tr>
                <tr>
                    <th class="datos-orden-titulo">
                        FECHA ATENCION:
                    </th>

                    <th class="datos-orden">
                        {{ Carbon\Carbon::parse($cotizacion->fecha_atencion)->format('d/m/y') }}
                    </th>

                </tr>
            </tbody>

          </table>
          
        </div>

        <div id="client">

            <div class="to">CONTACTO:</div>
            <h2 class="name">{{$nombre_completo}}</h2>
            <div class="address">{{$cotizacion->user->empleado->persona->telefono_movil}}</div>
            <div class="email"><a href="mailto:{{$cotizacion->user->empleado->persona->correo_electronico}}">{{$cotizacion->user->empleado->persona->correo_electronico}}</a></div>

        </div>



      </div>

      <table border="0" cellspacing="0" cellpadding="0" id="tabla-proveedor">
        <thead>
          <tr>
            <th colspan="2" class="text-center">DATOS DEL CLIENTE</th>
          </tr>
        </thead>
        <tbody>
            <tr>
                <th class="datos-proveedor-titulo">
                    TIPO DE DOCUMENTO:
                </th>

                <th class="datos-proveedor">
                    {{$cotizacion->cliente->tipo_documento}}
                </th>

            </tr>

           

            <tr>
                <th class="datos-proveedor-titulo">
                    DOCUMENTO:
                </th>

                <th class="datos-proveedor">
                    {{$cotizacion->cliente->documento}}
                </th>

            </tr>

       
            <tr>
                <th class="datos-proveedor-titulo">
                    NOMBRE:
                </th>

                <th class="datos-proveedor">
                    {{$cotizacion->cliente->nombre}}
                </th>

            </tr>
           

            <tr>
                <th class="datos-proveedor-titulo">
                    DIRECCION:
                </th>

                <th class="datos-proveedor">
                    {{$cotizacion->cliente->direccion}}
                </th>

            </tr>
            <tr>
                <th class="datos-proveedor-titulo">
                    CELULAR:
                </th>

                <th class="datos-proveedor">
                @if($cotizacion->cliente->telefono_movil)
                {{$cotizacion->cliente->telefono_movil}}
                @else
                -
                @endif
                </th>

            </tr>
            <tr>
                <th class="datos-proveedor-titulo">
                    TELEFONO:
                </th>

                <th class="datos-proveedor">
                    @if($cotizacion->cliente->telefono_fijo)
                    {{$cotizacion->cliente->telefono_fijo}}
                    @else
                    -
                    @endif
                </th>

            </tr>
            <tr>
                <th class="datos-proveedor-titulo">
                    CORREO:
                </th>

                <th class="datos-proveedor">
                    <a href="mailto:{{$cotizacion->cliente->correo_electronico}}">{{$cotizacion->cliente->correo_electronico}}
                    </a>
                </th>

            </tr>
        </tbody>

      </table>

      <table border="0" cellspacing="0" cellpadding="0" id="tabla-productos">
        <thead>
          <tr>
            <th class="no">CANT.</th>
            <th class="desc">UNIDAD DE MEDIDA</th>
            <th class="unit">DESCRIPCION DEL PRODUCTO</th>
            <th class="qty">PRECIO</th>
            <th class="total">TOTAL</th>
          </tr>
        </thead>
        <tbody>

        @foreach($detalles as $detalle)
        <tr>
            <td class="no">{{$detalle->cantidad}}</td>
            <td class="desc">
                    {{$detalle->producto->tabladetalle->simbolo.' - '.$detalle->producto->tabladetalle->descripcion}}
            </td>
            <td class="unit">{{$detalle->producto->codigo.' - '.$detalle->producto->nombre}}</td>
            <td class="qty">{{'S/. '.$detalle->precio}}</td>
            <td class="total">{{'S/. '.$detalle->importe}}</td>
        </tr>
  
        @endforeach

        </tbody>
        <tfoot>
            <tr>
                <td colspan="3"></td>
                <td class="sub" colspan="1">SUBTOTAL</td>
                <td class="sub-monto">{{'S. '.$cotizacion->sub_total}}</td>
            </tr>

            <tr>
                <td colspan="3"></td>
                <td class="sub" colspan="1">IGV 
                    @if($cotizacion->igv) 
                        {{$cotizacion->igv}} %
                    @else
                        18 %
                    @endif
                
                
                </td>
                <td class="sub-monto">{{'S/. '.$cotizacion->total_igv}}</td>
            </tr>
          <tr>
                <td colspan="3"></td>
                <td class="sub" colspan="1">TOTAL</td>
                <td class="sub-monto">{{'S/. '.$cotizacion->total}}</td>
          </tr>
        </tfoot>

        </tfoot>
      </table>


    </main>
    <footer>
      SISCOM SAC
    </footer>
  </body>
</html>