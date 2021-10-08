<?php


    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    require_once "../php/security.php";    
    require_once "../php/header_admin.php";
    require_once "../php/functions.php";    


    create_header();
    create_menu();
    begin_containers();
?>

<div class="container container-plus pos-rel">

        <div class="modal fade" id="modal_modificacion" tabindex="-1" role="dialog" aria-labelledby="label_modal_ver" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header"><h6 class="modal-title text-success font-bold" id="label_modal_ver">Modificacion de departamentos</h6><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>
                    <div class="modal-body">                
                        <div class="container-fluid">
                            <input type="hidden" id="idkey" value="0">
                                <div class="form-group row" style="margin:0px; padding:0px;">
                                    <div class="col-sm-12 col-md-4 col-lg-12" style="margin-bottom: 2px; margin-top: 0px;">
                                        <label class="col-form-label form-control-label">Nombre del departamento<span style="color:red;">*</span></label>
                                        <input type="text" class="form-control form-control-sm" name="nombre_f" id="nombre_f">
                                    </div>
                                </div>

                                <div class="form-group row" style="margin:0px; padding:0px;">
                                    <div class="col-sm-12 col-md-4 col-lg-12" style="margin-bottom: 2px; margin-top: 0px;">
                                        <label class="col-form-label form-control-label">Descripci&oacute;n<span style="color:red;">*</span></label>
                                        <textarea class="form-control required" id="descripcion_f" rows="5" cols="10" class="form-control" aria-label="With textarea"></textarea>
                                    </div>
                                </div>

                                <div class="form-group row" style="margin:0px; padding:0px;">
                                    <div class="col-sm-12 col-md-6 col-lg-7" style="margin-bottom: 5px; margin-top: 10px;">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <button onclick="secundary();" type="button" class="btn btn-success btn-sm"><i class="fas fa-save"></i>&nbsp;Guardar</button>

                                                <button data-dismiss="modal" type="button" class="btn btn-warning btn-sm"><i class="fas fa-window-close"></i>&nbsp;Cancelar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!--
                                    <form id="secundary">
                                        <input type="hidden" id="idkey" value="">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-4"><label for="nombre_f" style="padding-top: 10px;">Nombre del departamento</label></div>
                                                <div class="col-8"><input type="text" class="form-control form-control-sm" name="nombre_f" id="nombre_f" style="border:1px solid gray;"></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-4"><label for="descripcion_f" style="padding-top: 10px;">Descripci&oacute;n</label></div>
                                                <div class="col-8"><textarea class="required form-control"id="descripcion_f" rows="5" cols="10" class="form-control" aria-label="With textarea" style="border:1px solid gray;"></textarea></div>
                                            </div>
                                        </div>
                                    </div>
                                    </form>                                                   
                                -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-sm-center justify-content-md-center justify-content-lg-center mt-5">
            <div class="col-sm-12 col-lg-10">                                        
                    <div class="row">
                        <div class="mx-auto col-12">
                            <div class="card">
                                <h2 class="text-success p-4">Administracion de departamentos</h2>
                            <div class="card-body">

                                    <div class="row mt-2">
                                        <div class="mx-auto col-sm-12 col-md-12 col-lg-12">
                                            <div class="card">
                                            <div class="card-header bgc-success-l3 d-style">
                                                <h6 class="text-success font-bold">Nuevo departamento</h6>
                                            </div>
                                                <div class="card-body">

                                                    <div class="form-group row" style="margin:0px; padding:0px;">
                                                        <div class="col-sm-12 col-md-4 col-lg-12" style="margin-bottom: 2px; margin-top: 0px;">
                                                            <label class="col-form-label form-control-label">Nombre del departamento<span style="color:red;">*</span></label>
                                                            <input type="text" class="form-control form-control-sm" name="nombre" id="nombre">
                                                        </div>
                                                    </div>


                                                    <div class="form-group row" style="margin:0px; padding:0px;">
                                                        <div class="col-sm-12 col-md-4 col-lg-12" style="margin-bottom: 2px; margin-top: 0px;">
                                                            <label class="col-form-label form-control-label">Descripci&oacute;n<span style="color:red;">*</span></label>
                                                            <textarea class="form-control required" id="descripcion" rows="5" cols="10" class="form-control" aria-label="With textarea"></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row" style="margin:0px; padding:0px;">
                                                        <div class="col-sm-12 col-md-6 col-lg-7" style="margin-bottom: 5px; margin-top: 10px;">
                                                            <div class="row">
                                                                <div class="col-lg-12">
                                                                    <button onclick="mains();" id="safe_general" type="button" class="btn btn-success btn-sm"><i class="fas fa-save"></i>&nbsp;Guardar</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-12" id="resultados">
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
    end_containers();
?>


    <script>

        function modificacion(param)
        {
            $('#modal_modificacion').modal('show'); 

            $.ajax({type:"post",url:"php/search_general.php",data:"module=deparments_search&id="+param, success:function(resultado){

                    temp = resultado.split("|");
                    $('#nombre_f').val('');
                    $('#descripcion_f').val('');
                    $('#idkey').val('');
                    $('#nombre_f').val(temp[0]);
                    $('#descripcion_f').val(temp[1]);
                    $('#idkey').val(param);
            } });

        }


        function clearPrimary()
        {
            $('#nombre').val('');
            $('#descripcion').val('');
        }


        function mains()
        {
            if (document.getElementById("nombre").value.length==0)
            {
                alert("Introduzca el nombre del departamento");
                document.getElementById("nombre").focus();
            }
            else
                if (document.getElementById("descripcion").value.length==0)
                {
                    alert("Introduzca el nombre del departamento");
                    document.getElementById("descripcion").focus();
                }
                else
                {
                    $.ajax({type:"post",url:"php/safe_general.php",data:"module=deparments_new&nombre="+escape( $('#nombre').val())+"&descripcion="+escape($('#descripcion').val()), success:function(resultado)
                    {
                        $('#resultados').load("php/departamentos_show.php");
                        clearPrimary(); alertify.success("Datos guardados correctamente"); 
                        
                    }});                    
                }
        }


        function secundary()
        {

            if (document.getElementById("nombre_f").value.length==0)
            {
                alert("Introduzca el nombre del departamento");
                document.getElementById("nombre_f").focus();
            }
            else
                if (document.getElementById("descripcion_f").value.length==0)
                {
                    alert("Introduzca la descripcion del dapartamento");
                    document.getElementById("descripcion_f").focus();
                }
                else
                {

                    $.ajax({type:"post",url:"php/safe_general.php",data:"module=deparments_update&nombre="+escape( $('#nombre_f').val())+"&descripcion="+escape($('#descripcion_f').val())+"&idkey="+escape($('#idkey').val()), success:function(resultado){
                                                        clearPrimary(); alertify.success("Datos guardados correctamente"); 
                                                        $('#resultados').load("php/departamentos_show.php");
                                                        $('#modal_modificacion').modal('toggle'); 
                                                    }});

                }


        }

        $(document).ready(function()
        {

            $('#resultados').load("php/departamentos_show.php");
            $('#safe_secundary').click(function()
            {
                resultado = $("#secundary").valid();            
                if (resultado==true) $("#secundary").submit();
            });       
   

            $("#nombre").keyup(function(){$(this).val($(this).val().toUpperCase());});
            $('#nombre').on('input', function (e) { if (!/^[ a-záéíóúüñ]*$/i.test(this.value)) { this.value = this.value.replace(/[^ a-záéíóúüñ]+/ig,"");}});
            $("#descripcion").keyup(function(){$(this).val($(this).val().toUpperCase());});
            $('#descripcion').on('input', function (e) { if (!/^[ a-záéíóúüñ]*$/i.test(this.value)) { this.value = this.value.replace(/[^ a-záéíóúüñ]+/ig,"");}});
        });


    </script>


<?php
create_footer();
?>

  </body>
</html>
