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
                <div class="text-95 px-3 px-md-2" id="caja">
                    <ul class="nav mb-1 text-secondary-d2 text-100">
                        <li class="nav-item"><a class="nav-link text-secondary" href="#">Movimientos</a></li>
                        <li class="nav-item"><a class="nav-link text-secondary" href="#">Consulta</a></li>
                        <li class="nav-item"><a class="nav-link text-secondary" href="#">Depósito</a></li>
                        <li class="nav-item"><a class="nav-link text-secondary" href="#">Retiro</a></li>
                        <li class="nav-item"><a class="nav-link text-secondary" href="#">Abono</a></li>
                        <li class="nav-item"><a class="nav-link text-secondary" href="#">Total</a></li>
                        <li class="nav-item"><a class="nav-link text-secondary" href="#">Sim...</a></li>
                        <li class="nav-item"><a class="nav-link text-secondary" href="#">Amortización</a></li>
                        <li class="nav-item"><a class="nav-link text-secondary" href="#">Reimpresión</a></li>
                        <li class="nav-item"><a class="nav-link text-secondary" href="#">Cancelar</a></li>
                        <li class="nav-item"><a class="nav-link text-secondary" href="#">Salir</a></li>
                        <li class="nav-item">
                        <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Fecha: 30/07/2020</a>
                        </li>
                    </ul>
                    <hr>

                    <form>
                    <div class="row">
                        <div class="col-md-1">
                            <label class="col-form-label form-control-label text-secondary text-100">Cliente</label>
                        </div>
                        <div class="col-md-2">
                            <input type="number" class="form-control form-control-sm">
                        </div>
                        <div class="d-inline-flex ml-sm-0 pos-rel mt-2 mt-md-0">
                        <i class="fa fa-search text-grey position-lc ml-2"></i>
                        <input type="text" class="form-control form-control-sm pl-425" placeholder="Buscar">
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control form-control-sm">
                        </div>
                        <div class="col-md-1">
                            <label class="col-form-label form-control-label text-secondary text-100">Folio:</label>
                        </div>
                        <div class="col-md-2">
                            <input type="number" class="form-control form-control-sm">
                        </div>
                    </div> 
                    <div class="row mt-3">
                        <div class="col-lg-6 col-sm-12 table-responsive">
                            <table class="table table-bordered table-hover text-dark-m1">
                                <thead>
                                <tr class="bgc-secondary-l3"> 
                                    <th>Referencia</th>
                                    <th>Fecha</th>
                                    <th>Monto</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                </tr>
                                <tr>
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                </tr>
                                <tr>
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-lg-6 col-sm-12 table-responsive">
                            <table class="table table-bordered table-hover text-dark-m1">
                                <thead>
                                <tr class="bgc-secondary-l3"> 
                                    <th>Concepto</th>
                                    <th>Saldo</th>
                                    <th> --?-- </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                </tr>
                                <tr>
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                </tr>
                                <tr>
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div> 

                <div class="row bgc-secondary-l4 p-4">
                    <div class="col-lg-4 col-sm-12 border-0 border-r-1 radius-0 brc-grey-l2">
                        <table class="table table-responsive table-borderless table-sm">
                            <tr>
                                <td><label class="col-form-label form-control-label text-secondary text-100">Saldo Prestamo:</label></td>
                                <td><input type="text" class="form-control form-control-sm" id="saldo_prestamo"></td>
                            </tr>
                            <tr>
                                <td><label class="col-form-label form-control-label text-secondary text-100">Saldo nuevo:</label></td>
                                <td><input type="text" class="form-control form-control-sm" id="saldo_nuevo"></td>
                            </tr>
                            <tr>
                                <td><label class="col-form-label form-control-label text-secondary text-100">Tasa de interes:</label></td>
                                <td><input type="text" class="form-control form-control-sm" id="tasa-interes"></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td><input type="text" class="form-control form-control-sm" id="tasa-interes2"></td>
                            </tr>

                            <tr>
                                <td><label class="col-form-label form-control-label text-secondary text-100">Monto vencido:</label></td>
                                <td><input type="text" class="form-control form-control-sm" id="monto_vencido"></td>
                            </tr>
                            <tr>
                                <td><label class="col-form-label form-control-label text-secondary text-100">Días Int.:</label></td>
                                <td><input type="text" class="form-control form-control-sm" id="dias_int"></td>
                            </tr>
                            <tr>
                                <td><label class="col-form-label form-control-label text-secondary text-100">Capital:</label></td>
                                <td><input type="text" class="form-control form-control-sm" id="capital"></td>
                            </tr>
                            <tr>
                                <td><label class="col-form-label form-control-label text-secondary text-100">Interes:</label></td>
                                <td><input type="text" class="form-control form-control-sm" id="interes"></td>
                            </tr>
                            <tr>
                                <td><label class="col-form-label form-control-label text-secondary text-100">Moratorio:</label></td>
                                <td><input type="text" class="form-control form-control-sm" id="moratorio"></td>
                            </tr>
                            <tr>
                                <td><label class="col-form-label form-control-label text-secondary text-100">IVA Interes:</label></td>
                                <td><input type="text" class="form-control form-control-sm" id="iva_interes"></td>
                            </tr>
                            <tr>
                                <td><label class="col-form-label form-control-label text-secondary text-100">Comisiones:</label></td>
                                <td><input type="text" class="form-control form-control-sm" id="comisiones"></td>
                            </tr>
                            <tr>
                                <td><label class="col-form-label form-control-label text-secondary text-100">Seguro:</label></td>
                                <td><input type="text" class="form-control form-control-sm" id="seguro"></td>
                            </tr>
                            <tr>
                                <td><label class="col-form-label form-control-label text-secondary text-100">Ahorro:</label></td>
                                <td><input type="text" class="form-control form-control-sm" id="Ahorro"></td>
                            </tr>
                            <tr>
                                <td><label class="col-form-label form-control-label text-secondary text-100">Gastos Cobranza:</label></td>
                                <td><input type="text" class="form-control form-control-sm" id="gastos_cobranza"></td>
                            </tr>
                            <tr>
                                <td><label class="col-form-label form-control-label text-secondary text-100">IVA Gastos:</label></td>
                                <td><input type="text" class="form-control form-control-sm" id="iva_gastos"></td>
                            </tr>
                            <tr>
                                <td><label class="col-form-label form-control-label text-secondary text-100">Total:</label></td>
                                <td><input type="text" class="form-control form-control-sm" id="total"></td>
                            </tr>
                        </table>
                        <button type="button" class="btn btn-success btn-sm align-items-right">Registrar</button>
                    </div>

                    <div class="col-lg-8 col-sm-12 table-responsive pl-5">
                        <table class="table table-bordered table-hover text-dark-m1">
                            <thead>
                            <tr class="bgc-secondary-l3"> 
                                <th width="10%">TM</th>
                                <th>Concepto</th>
                                <th>Depósito</th>
                                <th>Retiro</th>
                                <th>--?--</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                </tr>
                                <tr>
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                </tr>
                                <tr>
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                </tr>
                            </tbody>
                        </table>

                        <h4 class="text-secondary-d1 text-120 ml-1 text-orange-d2 b-underline-4 mb-4 mt-3">Totales Depósitos Retiros</h4>
                        <p class="text-right">
                        <button class="btn btn-success mb-2px mr-3"><i class="fa fa-search mr-1"></i> Verificar huella</button>
                        <button class="btn btn-success mb-2px"><i class="fa fa-search mr-1"></i> Historial huella</button>
                        </p>
                        <hr class="mt-5">
                        <table class="table table-responsive table-borderless table-sm mt-5">
                            <tr>
                                <td><label class="col-form-label form-control-label text-secondary text-100">Depósitos del mes para IDE:</label></td>
                                <td><input type="text" class="form-control form-control-sm" id="depositos_ide"></td>
                            </tr>
                            <tr>
                                <td><label class="col-form-label form-control-label text-secondary text-100">Depósitos:</label></td>
                                <td><input type="text" class="form-control form-control-sm" id="deposito"></td>
                            </tr>
                            <tr>
                                <td><label class="col-form-label form-control-label text-secondary text-100">Retiros:</label></td>
                                <td><input type="text" class="form-control form-control-sm" id="retiros"></td>
                            </tr>
                          
                            <tr>
                                <td><label class="col-form-label form-control-label text-secondary text-100">Total:</label></td>
                                <td><input type="text" class="form-control form-control-sm" id="total2"></td>
                            </tr>
                        </table>

                        <p class="mt-5">
                        <button class="btn btn-sm btn-success mb-2px mr-3"><i class="fa fa-check mr-1"></i> Foto y firma</button>
                        <button class="btn btn-sm btn-success mb-2px"><i class="fa fa-check mr-1"></i> Fecha de cálculo</button>
                        </p>
                    </div>
                </div>
                </form>
                </div>


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
