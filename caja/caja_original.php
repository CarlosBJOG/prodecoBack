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
            <p class="text-100 text-secondary text-center">Módulo de operaciones de ingreso y egreso de capital</p>
        </div>
        <div class="col-lg-8 col-md-12">
        <h4 class="text-secondary-d1 text-120 ml-1 text-orange-d2 b-underline-4 mb-5 mt-3">Pagos en efectivo</h4>

        



            <table class="table table-responsive table-borderless table-sm mt-5">
                <tr>
                    <td width="20%"><label class="col-form-label form-control-label text-secondary text-100">Búsqueda de Crédito</label></td>
                    <td width="30%">
                        <input type="text" class="form-control form-control-sm pl-425" placeholder="Buscar" id="busqueda" onkeyup="buscar_credito()" oninput="cargar_credito()" list="creditos">
                        <datalist id="creditos">
                        </datalist>
                    </td>
                </tr>
                <tr>
                    <td><label class="col-form-label form-control-label text-secondary text-100">Tipo de pago</label></td>
                    <td>
                        <select name="tipo" id="tipo-poliza" class="form-control form-control-sm">
                            <option>Parcial</option>
                            <option>Completo</option>
                            <option>...</option>
                            <option>...</option>
                        </select>
                    </td>
                </tr>
            </table>
        </div>
    </div> <!-- row 1-->
        <form>
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
                    
                </div>

                <div class="col-lg-8 col-sm-12 table-responsive pl-5">
                    <h4 class="text-secondary-d1 text-120 ml-1 text-orange-d2 b-underline-4 mb-4 mt-3">Registro de efectivo por denominación</h4>

                    <div class="row">
                        <div class="col-lg-6 col-sm-12">
                        <p class="font-bold">Entrada</p>
                        <table class="table table-responsive table-borderless table-sm">
                            <tr>
                            <td><label class="col-form-label form-control-label text-secondary">$1,000</label></td>
                            <td><input type="number" class="form-control form-control-sm" id="denominacion"></td>
                            </tr>
                            <tr>
                            <td><label class="col-form-label form-control-label text-secondary">$500</label></td>
                            <td><input type="number" class="form-control form-control-sm" id="denominacion"></td>
                            </tr>
                            <tr>
                            <td><label class="col-form-label form-control-label text-secondary">$200</label></td>
                            <td><input type="number" class="form-control form-control-sm" id="denominacion"></td>
                            </tr>
                            <tr>
                            <td><label class="col-form-label form-control-label text-secondary">$100</label></td>
                            <td><input type="number" class="form-control form-control-sm" id="denominacion"></td>
                            </tr>
                            <tr>
                            <td><label class="col-form-label form-control-label text-secondary">$50</label></td>
                            <td><input type="number" class="form-control form-control-sm" id="denominacion"></td>
                            </tr>
                            <tr>
                            <td><label class="col-form-label form-control-label text-secondary">$20</label></td>
                            <td><input type="number" class="form-control form-control-sm" id="denominacion"></td>
                            </tr>
                            <tr>
                            <td><label class="col-form-label form-control-label text-secondary">$10</label></td>
                            <td><input type="number" class="form-control form-control-sm" id="denominacion"></td>
                            </tr>
                            <tr>
                            <td><label class="col-form-label form-control-label text-secondary">$5</label></td>
                            <td><input type="number" class="form-control form-control-sm" id="denominacion"></td>
                            </tr>
                            <tr>
                            <td><label class="col-form-label form-control-label text-secondary">$2</label></td>
                            <td><input type="number" class="form-control form-control-sm" id="denominacion"></td>
                            </tr>
                            <tr>
                            <td><label class="col-form-label form-control-label text-secondary">$1</label></td>
                            <td><input type="number" class="form-control form-control-sm" id="denominacion"></td>
                            </tr>
                            <tr>
                            <td><label class="col-form-label form-control-label text-secondary">$0.50</label></td>
                            <td><input type="number" class="form-control form-control-sm" id="denominacion"></td>
                            </tr>
                        </table>
                        </div>

                        <div class="col-lg-6 col-sm-12">
                        <p class="font-bold">Cambio / Salida</p>

                        <table class="table table-responsive table-borderless table-sm">
                            <tr>
                            <td><label class="col-form-label form-control-label text-warning">$1,000</label></td>
                            <td><input type="number" class="form-control form-control-sm" id="denominacion"></td>
                            </tr>
                            <tr>
                            <td><label class="col-form-label form-control-label text-warning">$500</label></td>
                            <td><input type="number" class="form-control form-control-sm" id="denominacion"></td>
                            </tr>
                            <tr>
                            <td><label class="col-form-label form-control-label text-warning">$200</label></td>
                            <td><input type="number" class="form-control form-control-sm" id="denominacion"></td>
                            </tr>
                            <tr>
                            <td><label class="col-form-label form-control-label text-warning">$100</label></td>
                            <td><input type="number" class="form-control form-control-sm" id="denominacion"></td>
                            </tr>
                            <tr>
                            <td><label class="col-form-label form-control-label text-warning">$50</label></td>
                            <td><input type="number" class="form-control form-control-sm" id="denominacion"></td>
                            </tr>
                            <tr>
                            <td><label class="col-form-label form-control-label text-warning">$20</label></td>
                            <td><input type="number" class="form-control form-control-sm" id="denominacion"></td>
                            </tr>
                            <tr>
                            <td><label class="col-form-label form-control-label text-warning">$10</label></td>
                            <td><input type="number" class="form-control form-control-sm" id="denominacion"></td>
                            </tr>
                            <tr>
                            <td><label class="col-form-label form-control-label text-warning">$5</label></td>
                            <td><input type="number" class="form-control form-control-sm" id="denominacion"></td>
                            </tr>
                            <tr>
                            <td><label class="col-form-label form-control-label text-warning">$2</label></td>
                            <td><input type="number" class="form-control form-control-sm" id="denominacion"></td>
                            </tr>
                            <tr>
                            <td><label class="col-form-label form-control-label text-warning">$1</label></td>
                            <td><input type="number" class="form-control form-control-sm" id="denominacion"></td>
                            </tr>
                            <tr>
                            <td><label class="col-form-label form-control-label text-warning">$0.50</label></td>
                            <td><input type="number" class="form-control form-control-sm" id="denominacion"></td>
                            </tr>
                        </table>
                        </div>
                        
                    </div>
                    <hr>

                    <p>
                    <button type="button" class="btn btn-success btn-sm align-items-right">Registrar pago</button>
                    <button type="button" class="btn btn-success btn-sm align-items-right">Imprimir comprobante</button>
                    <button type="button" class="btn btn-danger btn-sm align-items-right">Cancelar</button>

                    </p>
                </div>


            </div>
    </form>
    </div>


        <!--MODAL Razón estatus-->
        <div class="modal fade" id="razonModal" tabindex="-1" role="dialog" aria-labelledby="razonModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content border-width-0 px-3">
                    <div class="modal-header py-2">
                    <p class="text-warning-d1 text-120 text-center mt-2">Movimientos a polizas</p>
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
                    <button type="button" class="btn btn-sm px-2 px-md-4 btn-light-secondary btn-h-light-warning btn-a-light-danger" data-dismiss="modal">
                    <i class="fa fa-trash-o mr-1 text-danger-m2"></i> Borrar</button>
                    <button type="button" class="btn btn-sm px-2 px-md-4 btn-light-secondary btn-h-light-success btn-a-light-success" data-dismiss="modal">
                    <i class="fa fa-check mr-1 text-success"></i> Aceptar </button>
                    <button type="button" class="btn btn-sm px-2 px-md-4 btn-light-secondary btn-h-light-success btn-a-light-success" data-dismiss="modal">           
                    <i class="fa fa-times ml-1 text-success-m2"></i> Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <!--/MODAL Razón estatus-->


    </div> <!-- / row-->
</div><!-- /.page-content -->
<?php end_containers(); ?>


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


  <?php
    create_footer();
    ?>
</div><!-- /.body-container -->
<script type="text/javascript">
    function buscar_credito(){
        var busqueda = $("#busqueda").val();

        $.ajax({
            url: "../php/json_func_caja.php",
            data: {funcion: "consultar_creditos_like", busqueda: busqueda},
            type: 'post',
            dataType: "json",
            beforeSend: function () {
                //animación de carga
            },
            success: function (response) {
                console.log(response);
                $("#creditos").html(response['creditos']);
            },
            error: function(data) {
                console.log(data);
            }
        });
    }


     $(document).ready(function() {
        var busqueda = document.getElementById("busqueda");
        busqueda.addEventListener("input", function(e){
            var isInputEvent = (Object.prototype.toString.call(e).indexOf("InputEvent") > -1);
            if(!isInputEvent)
                alert("Selected: " + e.target.value);
            }, false);
    });
</script>
</body>
</html>
