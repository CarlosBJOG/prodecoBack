<?php
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    require_once "../php/security.php";
    require_once "../php/header_cartera.php";
    require_once "../php/functions.php";
    require_once "../php/db.php";
    
    create_header_forms();
    create_menu_cartera();
    begin_containers();
    
    ?>
<form class="text-grey">
      <div class="row m-4">
        <div class="col-12 col-md-4">
            <div class="card-header border-0 bg-transparent">
                <h4 class="text-success">Detalle del crédito</h4>            
            </div>
        </div>
        <div class="col-12 col-md-8">
            <div class="alert d-flex bgc-white brc-success-m3 border-1 p-0" role="alert">
                <div class="bgc-success p-25 text-center m-n1px radius-l-1">
                <i class="fa fa-check text-150 text-white"></i>
                </div>
                <span class="ml-3 align-self-center text-success-d2 text-110">Solicitud de crédito generada exitosamente</span>
            </div>
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
        
<div class="row border-t-1 brc-grey-l1 py-4">   
    <div class="col-sm-12 col-md-2 col-lg-2" style="margin-bottom:3px">
        <button id="amortizacion1" type="button" class="btn btn-success btn-sm btn-block" onclick="generar_amortizacion();">
            <i class="fa fa-file-pdf-o"></i>&nbsp;Amortización contrato
        </button>
    </div>
    <div class="col-sm-12 col-md-2 col-lg-2" style="margin-bottom:3px">
        <button id="amortizacion2" type="button" class="btn btn-success btn-sm btn-block" onclick="generar_amortizacion_cliente();">
            <i class="fa fa-file-pdf-o"></i>&nbsp;Amortización cliente
        </button>
    </div>
    <div class="col-sm-12 col-md-2 col-lg-2" style="margin-bottom:3px">
        <button id="generar_contrato" type="button" class="btn btn-primary btn-sm btn-block" onclick="generar_contrato();">
            <i class="fa fa-file-pdf-o"></i>&nbsp;Imprimir contrato
        </button>  
    </div>
    <div class="col-sm-12 col-md-2 col-lg-2 " style="margin-bottom:3px">       
        <button class="btn btn-warning btn-sm btn-block" type="button" onclick="generar_solicitud()">
            <i class="fa fa-print" ></i>&nbsp;Imprimir solicitud
        </button>
    </div>
    <div class="col-sm-12 col-md-2 col-lg-2 " style="margin-bottom:3px">
        <button id="generar_pagare" class="btn btn-info btn-sm btn-block" type="button" onclick="generar_pagare()">
            <i class="fa fa-print" ></i>&nbsp;Imprimir pagaré
        </button>
    </div>
    <div class="col-sm-12 col-md-2 col-lg-2 " style="margin-bottom:3px">
        <a href="cartera.php">
            <button class="btn btn-danger btn-sm  btn-block" type="button">
                <i class="fa fa-window-close"></i>&nbsp;Finalizar
            </button>
        </a>
    </div>
</div>
            


<?php end_containers(); ?>


<script type="text/javascript" src="../js/funciones_cartera.js"></script>
<script type="text/javascript">

  $(document).ready(function(){
    var idkey_credito=$('#idkey_credito').val();
    detalle_credito_general(idkey_credito);
    
  });
     
function regresar(){
    location.href="cartera.php"
}
    
</script>
<?php
    //require_once "php/security.php";
    //require_once "php/header_forms.php";
    create_footer_forms();
    ?>
</div>
</body>
</html>
