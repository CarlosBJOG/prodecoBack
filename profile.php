<?php

    require_once "php/security_home.php";    
    require_once "php/header_home.php";
    create_header();
    create_menu();
    begin_containers();
?>
                            <div class="col-12">
                                <div class="row justify-content-center">
                                    <div class="col-sm-12 col-md-12 col-lg-7">
                                        <div class="row rounded-top bg-info" style="border:1px solid rgb(223,223,223); padding: 13px;">
                                            <div class="col text-white"><b>Perfil de Usuario</b></div>
                                        </div>

                                        <div class="row rounded-bottom" style="border-bottom:1px solid rgb(223,223,223);border-left:1px solid rgb(223,223,223); border-right:1px solid rgb(223,223,223); padding: 10px;">
                                            <div class="col">

                                                    <div class="row justify-content-center">
                                                        <div class="col-lg-4">
                                                            <div class="card text-center">
                                                                <div class="card-body">
                                                                    <div class="row justify-content-center">
                                                                        <div class="col-sm-12 col-md-12 cold-lg-12 align-self-center">
                                                                            <div><img src="config/interface/default/images/empty.png"></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row justify-content-center mt-2">
                                                                        <div class="col-sm-12 col-md-12 cold-lg-12 align-self-center">
                                                                            <input type="file" id="file" />
                                                                            <label for="file" class="btn btn-primary btn-sm"><span>Subir</span></label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>                                            
                                                        </div>

                                                        <div class="col-lg-8">
                                                            <div class="row justify-content-center">
                                                                <div class="col-sm-12 col-md-3 col-lg-4 pt-1 pb-1">
                                                                    <label for="names" style="padding-top: 10px">Nombre(s)</label>
                                                                </div>
                                                                <div class="col-sm-12 col-md-8 col-lg-8 pt-1 pb-1">
                                                                    <input type="text" class="form-control form-control-sm" name="nombre" id="nombre">
                                                                </div>                            
                                                            </div>

                                                            <div class="row justify-content-center">
                                                                <div class="col-sm-12 col-md-3 col-lg-4 pt-1 pb-1">
                                                                    <label for="names" style="padding-top: 10px">Apellido Paterno</label>
                                                                </div>
                                                                <div class="col-sm-12 col-md-8 col-lg-8 pt-1 pb-1">
                                                                    <input type="text" class="form-control form-control-sm" name="nombre" id="nombre">
                                                                </div>                            
                                                            </div>

                                                            <div class="row justify-content-center">
                                                                <div class="col-sm-12 col-md-3 col-lg-4 pt-1 pb-1">
                                                                    <label for="names" style="padding-top: 10px">Apellido Materno</label>
                                                                </div>
                                                                <div class="col-sm-12 col-md-8 col-lg-8 pt-1 pb-1">
                                                                    <input type="text" class="form-control form-control-sm" name="nombre" id="nombre">
                                                                </div>                            
                                                            </div>

                                                            <div class="row justify-content-center">
                                                                <div class="col-sm-12 col-md-3 col-lg-4 pt-1 pb-1">
                                                                    <label for="names" style="padding-top: 10px">Nueva contraseña</label>
                                                                </div>
                                                                <div class="col-sm-12 col-md-8 col-lg-8 pt-1 pb-1">
                                                                    <input type="text" class="form-control form-control-sm" name="nombre" id="nombre">
                                                                </div>                            
                                                            </div>

                                                            <div class="row justify-content-center">
                                                                <div class="col-sm-12 col-md-3 col-lg-4 pt-1 pb-1">
                                                                    <label for="names" style="padding-top: 10px">Repetir Nueva contraseña</label>
                                                                </div>
                                                                <div class="col-sm-12 col-md-8 col-lg-8 pt-1 pb-1">
                                                                    <input type="text" class="form-control form-control-sm" name="nombre" id="nombre">
                                                                </div>                            
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12 text-right">
                                                            <input class="btn btn-primary submit btn-sm" type="submit" value="Guardar" />
                                                        </div>
                                                    </div>



                                                
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

<?php end_containers(); ?>

        



        <script type="text/javascript">
        $(document).ready(function(){});

        </script>


  </body>
</html>