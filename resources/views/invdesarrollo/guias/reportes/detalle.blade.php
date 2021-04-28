<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Ecovalle | Sistema de Producción</title>
    <link rel="stylesheet" href="{{asset('css/informe.css')}}" />    
  </head>
  <body>
    <header class="clearfix">
        
    
    </header>

    <main>
      <div id="details" class="clearfix">




        <div id="invoice">
            
          <table cellspacing="0" cellpadding="0" id="tabla-guia">
            <thead>
                <tr>
                    <th colspan="2" class="text-center">GUIA INTERNA</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <th class="datos-guia-titulo">
                        N°:
                    </th>

                    <th class="datos-guia">
                        GR - {{$guia->id}}
                    </th>

                </tr>
                <tr>
                    <th class="datos-guia-titulo">
                        FECHA EMISION:
                    </th>

                    <th class="datos-guia">
                        {{ Carbon\Carbon::parse($guia->fecha)->format('d/m/y') }}
                    </th>

                </tr>
                
            </tbody>

          </table>
          
        </div>

       
      </div>



      <table border="0" cellspacing="0" cellpadding="0" id="tabla-productos">
        <thead>
          <tr>
            <th class="text-center">ARTICULO</th>
            <th class="text-center">CANTIDAD SOLICITADA</th>
            <th class="text-center">CANTIDAD ENTREGADA</th>
            <th class="text-center">CANTIDAD DEVUELTA</th>
            <th class="text-center">OBSERVACION</th>
          </tr>
        </thead>
        <tbody>

        @foreach($detalles as $detalle)
          <tr>
            <td class="unit">{{$detalle->articulo->descripcion}}</td>
            <td class="no">{{$detalle->cantidad_solicitada}}</td>
            <td class="no">{{$detalle->cantidad_entregada}}</td>
            <td class="no">{{$detalle->cantidad_devuelta}}</td>
            <td class="no">{{$detalle->observacion}}</td>
          </tr>
        @endforeach

        </tbody>
        
      </table>

    </main>
    <footer>
      SISCOM SAC
    </footer>
  </body>
</html>