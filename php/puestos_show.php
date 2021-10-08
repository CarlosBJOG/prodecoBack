<?php


	require_once "db.php";

	
    
    $oconns = new database();


    $datas= $oconns->getRows("select puestos.idkey as pidkey,departamentos.idkey,departamentos.nombre as dnombre,puestos.nombre,puestos.descripcion from puestos,departamentos where puestos.idkey_departamentos=departamentos.idkey");

    if ($oconns->numberRows==0)
    {
?>
		<table border="0" class="table table-striped table-bordered" style="font-size:12px;">
			<tr>
				<th>Informacion</th>
			</tr>
			<tr>
				<td>No se ha encontrado informacion</td>
			</tr>
		</table>
<?php
    }
    else
    {

?>

		<table border="0" class="table table-striped table-bordered" style="font-size:12px;">
			<tr>
				<th width="25%">Departamento</th>
				<th width="10%">#</th>
				<th width="25%">Nombre</th>
			<th>Descripci&oacute;n</th>
		</tr>





<?php


    	foreach ($datas as $items) 
    	{
   ?>		
		<tr>
			<td><?php echo $items["dnombre"]; ?></td>
			<td>
				<div class="btn-group">
					<button type="button" class="btn btn-primary btn-sm rounded " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-bars"></i></button>
					<div class="dropdown-menu">
						<a href="#" onclick="modificacion('<?php echo $items["pidkey"]; ?>');" class="dropdown-item"><i class="fas fa-edit"></i>&nbsp;Modificar</a>
					</div>
				</div>                                                            
			</td>

			<td><?php echo $items["nombre"]; ?></td>
			<td><?php echo $items["descripcion"]; ?></td>
		</tr>

   <?php
    	}
    }
	?>
	</table>