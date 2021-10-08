<?php
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    require_once "../php/security.php";
    require_once "../php/header_seguimiento.php";
    require_once "functions_seguimiento.php";
    require_once "../php/db.php";
    
    create_header_seguimiento();
    create_menu_seguimiento();
    
    ?>
<form>
    <input type='hidden' name='idkey_cliente' id='idkey_cliente' value='<?php echo $_GET["idkey_cliente"];?>'>
    <?php
        if (isset($_GET["idkey_cliente"]))
        {
            $oconns = new database();
            $datas = $oconns->getRows("select * from (select 'Individual' as tipo,clientes.idkey,concat(generales.nombre,' ',generales.apellido_p,' ',generales.apellido_m) as nombre,clientes.fecha_creacion,clientes.idkey_promotor,u.usuario_nombre,creditos.monto,creditos.idkey_productos,p.nombre as producto,creditos.idkey as credito_id,creditos.folio,creditos.tasa_interes,creditos.numero_pagos,creditos.plazo,creditos.idkey_frecuencia,f.nombre as frecuencia,creditos.primer_pago,creditos.finalidad,creditos.estatus as estatus_id,ce.nombre as estatus from clientes left join creditos on creditos.idkey_clientes=clientes.idkey left join generales on generales.idkey=clientes.idkey_generales left join usuarios u on u.idkey=clientes.idkey_promotor inner join productos p on p.idkey=creditos.idkey_productos inner join frecuencia f on f.idkey=creditos.idkey_frecuencia inner join creditos_estatus ce on ce.idkey=creditos.estatus UNION select 'Grupal' as tipo,gn.idkey,gn.nombre,gn.fecha_creacion,gn.idkey_promotor,u.usuario_nombre,creditos.monto,creditos.idkey_productos,p.nombre as producto,creditos.idkey as credito_id,creditos.folio,creditos.tasa_interes,creditos.numero_pagos,creditos.plazo,creditos.idkey_frecuencia,f.nombre as frecuencia,creditos.primer_pago,creditos.finalidad,creditos.estatus as estatus_id,ce.nombre as estatus from grupos_nombre gn left join creditos on creditos.idkey_clientes = gn.idkey left join usuarios u on u.idkey=gn.idkey_promotor inner join productos p on p.idkey=creditos.idkey_productos inner join frecuencia f on f.idkey = creditos.idkey_frecuencia inner join creditos_estatus ce on ce.idkey=creditos.estatus) tab1 where tab1.monto > 0 and tab1.credito_id=".$_GET["credito_id"]." and tab1.tipo='".$_GET["tipo"]."';");
            
        }
        ?>
      <input type='hidden' name='idkey_credito' id='idkey_credito' value='<?php echo $datas[0]["credito_id"];?>'>

      <div class="row m-4">
        <div class="col-12 col-md-4">
            <div class="card-header border-0 bg-transparent">
                <h2 class="text-success">Nuevo crédito</h2>            
            </div>
        </div>
        <div class="col-12 col-md-4">
            <p class="text-100 text-secondary pt-3">Promotor: <b><?php echo $datas[0]["usuario_nombre"] ?></b></p>   
        </div>

        <div class="col-12 col-md-4">
            <p class="text-100 text-secondary pt-3">Estatus:
            <?php 
            $estatus = $datas[0]["estatus_id"];
            if($estatus==4){
            ?>
            <span class='badge badge-sm bgc-secondary-l2 text-secondary-d2 border-1 brc-secondary-m3'><?php echo $datas[0]["estatus"]; ?></span>
            <?php } 
            elseif($estatus==3){?>
            <span class='badge badge-sm bgc-danger-l2 text-danger-d2 border-1 brc-danger-m3'><?php echo $datas[0]["estatus"]; ?></span>
            <?php } 
            elseif($estatus==2){?>
            <span class='badge badge-sm bgc-warning-l2 text-warning-d2 border-1 brc-warning-m3'><?php echo $datas[0]["estatus"]; ?></span>
            <?php } 
            elseif($estatus==1){?>
            <span class='badge badge-sm bgc-success-l2 text-success-d2 border-1 brc-success-m3'><?php echo $datas[0]["estatus"]; ?></span>
            <?php } ?>
            </p>   
        </div>
    </div>

    <div class="row form-group m-4">
        <div class="col-sm-12 col-md-4 col-lg-4">
            <label class="text-success tect-grey text-110"> <?php echo $datas[0]["nombre"] ?></label>
            <hr class="brc-secondary-l1"/>
            <p class="text-600 text-grey">
            <label >No. de solicitud:</label>
            <input id="folio" hidden value=""  readonly /> <?php echo $datas[0]["folio"] ?></p>
            <hr>
            <p class="text-600 text-grey">
            <label >Fecha de solicitud:</label>
            <input id="fecha" hidden value=""  readonly /> <?php echo $datas[0]["fecha_creacion"] ?></p>
        </div>

            <div class="row col-md-8 col-lg-8 border-l-1 brc-secondary-l1 pl-4 mt-5">
                <div class="col-sm-12 col-md-6 col-lg-6">
                <p class="text-600 text-grey">
                <label for="tipo-producto">Tipo de producto:</label> <?php echo $datas[0]["producto"]; ?>
                <input hidden id="t_producto" value="<?php echo $datas[0]["idkey_productos"]; ?>" >
                </p>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-6">
                <p class="text-600 text-grey">
                <label >Monto de crédito: </label> $ <?php echo $datas[0]["monto"] ?></p>
                <input hidden id="t_monto" value="<?php echo $datas[0]["monto"]; ?>" >
            </div>

            <div class="col-sm-12 col-md-6 col-lg-6">
                <p class="text-600 text-grey">
                <label >Plazo en meses: </label> <?php echo $datas[0]["plazo"] ?></p>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-6">
                <p class="text-600 text-grey">
                <label for="frecuencia-pago">Frecuencia de pago: </label> <?php echo $datas[0]["frecuencia"] ?></p>
                <input hidden id="t_frec" value="<?php echo $datas[0]["idkey_frecuencia"]; ?>" >
                </p>
            </div>

            <div class="col-sm-12 col-md-6 col-lg-6" >
                <p class="text-600 text-grey">
                <label id="xxx">Número de pagos:</label> <?php echo $datas[0]["numero_pagos"] ?></p>
                <input hidden id="t_pagos" value="<?php echo $datas[0]["numero_pagos"]; ?>" >
            </div>
            <div class="col-sm-12 col-md-6 col-lg-6">
                <p class="text-600 text-grey">
                <label >Tasa de interés anual:</label> <?php echo $datas[0]["tasa_interes"] ?> %</p>                
            </div>

            <div class="col-sm-12 col-md-6 col-lg-6">
            <p class="text-600 text-grey">
                <?php $fecha = explode('-',$datas[0]["primer_pago"]);
                $f2 = $fecha[2]."/".$fecha[1]."/".$fecha[0];
                ?>
                <label class="col-form-label form-control-label mt-0 text-600 text-grey">Fecha de primer pago:</label> <?php echo $f2; ?></p>
                <input hidden id="t_pago1" value="<?php echo $f2; ?>" >
            </div>
            <div class="col-sm-12 col-md-6 col-lg-6">
            <p class="text-600 text-grey">
            <label >Finalidad: </label>
            <input hidden type="text" class="form-control" id="finalidad" placeholder=""><?php echo $datas[0]["finalidad"] ?></p>
        </div>
        </div>
    </div>
    <hr class="no-padding no-margin">
<!-- TABLA DE FACTORES -->
    <div class="row justify-content-center">
	<div class="col-lg-8 col-sm-12 col-md-12 pr-lg-0 mt-3 mt-lg-0 pl-5">
	    <div class="card-body p-3 px-sm-1 px-lg-0">
		<!-- Insert tabla factores -->
		<div id="div_factores"></div>
        <div id="div_avales"></div>
	    </div> <!-- / card-body -->
        </div> <!-- Col-lg-8 -->
        
        <div class="col-lg-4 col-sm-12 col-md-12 mt-3 mt-lg-0 p-4">
            <h4>SCORE</h4>
            <tr>
            <td id="tp">0.00</td>
            <td id="anotherid">0.00</td>
        </tr>
            <p>GRAFICA, GRAFICA, GRAFICA, </p>
        </div>
	    </div> <!-- / row -->
    <!-- TABLA AMORTIZACION -->
    <div hidden id="div_amortizacion"></div>
   <?php if (isset($_GET["idkey_cliente"]))
        {
            $oconns = new database();
            $cred_estatus = $oconns->getRows("select estatus from creditos where idkey=".$_GET["credito_id"].";");
            
            $estatus_id = $cred_estatus[0]["estatus"];
            
            $observacion = $oconns->getRows("select observacion from creditos_observaciones where idkye_credito=".$_GET["credito_id"].";");
        }
        ?>
    <div class="row border-t-1 brc-grey-l1 py-3">
        <div class="col-sm-12 col-md-3 mb-3">
        <a href="<?php echo "../perfil-cliente.php?idkey_cliente=".$_GET["idkey_cliente"].""; ?>" target="_blank">
        <button class="btn btn-secondary btn-sm ml-3" type="button">
            <i class="fa fa-eye"></i>
            Ver perfil de cliente
        </button></a>
        </div>

        <div class="col-sm-12 col-md-3">     
        <p class="text-600 text-grey">
        <label for="tipo-producto">Determinación de crédito</label>
        <select class="ace-select text-dark-m1 bgc-default-l5 bgc-h-warning-l3  brc-default-m3 brc-h-warning-m1" id="estatus_id">
            <option value="">Seleccionar...</option>
            <?php select_estatus($estatus_id); ?>
        </select>
        </p>
            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#razonModal">
            <i class="fa fa-send-o"></i>
            Enviar
            </button>
        </div>
        <div class="col-sm-12 col-md-5 mb-3">            
            <label for="tipo-producto" class="text-600 text-grey">Determinación de crédito</label>
            <p class="text-secondary-m2 text-105">
            <textarea class="form-control" id="razon_estatus" maxlength="200"><?php echo $observacion[0]["observacion"]; ?></textarea>        
            </p>            
        </div>
    </div>
</form>


<!--MODAL Razón estatus-->

<div class="modal fade" id="razonModal" tabindex="-1" role="dialog" aria-labelledby="razonModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-width-0 border-t-4 brc-success-m2 px-3">
            <div class="modal-header py-2">
                <i class="bgc-white fas fa-check-circle mb-n4 mx-auto fa-3x text-success-m2"></i>
            </div>
            <div class="modal-body text-center">
                <p class="text-secondary-d1 text-120 mt-3">
                El crédito ha sido autorizado exitosamente y se ha enviado a contabilidad.
                </p>
            </div>

            <div class="modal-footer bg-white justify-content-between px-0 py-3">
                <a href="contabilidad.php">
                <button onclick="actualizar_credito();" type="button" class="btn btn-md px-2 px-md-4 btn-light-secondary btn-h-light-warning btn-a-light-danger" data-dismiss="modal">
                <i class="fas fa-calculator mr-1 text-warning-m2"></i>
                Ir a Contabilidad
                </button></a>
                <a href="seguimiento-supervisor.php">
                <button onclick="actualizar_credito();" type="button" class="btn btn-md px-2 px-md-4 btn-light-secondary btn-h-light-success btn-a-light-success">
                Finalizar
                <i class="fa fa-arrow-right ml-1 text-success-m2"></i>
                </button>
                </a>
            </div>

        </div>
    </div>
</div>
<!--/MODAL Razón estatus-->
        
<?php end_containers(); ?>
<script>
    
</script>
<script>
    $(document).ready(function() 
    {
    <?php
        if (isset($_GET["idkey_cliente"]))
        {
        ?>
    //$('#div_relaciones').load("../php/show_interface_cliente.php?module=main_relaciones&param=<?php echo $_GET["idkey_cliente"] ?>");
    $('#div_factores').load("factores.php?module=create_factores&param=<?php echo $_GET["idkey_cliente"] ?>");
    $('#div_avales').load("factores.php?module=create_avales&param=<?php echo $_GET["idkey_cliente"] ?>");
    $('#div_amortizacion').load("amortizacion.php?module=create_amortizacion&producto="+$('#t_producto').val()+"&plazo="+$('#t_pagos').val()+"&monto="+$('#t_monto').val()+"&fecha_inicio="+$('#t_pago1').val()+"&frecuencia="+$('#t_frec').val()+"&credito_id="+$('#idkey_credito').val());
    $('.ace-switch').change(function(){
        alert('Checkeado');
    });
    <?php
        }
        else
        {
    
        ?>
    $.fn.start_for_clients();
    <?php
        }
        ?>
    $('.ace-switch').change(function(){
        alert('Checkeado');
        }) ;
    });
        
</script>

<?php
    require_once "../php/security.php";
    //require_once "../php/header_forms.php";
    create_footer_forms();
    ?>
</div>
</body>
</html>
