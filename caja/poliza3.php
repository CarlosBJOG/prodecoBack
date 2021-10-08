<?php
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    require_once "../php/security.php";
    require_once "../php/header_caja.php";
    require_once "../php/functions.php";
    require_once "../php/db.php";
    
    create_header();
    create_menu();
    begin_containers();

    ?>


<!-- MAIN CONTAINER --> 
<div class="page-content container container-plus px-md-4 px-xl-5">
    <div class="row justify-content-around">
     <!--   <div class="col-12">-->
        <div class="col-sm-12 col-lg-3 my-1 my-lg-0 px-sm-1 px-lg-0">
            <figure class="mx-auto text-center">
              <img src="../styles/ilustracion-cartera.png" width="200">
            </figure>
            <h1 class="text-grey-d2 pb-0 mb-3 mb-md-0 text-center">
             Caja
            </h1>
            <hr>
            
        </div>
    </div> <!-- row 1-->
 
     <!-- Poliza num 1 -->
    <h2 class="text-grey-d2 pb-0 mb-3 mb-md-0 text-left">
        Poliza de Egreso por Cliente
    </h2>
    <hr>
    <form action="" method="POST">
        <div class="card-body text-grey-d3">
            <!-- primera fila -->
            <div class="form-group row" style="margin:10px; padding-left:80px;">

                <div class="col-sm-12 col-md-4 col-lg-3" style="margin-bottom: 12px; margin-top: 0px;">
                    <label class="col-form-label form-control-label text-success-d1 text-100" style="margin-top: 0px;">Poliza de Egreso</label>
                    <select name="sexo" id="sexo" class="form-control form-control-sm">
                
                    </select> 
                </div> 
                
                <div class="col-sm-12 col-md-4 col-lg-3">
                    <label class="col-form-label form-control-label text-success-d1 text-100">Folio</label>
                    <input class="form-control form-control-sm" type="text" value="" id="mes" name="mes">
                </div>

                <div class="col-sm-12 col-md-4 col-lg-3" style="margin-bottom: 12px; margin-top: 0px;">
                    <label class="col-form-label form-control-label mt-0 text-success-d1 text-100" for="nacimiento">Fecha</label>
                    <div class="input-group date" id="id-timepicker">
                        <div class="input-group-addon input-group-append">
                            <div class="input-group-text">
                                <i class="fa fa-calendar"></i>
                            </div>
                        </div>
                        <input type="date" name="nacimiento" class="form-control form-control-sm" id="nacimiento" autocomplete="off">
                    </div>
                </div>

                <div class="col-sm-12 col-md-4 col-lg-2">
                    <label class="col-form-label form-control-label text-success-d1 text-100">Periodo</label>
                    <input class="form-control form-control-sm" type="text" value="" placeholder="Ej. 1" id="mes" name="mes">
                </div>

            </div>

            <!-- segunda fila -->
            <div class="form-group row" style="margin:10px; padding-left:80px;">
            
                <div class="col-sm-12 col-md-3 col-lg-4">
                    <label class="col-form-label text-success-d1 text-100">Vincular poliza de diario</label>
                    
                    <select name="sexo" id="sexo" class="form-control form-control-sm">
                        <option value="value1" selected>...</option>
                    </select> 
                </div>
                <div class="col-sm-12 col-md-3 col-lg-4">
                    <label class="col-form-label text-success-d1 text-100">Monto</label>
                    
                    <input class="form-control form-control-sm" type="number" value=""  id="monto" placeholder="$1 000.00" name="monto" >
                </div>

                <div class="col-sm-12 col-md-3 col-lg-3 ">
                    <label class="col-form-label form-control-label text-success-d1 text-100 ">Nombre del Solicitante</label>
                    <input class="form-control form-control-sm" type="nombre_solicitante" value=""  id="nombre_solicitante" 
                    placeholder="Ej. Maria Lopez (supervisor)" name="monto" onblur="this.value=this.value.toUpperCase();">
                </div>

            </div>

            <hr />
       
            <div class="mt-4 mt-lg-2 col-lg-11 col-lg-4 " style="margin:10px; padding-left:80px;">
                <h3 class="text-grey-d2 pb-0 mb-3 mb-md-0 text-left">
                    Datos del cliente
                </h3>
                <hr />
                <!-- datos del cliente -->
                <div class="form-group row" style="margin:10px; padding-left:80px;">

                    <div class="col-sm-12 col-md-3 col-lg-4 ">
                        <label class="col-form-label form-control-label text-success-d1 text-100 ">Nombre del Cliente</label>
                        <input class="form-control form-control-sm" type="nombre_solicitante" value=""  id="nombre_solicitante" 
                        placeholder="Ej. Jorge Armando Lopez" name="monto" >
                    </div>

                    <div class="col-sm-12 col-md-3 col-lg-7 ">
                        <label class="col-form-label form-control-label text-success-d1 text-100 ">Direccion principal (cliente)</label>
                        <textarea class="form-control form-control-sm" type="nombre_solicitante" value=""  id="nombre_solicitante" 
                        placeholder="Ej. Maria Lopez (supervisor)" name="monto" style="resize: none;"> </textarea>
                    </div>

                  
                    <h5 class="text-grey-d2 pb-0 mb-3 mb-md-0 text-left">
                        Datos de credito
                    </h5>
                    
                </div>
                <hr />

                   <!-- datos del credito -->
                <div class="form-group row" style="margin:10px; padding-left:80px;">

                    <div class="col-sm-12 col-md-3 col-lg-4 ">
                        <label class="col-form-label form-control-label text-success-d1 text-100 ">Tipo de producto</label>
                        <input class="form-control form-control-sm" type="nombre_solicitante" value=""  id="nombre_solicitante" 
                         name="monto" >
                    </div>

                    <div class="col-sm-12 col-md-3 col-lg-4 ">
                        <label class="col-form-label form-control-label text-success-d1 text-100 ">Monto solicitado</label>
                        <input class="form-control form-control-sm" type="nombre_solicitante" value=""  id="nombre_solicitante" 
                         name="monto" >
                    </div>

                    <div class="col-sm-12 col-md-3 col-lg-4 ">
                        <label class="col-form-label form-control-label text-success-d1 text-100 ">Frecuencia de pago</label>
                        <input class="form-control form-control-sm" type="nombre_solicitante" value=""  id="nombre_solicitante" 
                         name="monto" >
                    </div>

                    <div class="col-sm-12 col-md-3 col-lg-4 ">
                        <label class="col-form-label form-control-label text-success-d1 text-100 ">Interes</label>
                        <input class="form-control form-control-sm" type="nombre_solicitante" value=""  id="nombre_solicitante" 
                         name="monto" >
                    </div>

                    <div class="col-sm-12 col-md-3 col-lg-4 ">
                        <label class="col-form-label form-control-label text-success-d1 text-100 ">Plazo </label>
                        <input class="form-control form-control-sm" type="nombre_solicitante" value=""  id="nombre_solicitante" 
                         name="monto" >
                    </div>

                </div>

                
                <hr />

            <div class="form-group row" style="margin:10px; padding-left:80px;">
            
                <div class="col-sm-12 col-md-3 col-lg-4">
                    <label class="col-form-label text-success-d1 text-100">Seleccionar cuenta contable</label>
                    
                    <select name="sexo" id="sexo" class="form-control form-control-sm">
                        <option value="value1" selected>...</option>
                    </select> 
                </div>

                <div class="col-sm-12 col-md-3 col-lg-4">
                    <label class="col-form-label text-success-d1 text-100">Tipo de pago</label>
                    
                    <select name="sexo" id="sexo" class="form-control form-control-sm">
                        <option value="value1" selected>...</option>
                        <option value="cheque" >Cheque</option>
                        <option value="transferencia">Transferencia</option>
                        <option value="efectivo">Efectivo</option>
                        <option value="efectivo">Deposito</option>
                    </select> 
                </div>


            </div>
            <h3 class="text-grey-d2 pb-0 mb-3 mb-md-0 text-left">
               Tabla de amortizacion
            </h3>
            
            <div class="col-sm-12 col-md-4 col-lg-3" style="margin-bottom: 12px; margin-top: 0px;">
                <label class="col-form-label form-control-label mt-0 text-success-d1 text-100" for="nacimiento">Fecha de primer pago</label>
                <input class="form-control form-control-sm" type="nombre_solicitante" value=""  id="nombre_solicitante" 
                        placeholder="01/01/2020" name="monto" >
            </div>
            <hr />
                    <hr class="d-lg-none" />
                    <div>
                    <table class="table table-striped-success table-borderless text-dark-m1"  id="responsive-table">
                        <thead>
                            <tr class="bgc-success-m1 text-white">
                                <th>Fecha de pagos</th>
                                <th>Interes</th>
                                <th>IVA</th>
                                <th>Capital</th>
                                <th>Total</th>
                                <th>Saldo insoluto</th>
                                <th>Cancelar/Activo</th>
                            </tr>
                        </thead>

                        <tbody class="bgc-success-m1">
                            <?php for($i=0; $i<2; $i++){?>
                            <tr>
                                <td>04/04/2020</td>
                                <td>$ 32.02</td>
                                <td>$ 232.58</td>
                                <td>$ 400</td>
                                <td>$ 432.58</td>
                                <td>$ 5500</td>
                                <td>
                                    <div>
                                    <button class="btn btn-danger radius-2 border-b-0 pl-1 " >
                                        <i class="w-4 h-4 bgc-black-tp9 radius-round fa fa-times text-white-tp2 mr-1 align-middle pt-2"></i>
                                        <span class="text-105 align-middle"></span>
                                    </button>

                                    <button class="btn btn-success  radius-1 border-b-2 d-inline-flex align-items-center pl-2px py-2px btn-bold">
                                        <span class="bgc-white-tp9 shadow-sm radius-2px h-4 px-25 pt-1 mr-25 border-1">
                                        <i class="fa fa-check text-white-tp2 text-110 mt-3px"></i>
                                    </span>
                                      
                                    </button>
                                    </div>
                                  
                                </td>
                            </tr>
                            <?php }?>
                        
                        </tbody>

                        <tfoot class="bgc-success-m1">


                        </tfoot>
                    </table>

                    </div>
                </div>

                <div class="col-12">
                    <hr class="border-double" />
                    <div class="form-group col-md-3 offset-md-8 mt-2">
                        <button type="button" class="btn btn-warning btn-block btn-md btn-bold mt-2 mb-3 radius-2" data-toggle="modal" data-target="#exampleModal">
                            Aceptar
                        </button>
                    </div>
                </div>

        </div>
    
    </form>

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Confirmacion</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p> <h5 class="text-grey-d2 pb-0 mb-3 mb-md-0 text-left">El dinero sera ingresado a boveda </h5></p>
                    
                    <p> <h5 class="text-grey-d2 pb-0 mb-3 mb-md-0 text-left">Cantidad:</h5></p>
                    <br />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary">Guardar cambios</button>
                </div>
            </div>
        </div>
    </div>
 
    



<!-- include common vendor scripts used in demo pages -->
        <script type="text/javascript" src="../ace-admin/node_modules/jquery/dist/jquery.js"></script>
        <script type="text/javascript" src="../ace-admin/node_modules/popper.js/dist/umd/popper.js"></script>
        <script type="text/javascript" src="../ace-admin/node_modules/bootstrap/dist/js/bootstrap.js"></script>

        <!-- include vendor scripts used in "DataTables" page. see "application/views/default/pages/partials/table-datatables/@vendor-scripts.hbs" -->
        <script type="text/javascript" src="../ace-admin/node_modules/datatables/media/js/jquery.dataTables.js"></script>
        <script type="text/javascript" src="../ace-admin/node_modules/datatables.net-bs4/js/dataTables.bootstrap4.js"></script>
        <script type="text/javascript" src="../ace-admin/node_modules/datatables.net-colreorder/js/dataTables.colReorder.js"></script>
        <script type="text/javascript" src="../ace-admin/node_modules/datatables.net-select/js/dataTables.select.js"></script>


        <script type="text/javascript" src="../ace-admin/node_modules/datatables.net-buttons/js/dataTables.buttons.js"></script>
        <script type="text/javascript" src="../ace-admin/node_modules/datatables.net-buttons-bs4/js/buttons.bootstrap4.js"></script>
        <script type="text/javascript" src="../ace-admin/node_modules/datatables.net-buttons/js/buttons.html5.js"></script>
        <script type="text/javascript" src="../ace-admin/node_modules/datatables.net-buttons/js/buttons.print.js"></script>
        <script type="text/javascript" src="../ace-admin/node_modules/datatables.net-buttons/js/buttons.colVis.js"></script>

        <script type="text/javascript" src="../ace-admin/node_modules/select2/dist/js/select2.js"></script>
        <script type="text/javascript" src="../ace-admin/node_modules/chosen-js/chosen.jquery.js"></script>
        <!-- include Ace script -->
        <script type="text/javascript" src="../ace-admin/dist/js/ace.js"></script>


        <script type="text/javascript" src="../ace-admin/assets/js/demo.js"></script>
        <!-- this is only for Ace's demo and you don't need it -->

        <!-- "DataTables" page script to enable its demo functionality -->
        <script type="text/javascript" src="../ace-admin/application/views/default/pages/partials/table-datatables/@page-script.js"></script>
        <!-- "Horizontal Menu" page script to enable its demo functionality -->
        <script type="text/javascript" src="../ace-admin/application/views/default/pages/partials/horizontal-menu/@page-script.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

  <?php
    create_footer();
    ?>
</div><!-- /.body-container -->

</body>
</html>
