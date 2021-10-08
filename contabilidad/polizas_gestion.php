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

    <?php
    if(isset($_GET["idkey_poliza"]) && isset($_GET["tipo"])){
        //////////
    }
    else{
        $fecha = date('d/m/Y');
        $ejercicio =date('Y');
    }
    ?>

<!-- MAIN CONTAINER --> 
<div class="page-content container container-plus px-md-4 px-xl-5">
    <div class="row">

                <!--CONTENIDO POLIZAS-->
                <form name="polizasForm" id="polizasForm">
                <div class="text-95 px-3 px-md-2">
                    
                    <div class="row form group mt-4">
                    
                        <div class="col-3 ">
                                <figure class="mx-auto text-center">
                                  <img src="../styles/ilustracion-cartera.png" width="300">
                                </figure>
                                <h1 class="text-grey-d2 pb-0 mb-3 mb-md-0 text-center">Contabilidad</h1>
                                 <hr>
                                <p class="text-100 text-secondary text-center">
                                 <!-- -->
                                </p>
                          </div>

                       <div class="col-9 col-lg-9" >
                        <div class="card px-3 border-1 brc-secondary-l1 radius-3px bgc-grey-l5 pb-5">
                            <p class="font-bold pt-3 text-success">Identificación de póliza</p>
                            <div class="row">
                                <div class="col-md-2">
                                <label class="col-form-label form-control-label text-secondary text-100">Fecha</label>
                                <input type="text" id="fecha" name="fecha" class="form-control form-control-sm" readonly value="<?php echo $fecha; ?>">
                                </div>
                                <div class="col-md-3">
                                    <label class="col-form-label form-control-label text-secondary text-100">Tipo:</label>
                                    <select name="tipo" id="tipo" class="form-control form-control-sm" required>
                                    <option value="1">Diario</option>
                                    <option value="2">Ingreso</option>
                                    <option value="3">Egreso</option>
                                    <option value="4">Orden</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                <label class="col-form-label form-control-label text-secondary text-100">Ejercicio</label>
                                <input type="number" class="form-control form-control-sm" value="<?php echo $ejercicio; ?>" readonly >
                                </div>
                                <div class="col-md-2">
                                <label class="col-form-label form-control-label text-secondary text-100">Periodo</label>
                                <input type="number" name="periodo" id="periodo" class="form-control form-control-sm" required>
                                </div>
                                <div class="col-md-3">
                                <label class="col-form-label form-control-label text-secondary text-100">Ser. -Ref.</label>
                                <input type="text" id="serie" name="serie" class="form-control form-control-sm" required>
                                </div>
                            </div>
                            <div class="row" style="margin-top: 20px">
                                <div class="col-md-4">
                                <label class="col-form-label form-control-label text-secondary text-100">Ult. Modificó</label>
                                <input type="text" value="<?php echo $_SESSION["apellido_p"]." ".$_SESSION["apellido_m"]." ".$_SESSION["nombre"]; ?>" class="form-control form-control-sm" disabled>
                                </div>
                                <div class="col-md-8">
                                <label class="col-form-label form-control-label text-secondary text-100">Concepto</label>
                                <input type="text" name="concepto" id="concepto" class="form-control form-control-sm" required>
                                </div>
                            </div>
                            <hr>
                            <p class="font-bold pt-3 text-success">Movimientos de póliza</p>
                            <div class="row">
                                <div class="col-12 table-responsive-md">
                                <table class="table table-bordered table-hover table-sm text-dark-m1">
                                    <thead>
                                    <tr class="bgc-secondary-l3">
                                        <th>Cuenta</th>
                                        <th>Nombre</th>
                                        <th>Referencia</th>
                                        <th>Descripción</th>
                                        <th>Debe</th>
                                        <th>Haber</th>
                                    </tr>
                                    </thead>
                                    <tbody id="filas_movimientos" class="small"></tbody>
                                    <tfoot>
                                        <td colspan="4"></td>
                                        <td id="total_debe"></td>
                                        <td id="total_haber"></td>
                                    </tfoot>
              
                                </table>
                                </div>

                                
                            </div>

                            <div class="row justify-content-between">
                                <div class="col-3">
                                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalMovimientos" onclick="resetearForm()">
                                <i class="fa fa-plus"></i>
                                Agregar
                                </button>
                                </div>
                            </div>

                        </div>

                        <div class="form-group row" style="margin:0px; padding:0px;">
                         <div class="col-sm-12 col-md-12 col-lg-12 text-right" style="margin-bottom: 12px; margin-top: 10px;">
                          <button id="guardar" type="submit" class="btn btn-success btn-sm">
                            <i class="fas fa-save"></i>&nbsp;Guardar
                          </button>  
                         </div>
                        </div>

                        </div>
                    


                        <!--
                        <div class="col-2">
                            <p>
                            <button type="button" class="btn btn-sm px-2 px-md-4 mb-2 minw-100 btn-light-secondary btn-h-light-warning">
                            <i class="fa fa-file-o mr-1"></i> Nuevo</button>
                            <button type="button" class="btn btn-sm px-2 px-md-4 mb-2 minw-100 btn-light-secondary btn-h-light-warning">
                            <i class="fa fa-search mr-1"></i> Buscar</button>
                            <button type="button" class="btn btn-sm px-2 px-md-4 mb-2  minw-100 btn-light-secondary btn-h-light-warning">
                            <i class="fa fa-print mr-1"></i> Imprimir</button>                       
                            <button type="button" class="btn btn-sm px-2 px-md-4 mb-2  minw-100 btn-light-secondary btn-h-light-warning">
                            <i class="fa fa-arrow-right mr-1"></i> Pol. siguiente</button>
                            <button type="button" class="btn btn-sm px-2 px-md-4 mb-2  minw-100 btn-light-secondary btn-h-light-warning">
                            <i class="fa fa-arrow-left mr-1"></i> Pol. anterior</button>
                            <button type="button" class="btn btn-sm px-2 px-md-4 mb-2  minw-100 btn-light-secondary btn-h-light-warning">
                            <i class="fa fa-exchange mr-1"></i> Navega</button>
                            <button type="button" class="btn btn-sm px-2 px-md-4 mb-2  minw-100 btn-light-secondary btn-h-light-warning">
                            <i class="fa fa-copy mr-1"></i> Copiar</button>
                            <button type="button" class="btn btn-sm px-2 px-md-4 mb-2  minw-100 btn-light-secondary btn-h-light-warning">
                            <i class="fa fa-clipboard mr-1"></i> PrePoliza</button>
                            <button type="button" class="btn btn-sm px-2 px-md-4 mb-2  minw-100 btn-light-secondary btn-h-light-warning">
                            <i class="fa fa-cog mr-1"></i> LogPoliza</button>
                            </p>
                        <hr class="mt-2">
                            <p class="mt-2">
                            <button type="button" class="btn btn-sm px-2 px-md-4 mb-2  minw-100 btn-light-secondary btn-h-light-warning">
                            <i class="fa fa-times mr-1"></i> Cancelar</button>
                            <button type="button" class="btn btn-sm px-2 px-md-4 mb-2  minw-100 btn-light-secondary btn-h-light-warning">
                            <i class="fa fa-check mr-1"></i> Aceptar</button>
                            <button type="button" class="btn btn-sm px-2 px-md-4 mb-2  minw-100 btn-light-secondary btn-h-light-warning">
                            <i class="fa fa-times mr-1"></i> Cerrar</button>
                            <button type="button" class="btn btn-sm px-2 px-md-4 mb-2  minw-100 btn-light-secondary btn-h-light-warning" 
                            data-toggle="modal" data-target="#xmlModal"><i class="fa fa-link mr-1"></i> Adjuntar XML</button>
                            </p>
                        </div>
                -->
                    </div>

                </div>
            </form>
            <!--/CONTENIDO POLIZAS-->


        <!--MODAL -->
        <form name="movimientosForm" id="movimientosForm">
        <div class="modal fade" id="modalMovimientos" tabindex="-1" role="dialog" aria-labelledby="modalMovimientosLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content border-width-0 px-3">
                    <div class="modal-header">
                        <p class="modal-title text-warning-d1 text-120 text-center mt-2" >Movimientos a polizas</p>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12 pl-0">
                                <label class="col-form-label form-control-label text-secondary text-90">Cuenta</label>
                                <select name="cuenta" id="cuenta" class="form-control chosen-select form-control-sm" required style="width: 100%">
                                <option value=""></option>
                                <?php
                                    $oconns = new database();
                                    $dats = $oconns->getRows("select no_cuenta, nombre from cuentas_contables order by no_cuenta asc;");
                                    echo "<option></option>";
                                    foreach ($dats as $items)
                                        echo "<option value='".$items["no_cuenta"]."'>".$items["no_cuenta"]." - ".$items["nombre"]."</option>";
                                ?>
                                </select>
                            </div>
                            <div class="col-12 pl-0">
                                <label class="col-form-label form-control-label text-secondary text-90">Referencia</label>
                                <input type="text" name="referencia" id="referencia" class="form-control form-control-sm" required>
                            </div>
                            <div class="col-6 pl-0">
                            <label class="col-form-label form-control-label text-secondary text-90">Debe</label>
                            <input type="number" name="debe" id="debe" class="form-control form-control-sm" required>
                            </div>
                            <div class="col-6 pl-0">
                            <label class="col-form-label form-control-label text-secondary text-90">Haber</label>
                            <input type="number" name="haber" id="haber" class="form-control form-control-sm" required>
                            </div>
                            <div class="col-12 pl-0">
                            <label class="col-form-label form-control-label text-secondary text-90">Descripción</label>
                            <input type="text" name="descripcion" id="descripcion" class="form-control form-control-sm" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-white justify-content-between px-0 py-3">
                        <!--<button type="button" class="btn btn-sm px-2 px-md-4 btn-light-secondary btn-h-light-warning">
                        <i class="fa fa-trash-o mr-1 text-danger-m2"></i> Borrar</button>-->
                        <button type="submit" class="btn btn-sm px-2 px-md-4 btn-light-secondary btn-h-light-success">
                            <i class="fa fa-check mr-1 text-success"></i> Guardar </button>
                        <button type="button" class="btn btn-sm px-2 px-md-4 btn-light-secondary btn-h-light-success" data-dismiss="modal">           
                        <i class="fa fa-times ml-1 text-success-m2"></i> Cerrar</button>
                    </div> <!--modal footer-->
                </div>
            </div>
        </div>
    </form>
    <!--/MODAL -->


    </div> <!-- / row-->
</div><!-- /.page-content -->
<?php end_containers(); ?>


<!-- include common vendor scripts used in demo pages -->
        <script type="text/javascript" src="../ace-admin/node_modules/jquery/dist/jquery.js"></script>
        <script type="text/javascript" src="../ace-admin/node_modules/popper.js/dist/umd/popper.js"></script>
        <script type="text/javascript" src="../ace-admin/node_modules/bootstrap/dist/js/bootstrap.js"></script>

        <script type="text/javascript" src="../ace-admin/node_modules/select2/dist/js/select2.js"></script>
        <script type="text/javascript" src="../ace-admin/node_modules/chosen-js/chosen.jquery.js"></script>
        <!-- include Ace script -->
        <script type="text/javascript" src="../ace-admin/dist/js/ace.js"></script>


        <script type="text/javascript" src="../ace-admin/assets/js/demo.js"></script>
        <!-- this is only for Ace's demo and you don't need it -->

        <script type="text/javascript" src="../ace-admin/node_modules/bootbox/bootbox.all.js"></script>
        <script type="text/javascript" src="../ace-admin/node_modules/sweetalert2/dist/sweetalert2.all.js"></script>
        <script type="text/javascript" src="../ace-admin/node_modules/interactjs/dist/interact.js"></script>

     <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
        <script type="text/javascript" src="../js/default.js"></script>


        <!-- Para validar los campos de los forms-->
          <script type="text/javascript" src="../js/jquery.validate.min.js"></script>
          <script src="../js/validate_rules.js"></script>
          <script src="../js/funciones_contabilidad.js"></script>

    </div><!-- /.body-container -->




<?php
    create_footer_forms();
    ?>
</div>
<script>
$(document).ready(function(){
    $('#cuenta').select2({
        dropdownParent: $('#modalMovimientos')
      });
    $("#polizasForm").validate({errorClass: 'text-error'});
    $("#movimientosForm").validate({errorClass: 'text-error'});

    $("#polizasForm").submit(function( event ) {
        if($("#polizasForm").valid()){
            var debe = $("#total_d").val();
            var haber = $("#total_h").val();
            if($('input.deberes').length ==0)
                alertify.error("¡Debes agregar al menos un Movimiento!");
            else if(debe != haber)
                alertify.error("¡El total de los movimientos de Debe y Haber deben ser iguales!");
            else
                guardar_poliza_general();
                
        }
        else
            alertify.error("Algunos datos están incompletos o erróneos");
        event.preventDefault();
    });

    $("#movimientosForm").submit(function( event ) {
        if($("#movimientosForm").valid()){
            var fila = "<tr>";
            fila += "<td>"+$("#cuenta").val()+"<input hidden name='cuentas[]' value='"+$("#cuenta").val()+"' readonly></td>";
            fila += "<td>"+$('select[name="cuenta"] option:selected').text()+"</td>";
            fila += "<td>"+$("#referencia").val()+"<input hidden name='referencias[]' value='"+$("#referencia").val()+"' readonly></td>";
            fila += "<td>"+$("#descripcion").val()+"<input hidden name='descripciones[]' value='"+$("#descripcion").val()+"' readonly></td>";
            fila += "<td>$"+parseFloat($("#debe").val())+"<input hidden class='deberes' name='deberes[]' id='' value='"+$("#debe").val()+"' readonly></td>";
            fila += "<td>$"+parseFloat($("#haber").val())+"<input hidden class='haberes' name='haberes[]' value='"+$("#haber").val()+"' readonly></td>";
            $("#filas_movimientos").append(fila+"</tr>");
            alertify.success("Movimiento agregado.");
            resetearForm();
            calcular_totales();
        }
        else
            alertify.error("Algunos datos están incompletos o erróneos");
        event.preventDefault();
    });

});

function resetearForm(){
    $("#movimientosForm")[0].reset();
    var validator = $("#movimientosForm").validate();
    validator.resetForm();

}
function calcular_totales(){
    var total_debe=0;
    var total_haber =0;
    $('input.deberes').each(function() {
        total_debe += parseFloat($(this).val()); 
    });
    $('input.haberes').each(function() {
        total_haber += parseFloat($(this).val()); 
    });
    $("#total_debe").html("$"+total_debe+"<input hidden name='total_d' id='total_d' value='"+total_debe+"' readonly>");
    $("#total_haber").html("$"+total_haber+"<input hidden name='total_h' id='total_h' value='"+total_haber+"' readonly>");
}
</script>
</body>
</html>
