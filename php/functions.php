<?php

	    require_once('db.php');
	    
	    function create_porcentajes($param)
	    {

	        $oconns = new database();
	        $dats = $oconns->getRows("select * from porcentajes order by valor;");
	        
	        foreach ($dats as $items)
	        {
	            if ($param==$items["valor"])
	            {
	                echo "<option value='".$items["valor"]."' selected>".$items["nombre"]."</option>";
	            }
	            else
	                {
	                    echo "<option value='".$items["valor"]."'>".$items["nombre"]."</option>";
	                }
	        }
	    }

	    function create_tipo_desembolso()
	    {
	        $oconns = new database();
	        $dats = $oconns->getRows("select * from tipo_desembolso order by nombre asc;");
	        echo "<option value=''></option>";
	        foreach ($dats as $items)
	            echo "<option value='".$items["idkey"]."'>".$items["nombre"]."</option>";
	    }
	    
	    function create_socios_2($param)
	    {

	        $oconns = new database();
	        $dats = $oconns->getRows("select clientes.idkey,concat(generales.nombre,' ',generales.apellido_p,' ',generales.apellido_m) as nombre from clientes inner join generales on clientes.idkey_generales=generales.idkey order by nombre;");
	        
	        foreach ($dats as $items)
	        {
		    
		    foreach($param as $p){
			$x=$p["idkey_cliente"];
			if ($x==$items["idkey"])
			{
			    echo "<option value='".$items["idkey"]."' selected>".$items["nombre"]."</option>";
			}
			else
	                {
	                    echo "<option value='".$items["idkey"]."'>".$items["nombre"]."</option>";
	                }
		    }
	            
	        }
	    }
	    
	    function create_socios()
	    {

	        $oconns = new database();
	        $dats = $oconns->getRows("select clientes.idkey,concat(generales.nombre,' ',generales.apellido_p,' ',generales.apellido_m) as nombre from clientes inner join generales on clientes.idkey_generales=generales.idkey order by nombre;");
	        
	        foreach ($dats as $items)
	        {
	            if ($param==$items["idkey"])
	            {
	                echo "<option value='".$items["idkey"]."' selected>".$items["nombre"]."</option>";
	            }
	            else
	                {
	                    echo "<option value='".$items["idkey"]."'>".$items["nombre"]."</option>";
	                }
	        }
	    }
	    
	    function create_tipo_piso($param)
	    {

	        $oconns = new database();
	        $dats = $oconns->getRows("select * from piso;");
	        if ($param=="")
	        {
	            echo "<option value='' selected></option>";
	        }
	        foreach ($dats as $items)
	        {
	            if ($param==$items["idkey"])
	            {
	                echo "<option value='".$items["idkey"]."' selected>".$items["nombre"]."</option>";
	            }
	            else
	                {
	                    echo "<option value='".$items["idkey"]."'>".$items["nombre"]."</option>";
	                }
	        }
	    }
	    
	    function create_cargos_publicos($param)
	    {

	        $oconns = new database();
	        $dats = $oconns->getRows("select idkey, cargo from siti order by cargo asc;");
	        if ($param=="")
	        {
	            echo "<option value='' selected></option>";
	        }
	        foreach ($dats as $items)
	        {
	            if ($param==$items["idkey"])
	            {
	                echo "<option value='".$items["idkey"]."'>".$items["cargo"]."</option>";
	            }
	            else
	                {
	                    echo "<option value='".$items["idkey"]."'>".$items["cargo"]."</option>";
	                }
	        }
	    }
	    
	    function create_tipo_techo($param)
	    {

	        $oconns = new database();
	        $dats = $oconns->getRows("select * from techo;");
	        if ($param=="")
	        {
	            echo "<option value='' selected></option>";
	        }
	        foreach ($dats as $items)
	        {
	            if ($param==$items["idkey"])
	            {
	                echo "<option value='".$items["idkey"]."' selected>".$items["nombre"]."</option>";
	            }
	            else
	                {
	                    echo "<option value='".$items["idkey"]."'>".$items["nombre"]."</option>";
	                }
	        }
	    }
	    
	    function create_tipo_material($param)
	    {

	        $oconns = new database();
	        $dats = $oconns->getRows("select * from material;");
	        if ($param=="")
	        {
	            echo "<option value='' selected></option>";
	        }
	        foreach ($dats as $items)
	        {
	            if ($param==$items["idkey"])
	            {
		    
	                echo "<option value='".$items["idkey"]."' selected>".$items["nombre"]."</option>";
	            }
	            else
	                {
	                    echo "<option value='".$items["idkey"]."'>".$items["nombre"]."</option>";
	                }
	        }
	    }
	    
	    function create_tipo_hacinamiento($param)
	    {

	        $oconns = new database();
	        $dats = $oconns->getRows("select * from hacinamiento;");
	        if ($param=="")
	        {
	            echo "<option value='' selected></option>";
	        }
	        foreach ($dats as $items)
	        {
	            if ($param==$items["idkey"])
	            {
	                echo "<option value='".$items["idkey"]."' selected>".$items["nombre"]."</option>";
	            }
	            else
	                {
	                    echo "<option value='".$items["idkey"]."'>".$items["nombre"]."</option>";
	                }
	        }
	    }
	    
	    function create_tipo_vivienda($param)
	    {

	        $oconns = new database($param);
	        $dats = $oconns->getRows("select * from tipo_vivienda;");
	        if ($param=="")
	        {
	            echo "<option value='' selected></option>";
	        }
	        foreach ($dats as $items)
	        {
	            if ($param==$items["idkey"])
	            {
	                echo "<option value='".$items["idkey"]."' selected>".$items["nombre"]."</option>";
	            }
	            else
	                {
	                    echo "<option value='".$items["idkey"]."'>".$items["nombre"]."</option>";
	                }
	        }
	    }
	    
	    //Catalogo Actividades SITI
	    function create_actividades_siti($param)
	    {

	        $oconns = new database();
	        $dats = $oconns->getRows("select * from actividad_siti;");
	        if ($param=="")
	        {
	            echo "<option value='' selected></option>";
	        }
	        foreach ($dats as $items)
	        {
	            if ($param==$items["idkey"])
	            {
	                echo "<option value='".$items["idkey"]."'>".$items["actividad"]. "'/'".$items["sector"]."</option>";
	            }
	            else
	                {
	                    echo "<option value='".$items["idkey"]."'>".$items["actividad"]. "/".$items["sector"]."</option>";
	                }
	        }
	    }
	    // Cataogo tipo de ingreso
	    function create_tipo_ingreso($param)
	    {

	        $oconns = new database();
	        $dats = $oconns->getRows("select * from ingresos_tipos;");
	        if ($param=="")
	        {
	            echo "<option value='' selected></option>";
	        }
	        foreach ($dats as $items)
	        {
	            if ($param==$items["idkey"])
	            {
	                echo "<option value='".$items["idkey"]."' selected>".$items["nombre"]."</option>";
	            }
	            else
	                {
	                    echo "<option value='".$items["idkey"]."'>".$items["nombre"]."</option>";
	                }
	        }
	    }
	    
	    // Catálogo empleador
	    
	   function create_empleador($param)
	    {
	        $oconns = new database();
	        $dats = $oconns->getRows("select * from ingresos_empleador;");
	        if ($param=="")
	        {
	            echo "<option value='' selected></option>";
	        }
	        foreach ($dats as $items)
	        {
	            if ($param==$items["idkey"])
	            {
	                echo "<option value='".$items["idkey"]."' selected>".$items["nombre"]."</option>";
	            }
	            else
	                {
	                    echo "<option value='".$items["idkey"]."'>".$items["nombre"]."</option>";
	                }
	        }
	    }
	    
	    
	    function create_domicilio_empleador($param1,$param2)
		{

		    $oconns = new database();
		    if ($param1=="")
		    {
			echo "<option value='' selected></option>";
		    }
		    else
		    {
			$dats = $oconns->getRows("select * from ingresos_domicilio_empleador where idkey_empleador='".$param1."';");
			if ($param2=="")
			{
			    echo "<option value='' selected></option>";
			}

			foreach ($dats as $items)
			{            
			    if ($param2==$items["idkey"])
			    {
				echo "<option value='".$items["idkey"]."' selected>".$items["domicilio"]."</option>";
			    }
				else
				    {
					echo "<option value='".$items["idkey"]."'>".$items["domicilio"]."</option>";
				    }
			}

		    }
		}
		
	    //Catálogo egresos
	    function create_tipo_egreso($param)
	    {

	        $oconns = new database();
	        $dats = $oconns->getRows("select * from egresos_tipos;");
	        if ($param=="")
	        {
	            echo "<option value='' selected></option>";
	        }
	        foreach ($dats as $items)
	        {
	            if ($param==$items["idkey"])
	            {
	                echo "<option value='".$items["idkey"]."' selected>".$items["nombre"]."</option>";
	            }
	            else
	                {
	                    echo "<option value='".$items["idkey"]."'>".$items["nombre"]."</option>";
	                }
	        }
	    }
	    
	    /* tipos relaciones */
	    function create_tipos_relaciones($param)
	    {
	        $oconns = new database();
	        $dats = $oconns->getRows("select * from relaciones;");
	        if ($param=="")
	        {
	            echo "<option value='' selected></option>";
	        }
	        foreach ($dats as $items)
	        {
	            if ($param==$items["idkey"])
	            {
	                echo "<option value='".$items["idkey"]."' selected>".$items["nombre"]."</option>";
	            }
	            else
	                {
	                    echo "<option value='".$items["idkey"]."'>".$items["nombre"]."</option>";
	                }
	        }
	    }

	    function create_fondeo()
	    {
	        $oconns = new database();
	        $dats = $oconns->getRows("select * from fondeo;");
	        if ($param=="")
	        {
	            echo "<option value='' selected></option>";
	        }
	        foreach ($dats as $items)
	        {
	            if ($param==$items["idkey"])
	            {
	                echo "<option value='".$items["idkey"]."' selected>".$items["nombre"]."</option>";
	            }
	            else
	                {
	                    echo "<option value='".$items["idkey"]."'>".$items["nombre"]."</option>";
	                }
	        }
	    }
	    
	    function create_condiciones_pago()
	    {
	        $oconns = new database();
	        $dats = $oconns->getRows("select * from condiciones_pago;");
	        if ($param=="")
	        {
	            echo "<option value='' selected></option>";
	        }
	        foreach ($dats as $items)
	        {
	            if ($param==$items["idkey"])
	            {
	                echo "<option value='".$items["idkey"]."' selected>".$items["nombre"]."</option>";
	            }
	            else
	                {
	                    echo "<option value='".$items["idkey"]."'>".$items["nombre"]."</option>";
	                }
	        }
	    }
	    
	    function create_productos($tipo)
	    {
	        $oconns = new database();
	        $dats = $oconns->getRows("select * from productos where tipo='$tipo' order by nombre asc;");
	        if ($param=="")
	        {
	            echo "<option value=''></option>";
	        }
	        foreach ($dats as $items)
	        {
	            if ($param==$items["idkey"])
	            {
	                echo "<option value='".$items["idkey"]."' selected>".$items["nombre"]."</option>";
	            }
	            else
	                {
	                    echo "<option value='".$items["idkey"]."'>".$items["nombre"]."</option>";
	                }
	        }
	    }


	    function create_identificacion($param)
	    {
	        $oconns = new database();
	        $dats = $oconns->getRows("select * from identificacion;");
	        if ($param=="")
	        {
	            echo "<option value='' selected></option>";
	        }
	        foreach ($dats as $items)
	        {
	            if ($param==$items["idkey"])
	            {
	                echo "<option value='".$items["idkey"]."' selected>".$items["nombre"]."</option>";
	            }
	            else
	                {
	                    echo "<option value='".$items["idkey"]."'>".$items["nombre"]."</option>";
	                }
	        }
	    }


	    function create_regimen_fiscal($param)
	    {
	        $oconns = new database();
	        $dats = $oconns->getRows("select * from regimen_fiscal;");
	        if ($param=="")
	        {
	            echo "<option value='' selected></option>";
	        }
	        foreach ($dats as $items)
	        {
	            if ($param==$items["idkey"])
	            {
	                echo "<option value='".$items["idkey"]."' selected>".$items["nombre"]."</option>";
	            }
	            else
	                {
	                    echo "<option value='".$items["idkey"]."'>".$items["nombre"]."</option>";
	                }
	        }
	    }


	    function create_nivel_academico($param)
	    {
	        $oconns = new database();
	        $dats = $oconns->getRows("select * from nivel_academico;");
	        if ($param=="")
	        {
	            echo "<option value='' selected></option>";
	        }
	        foreach ($dats as $items)
	        {
	            if ($param==$items["idkey"])
	            {
	                echo "<option value='".$items["idkey"]."' selected>".$items["nombre"]."</option>";
	            }
	            else
	                {
	                    echo "<option value='".$items["idkey"]."'>".$items["nombre"]."</option>";
	                }
	        }
	    }
	    
	    function create_estado_civil($param)
	    {
	        $oconns = new database();
	        $dats = $oconns->getRows("select * from estado_civil;");
	        if ($param=="")
	        {
	            echo "<option value='' selected></option>";
	        }
	        foreach ($dats as $items)
	        {
	            if ($param==$items["idkey"])
	            {
	                echo "<option value='".$items["idkey"]."' selected>".$items["nombre"]."</option>";
	            }
	            else
	                {
	                    echo "<option value='".$items["idkey"]."'>".$items["nombre"]."</option>";
	                }
	        }
	    }

	    function create_contacto_prioridad($param)
	    {
	        $oconns = new database();
	        $dats = $oconns->getRows("select * from contacto_prioridad;");
	        if ($param=="")
	        {
	            echo "<option value='' selected></option>";
	        }
	        foreach ($dats as $items)
	        {
	            if ($param==$items["idkey"])
	            {
	                echo "<option value='".$items["idkey"]."' selected>".$items["nombre"]."</option>";
	            }
	            else
	                {
	                    echo "<option value='".$items["idkey"]."'>".$items["nombre"]."</option>";
	                }
	        }
	    }

	    function create_frecuencia()
	    {

	        $oconns = new database();
	        $dats = $oconns->getRows("select * from frecuencia;");
	        if ($param=="")
	        {
	            echo "<option value='' selected></option>";
	        }
	        foreach ($dats as $items)
	        {
	            if ($param==$items["idkey"])
	            {
	                echo "<option value='".$items["idkey"]."' selected>".$items["nombre"]."</option>";
	            }
	            else
	                {
	                    echo "<option value='".$items["idkey"]."'>".$items["nombre"]."</option>";
	                }
	        }
	    }

	    function create_puestos($param1,$param2)
	    {
	        $oconns = new database();
	        if ($param1=="")
	        {
	            echo "<option value='' selected></option>";
	        }
	        else
	        {
	            $dats = $oconns->getRows("select * from puestos where idkey_departamentos='".$param1."';");
	            if ($param2=="")
	            {
	                echo "<option value='' selected></option>";
	            }

	            foreach ($dats as $items)
	            {            
	                if ($param2==$items["idkey"])
	                {
	                    echo "<option value='".$items["idkey"]."' selected>".$items["nombre"]."</option>";
	                }
	                else
	                    {
	                        echo "<option value='".$items["idkey"]."'>".$items["nombre"]."</option>";
	                    }
	            }
	        }
	    }


	    function create_departamentos($param)
	    {

	        $oconns = new database();
	        $dats = $oconns->getRows("select * from departamentos;");
	        if ($param=="")
	        {
	            echo "<option value='' selected></option>";
	        }
	        foreach ($dats as $items)
	        {
	            if ($param==$items["idkey"])
	            {
	                echo "<option value='".$items["idkey"]."' selected>".$items["nombre"]."</option>";
	            }
	            else
	                {
	                    echo "<option value='".$items["idkey"]."'>".$items["nombre"]."</option>";
	                }
	        }
	    }


	    function create_sexo($param)
	    {

	        $oconns = new database();
	        $dats = $oconns->getRows("select * from sexo;");
	        if ($param=="")
	        {
	            echo "<option value='' selected></option>";
	        }
	        foreach ($dats as $items)
	        {
	            if ($param==$items["idkey"])
	            {
	                echo "<option value='".$items["idkey"]."' selected>".$items["nombre"]."</option>";
	            }
	            else
	                {
	                    echo "<option value='".$items["idkey"]."'>".$items["nombre"]."</option>";
	                }
	        }


	    }

	    function create_tipo_direccion($param)
	    {

	        $oconns = new database();
	        $dats = $oconns->getRows("select * from tipo_direccion order by nombre asc;");
	        if ($param=="")
	        {
	            echo "<option value='' selected></option>";
	        }
	        foreach ($dats as $items)
	        {
	            if ($param==$items["idkey"])
	            {
	                echo "<option value='".$items["idkey"]."' selected>".$items["nombre"]."</option>";
	            }
	            else
	                {
	                    echo "<option value='".$items["idkey"]."'>".$items["nombre"]."</option>";
	                }
	        }


	    }

	    function create_parentesco($param)
	    {

	        $oconns = new database();
	        $dats = $oconns->getRows("select * from parentesco;");
	        if ($param=="")
	        {
	            echo "<option value='' selected></option>";
	        }
	        foreach ($dats as $items)
	        {
	            if ($param==$items["idkey"])
	            {
	                echo "<option value='".$items["idkey"]."' selected>".$items["nombre"]."</option>";
	            }
	            else
	                {
	                    echo "<option value='".$items["idkey"]."'>".$items["nombre"]."</option>";
	                }
	        }


	    }


    function create_estados($param)
    {

        $oconns = new database();
        $dats = $oconns->getRows("select * from estados;");
        if ($param=="")
        {
            echo "<option value='' selected></option>";
        }
        foreach ($dats as $items)
        {
            if ($param==$items["idkey"])
            {
                echo "<option value='".$items["idkey"]."' selected>".$items["nombre"]."</option>";
            }
            else
                {
                    echo "<option value='".$items["idkey"]."'>".$items["nombre"]."</option>";
                }
        }

    }






    function create_municipios($param1,$param2)
    {
        $oconns = new database();
        if ($param1=="")
        {
            echo "<option value='' selected></option>";
        }
        else
        {
            $dats = $oconns->getRows("select * from municipios where idkey_estados='".$param1."' order by nombre asc;");
            if ($param2=="")
            {
                echo "<option value='' selected></option>";
            }

            foreach ($dats as $items)
            {            
                if ($param2==$items["idkey"])
                {
                    echo "<option value='".$items["idkey"]."' selected>".$items["nombre"]."</option>";
                }
                else
                    {
                        echo "<option value='".$items["idkey"]."'>".$items["nombre"]."</option>";
                    }
            }
        }
    }


    function create_localidad($param1,$param2)
    {

        $oconns = new database();
        if ($param1=="")
        {
            echo "<option value='' selected></option>";
        }
        else
        {
            $dats = $oconns->getRows("select * from localidad where idkey_municipios='".$param1."' order by nombre asc;");
            if ($param2=="")
            {
                echo "<option value='' selected></option>";
            }

            foreach ($dats as $items)
            {            
                if ($param2==$items["idkey"])
                {
                    echo "<option value='".$items["idkey"]."' selected>".$items["nombre"]."</option>";
                }
                else
                    {
                        echo "<option value='".$items["idkey"]."'>".$items["nombre"]."</option>";
                    }
            }
        }
    }



    function create_cp($param1,$param2)
    {

        $oconns = new database();
        if ($param1=="")
        {
            echo "<option value='' selected></option>";
        }
        else
        {
            $dats = $oconns->getRows("select * from codigo_postal where idkey_localidad='".$param1."';");
            if ($param2=="")
            {
                echo "<option value='' selected></option>";
            }

            foreach ($dats as $items)
            {            
                if ($param2==$items["idkey"])
                {
                    echo "<option value='".$items["idkey"]."' selected>".$items["nombre"]."</option>";
                }
                    else
                        {
                            echo "<option value='".$items["idkey"]."'>".$items["nombre"]."</option>";
                        }
            }

        }
    }

    function create_garantia_tipo($param)
	    {
	        $oconns = new database();
	        $dats = $oconns->getRows("select * from garantias_tipos;");
	        if ($param=="")
	        {
	            echo "<option value='' selected></option>";
	        }
	        foreach ($dats as $items)
	        {
	            if ($param==$items["idkey"])
	            {
	                echo "<option value='".$items["idkey"]."' selected>".$items["nombre"]."</option>";
	            }
	            else
	                {
	                    echo "<option value='".$items["idkey"]."'>".$items["nombre"]."</option>";
	                }
	        }
	    }

    
    function create_garantia_categoria_muebles($param)
    {
	$oconns = new database();
	        $dats = $oconns->getRows("select * from garantias_categorias where idkey_garantias_tipos=5;");
	        if ($param=="")
	        {
	            echo "<option value='' selected></option>";
	        }
	        foreach ($dats as $items)
	        {
	            if ($param==$items["idkey"])
	            {
	                echo "<option value='".$items["idkey"]."' selected>".$items["nombre"]."</option>";
	            }
	            else
	                {
	                    echo "<option value='".$items["idkey"]."'>".$items["nombre"]."</option>";
	                }
	        }
    }
    
    function create_garantia_categoria_inmuebles($param)
    {
	$oconns = new database();
	        $dats = $oconns->getRows("select * from garantias_categorias where idkey_garantias_tipos=6;");
	        if ($param=="")
	        {
	            echo "<option value='' selected></option>";
	        }
	        foreach ($dats as $items)
	        {
	            if ($param==$items["idkey"])
	            {
	                echo "<option value='".$items["idkey"]."' selected>".$items["nombre"]."</option>";
	            }
	            else
	                {
	                    echo "<option value='".$items["idkey"]."'>".$items["nombre"]."</option>";
	                }
	        }
    }
    
    function create_fields($basic,$subfijo,$status,$position)
    {
        $setstatus="";
        if ($status==true)
            $setstatus="disabled";

?>

    <div class="row mt-2">
        <div class="mx-auto col-sm-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header"><h6 class="mb-0">Datos generales</h6></div>
                <div class="card-body">
                    <div class="form-group row" style="margin:0px; padding:0px;">
                        <div class="col-sm-12 col-md-4 col-lg-4" style="margin-bottom: 2px; margin-top: 0px;">
                            <label class="col-form-label form-control-label">Nombre(s) <span style="color:red;">*</span></label>
                            <input type="text" class="form-control form-control-sm" name="nombre<?php echo $subfijo ?>" id="nombre<?php echo $subfijo ?>"  <?php echo $setstatus ?>>
                        </div>                        
                        <div class="col-sm-12 col-md-4 col-lg-4" style="margin-bottom: 2px; margin-top: 0px;">
                            <label class="col-form-label form-control-label">Apellido Paterno <span style="color:red;">*</span></label>
                            <input type="text" class="form-control form-control-sm" name="apellido_p<?php echo $subfijo ?>" id="apellido_p<?php echo $subfijo ?>" <?php echo $setstatus ?>>
                        </div>
                        <div class="col-sm-12 col-md-4 col-lg-4" style="margin-bottom: 2px; margin-top: 0px;">
                            <label class="col-form-label form-control-label">Apellido Materno <span style="color:red;">*</span></label>
                            <input type="text" class="form-control form-control-sm" name="apellido_m<?php echo $subfijo ?>" id="apellido_m<?php echo $subfijo ?>" <?php echo $setstatus ?>>
                        </div>
                    </div>

                    <div class="form-group row" style="margin:0px; padding:0px;">
                        <div class="col-sm-12 col-md-4 col-lg-2" style="margin-bottom: 2px; margin-top: 0px;">
                            <label class="col-form-label form-control-label">Edad <span style="color:red;">*</span></label>
                            <input maxlength="2" type="text" class="form-control form-control-sm" name="edad<?php echo $subfijo ?>" id="edad<?php echo $subfijo ?>" <?php echo $setstatus ?>>
                        </div>

                        <div class="col-sm-12 col-md-4 col-lg-3" style="margin-bottom: 2px; margin-top: 0px;">
                            <label class="col-form-label form-control-label">Sexo <span style="color:red;">*</span></label>
                            <select name="sexo<?php echo $subfijo ?>" id="sexo<?php echo $subfijo ?>" class="form-control form-control-sm" <?php echo $setstatus ?>>
                            <?php create_sexo(''); ?>
                            </select>
                        </div>

                        <?php
                        if ($basic=="1")
                        {
                        ?>

                        <div class="col-sm-12 col-md-4 col-lg-3" style="margin-bottom: 2px; margin-top: 0px;">
                            <label class="col-form-label form-control-label">Parentesco <span style="color:red;">*</span></label>
                            <select name="parentesco<?php echo $subfijo ?>" id="parentesco<?php echo $subfijo ?>" class="form-control form-control-sm" <?php echo $setstatus ?>>
                            <?php create_parentesco('') ?>
                            </select>

                        </div>


                        <?php
                        }
                        ?>


                    </div>



                </div>
            </div>
        </div>
    </div>

  <?php
        if ($basic=="1")
        {
    ?>
    <div class="row mt-2" id="incompleto<?php echo $subfijo ?>">
        <div class="mx-auto col-sm-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header"><h6 class="mb-0">Direcci&oacute;n</h6></div>
                <div class="card-body">
                    <div class="form-group row" style="margin:0px; padding:0px;">
                        <div class="col-sm-12 col-md-4 col-lg-12" style="margin-bottom: 2px; margin-top: 0px;">
                            <label class="col-form-label form-control-label">Desea utilizar la misma direccion del empleado? </label>
                            <div class="row  justify-content-center">
                                <div class="col-6">
                                    <div class="row  justify-content-center">
                                        <div class="col-10">                                                                
                                            <input type="button" class="btn btn-sm btn-primary" name="opcion_direccion1<?php echo $subfijo ?>" id="opcion_direccion1<?php echo $subfijo ?>" aria-label="" value="Si" disabled>
                                        </div>
                                        <div class="col-2">
                                            <input type="button" class="btn btn-sm btn-primary" name="opcion_direccion2<?php echo $subfijo ?>" id="opcion_direccion2<?php echo $subfijo ?>" aria-label="" value="No">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php        
        }
        if ($basic=="1")
        {
    ?>
    <div class="row mt-2" style="display:none;" id="completo<?php echo $subfijo ?>">
    <?php
        }
        else
        {
    ?>
    <div class="row mt-2" id="completo<?php echo $subfijo ?>">
    <?php
        }
    ?>
        <div class="mx-auto col-sm-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header"><h6 class="mb-0">Direcci&oacute;n</h6></div>
                <div class="card-body">
                    <div class="form-group row" style="margin:0px; padding:0px;">
                        <div class="col-sm-12 col-md-4 col-lg-12" style="margin-bottom: 2px; margin-top: 0px;">
                            <label class="col-form-label form-control-label">Domicilio <span style="color:red;">*</span></label>
                            <input type="text"  size="10"  class="form-control form-control-sm" name="domicilio<?php echo $subfijo ?>" id="domicilio<?php echo $subfijo ?>" <?php echo $setstatus ?>>
                        </div>
                    </div>
                    <div class="form-group row" style="margin:0px; padding:0px;">
                        <div class="col-sm-12 col-md-6 col-lg-6" style="margin-bottom: 2px; margin-top: 0px;">
                            <label class="col-form-label form-control-label">Estado <span style="color:red;">*</span></label>
                            <select name="estados<?php echo $subfijo ?>" id="estados<?php echo $subfijo ?>" class="form-control form-control-sm" <?php echo $setstatus ?>><?php create_estados('','') ?></select>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-6" style="margin-bottom: 2px; margin-top: 0px;">
                            <label class="col-form-label form-control-label">Ciudad/Delegaci&oacute;n <span style="color:red;">*</span></label>
                            <select name="municipios<?php echo $subfijo ?>" id="municipios<?php echo $subfijo ?>" class="form-control form-control-sm" <?php echo $setstatus ?>><?php create_municipios('','') ?></select>
                        </div>
                    </div>

                    <div class="form-group row" style="margin:0px; padding:0px;">
                        <div class="col-sm-12 col-md-6 col-lg-6" style="margin-bottom: 2px; margin-top: 0px;">
                            <label class="col-form-label form-control-label">Localidad <span style="color:red;">*</span></label>
                            <select name="localidad<?php echo $subfijo ?>" id="localidad<?php echo $subfijo ?>" class="form-control form-control-sm" <?php echo $setstatus ?>><?php create_localidad('','') ?></select>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-6" style="margin-bottom: 2px; margin-top: 0px;">
                            <label class="col-form-label form-control-label">Codigo Postal <span style="color:red;">*</span></label>
                            <select name="codigo_postal<?php echo $subfijo ?>" id="codigo_postal<?php echo $subfijo ?>" class="form-control form-control-sm" <?php echo $setstatus ?>><?php create_cp('','') ?></select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <div class="row mt-2">
        <div class="mx-auto col-sm-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header"><h6 class="mb-0">Datos oficiales</h6></div>
                <div class="card-body">

                    <div class="form-group row" style="margin:0px; padding:0px;">
                        <div class="col-sm-12 col-md-6 col-lg-6" style="margin-bottom: 2px; margin-top: 0px;">
                            <label class="col-form-label form-control-label">I.N.E <span style="color:red;">*</span></label>
                            <input maxlength="18" type="text" class="form-control form-control-sm" name="ine<?php echo $subfijo ?>" id="ine<?php echo $subfijo ?>" <?php echo $setstatus ?>>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-6" style="margin-bottom: 2px; margin-top: 0px;">
                            <label class="col-form-label form-control-label">R.F.C <span style="color:red;">*</span></label>
                            <input maxlength="13" type="text" class="form-control form-control-sm" name="rfc<?php echo $subfijo ?>" id="rfc<?php echo $subfijo ?>" <?php echo $setstatus ?>>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>


    <div class="row mt-2">
        <div class="mx-auto col-sm-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header"><h6 class="mb-0">Contacto</h6></div>
                <div class="card-body">

                    <div class="form-group row" style="margin:0px; padding:0px;">
                        <div class="col-sm-12 col-md-6 col-lg-4" style="margin-bottom: 2px; margin-top: 0px;">
                            <label class="col-form-label form-control-label">Telefono Celular <span style="color:red;">*</span></label>
                            <input maxlength="10" type="text" class="form-control form-control-sm" name="telefono1<?php echo $subfijo ?>" id="telefono1<?php echo $subfijo ?>" <?php echo $setstatus ?>>
                        </div>

                        <div class="col-sm-12 col-md-6 col-lg-4" style="margin-bottom: 2px; margin-top: 0px;">
                            <label class="col-form-label form-control-label">Telefono Casa <span style="color:red;">*</span></label>
                            <input maxlength="10" type="text" class="form-control form-control-sm" name="telefono2<?php echo $subfijo ?>" id="telefono2<?php echo $subfijo ?>" <?php echo $setstatus ?>>
                        </div>

                        <div class="col-sm-12 col-md-6 col-lg-4" style="margin-bottom: 2px; margin-top: 0px;">
                            <label class="col-form-label form-control-label">Telefono Oficina <span style="color:red;">*</span></label>
                            <input maxlength="10" type="text" class="form-control form-control-sm" name="telefono3<?php echo $subfijo ?>" id="telefono3<?php echo $subfijo ?>" <?php echo $setstatus ?>>
                        </div>
                    </div>

                    <div class="form-group row" style="margin:0px; padding:0px;">
                        <div class="col-sm-12 col-md-6 col-lg-6" style="margin-bottom: 2px; margin-top: 0px;">
                            <label class="col-form-label form-control-label">E-Mail <span style="color:red;">*</span></label>
                            <input type="text" class="form-control form-control-sm" name="email<?php echo $subfijo ?>" id="email<?php echo $subfijo ?>" <?php echo $setstatus ?>>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    if ($position==true)
    {
    ?>

    <div class="row mt-2">
        <div class="mx-auto col-sm-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header"><h6 class="mb-0">Posición Laboral</h6></div>
                <div class="card-body">

                    <div class="form-group row" style="margin:0px; padding:0px;">
                        <div class="col-sm-12 col-md-6 col-lg-6" style="margin-bottom: 2px; margin-top: 0px;">
                            <label class="col-form-label form-control-label">Departamento <span style="color:red;">*</span></label>
                            <select name="departamentos<?php echo $subfijo ?>" id="departamentos<?php echo $subfijo ?>" class="form-control form-control-sm" <?php echo $setstatus ?>><?php create_departamentos('','') ?></select>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-6" style="margin-bottom: 2px; margin-top: 0px;">
                            <label class="col-form-label form-control-label">Puesto <span style="color:red;">*</span></label>
                            <select name="puestos<?php echo $subfijo ?>" id="puestos<?php echo $subfijo ?>" class="form-control form-control-sm" <?php echo $setstatus ?>><?php create_puestos('','') ?></select>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <?php
    }
}







  if ($_SERVER['REQUEST_METHOD'] === 'GET')
    {
        if (isset($_GET["module"]))
        {
            switch($_GET["module"])
            {
                case "change_estadosTOmunicipios":
                {
                    create_municipios($_GET["param1"],$_GET["param2"]);
                    break;
                }

                case "change_municipiosTOlocalidad":
                {

                    create_localidad($_GET["param1"],$_GET["param2"]);
                	break;
                }

                case "change_localidadTOcodigo_postal":
                {
                	create_cp($_GET["param1"],$_GET["param2"]);
                	break;
                }
		case "change_garantias_tiposTOgarantias_categorias":
                {
                	create_garantia_categoria($_GET["param1"],$_GET["param2"]);
                	break;
                }
		case "change_empleadorTOdomiclio_empleador":
                {
                	create_domicilio_empleador($_GET["param1"],$_GET["param2"]);
                	break;
                }
                case "change_departamentoTOpuesto":
                {
                	create_puestos($_GET["param1"],$_GET["param2"]);
                	break;
                }
                case "combo_departamentos":
                {

                    create_departamentos($_GET["param1"]);
                	break;
                }

                case "combo_puestos":
                {
                	create_puestos($_GET["param1"],$_GET["param2"]);
                	break;
                }
            }

        }
    }




?>
