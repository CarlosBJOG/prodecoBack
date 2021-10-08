<?php
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    require_once "../php/security.php";
    require_once "../php/header_contabilidad.php";
    require_once "../php/functions.php";
    require_once "../php/db.php";
    
    create_header_seguimiento();
    create_menu_seguimiento();
    
    
    ?>


<!-- MAIN CONTAINER --> 
<div class="page-content container container-plus px-md-4 px-xl-5">
    <div class="row">
        
            <!--
            <ul class="nav nav-tabs nav-spaced nav-tabs-simple nav-tabs-scroll border-b-1 brc-secondary-l2 mx-n3 mx-md-0 px-3 px-md-0" role="tablist">
                <li class="nav-item">
                <a class="nav-link brc-success d-style" id="home-tab" data-toggle="tab" href="#home0" role="tab" aria-controls="home" aria-selected="true">
                    <i class="fa fa-cash-register text-success-m2 mr-3px"></i>
                    <span class="d-n-active">Caja</span>
                    <span class="d-active text-success">Caja</span>
                </a>
                </li>
                <li class="nav-item">
                <a class="nav-link brc-success d-style" id="profile-tab" data-toggle="tab" href="#profile0" role="tab" aria-controls="profile" aria-selected="false">
                    <i class="fas fa-university text-success-m2 mr-3px"></i>
                    <span class="d-n-active">Bancos</span>
                    <span class="d-active text-success">Bancos</span>
                </a>
                </li>
                <li class="nav-item">
                <a class="nav-link active brc-success d-style" id="contact-tab" data-toggle="tab" href="#polizas" role="tab" aria-controls="polizas" aria-selected="false">
                    <i class="fas fa-file-invoice-dollar text-success mr-3px"></i>
                    <span class="d-n-active">Polizas</span>
                    <span class="d-active text-success">Polizas</span>
                </a>
                </li>
                <li class="nav-item">
                <a class="nav-link brc-success d-style" id="contact-tab" data-toggle="tab" href="#inversion" role="tab" aria-controls="inversion" aria-selected="false">
                    <i class="fa fa-retweet text-success mr-3px"></i>
                    <span class="d-n-active">Inversión</span>
                    <span class="d-active text-success">Inversión</span>
                </a>
                </li>
                <li class="nav-item">
                <a class="nav-link brc-success d-style" id="contact-tab" data-toggle="tab" href="#consulta" role="tab" aria-controls="consulta" aria-selected="false">
                    <i class="fas fa-search-dollar text-success mr-3px"></i>
                    <span class="d-n-active">Consulta</span>
                    <span class="d-active text-success">Consulta</span>
                </a>
                </li>
            </ul>
            <div class="tab-content tab-sliding px-0 mx-n3 mx-md-0">-->
            <div class="tab-sliding px-0 mx-n3 mx-md-0">
                <div class="tab-pane text-95 px-3 px-md-2" id="caja" role="tabpanel" aria-labelledby="caja-tab">
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

                <div class="tab-pane text-95 px-3 px-md-2" id="bancos" role="tabpanel" aria-labelledby="bancos-tab">
                    <h2>SIN CONTENIDO DISPONIBLE</h2>
                </div>

                <!--CONTENIDO POLIZAS-->
                <div class="tab-pane show active text-95 px-3 px-md-2" id="polizas" role="tabpanel" aria-labelledby="polizas-tab">
                    <h4 class="text-secondary-d1 text-120 mb-1 text-orange-d2 b-underline-4 mt-2 px-lg-0">Polizas</h4>
                    <div class="row form group mt-3">
                        <div class="col-10">
                        <div class="card px-3 border-1 brc-secondary-l1 radius-3px bgc-grey-l5 pb-5">
                            <p class="font-bold pt-3">Identificación de poliza</p>
                            <div class="row">
                                <div class="col-md-3">    
                                <label class="col-form-label form-control-label text-secondary text-100">Fecha: 12/04/2020</label>
                                </div>
                                <div class="col-md-3">
                                    <label class="col-form-label form-control-label text-secondary text-100">Tipo:</label>
                                    <select name="tipo" id="tipo-poliza" class="form-control form-control-sm">
                                    <option>Diario</option>
                                    <option>Ingreso</option>
                                    <option>Egreso</option>
                                    <option>Orden</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                <label class="col-form-label form-control-label text-secondary text-100">No.</label>
                                <input type="number" class="form-control form-control-sm">
                                </div>
                                <div class="col-md-2">
                                <label class="col-form-label form-control-label text-secondary text-100">Ejercicio</label>
                                <input type="number" class="form-control form-control-sm">
                                </div>
                                <div class="col-md-2">
                                <label class="col-form-label form-control-label text-secondary text-100">Periodo</label>
                                <input type="number" class="form-control form-control-sm">
                                </div>
                                <div class="col-md-2">
                                <label class="col-form-label form-control-label text-secondary text-100">Ser. -Ref.</label>
                                <input type="number" class="form-control form-control-sm">
                                </div>
                                <div class="col-md-2">
                                <label class="col-form-label form-control-label text-secondary text-100">Ult. Modifico</label>
                                <input type="text" class="form-control form-control-sm">
                                </div>
                                <div class="col-md-8">
                                <label class="col-form-label form-control-label text-secondary text-100">Concepto</label>
                                <input type="text" class="form-control form-control-sm">
                                </div>
                            </div>
                            <hr>
                            <p class="font-bold pt-3">Movimientos de poliza</p>
                            <div class="row">
                                <div class="col-12 table-responsive-md">
                                <table class="table table-bordered table-hover table-sm text-dark-m1">
                                    <thead>
                                    <tr class="bgc-secondary-l3">
                                        <th width="5%">#</th>
                                        <th>Cuenta</th>
                                        <th>Nombre</th>
                                        <th>Referencia</th>
                                        <th>Debe</th>
                                        <th>Haber</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td> </td>
                                        <td> </td>
                                        <td> </td>
                                        <td> </td>
                                        <td> </td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td> </td>
                                        <td> </td>
                                        <td> </td>
                                        <td> </td>
                                        <td> </td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td> </td>
                                        <td> </td>
                                        <td> </td>
                                        <td> </td>
                                        <td> </td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td> </td>
                                        <td> </td>
                                        <td> </td>
                                        <td> </td>
                                        <td> </td>
                                    </tr>
                                    </tbody>
                                </table>
                                </div>

                                
                            </div>

                            <div class="row justify-content-between">
                                <div class="col-3">
                                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#razonModal">
                                <i class="fa fa-plus"></i>
                                Agregar
                                </button>
                                </div>

                                <div class="col-2 offset-md-5">
                                <input type="text" class="form-control form-control-sm">
                                </button>
                                </div>
                                <div class="col-2">
                                <input type="text" class="form-control form-control-sm">
                                </div>
                            </div>

                        </div>
                        </div>
                        <div class="col-2">
                            <p>
                            <button type="button" class="btn btn-sm px-2 px-md-4 mb-2 minw-100 btn-light-secondary btn-h-light-warning btn-a-light-danger" data-dismiss="modal">
                            <i class="fa fa-file-o mr-1"></i> Nuevo</button>
                            <button type="button" class="btn btn-sm px-2 px-md-4 mb-2 minw-100 btn-light-secondary btn-h-light-warning btn-a-light-danger" data-dismiss="modal">
                            <i class="fa fa-search mr-1"></i> Buscar</button>
                            <button type="button" class="btn btn-sm px-2 px-md-4 mb-2  minw-100 btn-light-secondary btn-h-light-warning btn-a-light-danger" data-dismiss="modal">
                            <i class="fa fa-print mr-1"></i> Imprimir</button>                       
                            <button type="button" class="btn btn-sm px-2 px-md-4 mb-2  minw-100 btn-light-secondary btn-h-light-warning btn-a-light-danger" data-dismiss="modal">
                            <i class="fa fa-arrow-right mr-1"></i> Pol. siguiente</button>
                            <button type="button" class="btn btn-sm px-2 px-md-4 mb-2  minw-100 btn-light-secondary btn-h-light-warning btn-a-light-danger" data-dismiss="modal">
                            <i class="fa fa-arrow-left mr-1"></i> Pol. anterior</button>
                            <button type="button" class="btn btn-sm px-2 px-md-4 mb-2  minw-100 btn-light-secondary btn-h-light-warning btn-a-light-danger" data-dismiss="modal">
                            <i class="fa fa-exchange mr-1"></i> Navega</button>
                            <button type="button" class="btn btn-sm px-2 px-md-4 mb-2  minw-100 btn-light-secondary btn-h-light-warning btn-a-light-danger" data-dismiss="modal">
                            <i class="fa fa-copy mr-1"></i> Copiar</button>
                            <button type="button" class="btn btn-sm px-2 px-md-4 mb-2  minw-100 btn-light-secondary btn-h-light-warning btn-a-light-danger" data-dismiss="modal">
                            <i class="fa fa-clipboard mr-1"></i> PrePoliza</button>
                            <button type="button" class="btn btn-sm px-2 px-md-4 mb-2  minw-100 btn-light-secondary btn-h-light-warning btn-a-light-danger" data-dismiss="modal">
                            <i class="fa fa-cog mr-1"></i> LogPoliza</button>
                            </p>
                        <hr class="mt-2">
                            <p class="mt-2">
                            <button type="button" class="btn btn-sm px-2 px-md-4 mb-2  minw-100 btn-light-secondary btn-h-light-warning btn-a-light-danger" data-dismiss="modal">
                            <i class="fa fa-times mr-1"></i> Cancelar</button>
                            <button type="button" class="btn btn-sm px-2 px-md-4 mb-2  minw-100 btn-light-secondary btn-h-light-warning btn-a-light-danger" data-dismiss="modal">
                            <i class="fa fa-check mr-1"></i> Aceptar</button>
                            <button type="button" class="btn btn-sm px-2 px-md-4 mb-2  minw-100 btn-light-secondary btn-h-light-warning btn-a-light-danger" data-dismiss="modal">
                            <i class="fa fa-times mr-1"></i> Cerrar</button>
                            <button type="button" class="btn btn-sm px-2 px-md-4 mb-2  minw-100 btn-light-secondary btn-h-light-warning btn-a-light-danger" data-dismiss="modal">
                            <i class="fa fa-link mr-1"></i> Adjuntar XML</button>
                            </p>
                        </div>
                    </div>
                
                </div>
                <!--/CONTENIDO POLIZAS-->

                <div class="tab-pane text-95 px-3 px-md-2" id="inversion" role="tabpanel" aria-labelledby="inversion-tab">
                    <h2>SIN CONTENIDO DISPONIBLE</h2>
                </div>

                <div class="tab-pane text-95 px-3 px-md-2" id="consulta" role="tabpanel" aria-labelledby="consulta-tab">
                    <h2>SIN CONTENIDO DISPONIBLE</h2>
                </div>
            </div>  <!--Tab sliding Sección de tabs -->
        

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
    </div><!-- /.body-container -->
  </body>




<?php
    require_once "php/security.php";
    require_once "php/header_contabilidad.php";
    create_footer_forms();
    ?>
</div>
</body>
</html>
