<?php
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    require_once "../php/security.php";
    require_once "../php/header_contabilidad.php";
    require_once "../php/functions.php";
    require_once "../php/db.php";
    
    create_header();
    create_menu();
    
    
    ?>


<!-- MAIN CONTAINER --> 
<div class="page-content container container-plus px-md-4 px-xl-5">
    <div class="row">

                <!--CONTENIDO INVERSION-->
                <div class="text-95 px-3 px-md-2">
                    <h4 class="text-secondary-d1 text-120 mb-1 text-orange-d2 b-underline-4 mt-2 px-lg-0">Consulta</h4>
                </div>
                <!--/CONTENIDO INVERSION-->


        <!--MODAL Razón estatus-->
        <div class="modal fade" id="razonModal" tabindex="-1" role="dialog" aria-labelledby="razonModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content border-width-0 px-3">
                    <div class="modal-header">
                        <p class="modal-title text-warning-d1 text-120 text-center mt-2" id="razonModalLabel">Movimientos a polizas</p>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-4 pl-0">
                            <label class="col-form-label form-control-label text-secondary text-90">Cuenta</label>
                            <input type="text" class="form-control form-control-sm">
                            </div>
                            <div class="col-8 pr-0">
                                <label class="col-form-label form-control-label text-secondary text-90">Seleccionar cuenta</label>
                                <select name="tipo" id="tipo-poliza" class="form-control chosen-select form-control-sm">
                                <option value=""></option>
                                <option>11 DOCUMENTOS</option>
                                <option>110201020102 BANORTE CTA 0839599043</option>
                                <option>11 DOCUMENTOS</option>
                                <option>110201020102 BANORTE CTA 0839599043</option>
                                <option>11 DOCUMENTOS</option>
                                <option>110201020102 BANORTE CTA 0839599043</option>
                                <option>11 DOCUMENTOS</option>
                                <option>110201020102 BANORTE CTA 0839599043</option>
                                <option>11 DOCUMENTOS</option>
                                <option>110201020102 BANORTE CTA 0839599043</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                            <label class="col-form-label form-control-label text-secondary text-90">Referencia</label>
                            <input type="text" class="form-control form-control-sm">
                            </div>
                            <div class="col-4">
                            <label class="col-form-label form-control-label text-secondary text-90">Debe</label>
                            <input type="text" class="form-control form-control-sm">
                            </div>
                            <div class="col-4">
                            <label class="col-form-label form-control-label text-secondary text-90">Haber</label>
                            <input type="text" class="form-control form-control-sm">
                            </div>
                            <div class="col-12">
                            <label class="col-form-label form-control-label text-secondary text-90">Descripción</label>
                            <input type="text" class="form-control form-control-sm">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-white justify-content-between px-0 py-3">
                        <button type="button" class="btn btn-sm px-2 px-md-4 btn-light-secondary btn-h-light-warning">
                        <i class="fa fa-trash-o mr-1 text-danger-m2"></i> Borrar</button>
                        <button type="button" class="btn btn-sm px-2 px-md-4 btn-light-secondary btn-h-light-success">
                        <i class="fa fa-check mr-1 text-success"></i> Aceptar </button>
                        <button type="button" class="btn btn-sm px-2 px-md-4 btn-light-secondary btn-h-light-success" data-dismiss="modal">           
                        <i class="fa fa-times ml-1 text-success-m2"></i> Cerrar</button>
                    </div> <!--modal footer-->
                </div>
            </div>
        </div>
        <!--/MODAL Razón estatus-->

        <!--MODAL XML-->
        <div class="modal fade" id="xmlModal" tabindex="-1" role="dialog" aria-labelledby="xmlModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content border-width-0 px-3">
                    <div class="modal-header py-2">
                    <p class="modal-title text-warning-d1 text-120 text-center mt-2" id="xmlModalLabel">XML Poliza</p>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="col-12">
                            <label class="ace-file-input">
                                <input type="file" class="ace-file-input" id="ace-file-input1" autocomplete="off">
                                <div class="ace-file-container d-flex flex-column border-1 brc-grey-l2 brc-h-warning-m1">
                                <div class="ace-file-placeholder h-100">
                                <span class="ace-file-icon align-self-center mx-2px">
                                <i class="fa fa-upload bgc-grey-m1 text-white w-4 py-2 text-center"></i></span>
                                <span class="ace-file-name text-grey-m2 px-1">Ningún archivo seleccionado</span>
                                <span class="ace-file-btn ml-auto bgc-success text-white px-2 pt-2 text-90 my-1px mr-1px">Adjuntar XML</span>
                                </div>
                                </div>
                                <a title="" class="remove position-rc text-danger mr-n25 w-3 radius-2 border-1 brc-h-danger-m4 text-center" href="#">
                                <i class="fa fa-times"></i></a>
                            </label>
                            <table class="table table-responsive-md table-bordered table-hover text-dark-m1">
                                <thead>
                                <tr class="bgc-secondary-l3">
                                    <th>PolizaID</th>
                                    <th>XML</th>
                                    <th>ID</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td> </td> <td> </td> <td> </td>
                                </tr>
                                <tr>
                                    <td> </td> <td> </td> <td> </td>
                                </tr>                                
                                <tr>
                                    <td> </td> <td> </td> <td> </td>
                                </tr>                                
                                <tr>
                                    <td> </td> <td> </td> <td> </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer bg-white justify-content-between px-0 py-3">
                        <button type="button" class="btn btn-sm px-2 px-md-4 btn-light-secondary btn-h-light-success" data-dismiss="modal">           
                        <i class="fa fa-times ml-1 text-success-m2"></i> Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <!--/MODAL XML-->


    </div> <!-- / row-->
</div><!-- /.page-content -->
<?php end_containers(); ?>


<!-- include common vendor scripts used in demo pages -->
        <script type="text/javascript" src="./ace-admin/node_modules/jquery/dist/jquery.js"></script>
        <script type="text/javascript" src="./ace-admin/node_modules/popper.js/dist/umd/popper.js"></script>
        <script type="text/javascript" src="./ace-admin/node_modules/bootstrap/dist/js/bootstrap.js"></script>

        <!-- include vendor scripts used in "DataTables" page. see "application/views/default/pages/partials/table-datatables/@vendor-scripts.hbs" -->
        <script type="text/javascript" src="./ace-admin/node_modules/datatables/media/js/jquery.dataTables.js"></script>
        <script type="text/javascript" src="./ace-admin/node_modules/datatables.net-bs4/js/dataTables.bootstrap4.js"></script>
        <script type="text/javascript" src="./ace-admin/node_modules/datatables.net-colreorder/js/dataTables.colReorder.js"></script>
        <script type="text/javascript" src="./ace-admin/node_modules/datatables.net-select/js/dataTables.select.js"></script>


        <script type="text/javascript" src="./ace-admin/node_modules/datatables.net-buttons/js/dataTables.buttons.js"></script>
        <script type="text/javascript" src="./ace-admin/node_modules/datatables.net-buttons-bs4/js/buttons.bootstrap4.js"></script>
        <script type="text/javascript" src="./ace-admin/node_modules/datatables.net-buttons/js/buttons.html5.js"></script>
        <script type="text/javascript" src="./ace-admin/node_modules/datatables.net-buttons/js/buttons.print.js"></script>
        <script type="text/javascript" src="./ace-admin/node_modules/datatables.net-buttons/js/buttons.colVis.js"></script>

        <script type="text/javascript" src="./ace-admin/node_modules/select2/dist/js/select2.js"></script>
        <script type="text/javascript" src="./ace-admin/node_modules/chosen-js/chosen.jquery.js"></script>
        <!-- include Ace script -->
        <script type="text/javascript" src="./ace-admin/dist/js/ace.js"></script>


        <script type="text/javascript" src="./ace-admin/assets/js/demo.js"></script>
        <!-- this is only for Ace's demo and you don't need it -->

        <!-- "DataTables" page script to enable its demo functionality -->
        <script type="text/javascript" src="./ace-admin/application/views/default/pages/partials/table-datatables/@page-script.js"></script>
        <!-- "Horizontal Menu" page script to enable its demo functionality -->
        <script type="text/javascript" src="./ace-admin/application/views/default/pages/partials/horizontal-menu/@page-script.js"></script>
    </div><!-- /.body-container -->
  </body>




<?php
    require_once "../php/security.php";
    require_once "../php/header_contabilidad.php";
    create_footer_forms();
    ?>
</div>
</body>
</html>
