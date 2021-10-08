<?php
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    require_once "../php/security.php";
    require_once "../php/header_seguimiento.php";
    require_once "../php/db.php";
    require_once '../php/clases/conversor.php';
    create_header_seguimiento();
    create_menu_seguimiento();
    begin_containers();
    
    ?>
<form class="text-grey">
      <div class="row m-4">
        
            <div class="card-header border-0 bg-transparent">
                <h4 class="text-success">Detalle del crédito</h4>            
            </div>
        
    </div>
    <?php
     if (isset($_GET["idkey_credito"]) && isset($_GET["tipo"])){
        $idkey_credito = $_GET["idkey_credito"];
        $tipo = $_GET["tipo"];
    }
    else{
        echo "<script> alert('No se han encontrado datos coincidentes.'); window.location.href='index.php'; </script>";
    }
    ?>
    <input  hidden name='idkey_credito' id='idkey_credito' value="<?php echo $idkey_credito; ?>" >
    <input  hidden name='idkey_cliente' id='idkey_cliente' value=''>
    <input hidden name='tipo_credito' id='tipo_credito' value='<?php echo $tipo;?>'>
   
    
    
</form>

<div class="col-12 col-sm-12 mt-12 mt-sm-0 cards-container" id="card-container-2">
  <div class="card bgc-success brc-primary radius-0" id="card-2">
    <div class="card-header">
      <h5 class="card-title text-white font-light"><i class="fa fa-table mr-2px"></i>
        <b>Nombre:&nbsp;</b><span id="nombre"></span>
      </h5>
    </div>

    <div class="card-body p-0 bg-white">
      <table class="table table-striped table-hover mb-0 table-bordered">
        <thead class="thin-border-bottom">
          <tr>
            <tr style="margin-bottom: 0px; margin-left: 20px" id="socios"></tr>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td width="50%">
                <div class="row">
                    <div class="col-sm-4 col-md-4 col-lg-4 card-title"><b>Folio:</b></div>
                    <div class="col-sm-8 col-md-8 col-lg-8 text-grey" id="folio"></div>
                </div>
            </td>
            <td>
                <div class="row">
                    <div class="col-sm-4 col-md-4 col-lg-4 card-title"><b>Fecha de solicitud:</b></div>
                    <div class="col-sm-8 col-md-8 col-lg-8 text-grey" id="fecha_creacion"></div>
                </div>
            </td>
          </tr>
          <tr>
            <td>
                <div class="row">
                    <div class="col-sm-4 col-md-4 col-lg-4 card-title"><b>Tipo de producto:</b></div>
                    <div class="col-sm-8 col-md-8 col-lg-8 text-grey" id="producto"></div>
                </div>
            </td>
            <td>
                <div class="row">
                    <div class="col-sm-4 col-md-4 col-lg-4 card-title"><b>Monto de crédito:</b></div>
                    <div class="col-sm-8 col-md-8 col-lg-8 text-grey" id="monto"></div>
                </div>
            </td>
          </tr>
          <tr>
            <td>
                <div class="row">
                    <div class="col-sm-4 col-md-4 col-lg-4 card-title"><b>% PRODECO:</b></div>
                    <div class="col-sm-8 col-md-8 col-lg-8 text-grey" id="prodeco"></div>
                </div>
            </td>
            <td>
                <div class="row">
                    <div class="col-sm-4 col-md-4 col-lg-4 card-title"><b>% FONDEADORA:</b></div>
                    <div class="col-sm-8 col-md-8 col-lg-8 text-grey" id="fondeadora"></div>
                </div>
            </td>
          </tr>
          <tr>
            <td>
                <div class="row">
                    <div class="col-sm-4 col-md-4 col-lg-4 card-title"><b>Plazo en meses: </b></div>
                    <div class="col-sm-8 col-md-8 col-lg-8 text-grey" id="plazo"></div>
                </div>
            </td>
            <td>
                <div class="row">
                    <div class="col-sm-4 col-md-4 col-lg-4 card-title"><b>Frecuencia de pago:</b></div>
                    <div class="col-sm-8 col-md-8 col-lg-8 text-grey" id="frecuencia"></div>
                </div>
            </td>
          </tr>
          <tr>
            <td>
                <div class="row">
                    <div class="col-sm-4 col-md-4 col-lg-4 card-title"><b>Número de pagos:</b></div>
                    <div class="col-sm-8 col-md-8 col-lg-8 text-grey" id="no_pagos"></div>
                </div>
            </td>
            <td>
                <div class="row">
                    <div class="col-sm-4 col-md-4 col-lg-4 card-title"><b>Tasa de interés anual:</b></div>
                    <div class="col-sm-8 col-md-8 col-lg-8 text-grey" id="tasa_interes"></div>
                </div>
            </td>
          </tr>
          <tr>
            <td>
                <div class="row">
                    <div class="col-sm-4 col-md-4 col-lg-4 card-title"><b>Garantía líquida:</b></div>
                    <div class="col-sm-8 col-md-8 col-lg-8 text-grey" id="gliquida"></div>
                </div>
            </td>
            <td>
                <div class="row">
                    <div class="col-sm-4 col-md-4 col-lg-4 card-title"><b>Fecha de desembolso:</b></div>
                    <div class="col-sm-8 col-md-8 col-lg-8 text-grey" id="fecha_desembolso"></div>
                </div>
            </td>
          </tr>
          <tr>
            <td>
                <div class="row">
                    <div class="col-sm-4 col-md-4 col-lg-4 card-title"><b>Tipo desembolso:</b></div>
                    <div class="col-sm-8 col-md-8 col-lg-8 text-grey" id="tipo_desembolso"></div>
                </div>
            </td>
            <td>
                <div class="row">
                    <div class="col-sm-4 col-md-4 col-lg-4 card-title"><b>Fecha de primer pago:</b></div>
                    <div class="col-sm-8 col-md-8 col-lg-8 text-grey" id="primer_pago"></div>
                </div>
            </td>
          </tr>
          <tr>
            <td>
                <div class="row">
                    <div class="col-sm-4 col-md-4 col-lg-4 card-title"><b>Estatus:</b></div>
                    <div class="col-sm-8 col-md-8 col-lg-8 text-grey" id="estatus"></div>
                </div>
            </td>
            <td>
                <div class="row">
                    <div class="col-sm-4 col-md-4 col-lg-4 card-title"><b>Estatus Pagos:</b></div>
                    <div class="col-sm-8 col-md-8 col-lg-8 text-grey" id="estatus_pagos"></div>
                </div>
            </td>
          </tr>
          <tr>
            <td colspan="2">
                <div class="row">
                    <div class="col-sm-2 col-md-2 col-lg-2 card-title"><b>Finalidad:</b></div>
                    <div class="col-sm-10 col-md-10 col-lg-10 text-grey" id="finalidad"></div>
                </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>

<hr>
<!--TABLA AMORTIZACIÓN-->
    <div class="accordion" id="tabla-datos">
        <div class="card border-0">
            <div class="card-header border-0 bg-transparent" id="tabla-datos">
                <h2 class="card-title">
                <a class="accordion-toggle bgc-success-l3 rounded-lg d-style" href="#tabla-1" data-toggle="collapse" aria-expanded="false" aria-controls="tabla-1">
                    <span class="v-n-collapsed h-100 position-tl border-l-3 brc-success-tp2"></span>
                    <span class="text-success-m1">
                        <i class="fa fa-angle-right toggle-icon mr-1"></i>
                            TABLA AMORTIZACIÓN ESTÁTICA
                        </span>
                </a>
                </h2>
            </div>
            <div id="tabla-1" class="collapse" aria-labelledby="tabla-datos" data-parent="#tabla-datos">
            <div class="card-body">
                <div class="pb-2 flex-column flex-sm-row">
                    <div class="page-tools mt-3 mt-sm-0 mb-sm-n1"></div>
                </div>       
                <div class="mt-4 mx-md-2 border-t-1 brc-secondary-l1">
                    <div id="table-header" class="d-none justify-content-between px-2 py-25 border-b-1 brc-secondary-l1">
                    <div>Resultados <span class="text-600 text-primary-d1">"Clientes"</span>
                        <small class="text-grey-m2">(Con columnas reordenables)</small>
                    </div>
                    </div> 

                    <div class="table-responsive-md">
                        <table id="datatable" class="table table-bordered table-bordered-x table-hover text-dark-m2 text-85">
                            <thead class="text-uppercase text-dark-m3 bgc-grey-l4">
                                <tr class="font-bold text-100">
                                    <td>#</td>
                                    <td width="15%">Fecha de pago</td>
                                    <td>Núm. de pago</td>
                                    <td>Interés</td>
                                    <td>IVA</td>
                                    <td>Capital</td>
                                    <td>Pago</td>
                                    <td>Saldo insoluto</td>
                                </tr>
                            </thead>
                            <?php
                            
                                $oconns  = new database();
                                $datas = $oconns->getRows("select *, DATE_FORMAT(fecha_pago,'%d/%m/%Y') as fecha_pago from amortizaciones where idkey_creditos='".$_GET["idkey_credito"]."' order by pago asc;");
                            ?>
                            <tbody>
                                <?php
                                if($oconns->numberRows > 0){
                                    foreach($datas as $td){
                                    ?>
                                    <tr>
                                        <td><?php echo $td["pago"] ?></td>
                                        <td><?php echo $td["fecha_pago"]; ?></td>
                                        <td><?php echo $td["descripcion"]; ?></td>
                                        <td>$<?php echo strval(number_format($td["intereses"],2)); ?></td>
                                        <td>$<?php echo strval(number_format($td["iva"],2)); ?></td>
                                        <td>$<?php echo strval(number_format($td["renta"],2)); ?></td>
                                        <td>$<?php echo strval(number_format($td["total"],2)); ?></td>
                                        <td>$<?php echo strval(number_format($td["saldo_insoluto"],2)); ?></td>
                                    </tr>
                                    <?php
                                    } 
                                } 
                                else
                                    echo"<tr align='center'><td colspan='8'><i>No se encontraron resultados</i></td></tr>";
                                ?>
                            </tbody>
                        </table>
                    </div> <!-- / table responsive -->
                </div>
            </div>
            </div> <!-- / acoordeon tabla 1 -->
        </div>

        <div class="card border-0">
            <div class="card-header border-0 bg-transparent" id="tabla-datos2">
                <h2 class="card-title">
                <a class="accordion-toggle bgc-success-l3 rounded-lg d-style" href="#tabla-2" data-toggle="collapse" aria-expanded="true" aria-controls="tabla-2">
                    <span class="v-n- h-100 position-tl border-l-3 brc-success-tp2"></span>
                    <span class="text-success-m1">
                        <i class="fa fa-angle-right toggle-icon mr-1"></i>
                            TABLA DE AMORTIZACIÓN DINÁMICA
                        </span>
                </a>
                </h2>
            </div>

            <div id="tabla-2" class="collapse" aria-labelledby="datosGenerales" data-parent="#tabla-datos">
                <!--<div class="pb-2 flex-column flex-sm-row">
                    <div class="page-tools mt-3 mt-sm-0 mb-sm-n1"></div>
                </div>  -->     
                <div class="mt-4 mx-md-2 border-t-1 brc-secondary-l1">
                    <!--<div id="table-header" class="d-none justify-content-between px-2 py-25 border-b-1 brc-secondary-l1">
                        <div>
                            Resultados <span class="text-600 text-primary-d1">"Clientes"</span>
                            <small class="text-grey-m2">(Con columnas reordenables)</small>
                        </div>-->
                    </div> 

                    <div class="table-responsive-md">
                       <table id="datatable" class="table table-bordered table-bordered-x table-hover text-dark-m2 text-85">
                            <thead class="text-uppercase text-dark-m3 bgc-grey-l4">
                                <tr class="font-bold text-100">
                                    <td>#</td>
                                    <td width="15%">Fecha de pago</td>
                                    <td>Pago</td>
                                    <td>Interés</td>
                                    <td>IVA</td>
                                    <td>Monto</td>
                                    <td>Interés acumulado</td>
                                    <td>Pago interés moratorio</td>
                                    <td>Iva interés moratorio</td>
                                    <td>Saldo a favor</td>
                                    <td>Días transcurridos</td>
                                    <td>Amortización</td>
                                    <td>Saldo insoluto</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $oconns  = new database();
                                $datas = $oconns->getRows("select *, DATE_FORMAT(fecha_valor,'%d/%m/%Y') as fecha_valor from amortizaciones_dinamicas where idkey_creditos='".$_GET["idkey_credito"]."' order by no_pago asc, idkey asc;");
                                if($oconns->numberRows > 0){
                                    foreach($datas as $td){
                                        ?>
                                        <tr>
                                            <td><?php echo $td["no_pago"] ?></td>
                                            <td><?php echo $td["fecha_valor"]; ?></td>
                                            <td>$<?php echo strval(number_format($td["pago"],2)); ?></td>
                                            <td>$<?php echo strval(number_format($td["interes"],2)); ?></td>
                                            <td>$<?php echo strval(number_format($td["iva"],2)); ?></td>
                                            <td>$<?php echo strval(number_format($td["monto"],2)); ?></td>
                                            <td>$<?php echo strval(number_format($td["interes_acumulado"],2)); ?></td>
                                            <td>$<?php echo strval(number_format($td["pago_interes_moratorio"],2)); ?></td>
                                            <td>$<?php echo strval(number_format($td["iva_interes_moratorio"],2)); ?></td>
                                            <td>$<?php echo strval(number_format($td["saldo_afavor"],2)); ?></td>
                                            <td><?php echo $td["dias_transcurridos"]; ?></td>
                                            <td>$<?php echo strval(number_format($td["amortizacion"],2)); ?></td>
                                            <td>$<?php echo strval(number_format($td["saldo_insoluto"],2)); ?></td>
                                        </tr>
                                    <?php
                                    }
                                }
                                else
                                    echo"<tr align='center'><td colspan='11'><i>No se encontraron resultados</i></td></tr>";

                                ?>
                                
                            </tbody>
                        </table>
                    </div> <!-- / table responsive -->
                </div>
            </div> <!-- / acoordeon tabla 2 -->
        </div>


        </div><!-- fin de card-->
    </div> <!-- fin de acordeon-->

    <br>
        
            


<?php end_containers(); ?>

<!--Datatables-->
<script type="text/javascript" src="../ace-admin/node_modules/datatables/media/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="../ace-admin/node_modules/datatables.net-bs4/js/dataTables.bootstrap4.js"></script>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>



<script type="text/javascript" src="../js/funciones_cartera.js"></script>
<script type="text/javascript">

  $(document).ready(function(){
    var idkey_credito=$('#idkey_credito').val();
    detalle_credito_general(idkey_credito);
    
  });
     
    
</script>
<?php
    //require_once "php/security.php";
    //require_once "php/header_forms.php";
    create_footer_forms();
    ?>
</div>
</body>
</html>
