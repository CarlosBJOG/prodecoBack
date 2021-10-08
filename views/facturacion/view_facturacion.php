<div id="modalFacturacion" class="collapse show" aria-labelledby="datosGarantias" data-parent="#nuevoClienteAlta4">
        <div class="card-body text-grey-d3">
              <!-- MODAL -->

            <div class="modal fade modal-lg" id="modal_facturacion" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable" role="document">
                  <div class="modal-content">

                        <div class="modal-header">
                            <h5 class="modal-title text-success">INFORMACI&Oacute;N PARA FACTURACI&Oacute;N</h5>
                            
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body ace-scrollbar">
                    
                        <div class="accordion" id="paso1Acordeon">

<!--PASO 1 - DATOS GENERALES -->
<div class="card border-0">
 <div class="card-header border-0 bg-transparent" id="datosGenerales">
   <h2 class="card-title">
     <a class="accordion-toggle bgc-secondary-l3 rounded-lg d-style" href="#formDatosGenerales" data-toggle="collapse" aria-expanded="true" aria-controls="formDatosGenerales">
       <span class="v-n-collapsed h-100 position-tl border-l-3 brc-secondary-tp2"></span>
       <span class="text-success-m1"><i class="fa fa-angle-right toggle-icon mr-1"></i>Datos Generales</span>
     </a>
   </h2>
 </div>
 <div id="formDatosGenerales" class="collapse show" aria-labelledby="datosGenerales" data-parent="#paso1Acordeon">
     <div class="card-body text-grey-d3">
       <div class="form-group " style="margin:0px; padding:0px;">
            <div class="bgc-white px-1 bo1rder-1 brc-secondary-l2 radius-1">
                <table class="table table table-striped-info table-borderless">
                <tr>
                    <td><i class="fa fa-user text-success-l1"></i></td>
                    <td class="text-95 text-default-d3">Nombre de Cliente:</td>
                    <td class="text-secondary-d2" id="nom_cliente"></td>
                </tr>
                <tr>
                    <td><i class="fa fa-envelope text-blue-m3"></i></td>
                    <td class="text-95 text-default-d3">Email:</td>
                    <td class="text-secondary-d2 text-wrap"  id="email"></td>
                </tr>
                <tr>
                    <td><i class="fa fa-phone text-purple-m3"></i></td>
                    <td class="text-95 text-default-d3">Tel&eacute;fono:</td>
                    <td class="text-secondary-d2"  id="telefono"></td>
                </tr>
                <tr>
                    <td><i class="fa fa-map-marker text-orange-m3"></i></td>
                    <td class="text-95 text-default-d3">Domicilio:</td>
                    <td class="text-secondary-d2" id="domicilio"></td>
                </tr>
                <tr>
                    <td><i class="far fa-id-badge text-secondary-m3"></i></td>
                    <td class="text-95 text-default-d3">RFC:</td>
                    <td class="text-secondary-d2" id="rfc"></td>
                </tr>
                <tr>
                    <td><i class="far fa-address-card text-orange-m3"></i></td>
                    <td class="text-95 text-default-d3">Tipo de Indentificación:</td>
                    <td class="text-secondary-d2" id="tipo_id"></td>
                </tr>
                <tr>
                    <td><i class="fas fa-info text-secondary-m3"></i></td>
                    <td class="text-95 text-default-d3">No. Identificación:</td>
                    <td class="text-secondary-d2" id="nom_id"></td>
                </tr>
                </table>
            </div>
       </div>
     </div>
   </div>  
 </div> <!-- /PASO 1 - DATOS GENERALES  -->

 
<!--PASO 1 - DATOS FISCALES -->
<div class="card border-0">
 <div class="card-header border-0 bg-transparent" id="datosGenerales">
   <h2 class="card-title">
     <a class="accordion-toggle bgc-secondary-l3 rounded-lg d-style" href="#formDatosGenerales" data-toggle="collapse" aria-expanded="true" aria-controls="formDatosGenerales">
       <span class="v-n-collapsed h-100 position-tl border-l-3 brc-secondary-tp2"></span>
       <span class="text-success-m1"><i class="fa fa-angle-right toggle-icon mr-1"></i>Datos Fiscales</span>
     </a>
   </h2>
 </div>
 <div id="formDatosGenerales" class="collapse show" aria-labelledby="datosGenerales" data-parent="#paso1Acordeon">
     <div class="card-body text-grey-d3">
       <div class="form-group " style="margin:0px; padding:0px;">
            <div class="bgc-white px-1 bo1rder-1 brc-secondary-l2 radius-1">
                <table class="table table table-striped-info table-borderless">
                <tr>
                    <td><i class="fa fa-user text-success-l1"></i></td>
                    <td class="text-95 text-default-d3">Domicilio Fiscal</td>
                    <td class="text-secondary-d2" id="dom_fiscal"></td>
                </tr>
                <tr>
                    <td><i class="fa fa-envelope text-blue-m3"></i></td>
                    <td class="text-95 text-default-d3">Email Facturaci&oacute;n:</td>
                    <td class="text-secondary-d2 text-wrap" id="email_fact"></td>
                </tr>
               
                </table>
            </div>
       </div>
     </div>
   </div>  
 </div> <!-- /PASO 1 - DATOS GENERALES  -->


 <!-- PASO 1 - IDENTIFICACIONES  -->
 <div class="card border-0">
   <div class="card-header border-0 bg-transparent" id="identificaciones">
     <h2 class="card-title">
       <a class="accordion-toggle bgc-secondary-l3 collapsed rounded-lg d-style" href="#formIdentificaciones" data-toggle="collapse" aria-expanded="false" aria-controls="formIdentificaciones">
          <span class="v-n-collapsed h-100 position-tl border-l-3 brc-secondary-tp2" ></span>
          <span class="text-success-m1"><i class="fa fa-angle-right toggle-icon mr-1"></i>Datos Del Cr&eacute;dito</span>
       </a>
     </h2>
   </div>
   <div id="formIdentificaciones" class="collapse" aria-labelledby="identificaciones" data-parent="#paso1Acordeon">
     <div class="card-body text-grey-d3">
       <div class="form-group " style="margin:0px; padding:0px;">


       <div class="bgc-white px-1 bo1rder-1 brc-secondary-l2 radius-1">
                <table class="table table table-striped-info table-borderless">
                <tr>
                    <td><i class="far fa-sticky-note text-success-l1"></i></td>
                    <td class="text-95 text-default-d3">Nombre de Producto:</td>
                    <td class="text-secondary-d2" id="nom_producto"></td>
                </tr>
                <tr>
                    <td><i class="fas fa-paperclip text-blue-m3"></i></td>
                    <td class="text-95 text-default-d3">Monto Solicitado:</td>
                    <td class="text-secondary-d2 text-wrap" id="monto"></td>
                </tr>
 
                </table>
            </div>
       </div>
     </div> <!-- / card-body -->
   </div> <!-- / id="formIdentificaciones" class="collapse" -->
 </div> <!-- /PASO 1 - IDENTIFICACIONES  -->

  <!-- PASO 1 - IDENTIFICACIONES  -->
  <div class="card border-0">
   <div class="card-header border-0 bg-transparent" id="identificaciones">
     <h2 class="card-title">
       <a class="accordion-toggle bgc-secondary-l3 collapsed rounded-lg d-style" href="#formIdentificaciones" data-toggle="collapse" aria-expanded="false" aria-controls="formIdentificaciones">
          <span class="v-n-collapsed h-100 position-tl border-l-3 brc-secondary-tp2" ></span>
          <span class="text-success-m1"><i class="fa fa-angle-right toggle-icon mr-1"></i>Información de Pagos</span>
       </a>
     </h2>
   </div>
   <div id="formIdentificaciones" class="collapse" aria-labelledby="identificaciones" data-parent="#paso1Acordeon">
     <div class="card-body text-grey-d3">
       <div class="form-group " style="margin:0px; padding:0px;">


       <div class="bgc-white px-1 bo1rder-1 brc-secondary-l2 radius-1">
                <table class="table table-striped table-bordered" id="table_pagos">
                <thead class="text-dark-m3 bgc-grey-l4 text-uppercase text-85" >
                    <tr style="font-size: 10px;">
                        
                        <th class="border-0">No. de Pago</th>
                        <th class="border-0">Pago</th>
                        <th class="border-0">Fecha de Pago</th>
                        <th class="border-0">Interes</th>
                        <th class="border-0">IVA</th>
                        <th class="border-0">Subtotal</th>
                        <th class="border-0">Total</th>
            
                    </tr>
                </thead>
                <tbody style="font-size: 10px;" class="" id="body_table">

                </tbody>
                <tfoot id="footer_table">
                <tr>
                    <td class="text-95 text-default-d3">Total:</td>
                    <td class="text-secondary-d2" id="total_pago"></td>
                    <td class="text-secondary-d2" id=""></td>
                    <td class="text-secondary-d2" id="total_interes"></td>
                    <td class="text-secondary-d2" id="total_iva"></td>
                    <td class="text-secondary-d2" id="total_monto"></td>
                    <td class="text-secondary-d2" id="total_amort"></td>
                </tr>

                </tfoot>
          
     
 
                </table>
            </div>
       </div>
     </div> <!-- / card-body -->
   </div> <!-- / id="formIdentificaciones" class="collapse" -->
 </div> <!-- /PASO 1 - IDENTIFICACIONES  -->






</div>


                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" id="cerrar" onclick="miModuloFacturacion.cerrar()">Cerrar</button>
                            </div>

                        </div>
                    </div>
                </div>
          
                    
            </div> <!-- / class="collapse" -->
        </div> <!-- / Card Garantias -->
</div> <!-- /PRINCIPAL-->    