<?php


   header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    require_once "../php/db.php";
    require_once "../php/security.php";    
    require_once "../php/header_admin.php";
    require_once "../php/functions.php"; 
    


    $query="";
    if (isset($_GET["query"])) $query = $_GET["query"];

    create_header();
    create_menu();
    begin_containers();
?>
<style>

#register label{
    font-size:12px;
margin-right:5px;
}
#register input {
padding: 5px 14px;
border: 1px solid #d5d9da;

width: 272px;
font-size: 1em;
height: 25px;
}
#register .short{
font-weight:bold;
color:#FF0000;
font-size:larger;
}
#register .weak{
font-weight:bold;
color:orange;
font-size:larger;
}
#register .good{
font-weight:bold;
color:#2D98F3;
font-size:larger;
}
#register .strong{
font-weight:bold;
color: limegreen;
font-size:larger;
}
    </style>

<div class="container container-plus pos-rel">

        <div class="modal fade" id="modal_acceso" tabindex="-1" role="dialog" aria-labelledby="label_modal_ver" aria-hidden="true">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title text-success font-bold" id="label_modal_ver">Modificacion de departamentos</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">                
                        <div class="container-fluid">
                            <form id="register" autocomplete="new-password">
                                <input type="hidden" id="idkey" name="idkey" value="">
                            <div class="row">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-4"><label for="unamef" style="padding-top: 10px;">Nombre de usuario</label></div>
                                        <div class="col-8"><input type="text" class="form-control form-control-sm" name="unamef" id="unamef" style="border:1px solid gray;" autocomplete="off"></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-4"><label for="upass" style="padding-top: 10px;">Contrase&ntilde;a</label></div>
                                        <div class="col-8"><input type="password" class="form-control form-control-sm" name="upassf" id="upassf" style="border:1px solid gray;" autocomplete="off"><span id="result"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </form>                                                   
                        </div>
                    </div>
                    <div class="modal-footer">                      
                        <input type="button" value="Guardar" id="safe_secundary" class="btn btn-success btn-sm">
                        <button type="button" class="btn btn-warning btn-sm" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>


        <div class="row justify-content-sm-center justify-content-md-center justify-content-lg-center mt-5">
            <div class="col-sm-12 col-lg-10">                                        
                <div class="row">
                    <div class="mx-auto col-12">
                        <div class="card">
                            <h2 class="text-success p-3">Control de Acceso</h2>
                            <div class="card-body">
                                <div class="form-group row" style="margin:0px; padding:0px;">
                                    <div class="col-sm-12 col-md-12 col-lg-12" style="margin-bottom: 2px; margin-top: 0px;">
                                        <label class="col-form-label form-control-label text-success-d1 text-100">Nombre del Empleado <span style="color:red;">*</span></label>
                                        <input type="text"  size="10"  class="form-control form-control-sm" value="<?php echo $query; ?>" name="busqueda" id="busqueda">
                                    </div>                        
                                </div>

                                <div class="form-group row" style="margin:0px; padding-top:10px;">
                                    <div class="col-sm-12 col-md-12 col-lg-12 text-right" style="margin-bottom: 2px; margin-top: 0px;">
                                        <button id="boton_buscar" class="btn btn-success btn-sm"><i class="fas fa-search"></i>&nbsp; Buscar</button>
                                    </div>                                                            
                                </div>
                                <hr>
                            </div>
                            
                            <div class="mx-auto col-12">
                                <h4 class="p-3">Resultados</h4>
                                <div class="form-group row" style="margin:0px; padding:0px;">
                                    <div class="col-sm-12" style="margin-bottom: 2px; margin-top: 0px;">
                                        <div class="row" id="busqueda_resultado">
                                            <table border="0" class="table">
                                                <tr>
                                                    <th>&nbsp;</th>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div> <!--/card-->
                    </div>
                </div>
            </div> <!--Col-sm-12 col-lg-10 -->
        </div> <!--/row justify content-->

</div>


<?php 
    end_containers();

?>


    <script>

        function viewAccess(param1)
        {
            $("#unamef").prop("disabled", false);
            $.ajax({type:"post",url:"../php/search_general.php",data:"module=access_datas&id="+param1, success:function(resultado)
            {
                temp = resultado.split("|");
                if (temp[0].trim()!="") $("#unamef").prop("disabled", true);            
                $('#unamef').val(temp[0].trim());
                $('#upassf').val(temp[1].trim());
                $('#idkey').val(temp[2].trim());
                $('#unamef').focus();

            } });
            $('#modal_acceso').modal('show'); 
        }

        $(document).ready(function () {

            $('#safe_secundary').click(function(){

                if ($('#unamef').val()=="")
                {
                    alert("Introduzca el nombre de usuario");
                    $('#unamef').focus();
                }
                else
                    if ($('#upassf').val()=="")
                    {
                        alert("Introduzca la contraseña");
                        $('#upassf').focus();
                    }
                    else
                    {

                        $.ajax({type:"post",url:"../php/safe_general.php",data:"module=access_safe&uname="+escape($('#unamef').val())+"&upass="+escape($('#upassf').val()) +"&id="+($('#idkey').val()), success:function(resultado){                         
                            if (resultado.trim()=="OK")
                            {
                                alertify.success("Datos guardados correctamente");
                                $('#modal_acceso').modal('toggle'); 
                                $.ajax({type:"post",url:"../php/search_general.php",data:"module=access_search&busqueda="+$('#busqueda').val(), success:function(resultado){ $('#busqueda_resultado').html(resultado); } });                
                            }
                            else
                            {
                                alertify.error("El nombre de usuario ya existe, por favor intente uno diferente");
                            }
                        } });

                    }
                 
            });




            if ( $('#busqueda').val().length>0)
            {

                $.ajax({type:"post",url:"../php/search_general.php",data:"module=access_search&busqueda="+$('#busqueda').val(), success:function(resultado){ $('#busqueda_resultado').html(resultado); } });                

            }

            $('#boton_buscar').click(function(){
                if ($('#busqueda').val()=="")
                {
                    alert("Introduzca el criterio de busqueda");
                    $('#busqueda').focus();
                }
                else
                {
                    $.ajax({type:"post",url:"../php/search_general.php",data:"module=access_search&busqueda="+$('#busqueda').val(), success:function(resultado){ $('#busqueda_resultado').html(resultado); } });
                }

            });







$('#upass').keyup(function() {
$('#result').html(checkStrength($('#upass').val()))
})
function checkStrength(password) {
var strength = 0
if (password.length < 6) {
$('#result').removeClass()
$('#result').addClass('short')
return 'Too short'
}
if (password.length > 7) strength += 1
// If password contains both lower and uppercase characters, increase strength value.
if (password.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/)) strength += 1
// If it has numbers and characters, increase strength value.
if (password.match(/([a-zA-Z])/) && password.match(/([0-9])/)) strength += 1
// If it has one special character, increase strength value.
if (password.match(/([!,%,&,@,#,$,^,*,?,_,~])/)) strength += 1
// If it has two special characters, increase strength value.
if (password.match(/(.*[!,%,&,@,#,$,^,*,?,_,~].*[!,%,&,@,#,$,^,*,?,_,~])/)) strength += 1
// Calculated strength value, we can return messages
// If value is less than 2
if (strength < 2) {
$('#result').removeClass()
$('#result').addClass('weak')
return 'Weak'
} else if (strength == 2) {
$('#result').removeClass()
$('#result').addClass('good')
return 'Good'
} else {
$('#result').removeClass()
$('#result').addClass('strong')
return 'Strong'
}
}











        });



    </script>


    
<?php
create_footer();
?>
  </body>
</html>
