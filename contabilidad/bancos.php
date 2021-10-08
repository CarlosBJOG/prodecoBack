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

    <!-- tab menu-->

        <div class="col-12 mt-4 mt-md-0">
            <ul class="nav nav-tabs nav-tabs-simple nav-tabs-scroll border-b-1 brc-secondary-l2 mx-n3 mx-md-0 px-3 px-md-0" role="tablist">
            <li class="nav-item">
                <a class="nav-link active brc-success d-style" id="home-tab" data-toggle="tab" href="#idmov" role="tab" aria-controls="idmov" aria-selected="true">
                <i class="fa fa-caret-right text-success-m2 mr-3px"></i>
                <span class="d-n-active">Identificación del Movimiento</span>
                <span class="d-active text-success">Identificación del Movimiento</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link brc-success d-style" id="profile-tab" data-toggle="tab" href="#conciliacion" role="tab" aria-controls="conciliacion" aria-selected="false">
                <i class="fa fa-caret-right text-success-m2 mr-3px"></i>
                <span class="d-n-active">Conciliación Bancaria</span>
                <span class="d-active text-success">Conciliación Bancaria</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link brc-success d-style" id="contact-tab" data-toggle="tab" href="#catalogo-cuentas" role="tab" aria-controls="catalogo-cuentas" aria-selected="false">
                <i class="fa fa-caret-right text-success-m2 mr-3px"></i>
                <span class="d-n-active">Catálogo de Cuentas Contables</span>
                <span class="d-active text-success">Catálogo de Cuentas Contables</span>
                </a>
            </li>
            </ul>

            <div class="tab-content tab-sliding px-0 mx-n3 mx-md-0">
            <div class="tab-pane show active text-95 px-3 px-md-2" id="idmov" role="tabpanel" aria-labelledby="idmov-tab">

                <div class="row form group mt-3">
                    <div class="col-10">
                    <div class="card px-3 border-1 brc-secondary-l1 radius-3px bgc-grey-l5 pb-5">
                        <p class="font-bold pt-3">Identificación del Movimiento</p>
                        <div class="row">
                        <table class="table table-responsive table-borderless table-sm p-3">
                            <tr>
                                <td><label class="col-form-label form-control-label text-secondary text-100">Cuenta:</label></td>
                                <td>
                                    <select name="tipo" id="tipo-poliza" class="form-control form-control-sm">
                                    <option>Cuenta 1</option>
                                    <option>Cuenta 2</option>
                                    <option>Cuenta 3</option>
                                    <option>Cuenta 4</option>
                                    </select>
                                </td>
                                <td  style="text-align:right;"><label class="col-form-label form-control-label text-secondary text-100">Consecutivo</label></td>
                                <td width="5%"><input type="number" class="form-control form-control-sm"></td>
                                <td>
                                    <div class="d-inline-flex ml-sm-0 pos-rel mt-2 mt-md-0">
                                        <i class="fa fa-search text-grey position-lc ml-2"></i>
                                        <input type="text" class="form-control form-control-sm pl-425" placeholder="Buscar">
                                    </div>
                                </td>
                                <td style="text-align:right;"><label class="col-form-label form-control-label text-secondary text-100">Ref.:</label></td>
                                <td><input type="number" class="form-control form-control-sm"></td>
                            </tr>
                            <tr>
                                <td><label class="col-form-label form-control-label text-secondary text-100">Mov.:</label></td>
                                <td>
                                    <select name="tipo" id="tipo-poliza" class="form-control form-control-sm">
                                    <option>Cuenta 1</option>
                                    <option>Cuenta 2</option>
                                    <option>Cuenta 3</option>
                                    <option>Cuenta 4</option>
                                    </select>
                                </td>
                                <td  style="text-align:right;"><label class="col-form-label form-control-label text-secondary text-100">Prestamo No.</label></td>
                                <td colspan="2">
                                    <div class="d-inline-flex ml-sm-0 pos-rel mt-2 mt-md-0">
                                        <i class="fa fa-search text-grey position-lc ml-2"></i>
                                        <input type="text" class="form-control form-control-sm pl-425" placeholder="Buscar">
                                    </div>
                                </td>
                                <td style="text-align:right;"><label class="col-form-label form-control-label text-secondary text-100">Fecha:</label></td>
                                <td>
                                    <div class="input-group date" id="id-timepicker">
                                        <input type="text" name="nacimiento" class="form-control form-control-sm" id="fecha-bancos">
                                        <div class="input-group-addon input-group-append">
                                        <div class="input-group-text">
                                        <i class="fa fa-calendar"></i>
                                        </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><label class="col-form-label form-control-label text-secondary text-100">Beneficiario:</label></td>
                                <td colspan="4"><input type="text" class="form-control form-control-sm"></td>
                                <td style="text-align:right;"><label class="col-form-label form-control-label text-secondary text-100">Cantidad:</label></td>
                                <td><input type="number" class="form-control form-control-sm"></td>
                            </tr>

                            <tr>
                                <td rowspan="2"><label class="col-form-label form-control-label text-secondary text-100">Concepto:</label></td>
                                <td colspan="4" rowspan="2">
                                    <textarea class="form-control" id="id-textarea-limit1" maxlength="60"></textarea>
                                </td>
                                <td style="text-align:right;"><label class="col-form-label form-control-label text-secondary text-100">Poliza:</label></td>
                                <td><input type="text" class="form-control form-control-sm"></td>
                            </tr>
                            <tr>
                                <td style="text-align:right;"><label class="col-form-label form-control-label text-secondary text-100">Saldo actual:</label></td>
                                <td><input type="text" class="form-control form-control-sm"></td>
                            </tr>
                        </table>

                        </div>
                        <hr>
                        <p class="font-bold pt-3">Poliza</p>
                        <div class="row">
                            <div class="col-12 table-responsive-md p-3">
                                <table class="table table-bordered table-hover table-sm text-dark-m1">
                                    <thead>
                                    <tr class="bgc-secondary-l3">
                                        <th width="5%">#</th>
                                        <th>Cuenta</th>
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
                                    </tr>
                                    <tr>
                                        <td>2</td>
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
                                    </tr>
                                    <tr>
                                        <td>4</td>
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
                        <button type="button" class="btn btn-sm px-2 px-md-4 mb-2 minw-100 btn-light-secondary btn-h-light-warning">
                        <i class="fa fa-file-o mr-1"></i> Nuevo</button>
                        <button type="button" class="btn btn-sm px-2 px-md-4 mb-2 minw-100 btn-light-secondary btn-h-light-warning">
                        <i class="fa fa-search mr-1"></i> Buscar</button>
                        <button type="button" class="btn btn-sm px-2 px-md-4 mb-2  minw-100 btn-light-secondary btn-h-light-warning">
                        <i class="fa fa-print mr-1"></i> Imprimir</button> 
                        </p>                      

                        <p class="mt-5 mb-5">
                        <button type="button" class="btn btn-sm px-2 px-md-4 mb-2  minw-100 btn-light-secondary btn-h-light-warning">
                        <i class="fa fa-times mr-1"></i> Cancelar</button>
                        </p>
                        <p class="mt-5">
                        <button type="button" class="btn btn-sm px-2 px-md-4 mb-2  minw-100 btn-light-secondary btn-h-light-warning">
                        <i class="fa fa-check mr-1"></i> Aceptar</button>
                        <button type="button" class="btn btn-sm px-2 px-md-4 mb-2  minw-100 btn-light-secondary btn-h-light-warning">
                        <i class="fa fa-times mr-1"></i> Cerrar</button>
                        <button type="button" class="btn btn-sm px-2 px-md-4 mb-2  minw-100 btn-light-secondary btn-h-light-warning" 
                        data-toggle="modal" data-target="#xmlModal"><i class="fa fa-link mr-1"></i> Adjuntar XML</button>
                        </p>
                    </div>
                </div>


            </div>
            <div class="tab-pane text-95 px-3 px-md-2" id="conciliacion" role="tabpanel" aria-labelledby="conciliacion-tab">

                <!--Conciliación bancaria-->
                <div class="row form-group mt-3">
                    <div class="col-10">
                    <div class="card px-3 border-1 brc-secondary-l1 radius-3px bgc-grey-l5 pb-5">
                        <p class="font-bold pt-3">Conciliación Bancaria</p>
                        <div class="row">
                            <table class="table table-responsive table-borderless table-sm p-3">
                                <tr>
                                    <td><label class="col-form-label form-control-label text-secondary text-100">Cuenta:</label></td>
                                    <td width="30%">
                                        <select name="tipo" id="tipo-poliza" class="form-control form-control-sm">
                                        <option>Cuenta 1</option>
                                        <option>Cuenta 2</option>
                                        <option>Cuenta 3</option>
                                        <option>Cuenta 4</option>
                                        </select>
                                    </td>

                                    <td style="text-align:right;"><label class="col-form-label form-control-label text-secondary text-100">De:</label></td>
                                    <td>
                                        <div class="input-group date" id="id-timepicker">
                                            <input type="text" name="nacimiento" class="form-control form-control-sm" id="fecha-de">
                                            <div class="input-group-addon input-group-append">
                                            <div class="input-group-text">
                                            <i class="fa fa-calendar"></i>
                                            </div>
                                            </div>
                                        </div>
                                    </td>

                                    <td style="text-align:right;"><label class="col-form-label form-control-label text-secondary text-100">A:</label></td>
                                    <td>
                                        <div class="input-group date" id="id-timepicker">
                                            <input type="text" name="nacimiento" class="form-control form-control-sm" id="fecha-a">
                                            <div class="input-group-addon input-group-append">
                                            <div class="input-group-text">
                                            <i class="fa fa-calendar"></i>
                                            </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div> <!-- row-->

                        <div class="row">
                            <div class="col-12 table-responsive-md p-3">
                                <table class="table table-bordered table-hover text-dark-m1">
                                    <thead>
                                    <tr class="bgc-secondary-l3">
                                        <th>Fecha</th>
                                        <th>Movimiento</th>
                                        <th>Referencia</th>
                                        <th>Beneficiario</th>
                                        <th>Debe</th>
                                        <th>Haber</th>
                                        <th width="5%"> * </th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    <tr>
                                        <td> </td>
                                        <td> </td>
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
                                        <td> </td>
                                        <td> </td>
                                    </tr>
                                    <tr>
                                        <td> </td>
                                        <td> </td>
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
                                        <td> </td>
                                        <td> </td>
                                    </tr>
                                    <tr>
                                        <td> </td>
                                        <td> </td>
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
                                        <td> </td>
                                        <td> </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <hr> 
                            </div>
                        </div> <!--/row-->

                        <div class="row">
                            <div class="col-lg-8 col-sm-12">
                            </div>
                            <div class="col-lg-4 col-sm-12 align-self-end">
                                <table class="table table-responsive table-borderless table-sm p-3">
                                    <tr>
                                        <td width="50%"><label class="col-form-label form-control-label text-secondary text-100">Saldo inicial:</label></td>
                                        <td width="50%"><input type="number" class="form-control form-control-sm"></td>
                                    </tr>
                                    <tr>
                                        <td><label class="col-form-label form-control-label text-secondary text-100">Depósitos:</label></td>
                                        <td><input type="number" class="form-control form-control-sm"></td>
                                    </tr>
                                    <tr>
                                        <td><label class="col-form-label form-control-label text-secondary text-100">Retiros:</label></td>
                                        <td><input type="number" class="form-control form-control-sm"></td>
                                    </tr>
                                    <tr>
                                        <td><label class="col-form-label form-control-label text-secondary text-100">Saldo final:</label></td>
                                        <td><input type="number" class="form-control form-control-sm"></td>
                                    </tr>
                                </table>
                            </div>
                        </div> <!-- row -->                           
                    </div> <!-- estilos de card -->
                    </div> <!-- / col-10 -->
                    <div class="col-2">
                        <p>
                        <button type="button" class="btn btn-sm px-2 px-md-4 mb-2 minw-100 btn-light-secondary btn-h-light-warning">
                        <i class="fa fa-search mr-1"></i> Buscar</button>
                        </p>                      
                        <p class="mt-5">
                        <button type="button" class="btn btn-sm px-2 px-md-4 mb-2  minw-100 btn-light-secondary btn-h-light-warning">
                        <i class="fa fa-check mr-1"></i> Aceptar</button>
                        <button type="button" class="btn btn-sm px-2 px-md-4 mb-2  minw-100 btn-light-secondary btn-h-light-warning">
                        <i class="fa fa-times mr-1"></i> Cerrar</button>
                        </p>
                    </div> <!-- /col-2-->
                </div> <!-- /row form group -->
                <!--FIN Conciliación bancaria-->

            </div>
            <div class="tab-pane text-95 px-3 px-md-2" id="catalogo-cuentas" role="tabpanel" aria-labelledby="catalogo-cuentas-tab">

                <!--CATALOGO DE CUENTAS CONTABLES-->
                <div class="row">
                    <p class="font-bold pt-3 ml-3">Catálogo de Cuentas Contables</p>
                </div>
                <div class="row form group mt-3">
                    <div class="col-lg-10 col-sm-12">
                    <div class="card px-3 border-1 brc-secondary-l1 radius-3px bgc-grey-l5 pb-5">
                        <div class="row">
                            <div class="col-lg-3 col-sm-12 mt-3">
                                <label for="form-field-select-2 font-bold">Cuentas Contables</label>
                                <select class="form-control" id="form-field-select-2" multiple="" style="height: 90%;">
                                    <option value="C1">1</option>
                                    <option value="C11">11</option>
                                    <option value="C1101">1101</option>
                                    <option value="C110101">110101</option>
                                    <option value="C11010101">11010101</option>
                                    <option value="C1101010101">1101010101</option>
                                    <option value="C1101010102">1101010102</option>
                                    <option value="C11010102">11010102</option>
                                    <option value="C1101010201">1101010201</option>
                                    <option value="C1101010202">1101010202</option>
                                    <option value="C11010103">11010103</option>
                                    <option value="C1101010301">1101010301</option>
                                    <option value="C1101010302">1101010302</option>
                                    <option value="C110102">110102</option>
                                    <option value="C11010201">11010201</option>
                                    <option value="C1101020101">1101020101</option>
                                    <option value="C1101020102">1101020102</option>
                                    <option value="C1101020103">1101020103</option>
                                    <option value="C1101020104">1101020104</option>
                                    <option value="C1101020105">1101020105</option>
                                    <option value="C1101020106">1101020106</option>
                                </select>
                            </div>
                            <div class="col-lg-9 col-sm-12">
                                <p class="font-bold pt-3">Identificación</p>
                                
                                    <table class="table table-responsive table-borderless table-sm p-3">
                                        <tr>
                                            <td><label class="col-form-label form-control-label text-secondary text-100">Cuenta:</label></td>
                                            <td width="30%">
                                                <select name="tipo" id="tipo-poliza" class="form-control form-control-sm">
                                                <option>Cuenta 1</option>
                                                <option>Cuenta 2</option>
                                                <option>Cuenta 3</option>
                                                <option>Cuenta 4</option>
                                                </select>
                                            </td>
                                        </tr>
                                    </table>
                                    <hr/>
                                    <p class="font-bold pt-3">Datos de la cuenta</p>

                                    <table class="table table-responsive table-borderless table-sm p-3">
                                        <tr>
                                            <td><label class="col-form-label form-control-label text-secondary text-100">Rubro:</label></td>
                                            <td width="30%">
                                                <select name="tipo" id="tipo-poliza" class="form-control form-control-sm">
                                                <option>Cuenta 1</option>
                                                <option>Cuenta 2</option>
                                                <option>Cuenta 3</option>
                                                <option>Cuenta 4</option>
                                                </select>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td><label class="col-form-label form-control-label text-secondary text-100">Rubro:</label></td>
                                            <td><textarea class="form-control" id="id-textarea-limit1" maxlength="60"></textarea></td>
                                        </tr>

                                        <tr>
                                            <td><label class="col-form-label form-control-label text-secondary text-100">Tipo:</label></td>
                                            <td width="30%">
                                                <select name="tipo" id="tipo-poliza" class="form-control form-control-sm">
                                                <option>Cuenta 1</option>
                                                <option>Cuenta 2</option>
                                                <option>Cuenta 3</option>
                                                <option>Cuenta 4</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><label class="col-form-label form-control-label text-secondary text-100">Acumula a:</label></td>
                                            <td>
                                                <div class="d-inline-flex ml-sm-0 pos-rel mt-2 mt-md-0">
                                                    <i class="fa fa-search text-grey position-lc ml-2"></i>
                                                    <input type="text" class="form-control form-control-sm pl-425" placeholder="Buscar">
                                                </div>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td><label class="col-form-label form-control-label text-secondary text-100">Estado:</label></td>
                                            <td><input type="number" class="form-control form-control-sm"></td>
                                        </tr>

                                        <tr>
                                            <td><label class="col-form-label form-control-label text-secondary text-100">Naturaleza:</label></td>
                                            <td width="30%">
                                                <select name="tipo" id="tipo-poliza" class="form-control form-control-sm">
                                                <option>Cuenta 1</option>
                                                <option>Cuenta 2</option>
                                                <option>Cuenta 3</option>
                                                <option>Cuenta 4</option>
                                                </select>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td><label class="col-form-label form-control-label text-secondary text-100">Digito Agrupador:</label></td>
                                            <td><input type="number" class="form-control form-control-sm" placeholder="0"></td>
                                        </tr>

                                        <tr>
                                            <td><label class="col-form-label form-control-label text-secondary text-100">Cuenta SITI:</label></td>
                                            <td width="30%">
                                                <select name="tipo" id="tipo-poliza" class="form-control form-control-sm">
                                                <option>Cuenta 1</option>
                                                <option>Cuenta 2</option>
                                                <option>Cuenta 3</option>
                                                <option>Cuenta 4</option>
                                                </select>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td><label class="col-form-label form-control-label text-secondary text-100">Nombre de la cuenta SITI:</label></td>
                                            <td><textarea class="form-control" id="id-textarea-limit1" maxlength="30"></textarea></td>
                                        </tr>

                                        <tr>
                                            <td><label class="col-form-label form-control-label text-secondary text-100">Nivel Cuenta SITI:</label></td>
                                            <td><input type="number" class="form-control form-control-sm" placeholder="0"></td>
                                        </tr>
                                        <tr>
                                            <td><label class="col-form-label form-control-label text-secondary text-100">Orden Cuenta SITI:</label></td>
                                            <td><input type="number" class="form-control form-control-sm" placeholder="0"></td>
                                        </tr>
                                    </table>
                                </div>
                        </div><!--row interna-->
                    </div>  <!-- estilo card -->
                    </div> <!--col-lg-10-->
                    <div class="col-2">
                        <p>
                        <button type="button" class="btn btn-sm px-2 px-md-4 mb-2 minw-100 btn-light-secondary btn-h-light-warning">
                        <i class="fa fa-search mr-1"></i> Buscar</button>
                        </p>                      

                        <p class="mt-5">
                        <button type="button" class="btn btn-sm px-2 px-md-4 mb-2  minw-100 btn-light-secondary btn-h-light-warning">
                        <i class="fa fa-check mr-1"></i> Aceptar</button>
                        <button type="button" class="btn btn-sm px-2 px-md-4 mb-2  minw-100 btn-light-secondary btn-h-light-warning">
                        <i class="fa fa-times mr-1"></i> Cerrar</button>
                        </p>
                    </div>
                </div>
                <!--FIN Conciliación bancaria-->


            </div>
            </div>
        </div>

    <!--/ tab menu-->


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
