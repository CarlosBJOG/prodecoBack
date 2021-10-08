const url = "../php/json_func_empleados.php";
const fragment = document.createDocumentFragment();
//funcion principal 
const init = ()=>{
    let select_estados = $('#estado');
     //cargar genero
     $('#sexo').empty();
    sexo()
        .then( (generos) => {
            $.each(generos, (i, data) => {
                $('#sexo').append($("<option>", {
                    value: data.idkey,
                    text: data.nombre
                  }));
            })

        })
        .catch(err => alertify.error(err));
   
    //cargar estados
    get_estados()
        .then((estados) => {
           
            $.each(estados, (i, data) => {
                select_estados.append($("<option>", {
                    value: data.idkey,
                    text: data.nombre
                  }));
            })

            select_estados.change(() => {
                $('#ciudad').empty();
                $('#localidad').empty();
                $('#cp').empty();

                let idEstado = $('#estado').val();

                return loadCiudades_usuario(idEstado);
            });
            
        })
        .catch(err => alertify.error(err));
}


const btnEmpleado = () => {
   
    var form = $( "#form_empleados" );
    form.validate({errorClass: 'text-error'});

   if(form.valid()){
        Swal.fire({
            title: '¿Está seguro de guardar los datos del empleado?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Guardar',
            cancelButtonText: 'Cancelar'
            }).then(function (result) {
                if (result.value) {
                    var nombre = $('#nombre').val();
                    var apellido_p = $('#apellido_p').val();
                    var apellido_m = $('#apellido_m').val();
                    var edad = $('#edad').val();
                    var sexo = $('#sexo').val();
                    var domicilio = $('#domicilio').val();
                    var estado = $('#estado').val();
                    var ciudad = $('#ciudad').val();
                    var localidad = $('#localidad').val();
                    var cp = $('#cp').val();
                    var ine = $('#ine').val().toUpperCase();
                    var rfc =  $('#rfc').val().toUpperCase();
                    var num_cel = $('#num_celular').val();
                    var num_casa = $('#num_casa').val();
                    var num_oficina = $('#num_oficina').val();
                    var email = $('#email').val();

                    

                    var array = [nombre, apellido_p, apellido_m, edad, sexo, domicilio, estado, ciudad, localidad, cp, ine, rfc, num_cel, num_casa, num_oficina, email];
                    guardar_datos("guardar_empleado", array)
                        .then((valor) => {
                            load_modal_permisos()  
                        })
                        .catch(err => console.log(err));
                }
                else{
                    Swal.fire('Operación cancelada', '', 'error');
                }
                
            });       
     }
    
}

//cargar genero
const sexo = ()=>{
    
    return new Promise((resolve, reject) => {
        $.ajax( {
            url: url,
            dataType: 'json',
            type: 'POST',
            async: true,
            data:  {funcion: "cargar_sexo"},
            beforeSend: ()=> {

            },success: (response) => {
                (response['error']== 1 && response == '')
                    ? reject("Error al cargar la Ciudad")
                    : resolve(response);
            },error: (data) => {
                console.log(data);
                reject("Ocurrio un error")
            }
        })
    })
   

}


//cargar estados
const estados = () => {

    return new Promise((resolve, reject) => {
        $.ajax({
            url: url,
            dataType: 'json',
            type: 'POST',
            async: true,
            data: {
                funcion: "cargar_estados"
            },beforeSend: ()=>{

            },success: (response) => {
                (response['error']== 1 || response == '')
                    ? reject("error en promesa de estados")
                    : resolve(response);
            },error: (data) => {
                console.log(data);
                reject("Ocurrio un error")
            }
        });
    })

}

const get_estados = async () => {

    try{
        const id_estado = await estados();
        return id_estado;
    }catch(err){
        throw err;
    }

}

// funciones para las ciudades
const loadCiudades_usuario = (idkey_estado) => {
    getCIudad(idkey_estado)
        .then((ciudades) => {
            $.each(ciudades, (i, data) => {
                $('#ciudad').append($("<option>", {
                    value: data.idkey,
                    text: data.nombre
                  }));
            })

            $('#ciudad').change(() => {
                $('#localidad').empty();
                $('#cp').empty();

                let idCiudad = $('#ciudad').val();
                return load_localidadUsuario(idCiudad);
            });
        })
        .catch((err) => {
            alertify.error(err);
        });
}

const loadCiudades_familiar = (idkey_estado) => {
    getCIudad(idkey_estado)
        .then((ciudades) => {
            $.each(ciudades, (i, data) => {
                $('#ciudad2').append($("<option>", {
                    value: data.idkey,
                    text: data.nombre
                  }));
            })

            $('#ciudad2').change(() => {
                $('#localidad2').empty();
                $('#cp2').empty();

                let idCiudad = $('#ciudad2').val();
                return load_localidadFamiliar (idCiudad);
            });
        })
        .catch((err) => {
            alertify.error(err);
        });
}


//funciones para las localidades
const load_localidadUsuario = (idCiudad) =>{
    getLocalidad(idCiudad)
        .then((localidades) => {
            $.each(localidades, (i, data) => {
                $('#localidad').append($("<option>", {
                    value: data.idkey,
                    text: data.nombre
                }));
            })

            $('#localidad').change(() => {
                $('#cp').empty();

                let idLocalidad = $('#localidad').val();

                return load_cpUsuario(idLocalidad);
            });
        })
        .catch((err) => {
            alertify.error(err);
        });
}

const load_localidadFamiliar = (idCiudad) =>{
    getLocalidad(idCiudad)
        .then((localidades) => {
            $.each(localidades, (i, data) => {
                $('#localidad2').append($("<option>", {
                    value: data.idkey,
                    text: data.nombre
                }));
            })

            $('#localidad2').change(() => {
                $('#cp2').empty();

                let idLocalidad = $('#localidad2').val();

                return load_cpFamiliar(idLocalidad);
            });
        })
        .catch((err) => {
            alertify.error(err);
        });
}

//cargar codigo postal
const load_cpUsuario = (idLocalidad) =>{
    
    getCp(idLocalidad)
        .then((cp) => {
            $('#cp').empty(); 
            $.each(cp, (i, data) => {
                $('#cp').append($("<option>", {
                    value: data.idkey,
                    text: data.nombre
                }));
            })
         })
        .catch((err) => {
            alertify.error(err);
        });

}

const load_cpFamiliar = (idLocalidad) =>{
    
    getCp(idLocalidad)
        .then((cp) => {
            $('#cp2').empty(); 
            $.each(cp, (i, data) => {
                $('#cp2').append($("<option>", {
                    value: data.idkey,
                    text: data.nombre
                }));
            })
         })
        .catch((err) => {
            alertify.error(err);
        });

}

//cargar delegaciones
const getCIudad = valor =>{

    return new Promise((resolve, reject) => {
        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            data:  {
                funcion: 'cargar_delegacion',
                valor: valor
             
            },beforSend:function(){
                Swal.fire({
                    title: '¡Espere un momento!',
                    html: 'Cargando...',
                    allowOutsideClick: false,
                    onBeforeOpen: () => {
                        Swal.showLoading()
                    },
                });
            },
            success: function(response){
           
                swal.close();
                (response['error']!= 1 && response != '')
                    ? resolve(response)
                    : reject("Error al cargar la Ciudad");

              
            },
            error: function(data){
                swal.close();
                console.log(data);
                reject("Ocurrio un error")
    
            }
    
        });

    })    
}

//validar rfc
const validar_rfc = () =>{
    $.post(url,
        {funcion: "cargar_rfc"},
        function(data, status){
            data = JSON.parse(data);
            const rfc = $('#rfc').val().toUpperCase();
            $.each(data, function(i, response){
                if(rfc == response.rfc){
                    Swal.fire('El RFC ingresado ya existe');
                    $('#rfc').val('');

                }
            });

    });
}

const getLocalidad = (valor)=>{

    return new Promise ((resolve, reject) => {
        $.ajax({
            url: url,
            type: "POST",
            dataType: 'JSON',
            data: {
                funcion: "cargar_localidad",
                valor:valor
    
            },beforSend: function(){
                Swal.fire({
                    title: '¡Espere un momento!',
                    html: 'Cargando...',
                    allowOutsideClick: false,
                    onBeforeOpen: () => {
                        Swal.showLoading()
                    },
                });
    
            },success: function(response){
    
                swal.close();
                (response['error']!= 1 && response != '')
                    ? resolve(response)
                    : reject("Error al cargar Localidad");
                
      
                          
            },error: function(data){
                swal.close();
                reject("Ocurrio un error")
                console.log(data);
            }
        }); 
    })  
  
}

//obtener codigo postal
const getCp = (valor) => {
    
    return new Promise((resolve, reject) => {
        $.ajax({
            url: url,
            type: "POST",
            dataType: "json",
            data: {
                funcion: "cargar_cp",
                valor: valor
    
            },beforSend: function(){
                Swal.fire({
                    title: '¡Espere un momento!',
                    html: 'Cargando...',
                    allowOutsideClick: false,
                    onBeforeOpen: () => {
                        Swal.showLoading()
                    },
                });
    
            },success: function(response){
                swal.close();
               
                
                (response['error']!= 1 && response != '')
                    ? resolve(response)
                    : reject("Error al cargar CP");
    
            },error: function(data){
                console.log(data);
                reject("error en peticion ajax cp");
            }
    
        });

    })

}

//guardat datos del empleado
const guardar_datos = (funcion, array) =>{

    return new Promise((resolve, reject) => {
        $.ajax({
            url: url,
            dataType: 'json',
            type: 'POST',
            data: {
                funcion: funcion,
                datos: array,
    
            },beforSend: function(){
                Swal.fire({
                    title: '¡Espere un momento!',
                    html: 'Cargando...',
                    allowOutsideClick: false,
                    onBeforeOpen: () => {
                        Swal.showLoading()
                    },
                });
    
            },success: function(response){
                swal.close();       
    
                (response['error']== 1 || response == '')
                    ? reject("Ocurrio un error al guardar los datos")   
                    : resolve ("Datos Guardados");
                
            },error: function(data){
                swal.close();
                reject("Ocurrio un error")
                console.log(data);
            }
        });
    })
 
}

const load_modal_permisos = () => {
    getLastUser()
        .then((idkey) => modal_permisos(idkey))
        .catch(err => alertify.error(err));
}

const nuevoUsuario = () => {
    return new Promise((resolve, reject) =>{
        $.ajax({
            url: url,
            dataType: 'json',
            type: 'POST',
            async: true,
            data: {
                funcion:"ultimo_empleado",
            },beforeSend: ()=>{

            },success: (response)=>{
                (response == '')
                    ? reject("Ocurrio un error al cargar el empleado")
                    : resolve(response);

            },error: (data) => {
                console.log(data);
                reject('Ocurrio un error en peticion')
            }
        });
    })
}

const getLastUser = async ()=>{
    try {
        const idkey = await nuevoUsuario();
        
        return idkey;

    }catch(err) {
        throw err;
    }

}


const limpiar = () => {
    $('#nombre').val('');
    $('#apellido_p').val('');
    $('#apellido_m').val('');
    $('#edad').val('');
    $('#sexo').empty();
    $('#domicilio').val('');
    $('#estado').empty();
    $('#ciudad').empty();
    $('#localidad').empty();
    $('#cp').empty();
    $('#ine').val('');
    $('#rfc').val('');
    $('#num_celular').val('');
    $('#num_casa').val('');
    $('#num_oficina').val('');
    $('#email').val('');


}

const regresar = ()=>{
    window.location = "../admin/admin.php";

}

const datatable_empleados = () => {
    const parametros = {
        "funcion" : "cargar_tabla",
    };
   
    $.ajax({
        url: url,
        data: parametros,
        type: 'post',
        dataType: 'json',
        asycn: true,
        beforeSend: function () {
            $('#bodytable').html('<tr><td colspan=7 style="text-align:center"><div  class="spinner-grow text-success" role="status"><span class="sr-only">Loading...</span></div></td></tr>');
        },
        success: function (response) {
            
          
            const table = $("#datatable").dataTable();
            $.each(response, function(i, response) {
                let botones;

      
                     botones = '<a href="#" onclick="modal_fam('+response.idkey+');" class="btn radius-1 btn-sm btn-brc-tp btn-outline-primary btn-h-outline-primary btn-a-outline-primary btn-text-primary" title="Ingresar Familiar" target="_self"><i class="far fa-share-square"></i></a>' +
                    '<a href="#" onclick="modal_edit_usuario('+response.idkey+');"  class="btn radius-1 btn-sm btn-brc-tp btn-outline-success btn-h-outline-success btn-a-outline-success btn-text-success" title="Editar empleado" target="_self"><i class="far fa-edit"></i></a>' + 
                    '<a href="#"  onclick="permiso('+response.idkey+');" class="btn radius-1 btn-sm btn-brc-tp btn-outline-warning btn-h-outline-warning btn-a-outline-warning btn-text-warning" title="Editar Permisos" target="_self"><i class="fas fa-pen-nib"></i></a>' +
                    '<a href="#" onclick="delete_user('+response.idkey+');" class="btn radius-1 btn-sm btn-brc-tp btn-outline-danger btn-h-outline-danger btn-a-outline-danger btn-text-danger" title="Eliminar " target="_self"><i class="fas fa-user-minus"></i></a>'  ;
                    
                

                //Para alimentar el datatable
                table.fnAddData([
                    '<input type="checkbox" name="" id="" autocomplete="off" value="'+response.idkey+'"/>',
                    response.idkey,
                    response.nombre,
                    response.apellido_p,
                    response.apellido_m,
                    response.edad,
                    response.rfc,
                    response.email,
                    '<div class="text-secondary" ;>'+response.tipo_usuario+
                    '</div>',
                    response.nom_usuario,
                    response.fecha_registro,
                    '<div class="col text-center"><pre>'+botones+
                    '</pre></div>'
                    
               
                ]);
              });
        },
        error: function(data) {
          alertify.error("Ha ocurrido un error inesperado. Inténtelo más tarde!");
          console.log(data);
        }
    });
}

const clean = ()=> {
    $('#licence').empty();
    $('#licence2').empty();
    $('#username').val('');
    $('#password').val('');
}

const modal_permisos = (idkey) => {
    //mostrar modal
    clean();
    $("#modalPermisos").modal("show");
    $('#id').val(idkey);

    // //cargar permisos 

    $.ajax({
        url: url,
        type: "POST",
        dataType: "json",
        async: true,
        data: {
            funcion: "permisos"
        },beforSend: ()=> {

        },success: (response) => {
            // console.log(response);
            let licence = document.querySelector('#licence');       
            $.each(response, (i, data) => {
            
                let option = document.createElement('option');
                option.value = data.idkey;
                option.innerHTML = data.nombre;
                licence.appendChild(option);          

            });


        }, error: (data) => {
            console.log(data);
        }

    });   
}

const guardar_permiso = ()=> {

    var form = $( "#permisos" );
    form.validate({errorClass: 'text-error'});
    if(form.valid()){
        const id_usuario = $('#id').val();
        const nombre_usuario = $('#username').val();
        const contraseña = $('#password').val();
        const permiso_usuario = $('#licence').val();
    
        Swal.fire({
            title: '¿Está seguro de guardar los datos del usuario?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Guardar',
            cancelButtonText: 'Cancelar'
            }).then(function (result) {
                if (result.value) {
                    const datos_usuario = [id_usuario,nombre_usuario, contraseña, permiso_usuario];    

                    $.ajax({
                        url:url,
                        type: "POST",
                        dataType: "json",
                        async: true,
                        data:{funcion: "guardar_usuario", array: datos_usuario},
                        beforeSend: ()=>{

                        },success: (response)=>{
                            console.log(response);
                          
                            //se cierra el modal
                            $("#modalPermisos").modal("toggle");
                            $('.modal-backdrop').remove();
                            location.href = "../admin/admin.php";

                        },error: (data)=>{
                            console.log(data);
                        }

                    });
                }
                else{
                    Swal.fire('Operación cancelada', '', 'error');
           
                }
            });       
    }

}

const getInfo = async (id) => {
    try {
        const permisos_promise = await editar_permisos_promise(id);
        const datos = await cargar_usuario_promise(id);

        const select_permisos = document.querySelector('#licence2');       
        $('#username2').val(datos[0]);
        $('#user_name').val(datos[1]);
        $('#user_type').val(datos[2]);
        $.each(permisos_promise, (i, data) => {
        
            const option = document.createElement('option');
            option.value = data.idkey;
            option.innerHTML = data.nombre;
            select_permisos.appendChild(option);          

        });

        return datos;
    }catch(err){
        throw err;
    }
}


const editar_permisos_promise = (idkey)=>{
    //mostrar modal
    clean();
    $("#modal_edit_permisos").modal("show");
    $('#id').val(idkey);

    return new Promise ((resolve, reject) =>{
        //cargar permisos  
        $.ajax({
            url: url,
            type: "POST",
            dataType: "json",
            async: true,
            data: {
                funcion: "permisos"
            },beforSend: ()=> {

            },success: (response) => {
                
               resolve(response);


            }, error: (data) => {
               reject(data);
            }

        }); 
    });       
}

const cargar_usuario_promise = (idkey)=> {
    return new Promise((resolve, reject)=>{
           //cargar permisos  
           $.ajax({
            url: url,
            type: "POST",
            dataType: "json",
            async: true,
            data: {
                funcion: "cargar_usuario",
                idkey: idkey
            },beforSend: ()=> {

            },success: (response) => {
                let nombre;
                let usuario;
                let tipo_usuario;
                if(response == ''){
                    alertify.error('Ocurrio un error');
                    //se cierra el modal
                                        
                    setTimeout(()=>{
                        $("#modal_edit_permisos").modal("toggle");
                        $('.modal-backdrop').remove();
                    }, 1000)
                }else{
                    let datos = [];
                    $.each(response, (i, data)=>{
                        nombre = data.nombre;
                        usuario = data.usuario;
                        tipo_usuario = data.nombre_usuario;
                        datos = [nombre, usuario, tipo_usuario];
                    });
                    resolve(datos);
                    
                }


            }, error: (data) => {
                console.log(data);
               reject("ocurrio un error");
            }

        }); 
    });
}

const permiso = (id) => {
    getInfo(id)
        .then(permiso => permiso)
        .catch((err) => {
            alertify.error(err);
            setTimeout(()=>{
                $("#modal_edit_permisos").modal("toggle");
                $('.modal-backdrop').remove();
            }, 1000)

        });
}

const guardar_edicion = () => {
    const idkey = $('#id').val();
    const perfil = $('#licence2').val();
    const user_name = $('#user_name').val();


    let array_edit = [idkey, perfil, user_name];
    //console.log(array_edit);
    Swal.fire({
        title: '¿Está seguro de actualizar los datos del empleado?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Guardar',
        cancelButtonText: 'Cancelar'
        }).then(function (result) {
            if (result.value) {
                $.ajax({
                    url:url,
                    type: 'POST',
                    dataType: 'json',
                    async: true,
                    data: {
                        funcion: "guardar_edicion",
                        array:array_edit
                    },beforSend: () => {
            
                    },success: (response) => {
                        (response === 0)
                            ? alertify.error('Ocurrio un error al guardar los cambios')
                            : window.location.reload(true);
            
                    },error: (data) => {
                        console.log(data);
                    }
                });

            }
            else{
                Swal.fire('Operación cancelada', '', 'error');
            }
            
        }); 
    

}

const delete_user = (idkey) => {

    console.log(idkey);
    swal.fire({
        title: '¿Desea borrar los datos permanentemente?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Guardar',
        cancelButtonText: 'Cancelar'
        }).then(function (result) {
            if (result.value) {
                $.ajax({
                    url:url,
                    type: 'POST',
                    dataType: 'json',
                    async: true,
                    data: {
                        funcion: "delete",
                        idkey
                    },beforSend: () => {
            
                    },success: (response) => {
                        (response === 0)
                            ? alertify.error('Ocurrio un error al guardar los cambios')
                            : Swal.fire({
                                icon: 'success',
                                title: 'Aviso',
                                confirmButtonText: 'Aceptar',
                                text: 'Empleado eliminado correctamente.',
                                footer: '',
                                showCloseButton: true
                              })
                                .then(function (result) {
                     
                                    window.location.reload(true);
                                   
                              }); 
            
                    },error: (data) => {
                        console.log(data);
                    }
                });

            }
            else{
                Swal.fire('Operación cancelada', '', 'error');
            }
            
        
    })
}

const modal_edit_usuario = (idkey) => {


    $("#modal_edit_usuario").modal("show");
    $('#idkey_usuario').val(idkey);
    // $('#btnEdit_usuario').click(function(){
    //     console.log(idkey)
    // });
    sexo()
        .then( (generos) => {
            $.each(generos, (i, data) => {
                $('#sexo').append($("<option>", {
                    value: data.idkey,
                    text: data.nombre
                  }));
            })

        })
        .catch(err => alertify.error(err));

           //cargar estados
    get_estados()
        .then((estados) => {
        
            $.each(estados, (i, data) => {
                $('#estado').append($("<option>", {
                    value: data.idkey,
                    text: data.nombre
                }));
            })

            $('#estado').change(() => {
                $('#ciudad').empty();
                $('#localidad').empty();
                $('#cp').empty();

                let idEstado = $('#estado').val();

                return loadCiudades_usuario(idEstado);
            });
            
        })
        .catch(err => alertify.error(err));


    getInfoEmpleado(idkey)
        .then(([empleado]) => {
            console.log(idkey)
            $('idkey_usuario').val(idkey);
            $('#nombre').val(empleado.nombre);
            $('#apellido_p').val(empleado.apellido_p);
            $('#apellido_m').val(empleado.apellido_m);
            $('#edad').val(empleado.edad);
            $('#ine').val(empleado.ine);
            $('#rfc').val(empleado.rfc);
            $('#num_celular').val(parseFloat( empleado.celular));
            $('#num_casa').val(empleado.tel_casa);
            $('#num_oficina').val(empleado.tel_oficina);
            $('#email').val(empleado.email);
            $('#domicilio').val(empleado.domicilio);
        })
        .catch(err => console.log(err));

    

    // console.log(estado);

}

const getEmpleado = (idkey) => {
    return new Promise((resolve, reject) => {
        (idkey != '')
            ? $.ajax({
                url: url,
                dataType: 'json',
                type: 'POST',
                async: true,
                data: {
                    funcion: "cargar_empleado",
                    idkey
                },beforSend: () => {

                },success: (response) => {
                    resolve(response);
                },error: (data) => {
                    console.log(data);
                    reject("Ocurrio un error inesperado")
                }
            })
            : reject("Ocurrio un error en promesa");
    });
}

const getInfoEmpleado = async (idkey) => {
    try{
        const empleado = await getEmpleado(idkey);
        return empleado;

    }catch(error){
        throw error;

    }

}

const guardar_edit_usuario = () => {
    const idkey = $('#idkey_usuario').val();
    const form = $( "#edit_usuario" );
    form.validate({errorClass: 'text-error'});

    if(form.valid()){
        
        Swal.fire({
            title: '¿Está seguro de guardar los datos del empleado?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Guardar',
            cancelButtonText: 'Cancelar'
            }).then(function (result) {
                if (result.value) {
                    var nombre = $('#nombre').val();
                    var apellido_p = $('#apellido_p').val();
                    var apellido_m = $('#apellido_m').val();
                    var edad = $('#edad').val();
                    var sexo = $('#sexo').val();
                    var domicilio = $('#domicilio').val();
                    var estado = $('#estado').val();
                    var ciudad = $('#ciudad').val();
                    var localidad = $('#localidad').val();
                    var cp = $('#cp').val();
                    var ine = $('#ine').val().toUpperCase();
                    var rfc =  $('#rfc').val().toUpperCase();
                    var num_cel = $('#num_celular').val();
                    var num_casa = $('#num_casa').val();
                    var num_oficina = $('#num_oficina').val();
                    var email = $('#email').val();

                    var array = [nombre, apellido_p, apellido_m, edad, sexo, domicilio, estado, ciudad, localidad, cp, ine, rfc, num_cel, num_casa, num_oficina, email, idkey];
                    guardar_datos("guardar_edit_empleado", array)
                        .then( valor => {
                            close_modal_edit();
                        })
                        .catch(error=> alertify.error(error));
                }
                else{
                    Swal.fire('Operación cancelada', '', 'error');
                }
                
            });       
       
    }
    
}


const close_modal_edit = () => {
    Swal.fire({
        icon: 'success',
        title: 'Aviso',
        confirmButtonText: 'Aceptar',
        text: 'Datos actualizados',
        footer: '',
        showCloseButton: true
        })
        .then(function (result) {
            $("#modal_edit_usuario").modal("toggle");
            $('.modal-backdrop').remove();
            window.location.reload(true);
        
    })

}


const close_modal_fam = (aviso) => {
    Swal.fire({
        icon: 'success',
        title: 'Aviso',
        confirmButtonText: 'Aceptar',
        text: aviso,
        footer: '',
        showCloseButton: true
        })
        .then(function (result) {
            $("#modal_familiar").modal("toggle");
            $('.modal-backdrop').remove();
            window.location.reload(true);
        
    })

}

const valid_fam = (idkey) => {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: url,
            dataType: 'json',
            type: 'POST',
            async: true,
            data:{
                funcion: "validar_fam",
                idkey: idkey
            },beforSend: ()=> {

            },success: (response) => {
                resolve(response);
            },error: (data) => {
                console.log(data);
                reject("Ocurrio un error al cargar el formulario");
            }
        });
    });
}


const modal_fam = (idkey, flag = false) =>{
        if(flag == false){
            valid_fam(idkey)
                .then(([value]) => {
                    let numero =parseFloat( value.num_familiar)
                    if(numero > 0){
                        $('#idkey_fam').val(idkey);
                        modal_tablas(idkey);
                    }else{
                        $('#parentesco').empty();
                        $("#modal_familiar").modal("show");
                        $('#idkey_usuario2').val(idkey);
                    }
                })
                .catch((error) => alertify.error(error));
        }          
       
        parentesco();
        $('#sexo2').empty();
        sexo()
            .then( (generos) => {
                $.each(generos, (i, data) => {
                    $('#sexo2').append($("<option>", {
                        value: data.idkey,
                        text: data.nombre
                        }));
                })

            })
            .catch(err => alertify.error(err));

           //cargar estados
        get_estados()
            .then((estados) => {
            
                $.each(estados, (i, data) => {
                    $('#estado2').append($("<option>", {
                        value: data.idkey,
                        text: data.nombre
                    }));
                })

                $('#estado2').change(() => {
                    $('#ciudad2').empty();
                    $('#localidad2').empty();
                    $('#cp2').empty();

                    let idEstado = $('#estado2').val();

                    return loadCiudades_familiar(idEstado);
                });
                
            })
            .catch(err => alertify.error(err));

            
}



const parentesco = () => {

    let select = $('#parentesco');


    $.post(url,
    {funcion: "cargar_parentesco"},
    function(data, status){
        data = JSON.parse(data);
        //console.log(data);
        // pintarCard(data);
        $.each(data, function(i, data) {
            select.append("<option value=" + data.idkey + " id='value_sexo' >" + data.nombre + "</option>")
                       
        });
 
    });
}


const guardar_familiar = () => {
    const formulario = $('#add_fam');
    formulario.validate({errorClass: 'text-error'});
    if(formulario.valid()){
        Swal.fire({
            title: '¿Guardar datos del familiar?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Guardar',
            cancelButtonText: 'Cancelar'
            }).then(function (result) {
                if (result.value) {
                    let nombre = $('#nombre2').val();
                    let apellido_p = $('#apellido_p2').val();
                    let apellido_m = $('#apellido_m2').val();
                    let edad = $('#edad2').val();
                    let sexo = $('#sexo2').val();
                    let domicilio = $('#domicilio2').val();
                    let estado = $('#estado2').val();
                    let ciudad = $('#ciudad2').val();
                    let localidad = $('#localidad2').val();
                    let cp = $('#cp2').val();
                    let ine = $('#ine2').val().toUpperCase();
                    let parentesco =  $('#parentesco').val()
                    let num_cel = $('#num_celular2').val();
                    let num_casa = $('#num_casa2').val();
                    let email = $('#email2').val();
                    let idkey = $('#idkey_usuario2').val();

                    var array = [nombre, apellido_p, apellido_m, edad, domicilio, estado, ciudad, localidad, cp, ine, parentesco, num_cel, num_casa, email, sexo, idkey];
                    guardar_datos("guardar_familiar", array)
                        .then(value => close_modal_fam(value))
                        .catch(err => alertify.error(err))
                }
                else{
                    Swal.fire('Operación cancelada', '', 'error');
                }
                
            });       
    }
}

const modal_tablas = (idkey) =>{

    $("#modal_tablas_fam").modal("show");
    $('#idkey_fam').val(idkey);

    cargar_tablas(idkey);
}

const cargar_tablas = (idkey) => {

    $('#tabla_fam').dataTable().fnDestroy();
 
    $('#tabla_fam').DataTable({
        "ajax": {
            "url": url,
            "type": "POST",
            "dataSrc": "",
            "data" : {
              "idkey" : idkey,
              "funcion" : "cargar_fam"
            }
        },
        "columns": [
            {data: "id"},
            {data: "nombre"},
            {data: "fecha"},
            {data: "celular"},
            {data: "ine"},
            {data: "empleado"},
            {data: "parentesco"},
            {data: "domicilio"},
            {data: "acciones"}
        ],
        "bPaginate": false,
        "ordering": true,
        "searching": false,
        "bFilter": false,
        "bInfo": false,
        'sDom': 't' 
     });
}



const eliminar_familiar = (idkey) => {
    console.log(idkey);
    swal.fire({
        title: '¿Desea borrar los datos permanentemente?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Guardar',
        cancelButtonText: 'Cancelar'
        }).then(function (result) {
            if (result.value) {
                $.ajax({
                    url:url,
                    type: 'POST',
                    dataType: 'json',
                    async: true,
                    data: {
                        funcion: "delete_fam",
                        idkey
                    },beforSend: () => {
            
                    },success: (response) => {
                        (response === 0)
                            ? alertify.error('Ocurrio un error al eliminar los datos')
                            : Swal.fire({
                                icon: 'success',
                                title: 'Aviso',
                                confirmButtonText: 'Aceptar',
                                text: 'Familiar eliminado correctamente.',
                                footer: '',
                                showCloseButton: true
                              })
                                .then(function (result) {
                     
                                    window.location.reload(true);
                                   
                              }); 
            
                    },error: (data) => {
                        console.log(data);
                    }
                });

            }
            else{
                Swal.fire('Operación cancelada', '', 'error');
            }
            
        
    })
}

const agregar_familiar = ()=> {
    $("#modal_tablas_fam").modal("toggle");
    $('.modal-backdrop').remove();


    let idkey = $('#idkey_fam').val();

    $('#parentesco').empty();
    $("#modal_familiar").modal("show");
    $('#idkey_usuario2').val(idkey);

    modal_fam(idkey, true);
    
}

const editar_familiar = (idkey)=> {
    console.log(idkey);

    $("#modal_tablas_fam").modal("toggle");
    $('.modal-backdrop').remove();

    $('#parentesco').empty();
    $("#modal_familiar_edit").modal("show");
    $('#idkey_usuario2').val(idkey);

    modal_fam_edit(idkey);

    cargar_datos_fam(idkey, true)
        .then( ([datos])=> {
            $('#nombre3').val(datos.nombre);
            $('#apellido_p3').val(datos.apellido_p);
            $('#apellido_m3').val(datos.apellido_m);
            $('#edad3').val(datos.edad);
            $('#sexo3').val(datos.sexo);
            $('#parentesco3').val(datos.parentesco);
            $('#domicilio3').val(datos.domicilio);
            $('#ine3').val(datos.ine);
            $('#num_celular3').val(datos.num_cel);
            $('#num_casa3').val(datos.num_casa);
            $('#email3').val(datos.email);
            $('#idkey_usuario3').val(datos.idkey);
        })
        .catch(err=> alertify.error(err));

}

const modal_fam_edit = (idkey) =>{

    $('#idkey_usuario3').val();
    $('#parentesco3').empty();
    parentesco_edit();
    $('#sexo3').empty();
    sexo()
        .then( (generos) => {
            $.each(generos, (i, data) => {
                $('#sexo3').append($("<option>", {
                    value: data.idkey,
                    text: data.nombre
                    }));
            })

        })
        .catch(err => alertify.error(err));

       //cargar estados
    get_estados()
        .then((estados) => {
        
            $.each(estados, (i, data) => {
                $('#estado3').append($("<option>", {
                    value: data.idkey,
                    text: data.nombre
                }));
            })

            $('#estado3').change(() => {
                $('#ciudad3').empty();
                $('#localidad3').empty();
                $('#cp3').empty();

                let idEstado = $('#estado3').val();

                return loadCiudad_editfam(idEstado);
            });
            
        })
        .catch(err => alertify.error(err));

}

const loadCiudad_editfam = (idkey_estado) => {
    getCIudad(idkey_estado)
        .then((ciudades) => {
            $.each(ciudades, (i, data) => {
                $('#ciudad3').append($("<option>", {
                    value: data.idkey,
                    text: data.nombre
                  }));
            })

            $('#ciudad3').change(() => {
                $('#localidad3').empty();
                $('#cp3').empty();

                let idCiudad = $('#ciudad3').val();
                return load_localidadeditFam (idCiudad);
            });
        })
        .catch((err) => {
            alertify.error(err);
        });
}

const load_localidadeditFam = (idCiudad) =>{
    getLocalidad(idCiudad)
        .then((localidades) => {
            $.each(localidades, (i, data) => {
                $('#localidad3').append($("<option>", {
                    value: data.idkey,
                    text: data.nombre
                }));
            })

            $('#localidad3').change(() => {
                $('#cp3').empty();

                let idLocalidad = $('#localidad3').val();

                return load_cpFamEdit(idLocalidad);
            });
        })
        .catch((err) => {
            alertify.error(err);
        });
}


const load_cpFamEdit = (idLocalidad) =>{
    
    getCp(idLocalidad)
        .then((cp) => {
            $('#cp3').empty(); 
            $.each(cp, (i, data) => {
                $('#cp3').append($("<option>", {
                    value: data.idkey,
                    text: data.nombre
                }));
            })
         })
        .catch((err) => {
            alertify.error(err);
        });

}

const parentesco_edit = () => {

    let select = $('#parentesco3');


    $.post(url,
    {funcion: "cargar_parentesco"},
    function(data, status){
        data = JSON.parse(data);
        //console.log(data);
        // pintarCard(data);
        $.each(data, function(i, data) {
            select.append("<option value=" + data.idkey + " id='value_sexo' >" + data.nombre + "</option>")
                       
        });
 
    });
}

const cargar_datos_fam = (idkey)=>{
    return new Promise((resolve, reject) => {
        $.ajax({
            url: url,
            dataType: 'json',
            type: 'POST',
            async: true,
            data:{
                funcion: "cargar_info_fam",
                idkey
            },beforSend: () => {

            },success: (response) => {
                    
                (response['error']== 1 || response == '')
                    ? reject("Ocurrió un error al guardar los datos")   
                    : resolve (response);

            },error: (data) => {
                console.log(data);
                reject("Ocurrió un error al cargar los datos")
            }
        })
    })
}


const guardar_edit_fam = () => {
    let value = $('#idkey_usuario3').val();
    var form = $( "#edit_fam" );
    form.validate({errorClass: 'text-error'});
    if(form.valid()){
        Swal.fire({
            title: '¿Guardar datos del familiar?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Guardar',
            cancelButtonText: 'Cancelar'
            }).then(function (result) {
                if (result.value) {
                    let nombre = $('#nombre3').val();
                    let apellido_p = $('#apellido_p3').val();
                    let apellido_m = $('#apellido_m3').val();
                    let edad = $('#edad3').val();
                    let sexo = $('#sexo3').val();
                    let domicilio = $('#domicilio3').val();
                    let estado = $('#estado3').val();
                    let ciudad = $('#ciudad3').val();
                    let localidad = $('#localidad3').val();
                    let cp = $('#cp3').val();
                    let ine = $('#ine3').val().toUpperCase();
                    let parentesco =  $('#parentesco3').val()
                    let num_cel = $('#num_celular3').val();
                    let num_casa = $('#num_casa3').val();
                    let email = $('#email3').val();
                    let idkey = value

                    var array = [nombre, apellido_p, apellido_m, edad, domicilio, estado, ciudad, localidad, cp, ine, parentesco, num_cel, num_casa, email, sexo, idkey];
                    guardar_datos("actualizar_fam", array)
                        .then(value => close_modal_fam(value))
                        .catch(err => alertify.error(err))
                }
                else{
                    Swal.fire('Operación cancelada', '', 'error');
                }
                
            });       
    }

    
}





