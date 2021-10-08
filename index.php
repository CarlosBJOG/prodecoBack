<?php    
    @session_start(); 
    
    require_once "php/header_home.php";

    create_header();    
    //begin_containers();
?>
<div class="container-fluid">
    <div class="row justify-content-center">
        

                    <div class="col-lg-8 col-md-12 justify-content-center">
                        <div class="row mt-5">
                            <div class="col-lg-6 col-md-8 mx-auto">
                                <!-- form card login -->
                                <div class="card rounded shadow shadow-sm">
                                    <div class="card-header">
                                        <h3 class="mb-0">Acceso</h3>
                                    </div>
                                    <div class="card-body">
                                        <form class="form" role="form" autocomplete="off" id="formLogin" method="POST">
                                            <div class="form-group">
                                                <label for="uname1">Nombre de Usuario</label>
                                                <input type="text" class="form-control form-control-sm" name="uname1" id="uname1">
                                            </div>
                                            <div class="form-group">
                                                <label>Contraseña</label>
                                                <input type="password" class="form-control form-control-sm" name="pwds1" id="pwds1">
                                            </div>
                                            <button type="button" class="btn btn-success btn-sm float-right" id="btnLogin" onclick="entrar();">Entrar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

    </div>
    
</div>

<?php 
//end_containers();
 ?>


        <script type="text/javascript">

            function entrar()
            {
                if (document.getElementById("uname1").value=="")
                {
                    alert("Debe de proporcionar el nombre de usaurio");
                    document.getElementById("uname1").focus();
                }
                else
                    if (document.getElementById("pwds1").value=="")
                    {
                        alert("Debe de proporcionar el password del usuario");
                        document.getElementById("pwds1").focus();
                    }
                    else
                    {


                                        $.ajax({type: "post",url:"php/login.php",data: "uname1="+escape($('#uname1').val())+"&pwds1="+escape($('#pwds1').val()),
                                                    success:function(resultado){ 

                                                        if (resultado==0)
                                                        {
                                                            alertify.error("Error de usuario o contraseña");
                                                        }
                                                        else
                                                        {
                                                            
                                                            window.location.href="home.php";
                                                        }

                                                    },
                                                    error: function (xhr, textStatus, errorMessage) {alertify.error("Error al intentar guardar, por favor verifique su connexion de internet");}
                                                });

                    }
            }





        </script>
  </body>
</html>
