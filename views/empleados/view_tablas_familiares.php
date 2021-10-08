<div id="formdatosGarantias" class="collapse show" aria-labelledby="datosGarantias" data-parent="#nuevoClienteAlta4">
    <div class="card-body text-grey-d3">
            <!-- MODAL -->

        <div class="modal fade modal-lg" id="modal_tablas_fam" tabindex="-1" role="dialog" aria-hidden="true">

                <div class="modal-dialog modal-dialog-scrollable" role="document">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h5 class="modal-title text-success">Familiares</h5>
                        
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body ace-scrollbar" style="margin: 10px;">
                            <div class="row" >
                                <div class="col-12" >
                                    <input type="text"  id="idkey_fam" hidden>

                                    <table class="table table-sm table-hover text-uppercase text-center" id="tabla_fam" >
                                    <thead style="font-size: 12px;" > 
                                        <tr class="table-secondary">
                                            <th scope="col">ID</th>
                                            <th scope="col">Nombre</th>
                                            <th scope="col">Fecha</th>
                                            <th scope="col">Celular</th>
                                            <th scope="col">INE</th>
                                            <th scope="col">Empleado</th>                                    
                                            <th scope="col">Parentesco</th>
                                            <th scope="col">Domicilio</th>
                                            <th scope="col">Acciones</th>
                    
                                        </tr>
                                    </thead>
                                    <tbody style="font-size: 10px;" class=" ">

                                    </tbody>
                                </table>

                                </div><!-- /.col -->

             
                            </div><!-- /.row -->
                        </div>



                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" id="cerrar"  data-dismiss="modal" >Cerrar</button>
                            <button type="button" id="btnEdit_usuario" class="btn btn-success" onclick="agregar_familiar();" >Agregar Familiar</button>
                        </div>

                    </div>
                </div>
             
    
                    
        </div> <!-- / class="collapse" -->
    </div> <!-- / Card Garantias -->

</div> <!-- /PRINCIPAL-->    


<!-- <th class="border-0">ID</th>
                                    <th class="border-0">Nombre</th>
                                    <th class="border-0">Fecha Registro</th>
                                    <th class="border-0">INE</th>                      
                                    <th class="border-0">Número Celular</th>  
                                    <th class="border-0">Nombre de Empleado</th> 
                                    <th class="border-0">Parentesco</th>  
                                    <th class="border-0">Domicilio</th> 
                                    <th class="border-0">Acciones</th>    -->