<?php


    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    require_once "../php/db.php";
    require_once "../php/security.php";    
    require_once "../php/header_admin.php";
    require_once "../php/functions.php";    


    create_header();
    create_menu();
    begin_containers();


    $id=$_GET["id"];

    $oconns = new database();

    $datas=$oconns->getRows("select empleados.idkey,generales.nombre,generales.apellido_p,generales.apellido_m,generales.edad,sexo.nombre as sexo, generales.ine,generales.rfc,direcciones.domicilio,estados.nombre as estados,municipios.nombre as municipios, localidad.nombre as localidad,codigo_postal.nombre as codigo_postal,generales.telefono1,generales.telefono2, generales.telefono3,generales.email,departamentos.nombre as departamentos,puestos.nombre as puestos from empleados,generales,sexo,direcciones,estados,municipios,localidad,codigo_postal,departamentos,puestos where empleados.idkey = '".$id."' and empleados.idkey_generales = generales.idkey and sexo.idkey=generales.idkey_sexo and generales.idkey_direcciones=direcciones.idkey and direcciones.idkey_estados=estados.idkey and direcciones.idkey_municipios=municipios.idkey and direcciones.idkey_localidad=localidad.idkey and direcciones.idkey_codigo_postal=codigo_postal.idkey and empleados.idkey_departamentos=departamentos.idkey and empleados.idkey_puestos=puestos.idkey;");

?>

<div class="container container-plus pos-rel">

        <div class="modal fade" id="modal_familiares_ver" tabindex="-1" role="dialog" aria-labelledby="label_modal_ver" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title text-success font-bold" id="label_modal_ver">Datos del familiar visualizar</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">                
                        <div class="container-fluid" id="secundary">
                        <?php create_fields('0','_v',true,false); ?>
                        </div>
                    </div>
                    <div class="modal-footer">                                            
                        <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>



        <div class="row justify-content-sm-center justify-content-md-center justify-content-lg-center mt-5">
            <div class="col-sm-12 col-lg-10">                                        
                <div class="row">
                    <div class="mx-auto col-12">
                        <div class="card">
                            <h2 class="text-success p-3">Visualizaci&oacute;n de empleado</h2>
                            <div class="card-body">
                                <div class="row mt-2">
                                    <div class="mx-auto col-sm-12 col-md-12 col-lg-12">
                                        <div class="card">
                                        <div class="card-header bgc-success-l3 d-style">
                                            <h6 class="text-success font-bold">Datos generales</h6>
                                        </div>
                                            <div class="card-body">
                                                <div class="form-group row" style="margin:0px; padding:0px;">
                                                    <div class="col-sm-12 col-md-4 col-lg-4" style="margin-bottom: 2px; margin-top: 0px;">
                                                        <label class="col-form-label form-control-label">Nombre(s) <span style="color:red;">*</span></label>
                                                        <input type="text" class="form-control form-control-sm" disabled value="<?php echo $datas[0]["nombre"]; ?>">
                                                    </div>                        
                                                    <div class="col-sm-12 col-md-4 col-lg-4" style="margin-bottom: 2px; margin-top: 0px;">
                                                        <label class="col-form-label form-control-label">Apellido Paterno <span style="color:red;">*</span></label>
                                                        <input type="text" class="form-control form-control-sm" disabled value="<?php echo $datas[0]["apellido_p"]; ?>">
                                                    </div>
                                                    <div class="col-sm-12 col-md-4 col-lg-4" style="margin-bottom: 2px; margin-top: 0px;">
                                                        <label class="col-form-label form-control-label">Apellido Materno <span style="color:red;">*</span></label>
                                                        <input type="text" class="form-control form-control-sm" disabled value="<?php echo $datas[0]["apellido_m"]; ?>">
                                                    </div>
                                                </div>

                                                <div class="form-group row" style="margin:0px; padding:0px;">
                                                    <div class="col-sm-12 col-md-4 col-lg-2" style="margin-bottom: 2px; margin-top: 0px;">
                                                        <label class="col-form-label form-control-label">Edad <span style="color:red;">*</span></label>
                                                        <input type="text" class="form-control form-control-sm" disabled value="<?php echo $datas[0]["edad"]; ?>">
                                                    </div>

                                                    <div class="col-sm-12 col-md-4 col-lg-3" style="margin-bottom: 2px; margin-top: 0px;">
                                                        <label class="col-form-label form-control-label">Sexo <span style="color:red;">*</span></label>
                                                        <input type="text" class="form-control form-control-sm" disabled value="<?php echo $datas[0]["sexo"]; ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-2">
                                    <div class="mx-auto col-sm-12 col-md-12 col-lg-12">
                                        <div class="card">
                                        <div class="card-header bgc-success-l3 d-style">
                                            <h6 class="text-success font-bold">Direcci&oacute;n</h6>
                                        </div>
                                            <div class="card-body">
                                                <div class="form-group row" style="margin:0px; padding:0px;">
                                                    <div class="col-sm-12 col-md-4 col-lg-12" style="margin-bottom: 2px; margin-top: 0px;">
                                                        <label class="col-form-label form-control-label">Domicilio <span style="color:red;">*</span></label>
                                                        <input type="text" class="form-control form-control-sm" disabled value="<?php echo $datas[0]["domicilio"]; ?>">
                                                    </div>
                                                </div>
                                                <div class="form-group row" style="margin:0px; padding:0px;">
                                                    <div class="col-sm-12 col-md-6 col-lg-6" style="margin-bottom: 2px; margin-top: 0px;">
                                                        <label class="col-form-label form-control-label">Estado <span style="color:red;">*</span></label>
                                                        <input type="text" class="form-control form-control-sm" disabled value="<?php echo $datas[0]["estados"]; ?>">
                                                    </div>
                                                    <div class="col-sm-12 col-md-6 col-lg-6" style="margin-bottom: 2px; margin-top: 0px;">
                                                        <label class="col-form-label form-control-label">Ciudad/Delegaci&oacute;n <span style="color:red;">*</span></label>
                                                        <input type="text" class="form-control form-control-sm" disabled value="<?php echo $datas[0]["municipios"]; ?>">
                                                    </div>
                                                </div>

                                                <div class="form-group row" style="margin:0px; padding:0px;">
                                                    <div class="col-sm-12 col-md-6 col-lg-6" style="margin-bottom: 2px; margin-top: 0px;">
                                                        <label class="col-form-label form-control-label">Localidad <span style="color:red;">*</span></label>
                                                        <input type="text" class="form-control form-control-sm" disabled value="<?php echo $datas[0]["localidad"]; ?>">
                                                    </div>
                                                    <div class="col-sm-12 col-md-6 col-lg-6" style="margin-bottom: 2px; margin-top: 0px;">
                                                        <label class="col-form-label form-control-label">Codigo Postal <span style="color:red;">*</span></label>
                                                        <input type="text" class="form-control form-control-sm" disabled value="<?php echo $datas[0]["codigo_postal"]; ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>




                                <div class="row mt-2">
                                    <div class="mx-auto col-sm-12 col-md-12 col-lg-12">
                                        <div class="card">
                                        <div class="card-header bgc-success-l3 d-style">
                                            <h6 class="text-success font-bold">Datos oficiales</h6>
                                        </div>
                                            <div class="card-body">

                                                <div class="form-group row" style="margin:0px; padding:0px;">
                                                    <div class="col-sm-12 col-md-6 col-lg-6" style="margin-bottom: 2px; margin-top: 0px;">
                                                        <label class="col-form-label form-control-label">I.N.E <span style="color:red;">*</span></label>
                                                        <input type="text" class="form-control form-control-sm" disabled value="<?php echo $datas[0]["ine"]; ?>">
                                                    </div>
                                                    <div class="col-sm-12 col-md-6 col-lg-6" style="margin-bottom: 2px; margin-top: 0px;">
                                                        <label class="col-form-label form-control-label">R.F.C <span style="color:red;">*</span></label>
                                                        <input type="text" class="form-control form-control-sm" disabled value="<?php echo $datas[0]["rfc"]; ?>">
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="row mt-2">
                                    <div class="mx-auto col-sm-12 col-md-12 col-lg-12">
                                        <div class="card">
                                        <div class="card-header bgc-success-l3 d-style">
                                            <h6 class="text-success font-bold">Contacto</h6>
                                        </div>
                                            <div class="card-body">

                                                <div class="form-group row" style="margin:0px; padding:0px;">
                                                    <div class="col-sm-12 col-md-6 col-lg-4" style="margin-bottom: 2px; margin-top: 0px;">
                                                        <label class="col-form-label form-control-label">Telefono Celular <span style="color:red;">*</span></label>
                                                        <input type="text" class="form-control form-control-sm" disabled value="<?php echo $datas[0]["telefono1"]; ?>">
                                                    </div>

                                                    <div class="col-sm-12 col-md-6 col-lg-4" style="margin-bottom: 2px; margin-top: 0px;">
                                                        <label class="col-form-label form-control-label">Telefono Casa <span style="color:red;">*</span></label>
                                                        <input type="text" class="form-control form-control-sm" disabled value="<?php echo $datas[0]["telefono2"]; ?>">
                                                    </div>

                                                    <div class="col-sm-12 col-md-6 col-lg-4" style="margin-bottom: 2px; margin-top: 0px;">
                                                        <label class="col-form-label form-control-label">Telefono Oficina <span style="color:red;">*</span></label>
                                                        <input type="text" class="form-control form-control-sm" disabled value="<?php echo $datas[0]["telefono3"]; ?>">
                                                    </div>
                                                </div>

                                                <div class="form-group row" style="margin:0px; padding:0px;">
                                                    <div class="col-sm-12 col-md-6 col-lg-6" style="margin-bottom: 2px; margin-top: 0px;">
                                                        <label class="col-form-label form-control-label">E-Mail <span style="color:red;">*</span></label>
                                                        <input type="text" class="form-control form-control-sm" disabled value="<?php echo $datas[0]["email"]; ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>



                                <div class="row mt-2">
                                    <div class="mx-auto col-sm-12 col-md-12 col-lg-12">
                                        <div class="card">
                                        <div class="card-header bgc-success-l3 d-style">
                                            <h6 class="text-success font-bold">Posición Laboral</h6>
                                        </div>
                                            <div class="card-body">

                                                <div class="form-group row" style="margin:0px; padding:0px;">
                                                    <div class="col-sm-12 col-md-6 col-lg-6" style="margin-bottom: 2px; margin-top: 0px;">
                                                        <label class="col-form-label form-control-label">Departamento <span style="color:red;">*</span></label>
                                                        <input type="text" class="form-control form-control-sm" disabled value="<?php echo $datas[0]["departamentos"]; ?>">
                                                    </div>
                                                    <div class="col-sm-12 col-md-6 col-lg-6" style="margin-bottom: 2px; margin-top: 0px;">
                                                        <label class="col-form-label form-control-label">Puesto</label>
                                                        <input type="text" class="form-control form-control-sm" disabled value="<?php echo $datas[0]["puestos"]; ?>">
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="mx-auto col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header bgc-success-l3 d-style">
                                <h4 class="text-success">Datos familiares</h4>
                            </div>
                            <div class="card-body">                                                        
                                <div class="form-group row" style="margin:0px; padding:0px;">
                                    <div class="col-sm-12 col-md-4 col-lg-12" style="margin-bottom: 2px; margin-top: 0px;">
                                        <div class="col-12" id="familiares_div">
                                            <table class="table" border="0">
                                                <tr>
                                                    <td colspan="3"><input style="visibility:hidden" type="text" name="familiares" id="familiares" value="" data-error="#errNm1"><div class="errorTxt"><span id="errNm1"></span></div></td>
                                                </tr>                         
                                            </table>                    
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="mx-auto col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group row" style="margin:0px; padding:0px;">
                            <div class="col-sm-12 col-md-6 col-lg-7" style="margin-bottom: 5px; margin-top: 10px;">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <button class="btn btn-warning btn-sm" id="backto"><i class="fas fa-backward"></i>&nbsp;Regresar</button>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

</div>
<?php

        $dats=$oconns->getRows("select generales.nombre,generales.apellido_p,generales.apellido_m,generales.edad,generales.idkey_sexo as sexo,familiares.idkey_parentesco,direcciones.domicilio,direcciones.idkey_estados,direcciones.idkey_municipios,direcciones.idkey_localidad,direcciones.idkey_codigo_postal,generales.ine,generales.rfc,generales.telefono1,generales.telefono2,generales.telefono3,generales.email from familiares,generales,direcciones where familiares.idkey_empleados='".$datas[0]["idkey"]."' and familiares.idkey_generales=generales.idkey and generales.idkey_direcciones=direcciones.idkey;");
        $final = "";

        foreach ($dats as $items){ $final = $items["nombre"] ."|". $items["apellido_p"]."|". $items["apellido_m"]."|". $items["edad"]."|".$items["sexo"]."|".$items["idkey_parentesco"]."|". $items["domicilio"]."|". $items["idkey_estados"]."|". $items["idkey_municipios"]."|". $items["idkey_localidad"]."|". $items["idkey_codigo_postal"]."|". "0" ."|". $items["ine"]."|". $items["rfc"]."|". $items["telefono1"]."|". $items["telefono2"]."|". $items["telefono3"]."|". $items["email"]."/".$final;}
?>
<input type="hidden" name="datas" id="datas" value="<?php echo $final; ?>">
<?php end_containers(); ?>


    <script>

        function ViewFamiliar(param1,param2)
        {


            param3=param2.split("|");
            $('#nombre_v').val(param3[0]);
            $('#apellido_p_v').val(param3[1]);
            $('#apellido_m_v').val(param3[2]);
            $('#edad_v').val(param3[3]);
            $('#sexo_v').val(param3[4]);
            $('#parentesco_v').val(param3[4]);

            if (param3[11]=="1")
            {
                $('#incompleto_v').show(1);
                $('#completo_v').hide();
                $('#domicilio_v').val('');
                $('#estados_v').val('');
                $('#municipios_v').html("<option value='' selected></option>");
                $('#localidad_v').html("<option value='' selected></option>");
                $('#codigo_postal_v').html("<option value='' selected></option>");
            }
            else
            {
                $('#incompleto_v').hide();
                $('#completo_v').show(1);
                $('#domicilio_v').val(param3[6]);
                $('#estados_v').val(param3[7]);

                $.ajax({type: "get",url:"../php/functions.php",data:"module=change_estadosTOmunicipios&step=1&param1="+param3[7]+"&param2="+param3[8],success:function(resultdado){ $('#municipios_v').html(resultdado);  }     }); 
                $.ajax({type: "get",url:"../php/functions.php",data:"module=change_municipiosTOlocalidad&param1="+param3[8]+"&param2="+param3[9],success:function(resultdado){ $('#localidad_v').html(resultdado);  }     }); 
                $.ajax({type: "get",url:"../php/functions.php",data:"module=change_localidadTOcodigo_postal&param1="+param3[9]+"&param2="+param3[10],success:function(resultdado){ $('#codigo_postal_v').html(resultdado);  }     }); 
                $('#tipo_direccion').val(param3[11]);

                
                $('#tipo_direccion').val(param3[11]);
            }            


            $('#ine_v').val(param3[12]);
            $('#rfc_v').val(param3[13]);
            $('#telefono1_v').val(param3[14]);
            $('#telefono2_v').val(param3[15]);
            $('#telefono3_v').val(param3[16]);
            $('#email_v').val(param3[17]);

            $('#modal_familiares_ver').modal('show'); 

        }


    $(document).ready(function()
    {


        $('#familiares_div').load("../php/familiares_show_2.php?data="+escape($('#datas').val()   ));
        $('#backto').click(function(){
            window.location = "empleados_busqueda.php?query=<?php echo $_GET["query"]; ?>";

        });
    });


    </script>


  <?php
create_footer();
?>
  

  </body>
</html>
