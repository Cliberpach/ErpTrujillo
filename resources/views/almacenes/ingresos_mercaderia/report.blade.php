@extends ('layouts.admin')
@section ('contenido')
<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Reporte de Ingresos Mercaderia(s)</h3>
	</div>
</div>

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<script> document.title = "Reporte de Ingresos Mercaderia(s)"; </script>
			{!! Form::open(array('url'=>'ingresos_mercaderia_report','method'=>'GET','autocomplete'=>'off','role'=>'search')) !!}
			<div class="row">
				<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
					<div class="input-group">
						<label>Fecha Inicial : </label>
						<input type="Date" class="form-control" name="FechaIni" placeholder="Buscar..." value="{{$FechaIni}}">
					</div>
				</div>
				<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
					<div class="input-group">
						<label>Fecha Final : </label>
						<input type="Date" class="form-control" name="FechaFin" placeholder="Buscar..." value="{{$FechaFin}}">
					</div>
				</div>
				<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
					<div class="form-group">
						<button type="submit" class="btn btn-primary">Filtrar</button>
					</div>
				</div>
			</div>
			{{Form::close()}}
			<table id="exportar" class="table table-striped table-bordered table-condensed table-hover">
				<thead>
					
					<th>Id</th>
					<th>Factura</th>
					<th>Fecha Ingreso</th>
					<th>Articulos</th>
					<th>Lote</th>
					<th>Fecha Produccion</th>
					<th>Fecha Vencimiento</th>
					<th>Proveedores</th>
					<th>Peso Embalaje Dscto</th>
					<th>Usuario Id</th>
					<th>Estado</th>
					<th>Created At</th>
					<th>Updated At</th>
				</thead>
               @foreach ($ingresos_mercaderias as $ingresos_mercaderia)
				<tr>
					
					<td>{{$ingresos_mercaderia->id}}</td>
					<td>{{$ingresos_mercaderia->factura}}</td>
					<td>{{$ingresos_mercaderia->fecha_ingreso}}</td>
					<td>{{}}</td>
					<td>{{$ingresos_mercaderia->lote}}</td>
					<td>{{$ingresos_mercaderia->fecha_produccion}}</td>
					<td>{{$ingresos_mercaderia->fecha_vencimiento}}</td>
					<td>{{}}</td>
					<td>{{$ingresos_mercaderia->peso_embalaje_dscto}}</td>
					<td>{{$ingresos_mercaderia->usuario_id}}</td>
					<td>{{$ingresos_mercaderia->estado}}</td>
					<td>{{$ingresos_mercaderia->created_at}}</td>
					<td>{{$ingresos_mercaderia->updated_at}}</td>
				</tr>
				@endforeach
				<tfoot>
					 
                     <th></th>
                     <th></th>
                     <th></th>
                     <th></th>
                     <th></th>
                     <th></th>
                     <th></th>
                     <th></th>
                     <th></th>
                     <th></th>
                     <th></th>
                     <th></th>
                     <th></th>
                </tfoot>
			</table>
		</div>
		{{$ingresos_mercaderias->render()}}
	</div>
</div>
<script>
  calculaTotales();
  // Suma los totales
  function calculaTotales(){
    let total1=0;
    for (var i = 1; i<document.getElementById("exportar").rows.length; i++) {
      $dato1=document.getElementById("exportar").rows[i].cells[12].innerText;
      total1=total1+Number($dato1);
    }
     console.log(total1);
     //$('table#compra tfoot th:nth-child(' + 12 + ')').text(total1); 
     document.getElementById("total").innerText=total1.toFixed(2);
    return true;
  }
</script>	
@endsection