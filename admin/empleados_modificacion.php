<?php


    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    require_once "../php/db.php";
    require_once "../php/security.php";
    require_once "../php/header_admin.php";
    require_once "../php/functions.php";    


    $id="";
    if (isset($_GET["id"])) $id=$_GET["id"];

    $oconns = new database();

    $datas=$oconns->getRows("select empleados.idkey,empleados.idkey_departamentos,empleados.idkey_puestos,empleados.idkey_generales,generales.idkey_direcciones,generales.nombre,generales.apellido_p,generales.apellido_m,generales.edad,generales.idkey_sexo,generales.ine,generales.rfc,direcciones.domicilio,direcciones.idkey_estados,direcciones.idkey_municipios,direcciones.idkey_localidad,direcciones.idkey_codigo_postal,generales.telefono1,generales.telefono2,generales.telefono3,generales.email from empleados,generales,direcciones where empleados.idkey='".$id."' and empleados.idkey_generales=generales.idkey and generales.idkey_direcciones=direcciones.idkey;");



    $dats=$oconns->getRows("select generales.idkey_direcciones,generales.nombre,generales.apellido_p,generales.apellido_m,generales.edad,generales.idkey_sexo as sexo,familiares.idkey_parentesco,direcciones.domicilio,direcciones.idkey_estados,direcciones.idkey_municipios,direcciones.idkey_localidad,direcciones.idkey_codigo_postal,generales.ine,generales.rfc,generales.telefono1,generales.telefono2,generales.telefono3,generales.email from familiares,generales,direcciones where familiares.idkey_empleados='".$datas[0]["idkey"]."' and familiares.idkey_generales=generales.idkey and generales.idkey_direcciones=direcciones.idkey;");
    $final = "";

    

    foreach ($dats as $items)
    {
        $xtipo_direcciones="0";
        if ($items["idkey_direcciones"]==$datas[0]["idkey_direcciones"]) $xtipo_direcciones=1;

    $final = $items["nombre"] ."|". $items["apellido_p"]."|". $items["apellido_m"]."|". $items["edad"]."|".$items["sexo"]."|".$items["idkey_parentesco"]."|". $items["domicilio"]."|". $items["idkey_estados"]."|". $items["idkey_municipios"]."|". $items["idkey_localidad"]."|". $items["idkey_codigo_postal"]."|".$xtipo_direcciones. "|".$items["ine"]."|". $items["rfc"]."|". $items["telefono1"]."|". $items["telefono2"]."|". $items["telefono3"]."|". $items["email"]."/".$final;
    }



    if ($oconns->numberRows==1)
        $final = str_replace("/","",$final);
    else
        $final = substr($final,0,strlen($final)-1);





    create_header();
    create_menu();
    begin_containers();
?>

<div class="container container-plus pos-rel">

        <div class="modal fade" id="modal_familiares_ver" tabindex="-1" role="dialog" aria-labelledby="label_modal_ver" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header"><h6 class="modal-title" id="label_modal_ver">Datos del familiar visualizar</h6><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>
                    <div class="modal-body">                
                        <div class="container-fluid" id="secundary">
                        <?php create_fields('1','_v',true,false); ?>
                        </div>
                    </div>
                    <div class="modal-footer">                                            
                        <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>



        <div class="modal fade" id="modal_familiares" tabindex="-1" role="dialog" aria-labelledby="label_modal_captura" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header"><h6 class="modal-title" id="label_modal_captura">Datos del familiar</h6><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>
                    <form id="secundario" name="secundario"  autocomplete="off">
                        <input type='hidden' name='tipo_direccion' id='tipo_direccion' value='1'>
                    <div class="modal-body">                
                        <div class="container-fluid" id="secundary">
                        <?php create_fields('1','_f',false,false); ?>
                        </div>
                    </div>                              
                    <div class="modal-footer">                                            
                        <button type="button" id="cancelar-secundary" class="btn btn-secondary btn-sm">Cancelar</button>
                        <button type="submit" id="ok-secundary" class="btn btn-primary btn-sm">Aceptar</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>



        <div class="row justify-content-sm-center justify-content-md-center justify-content-lg-center mt-5">
            <div class="col-sm-12 col-lg-10">
                        <input type="hidden" id="get_idkey" value="<?php echo $datas[0]["idkey"]; ?>">
                        <input type="hidden" id="get_idkey_generales" value="<?php echo $datas[0]["idkey_generales"]; ?>">
                        <input type="hidden" id="get_idkey_direcciones" value="<?php echo $datas[0]["idkey_direcciones"]; ?>">
                        <input type="hidden" id="get_nombre" value="<?php echo $datas[0]["nombre"]; ?>">
                        <input type="hidden" id="get_apellido_p" value="<?php echo $datas[0]["apellido_p"]; ?>">
                        <input type="hidden" id="get_apellido_m" value="<?php echo $datas[0]["apellido_m"]; ?>">
                        <input type="hidden" id="get_idkey_sexo" value="<?php echo $datas[0]["idkey_sexo"]; ?>">
                        <input type="hidden" id="get_edad" value="<?php echo $datas[0]["edad"]; ?>">
                        <input type="hidden" id="get_ine" value="<?php echo $datas[0]["ine"]; ?>">
                        <input type="hidden" id="get_rfc" value="<?php echo $datas[0]["rfc"]; ?>">
                        <input type="hidden" id="get_domicilio" value="<?php echo $datas[0]["domicilio"]; ?>">
                        <input type="hidden" id="get_idkey_estados" value="<?php echo $datas[0]["idkey_estados"]; ?>">
                        <input type="hidden" id="get_idkey_municipios" value="<?php echo $datas[0]["idkey_municipios"]; ?>">
                        <input type="hidden" id="get_idkey_localidad" value="<?php echo $datas[0]["idkey_localidad"]; ?>">
                        <input type="hidden" id="get_idkey_codigo_postal" value="<?php echo $datas[0]["idkey_codigo_postal"]; ?>">
                        <input type="hidden" id="get_telefono1" value="<?php echo $datas[0]["telefono1"]; ?>">
                        <input type="hidden" id="get_telefono2" value="<?php echo $datas[0]["telefono2"]; ?>">
                        <input type="hidden" id="get_telefono3" value="<?php echo $datas[0]["telefono3"]; ?>">
                        <input type="hidden" id="get_idkey_departamentos" value="<?php echo $datas[0]["idkey_departamentos"]; ?>">
                        <input type="hidden" id="get_idkey_puestos" value="<?php echo $datas[0]["idkey_puestos"]; ?>">
                        <input type="hidden" id="get_email" value="<?php echo $datas[0]["email"]; ?>">
                        <input type="hidden" name="datas" id="datas" value="<?php echo $final; ?>">
                <div class="row">
                    <div class="mx-auto col-12">
                        <div class="card">
                            <h2 class="text-success p-3">Modificaci??n de empleado</h2>
                            <div class="card-body">
                                <input type='hidden' name='tipo_direccion' id='tipo_direccion' value='1'>
                                <?php create_fields('0','_m',false,true); ?>
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
                                        <input style="visibility:hidden" type="text" name="familiares" id="familiares" value="" data-error="#errNm1">
                                        <div class="col-12" id="familiares_div">
                                            <table class="table" border="0">
                                                <tr>
                                                    <td colspan="3"><div class="errorTxt"><span id="errNm1"></span></div></td>
                                                </tr>                         
                                            </table>                    
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row" style="margin:0px; padding:0px;">
                                    <div class="col-sm-12 col-md-6 col-lg-7" style="margin-bottom: 5px; margin-top: 10px;">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <button type="button" id="agregar_familiares" class="btn btn-primary btn-sm bg-info" >Agregar</button>
                                            </div>
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
                                                <button id="principal" class="btn btn-success btn-sm"><i class="fas fa-save"></i>&nbsp;Guardar</button>

                                                <button id="backto" class="btn btn-danger btn-sm"><i class="fas fa-ban"></i>&nbsp;Cancelar</button>                                                           
                                            </div>
                                        </div>
                                    </div>
                                </div>

                    </div>
                </div>

            </div>
        </div>



</div>
    

<?php end_containers(); ?>


    <script>
        function DeleteFamiliar(param1,param2)
        {            
            alertify.confirm('Desea eliminar este familiar?', function(){ 

                $.ajax(
                    {
                        type: "post",
                        url:"../php/safe_general.php",
                        data:"module=employee_delete&param1="+param1+"&param2="+param2,
                        success:function(resultado){
                            $('#familiares').val(resultado.trim());
                            $('#familiares_div').load("../php/familiares_show.php?data="+escape(resultado.trim()));
                        } 
                    }); 
             });

            




        }

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


        $.fn.loadDatas();
        $('#cancelar-secundary').click( function(){ $.fn.empleado_clearSecundary(); setDisabled(true); $('#modal_familiares').modal('toggle');});
        $('#ok-secundary').click(function() { if ($('#ok-secundary').validate_generales_familiar()==true){ $.ajax({type: "post",url:"../php/familiares.php",data:"nombre_f="+escape( $('#nombre_f').val()) +"&apellido_p_f="+escape( $('#apellido_p_f').val()) +"&apellido_m_f="+escape( $('#apellido_m_f').val()) +"&edad_f="+escape( $('#edad_f').val()) +"&sexo_f="+escape( $('#sexo_f').val()) +"&parentesco="+escape( $('#parentesco_f').val()) +"&domicilio_f="+escape( $('#domicilio_f').val()) +"&estados_f="+escape( $('#estados_f').val()) +"&municipios_f="+escape( $('#municipios_f').val()) +"&localidad_f="+escape( $('#localidad_f').val()) +"&codigo_postal_f="+escape( $('#codigo_postal_f').val()) +"&tipo_direccion="+escape( $('#tipo_direccion').val()) +"&ine_f="+escape( $('#ine_f').val()) +"&rfc_f="+escape( $('#rfc_f').val()) +"&telefono1_f="+escape( $('#telefono1_f').val()) +"&telefono2_f="+escape( $('#telefono2_f').val()) +"&telefono3_f="+escape( $('#telefono3_f').val()) +"&email_f="+escape( $('#email_f').val())+"&cumulo="+escape( $('#familiares').val()),success:function(resultado){if (resultado.substring(0,2)=="E1"){ alertify.error("Error no se pueden agregar mas de un Padre paterno"); } else if (resultado.substring(0,2)=="E2"){ alertify.error("Error no se pueden agregar mas de una Madre paterna"); } else if (resultado.substring(0,2)=="E3") { alertify.error("Error no se pueden agregar mas de un Padre materno"); } else if (resultado.substring(0,2)=="E4") { alertify.error("Error no se pueden agregar mas de una Madre materna"); } else if (resultado.substring(0,2)=="E6") { alertify.error("Error no se pueden agregar mas de una pareja"); } else { $('#familiares').val(resultado); $('#familiares_div').load("../php/familiares_show.php?data="+escape(resultado));}}}); $('#modal_familiares').modal('toggle'); } });

        $("#principal").click(function(){ if ($("#principal").validate_generales_empleado()==true) { $.ajax({type:"post",url:"../php/safe_general.php",data:"module=employee_update&nombre="+escape( $('#nombre_m').val()) +"&apellido_p="+escape( $('#apellido_p_m').val()) +"&apellido_m="+escape( $('#apellido_m_m').val()) +"&edad="+escape( $('#edad_m').val()) +"&sexo="+escape( $('#sexo_m').val())+"&domicilio="+escape( $('#domicilio_m').val()) +"&estados="+escape( $('#estados_m').val()) +"&municipios="+escape( $('#municipios_m').val()) +"&localidad="+escape( $('#localidad_m').val()) +"&codigo_postal="+escape( $('#codigo_postal_m').val())+"&ine="+escape( $('#ine_m').val()) +"&rfc="+escape( $('#rfc_m').val()) +"&telefono1="+escape( $('#telefono1_m').val()) +"&telefono2="+escape( $('#telefono2_m').val()) +"&telefono3="+escape( $('#telefono3_m').val()) +"&email="+escape( $('#email_m').val())+"&familiares="+escape( $('#familiares').val())+"&departamentos="+escape($('#departamentos_m').val())+"&puestos="+escape($('#puestos_m').val())+"&idkey="+$("#get_idkey").val()+"&idkey_generales="+$("#get_idkey_generales").val()+"&idkey_direcciones="+$("#get_idkey_direcciones").val(), success:function(resultado){ $.fn.empleado_clearPrimary(); alertify.success("Datos guardados correctamente"); window.location="empleados_ver.php?id="+$('#get_idkey').val()+"&query=<?php echo $_GET["query"]; ?>";    }});}});       


        $('#agregar_familiares').on( "click", function() { if ( $('#domicilio_m').val()==""&&$('#codigo_postal_m').val()==""){ alertify.warning("No se pueden agregar familiares hasta no introducir la direccion del empleado"); } else { $.fn.empleado_clearSecundary(); $('#modal_familiares').modal('show');} });

        $('#opcion_direccion2_f').click(function(){ $('#tipo_direccion').val('0');  $('#completo_f').show(1); $('#incompleto_f').hide(); });
        $('#opcion_direccion3_f').click(function() { $('#tipo_direccion').val('1'); $('#completo_f').hide(); $('#incompleto_f').show(1); });


    $("#nombre_m").inputFilter(function(value){ return /^[a-zA-Z????????????????????????\s\t]*$/i.test(value);  });
    $("#nombre_p_m").inputFilter(function(value){ return /^[a-zA-Z????????????????????????\s\t]*$/i.test(value);  });
    $("#nombre_m_m").inputFilter(function(value){ return /^[a-zA-Z????????????????????????\s\t]*$/i.test(value);  });
    $("#edad_m").inputFilter(function(value){ return /^[0-9\t]*$/i.test(value);  });
    $('#estados_m').change(function(){ $('#estados_m').onchange_estados(  $('#estados_m').val(), '#municipios_m','#localidad_m','#codigo_postal_m'   );   }  );
    $('#municipios_m').change(function(){ $('#municipios_m').onchange_municipios(  $('#municipios_m').val(),'#localidad_m','#codigo_postal_m'   );   }  );
    $('#localidad_m').change(function(){ $('#localidad_m').onchange_localidad(  $('#localidad_m').val(),'#codigo_postal_m'   );   }  );


    $('#departamentos_m').change(function(){ $('#departamentos_m').onchange_departamentos(  $('#departamentos_m').val(),'#puestos_m');   }  );

    $("#ine_m").inputFilter(function(value){ return /^[0-9a-zA-Z\t]*$/i.test(value);  });
    $("#rfc_m").inputFilter(function(value){ return /^[0-9a-zA-Z\t]*$/i.test(value);  });
    $("#telefono1_m").inputFilter(function(value){ return /^[0-9\t]*$/i.test(value);  });
    $("#telefono2_m").inputFilter(function(value){ return /^[0-9\t]*$/i.test(value);  });
    $("#telefono3_m").inputFilter(function(value){ return /^[0-9\t]*$/i.test(value);  });


    $("#nombre_f").inputFilter(function(value){ return /^[a-zA-Z????????????????????????\s\t]*$/i.test(value);  });
    $("#nombre_p_f").inputFilter(function(value){ return /^[a-zA-Z????????????????????????\s\t]*$/i.test(value);  });
    $("#nombre_m_f").inputFilter(function(value){ return /^[a-zA-Z????????????????????????\s\t]*$/i.test(value);  });
    $("#edad_f").inputFilter(function(value){ return /^[0-9\t]*$/i.test(value);  });
    $('#estados_f').change(function(){ $('#estados_f').onchange_estados(  $('#estados_f').val(), '#municipios_f','#localidad_f','#codigo_postal_f'   );   }  );
    $('#municipios_f').change(function(){ $('#municipios_f').onchange_municipios(  $('#municipios_f').val(),'#localidad_f','#codigo_postal_f'   );   }  );
    $('#localidad_f').change(function(){ $('#localidad_f').onchange_localidad(  $('#localidad_f').val(),'#codigo_postal_f'   );   }  );
    $("#ine_f").inputFilter(function(value){ return /^[0-9a-zA-Z\t]*$/i.test(value);  });
    $("#rfc_f").inputFilter(function(value){ return /^[0-9a-zA-Z\t]*$/i.test(value);  });
    $("#telefono1_f").inputFilter(function(value){ return /^[0-9\t]*$/i.test(value);  });
    $("#telefono2_f").inputFilter(function(value){ return /^[0-9\t]*$/i.test(value);  });
    $("#telefono3_f").inputFilter(function(value){ return /^[0-9\t]*$/i.test(value);  });

    

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
