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
                    <th colspan="2" class="text-center">LINEA DE PRODUCCIÓN</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <th class="datos-guia-titulo">
                        N°:
                    </th>

                    <th class="datos-guia">
                        GR - {{$linea_produccion->id}}
                    </th>

                </tr>
                
                
            </tbody>

          </table>
          
        </div>

       
      </div>



      <table border="0" cellspacing="0" cellpadding="0" id="tabla-productos">
        <thead>
          <tr>

            <th class="text-center">MAQUINARIA EQUIPO</th>
          </tr>
        </thead>
        <tbody>

        @foreach($detalles as $detalle)
          <tr>
            <td>{{$detalle->maquinaria_equipo->nombre}}</td>


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