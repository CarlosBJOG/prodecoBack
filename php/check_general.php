<?php

	require_once "db.php";

   	header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");


	if ($_SERVER['REQUEST_METHOD'] === 'GET')
    {
        if (isset($_GET["module"]))
        {

			switch($_GET["module"])
			{
				case "cliente_check_birtday":
				{
					$final="";
					$nacimiento=explode("/",$_GET["nacimiento"]);
					$date1 = new DateTime($nacimiento[2]."-".$nacimiento[1]."-".$nacimiento[0]);
					$date2 = new DateTime(date("Y-m-d"));
					$diff = $date1->diff($date2);


					$final = ($diff->invert == 1) ? $diff->y*-1: $diff->y;

					if ($final<0)
						echo "-1";
					else
						if ($final<18)
							echo "0";
						else
							echo $final;



					break;
				}


				case "cliente_check_habita":
				{
					$final ="";
					$nacimiento=explode("/",$_GET["inicia_habitar"]);
					$date1 = new DateTime($nacimiento[2]."-".$nacimiento[1]."-".$nacimiento[0]);
					$date2 = new DateTime(date("Y-m-d"));
					$diff = $date1->diff($date2);

					$final = ($diff->invert == 1) ? $diff->days*-1: $diff->days;


					if ($final<0)
						echo "0";
					else
						echo $final;

					break;
				}

			}
        }
    }


?>