<?php
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    require_once "../php/security.php";
    require_once "../php/header_contabilidad.php";
    require_once "../php/functions.php";
    require_once "../php/db.php";
    require_once '../php/clases/conversor.php';
    create_header();
    create_menu();
    begin_containers();
    
    ?>
<form class="text-grey">
      <div class="row m-4">
        <div class="col-12 col-md-4">
            <div class="card-header border-0 bg-transparent">
                <h4 class="text-success">Detalle de Póliza de Egreso</h4>            
            </div>
        </div>
        <div class="col-12 col-md-8">
            <div class="alert d-flex bgc-white brc-success-m3 border-1 p-0" role="alert">
                <div class="bgc-success p-25 text-center m-n1px radius-l-1">
                <i class="fa fa-check text-150 text-white"></i>
                </div>
                <span class="ml-3 align-self-center text-success-d2 text-110">Solicitud de poliza generada exitosamente</span>
            </div>
        </div>
    </div>
    <?php
     if (isset($_GET["idkey_poliza_egreso"])){
        $idkey_poliza_egreso = $_GET["idkey_poliza_egreso"];
        echo "<script> alert(".$idkey_poliza_egreso.") </script>";
        $oconns = new database();
        $data = $oconns->getRows("select DATE_FORMAT(pe.fecha,'%d/%m/%Y') as fecha, pe.no_poliza, pe.concepto, pe.monto, pe.idkey_tipo_poliza, periodo, serie, tipo 
            from poliza_egreso pe where idkey='$idkey_poliza_egreso'");
        if($oconns->numberRows==0){
            echo "<script> alert('No se han encontrado datos coincidentes.'); window.location.href='index.php'; </script>";
            exit;
        }
        else{
            $data1 = $oconns->getRows("select idkey as idkey_poliza_diario from poliza_diario where idkey_poliza_egreso='$idkey_poliza_egreso'");
            if($oconns->numberRows>0)
              $idkey_poliza_diario=$data1[0]["idkey_poliza_diario"];
            else $idkey_poliza_diario="";
            //Para los movimientos
            $data2 = $oconns->getRows("select m.idkey, m.idkey_cuenta_contable, m.referencia, m.debe, m.haber, m.descripcion, m.idkey_poliza, cc.nombre from poliza_egreso_movimientos m INNER JOIN cuentas_contables cc ON (m.idkey_cuenta_contable = cc.no_cuenta) WHERE m.idkey_poliza='$idkey_poliza_egreso'");
            $no_cuenta1 = $data2[0]["idkey_cuenta_contable"];
            $no_cuenta2= $data2[1]["idkey_cuenta_contable"];
            $nombre_cuenta1 = $data2[0]["nombre"];
            $nombre_cuenta2 = $data2[1]["nombre"];
            $idkey_tipo_poliza = $data[0]["idkey_tipo_poliza"];
        }
    }
    else{
        echo "<script> alert('No se han encontrado datos coincidentes.'); window.location.href='index.php'; </script>";
        exit;
    }
    ?>
    <input  hidden name='idkey_poliza_egreso' id='idkey_poliza_egreso' value="<?php echo $idkey_poliza_egreso; ?>" >
   
    
</form>

<div class="col-12 col-sm-12 mt-12 mt-sm-0 cards-container" id="card-container-2">
  <div class="card bgc-primary brc-primary radius-0" id="card-2">
    <div class="card-header">
      <h5 class="card-title text-white font-light"><i class="fa fa-table mr-2px"></i>
        <b>Datos Generales</b>
      </h5>
    </div>
    <div class="card-body p-0 bg-white">
      <table class="table table-striped table-hover mb-0 table-bordered">
        <tbody>
          <tr>
            <td colspan="2">
              <div class="row">
              <div class="col-sm-6 col-md-6 col-lg-6 card-title text-right"><b>Crédito</b></div>
              <div class="col-sm-6 col-md-6 col-lg-6 card-title"><b>Monto</b></div>

              <?php
               $dat = $oconns->getRows("select c.idkey as idkey_credito, c.folio, c.monto from poliza_egreso_creditos pe inner join creditos c on (pe.idkey_credito=c.idkey) where idkey_poliza_egreso='$idkey_poliza_egreso'");
                foreach ($dat as $item1) {
                      $dat1 = $oconns->getRows("select folio, monto_solicitado, ct.idkey as idkey_caja_transito from creditos c inner join caja_transito ct on (c.idkey=ct.idkey_credito) where ct.idkey_credito='".$item1["idkey_credito"]."'");
                      if($oconns->numberRows>0) $monto = $dat1[0]["monto_solicitado"];
                      else $monto = $item1["monto"];
              
                      echo '<div class="col-sm-6 col-md-6 col-lg-6 text-grey text-400 text-right">'.$item1["folio"].'</div>';
                      echo '<div class="col-sm-6 col-md-6 col-lg-6 text-grey text-400">$'.number_format($monto,2).'</div>';
                }
              ?>
              </div>
            </td>
          </tr>

          <tr>
            <td width="50%">
                <div class="row">
                    <div class="col-sm-4 col-md-4 col-lg-4 card-title"><b>Número de póliza:</b></div>
                    <div class="col-sm-8 col-md-8 col-lg-8 text-grey"><span id="npoliza"><?php echo $data[0]["no_poliza"]; ?></span></div>
                </div>
            </td>
            <td>
                <div class="row">
                    <div class="col-sm-4 col-md-4 col-lg-4 card-title"><b>Fecha póliza:</b></div>
                    <div class="col-sm-8 col-md-8 col-lg-8 text-grey" ><span id="fecha"><?php echo $data[0]["fecha"]; ?></span></div>
                </div>
            </td>
          </tr>
          <tr>
            <td>
                <div class="row">
                    <div class="col-sm-4 col-md-4 col-lg-4 card-title"><b>Monto:</b></div>
                    <div class="col-sm-8 col-md-8 col-lg-8 text-grey" >
                        <?php echo "$".number_format($data[0]["monto"],2); ?>
                        <span hidden id="monto"><?php echo $data[0]["monto"];?></span>
                    </div>
                </div>
            </td>
            <td>
                <div class="row">
                    <div class="col-sm-4 col-md-4 col-lg-4 card-title"><b>Periodo:</b></div>
                    <div class="col-sm-8 col-md-8 col-lg-8 text-grey"><span id="periodo"><?php echo $data[0]["periodo"]; ?></span></div>
                </div>
            </td>
          </tr>
          <tr>
            <td>
                <div class="row">
                    <div class="col-sm-4 col-md-4 col-lg-4 card-title"><b>Serie:</b></div>
                    <div class="col-sm-8 col-md-8 col-lg-8 text-grey"><span id="serie"><?php echo $data[0]["serie"]; ?></span></div>
                </div>
            </td>
            <td>
                <div class="row">
                    <div class="col-sm-4 col-md-4 col-lg-4 card-title"><b>Tipo:</b></div>
                    <div class="col-sm-8 col-md-8 col-lg-8 text-grey"><span id="tipo"><?php echo $data[0]["tipo"]; ?></span></div>
                </div>
            </td>
          </tr>
          <tr>
            <td colspan="2">
                <div class="row">
                    <div class="col-sm-2 col-md-2 col-lg-2 card-title"><b>Concepto:</b></div>
                    <div class="col-sm-10 col-md-10 col-lg-10 text-grey"><span id="concepto"><?php echo $data[0]["concepto"]; ?></span></div>
                </div>
            </td>
          </tr>
          <tr>
            <td colspan="2" class="bgc-info">
              <h5 class="card-title text-white font-light"><i class="fa fa-calculator mr-2px"></i>
                <b>Cuenta Contable 1</b>
              </h5>
            </td>
          </tr>
          <tr>
            <td>
                <div class="row">
                    <div class="col-sm-4 col-md-4 col-lg-4 card-title"><b>Cuenta Contable:</b></div>
                    <div class="col-sm-8 col-md-8 col-lg-8 text-grey"><?php echo $no_cuenta1; ?></div>
                </div>
            </td>
            <td>
                <div class="row">
                    <div class="col-sm-4 col-md-4 col-lg-4 card-title"><b>Nombre:</b></div>
                    <div class="col-sm-8 col-md-8 col-lg-8 text-grey" ><?php echo $nombre_cuenta1; ?></div>
                </div>
            </td>
          </tr>
          <tr>
            <td>
                <div class="row">
                    <div class="col-sm-4 col-md-4 col-lg-4 card-title"><b>Debe:</b></div>
                    <div class="col-sm-8 col-md-8 col-lg-8 text-grey" ><?php echo "$".number_format($data2[0]["debe"],2); ?></div>
                </div>
            </td>
            <td>
                <div class="row">
                    <div class="col-sm-4 col-md-4 col-lg-4 card-title"><b>Haber:</b></div>
                    <div class="col-sm-8 col-md-8 col-lg-8 text-grey" ><?php echo "$".number_format($data2[0]["haber"],2); ?></div>
                </div>
            </td>
          </tr>
          <tr>
            <td>
                <div class="row">
                    <div class="col-sm-4 col-md-4 col-lg-4 card-title"><b>Referencia:</b></div>
                    <div class="col-sm-8 col-md-8 col-lg-8 text-grey"><?php echo $data2[0]["referencia"]; ?></div>
                </div>
            </td>
          </tr>
          <tr>
            <td colspan="2" class="bgc-default">
              <h5 class="card-title text-white font-light"><i class="fa fa-calculator mr-2px"></i>
                <b>Cuenta Contable 2</b>
              </h5>
            </td>
          </tr>
          <tr>
            <td>
                <div class="row">
                    <div class="col-sm-4 col-md-4 col-lg-4 card-title"><b>Cuenta Contable:</b></div>
                    <div class="col-sm-8 col-md-8 col-lg-8 text-grey"><?php echo $no_cuenta2; ?></div>
                </div>
            </td>
            <td>
                <div class="row">
                    <div class="col-sm-4 col-md-4 col-lg-4 card-title"><b>Nombre:</b></div>
                    <div class="col-sm-8 col-md-8 col-lg-8 text-grey" ><?php echo $nombre_cuenta2; ?></div>
                </div>
            </td>
          </tr>
          <tr>
            <td>
                <div class="row">
                    <div class="col-sm-4 col-md-4 col-lg-4 card-title"><b>Debe:</b></div>
                    <div class="col-sm-8 col-md-8 col-lg-8 text-grey" ><?php echo "$".number_format($data2[1]["debe"],2); ?></div>
                </div>
            </td>
            <td>
                <div class="row">
                    <div class="col-sm-4 col-md-4 col-lg-4 card-title"><b>Haber:</b></div>
                    <div class="col-sm-8 col-md-8 col-lg-8 text-grey" ><?php echo "$".number_format($data2[1]["haber"],2); ?></div>
                </div>
            </td>
          </tr>
          <tr>
             <td>
                <div class="row">
                    <div class="col-sm-4 col-md-4 col-lg-4 card-title"><b>Referencia:</b></div>
                    <div class="col-sm-8 col-md-8 col-lg-8 text-grey"><?php echo $data2[1]["referencia"]; ?></div>
                </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
        
<div class="row border-t-1 brc-grey-l1 py-4 text-right">   
    <div class="col-sm-12 col-md-12 col-lg-12 text-white">
        <a href="../pdf/poliza_egreso.php?idkey_poliza_egreso=<?php echo $idkey_poliza_egreso; ?>" id="poliza_egreso"  class="btn btn-success btn-sm" target="_blank">
            <i class="fa fa-file-pdf-o"></i>&nbsp;Póliza Egreso
        </a>&nbsp;&nbsp;
        <a <?php if($data[0]["idkey_tipo_poliza"]!="1" && $data[0]["idkey_tipo_poliza"]!="3") echo "hidden";?> href="#" id="poliza_cheque"  class="btn btn-purple btn-sm" data-toggle="modal" data-target="#modalDatosCheque">
            <i class="fa fa-money"></i>&nbsp;Póliza Cheque
        </a>&nbsp;&nbsp;
        <?php
          if($idkey_poliza_diario !="")
            echo '<a href="../pdf/poliza_diario.php?idkey_poliza_diario='.$idkey_poliza_diario.'" target="_blank" id="poliza_diario"  class="btn btn-warning btn-sm">
            <i class="fa fa-file-pdf-o"></i>&nbsp;Póliza Diario</a>';
        ?>
        

    </div>
</div>

<!---- MODAL-->

<form id="formPCheque" name="formPCheque" action="">
  <div class="modal fade modal-md" id="modalDatosCheque" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-lg" role="document">
      <div class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title">Datos Póliza Cheque</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body ace-scrollbar">
          <div id="formPolizaCheque"  aria-labelledby="formPCheque" >
                    
              <!---***********Contenido del form-->
              <div class="form-group row" style="margin:0px; padding:0px;">
                <?php
                if($idkey_tipo_poliza==1){//Si se trata de Credito efectivo debe indicar el nombre del beneficiario 
                  echo'<div class="col-sm-12 col-md-12 col-lg-12" style="margin-bottom: 8px; margin-top: 0px;">
                    <label class="col-form-label form-control-label mt-0 text-success-d1 text-100">
                      Nombre del Beneficiario<span style="color:red;">*</span>
                    </label>
                    <input class="form-control form-control-sm bgc-grey-l4" type="text" value="" id="nombre" name="nombre" required> 
                  </div>';
                } 
                else{//si se trata de Credito cheque se deben desplegar los nombres de los miembros del crédito
                  echo'<div class="col-sm-12 col-md-12 col-lg-12" style="margin-bottom: 30px; margin-top: 0px;">
                     <label class="col-form-label form-control-label text-success-d1 text-100">Nombre<span style="color:red;">*</span></label>
                     <select name="nombre" id="nombre" class="form-control form-control-sm radius-round bgc-grey-l4 ace-select" required>';
                  $data2 = $oconns->getRows("select nombre, tipo_credito from view_creditos where idkey_credito='".$item1["idkey_credito"]."'");
                  if($data2[0]["tipo_credito"]=="1")//Individual
                    echo'<option value="'.$data2[0]["nombre"].'">'.$data2[0]["nombre"].'</option>';
                  else{
                    $data3 = $oconns->getRows("select idkey_cliente, nombre from view_clientes_grupo where idkey_credito='".$item1["idkey_credito"]."' order by nombre asc");
                    foreach ($data3 as $item3) 
                      echo'<option value="'.$item3["idkey_cliente"].'">'.$item3["nombre"].'</option>';
                  }

                  echo'</select></div>';
                  //Campo de control para los montos de los cheques
                  if($data2[0]["tipo_credito"]=="2") echo "<input hidden type='text' id='idkey_credito' value='".$item1["idkey_credito"]."'>";
                }
                ?>
                <div class="col-sm-12 col-md-12 col-lg-12" style="margin-bottom: 12px; margin-top: 0px;" id="div_monto">
                </div>
                <div class="col-sm-12 col-md-12 col-lg-12" style="margin-bottom: 12px; margin-top: 0px;">
                  <label class="col-form-label form-control-label mt-0 text-success-d1 text-100">
                    Número de Cheque <span style="color:red;">*</span>
                  </label>
                  <input class="form-control form-control-sm bgc-grey-l4" type="number" id="no_cheque" name="no_cheque" required> 
                </div>
                <div class="col-sm-12 col-md-12 col-lg-12" style="margin-bottom: 12px; margin-top: 0px;">
                  <label class="col-form-label form-control-label mt-0 text-success-d1 text-100">
                    Número de Cuenta<span style="color:red;">*</span>
                  </label>
                  <input class="form-control form-control-sm bgc-grey-l4" type="number" id="no_cuenta" name="no_cuenta" required> 
                </div>
                <div class="col-sm-12 col-md-12 col-lg-12" style="margin-bottom: 30px; margin-top: 0px;">
                     <label class="col-form-label form-control-label text-success-d1 text-100">Tipo<span style="color:red;">*</span></label>
                     <select name="banco" id="banco" class="form-control form-control-sm radius-round bgc-grey-l4 ace-select" required>
                        <option value="1">Bancomer</option>
                        <option value="2">Banorte</option>
                     </select>
                </div>
              </div>
              <!---//Contenido del form -->
          </div> <!-- / id="formPCheque" class="collapse" -->

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-success" id="btnGenerarCheque">Generar Cheque</button>
        </div>

      </div>
    </div>
  </div>
</div>
</form>
<!---//FIN DE MODAL-->
            


<?php end_containers(); ?>

<script type="text/javascript" src="../ace-admin/node_modules/jquery/dist/jquery.js"></script>
<script type="text/javascript" src="../ace-admin/node_modules/popper.js/dist/umd/popper.js"></script>
<script type="text/javascript" src="../ace-admin/node_modules/bootstrap/dist/js/bootstrap.js"></script>

<script type="text/javascript" src="../ace-admin/node_modules/bootbox/bootbox.all.js"></script>
<script type="text/javascript" src="../ace-admin/node_modules/sweetalert2/dist/sweetalert2.all.js"></script>
<script type="text/javascript" src="../ace-admin/node_modules/interactjs/dist/interact.js"></script>

<script type="text/javascript" src="../js/funciones_contabilidad.js"></script>
<script type="text/javascript" src="../js/jquery.validate.min.js"></script>
<script src="../js/validate_rules.js"></script>
<script type="text/javascript">

  $(document).ready(function(){
    $("#formPCheque").validate({errorClass: 'text-error'});
    $("#formPCheque").submit(function( event ) {
        if($("#formPCheque").valid()){
            if($("#idkey_credito").val() != undefined)//Grupal
              var idkey_credito = "&idkey_credito="+$("#idkey_credito").val();
            else idkey_credito ="";
            var urlcheque1 = "../pdf/poliza_cheque_bancomer.php?idkey="+$("#idkey_poliza_egreso").val()+"&nombre="+$("#nombre").val()+"&cheque="+$("#no_cheque").val()+"&cuenta="+$("#no_cuenta").val()+idkey_credito;
            var urlcheque2 = "../pdf/poliza_cheque_banorte.php?idkey="+$("#idkey_poliza_egreso").val()+"&nombre="+$("#nombre").val()+"&cheque="+$("#no_cheque").val()+"&cuenta="+$("#no_cuenta").val()+idkey_credito;
            if($("#banco").val()==1)
                window.open(urlcheque1, '_blank');
            else
                window.open(urlcheque2, '_blank');
        }
        else
            alertify.error("Algunos datos están incompletos o erróneos");
        event.preventDefault();
    });
  });

  $('#poliza_cheque').on('click', function (e) {
    //Se resetea el form cuando se cierra el modal
    $("#formPCheque")[0].reset();
     var validator = $("#formPCheque").validate();
    validator.resetForm();
   
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
