<?php

	
    
    //familiares_show.php



    if (strlen($_GET["data"])>0)
    {
    	    $datas=$_GET["data"];
		    $datas_all=$_GET["data"];
    		$datas = explode("/",$datas);

?>

	<table class="table">
		<tr>
			<th width="10%">#</th>
			<th width="80%">Nombre</th>
			<th>Parentesco</th>
		</tr>

<?php

   		for($i=0;$i<count($datas)-1;$i++)
		{

			$temp=explode("|",$datas[$i]);

	?>
		<tr>
			<td>
				<div class="btn-group">
					<button type="button" class="btn btn-primary btn-sm rounded " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-bars"></i></button>
					<div class="dropdown-menu">
						<a href="#" onclick="ViewFamiliar('<?php echo $i; ?>','<?php echo $datas[$i]; ?>');"id="ViewFamiliar<?php echo $i; ?>" class="dropdown-item"><i class="fas fa-search"></i>&nbsp;Ver</a>
					</div>
				</div>
			</td>
			<td><?php echo $temp[0]." ".$temp[1]." ".$temp[2]; ?></td>
			<td>
				<?php
					switch($temp[5])
					{
						case "1":{ echo "Padre Paterno"; break; }
						case "2":{ echo "Madre Paterna"; break; }
						case "3":{ echo "Padre Materno"; break; }
						case "4":{ echo "Madre Materna"; break; }
						case "5":{ echo "Hijo(a)"; break; }
						case "6":{ echo "Conyuge"; break; }
						case "7":{ echo "Hermano"; break; }
					}			
				?>
			</td>
		</tr>
	<?php
		}
    }
	?>
</table>
