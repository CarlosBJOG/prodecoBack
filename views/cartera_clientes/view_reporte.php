<div class="row" style="overflow-x: auto; min-width: 300px;">
	<div class="col-12 col-sm-12 mt-12 mt-sm-0 cards-container border-0">
	    <div class="card-header border-0 bg-transparent">
	        <h4 class="text-success">Detalle del Cliente</h4>            
	    </div>
	</div>
	<div class="col-12 col-md-8">
	    <div class="alert d-flex bgc-white brc-success-m3 border-1 p-0" role="alert">
	        <div class="bgc-success p-25 text-center m-n1px radius-l-1">
	        <i class="fa fa-check text-150 text-white"></i>
	        </div>
	        <span class="ml-3 align-self-center text-success-d2 text-110">Perfil de cliente completado exitosamente</span>
	    </div>
	</div>
</div>

<div class="col-12 col-sm-12 mt-12 mt-sm-0 cards-container border-0"  id="card-container-2">
  <div class="card bgc-success radius-0" id="card-2" style="min-width:350px">
    <div class="card-header border-0">
      <h5 class="card-title text-white font-light"><i class="fa fa-table mr-2px"></i>
        <b>Identificador de Cliente:&nbsp;</b><span><?php echo $idkey_cliente; ?></span>
      </h5>
    </div>

    <div class="card-body p-0 bg-white">
      <table class="table table-striped table-hover mb-0">
        <thead class="thin-border-bottom">
          <tr>
            <tr style="margin-bottom: 0px; margin-left: 20px" id="socios"></tr>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td width="50%" align="right">
                <div class="card-title text-success"><b>Fecha de solicitud:</b></div>   
            </td>
            <td>
                <div class="text-grey"><?php echo date("d/m/Y"); ?></div>
            </td>
          </tr>
          <tr>
            <td width="50%" align="right">
                <div class="card-title text-success"><b>Nombre:</b></div>   
            </td>
            <td>
                <div class="text-grey" id="f_nombre"></div>
            </td>
          </tr>
          <tr>
            <td width="50%" align="right">
                <div class="card-title text-success"><b>Fecha de nacimiento:</b></div>   
            </td>
            <td>
                <div class="text-grey" id="f_nacimiento"></div>
            </td>
          </tr>
          <tr>
            <td width="50%" align="right">
                <div class="card-title text-success"><b>RFC:</b></div>   
            </td>
            <td>
                <div class="text-grey" id="f_rfc"></div>
            </td>
          </tr>
          <tr>
            <td width="50%" align="right">
                <div class="card-title text-success"><b>CURP:</b></div>   
            </td>
            <td>
                <div class="text-grey" id="f_curp"></div>
            </td>
          </tr>
          <tr>
            <td width="50%" align="right">
                <div class="card-title text-success"><b>Domicilio:</b></div>   
            </td>
            <td>
                <div class="text-grey" id="f_domicilio"></div>
            </td>
          </tr>

        </tbody>
      </table>
    </div>
  </div>
</div>
