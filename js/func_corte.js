 ModuloCorte = ( () => {
     //url del back
    const url =  "../php/json_func_corte.php";

    const fechaInput = document.querySelector('#fecha');
    const horaInput = document.querySelector('#hora');
    const usuarioInput = document.querySelector('#usuario');
    const efectivoInput = document.querySelector('#efectivo');
    const fondoInput = document.querySelector('#fondo');
    const form = $('#form_corte');
    //variables de cerrar corte 
    const fechaCorte = document.querySelector('#fecha_corte');
    const horaCorte = document.querySelector('#hora_corte');
    const efectivoCorte = document.querySelector('#efectivo_corte');
    const fondoCorte = document.querySelector('#fondo_corte');
    const efectivoIngresar = document.querySelector('#efectivoIngresar');
    const fondoIngresar = document.querySelector('#fondoIngresar');
    const numeroCorte= document.querySelector('#num_corte');
    const total_corte = document.querySelector('#total_corte');

    //funcion para abrir una caja nueva
    const abrir_caja =  () => {
        cargar_datos("ultimo_corte")
            .then(([value]) => {
                let datos = value;
                let id = evaluarFecha(value);
                redireccion(id, datos);
            })
            .catch((err) => {
                Swal.fire({
                    title: '¿No existen registros, desea abrir un corte nuevo?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Abrir Corte',
                    cancelButtonText: 'Cancelar'
                    }).then( (result) =>{
                        (result.value) 
                            ? nuevo_corte()
                            : Swal.fire('Operación cancelada', '', 'error');
                    }); 
            });
    }

    //funcion para evaluar los cortes actuales
    const redireccion = async (value, datos ='') => {
       
        if(value === 1 ){
            Swal.fire({
                title: 'Corte vigente No. : '+datos.idkey,
                text: "Debes cerrar el corte actual para abrir uno nuevo",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '¡Entendido!'
              }).then((result) => {
                if (result.value) {
                    window.location = "../corte/corte_actual.php?corte="+datos.idkey;
                }else{
                    Swal.fire(
                        '¡Operación Cancelada!',
                        '',
                        'success'
                      )
                }
              })

        }else if(value === 2){

            confirmSweet( '¿Desea abrir un corte nuevo?', 'Se abrirá un nuevo corte', "Abrir Corte" )
                .then((result) => {
                    if (result.value) {
                        cargarFondoActual();
                    }else{
                    Swal.fire(
                        '¡Operación Cancelada!',
                        '',
                        'success'
                      )
                }
                })

        }
    }

    //funcion para evaluar las fechas de los cortes registrados
    const evaluarFecha = ( { fecha_cierre } ) =>{
        let value = 0;
        (fecha_cierre === '0000-00-00 00:00:00')
            ? value = 1
            :value = 2;
        return value;
    }

    //creacion de nuevo corte (cuando no existe ningun registro)
    const nuevo_corte = ( fondoActual = 0 ) => {
        //cargamos la fecha y hora actual 
        let fecha = new Date().toLocaleString("MXN");
        let fechayHora = cargarFecha(fecha);

        //cargamos los datos para crear el nuevo corte 
        cargar_datos("cargar_usuario")
            .then(value => {
                $('#modalCaja').modal("show");
                fechaInput.value = fechayHora.fecha_cambiada;
                horaInput.value = fechayHora.hora;
                usuarioInput.value = value.nombre_usuario;
                efectivoInput.value = 0;
                fondoInput.value = fondoActual;

            })
            .catch(err => {
                alertify.error(err);
            });
    }

    const cargarFondoActual = async () => {
        const [{fondo}] = await datosAsync('cargarFondo');

        return nuevo_corte(fondo);

    };

    //funcion para cargar la fecha actual retorna formato (YYYY-mm-dd hh:mm:ss)
    const cargarFecha = (fecha)=> {

        let temp,
            fecha_cambiada,
            hora;
            
        //separamos la fecha de la hora
        temp = fecha.split(' ');
        //asignamos a variables locale slos valores de la fecha
        fecha_cambiada = temp[0];
        hora = temp[1];

        temp = fecha_cambiada.split('/');
        fecha_cambiada = `${temp[temp.length -1]}-${temp[1]}-${temp[0]}`;

        return { fecha_cambiada, hora };        
    }

    // funcion para abrir un corte nuevo y guardarlo en la bd
    const abrir_corte = () => {
        form.validate({errorClass: 'text-error'});        
        if(form.valid()){
            Swal.fire({
                title: '¿Desea guardar los cambios y abrir un corte nuevo?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#80df5c',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Guardar Corte',
                cancelButtonText: 'Cancelar'
                }).then(function (result) {
                    if(result.value) {
                        let efectivo = efectivoInput.value;
                        let fondo = fondoInput.value;
                        let datos = [efectivo, fondo];
                        guardar_datos("abrir_corte", datos)
                            .then(value => {
                                Swal.fire( value,
                                    '', 'success')
                                window.location = "../corte/corte_actual.php"
                            })
                            .catch(err =>{
                                Swal.fire(err, '', 'error');
                            });
                    }else{
                        Swal.fire('Operación cancelada', '', 'error');
                    }
                       
                }); 
        }
    }


      //funcion para formatear a moneda mxn
    const format_currency = (cantidad) => new Intl.NumberFormat('MXN', {style: 'currency',currency: 'MXN', minimumFractionDigits: 2}).format(cantidad);

    //fucnion para cagrar el datatable de corte
    const init_corte = async() => {
        let table = $('#table_corte').dataTable();
        let tableDatos = await tableCorte();
        let totalCaja =0;

        swal.close();
        tableDatos.forEach( ( {idkey_pago, monto, fecha_aplicacion} ) => {
           // //Para alimentar el datatable
            table.fnAddData([
                '<input type="checkbox" id="" autocomplete="off" value=""/>',
                idkey_pago,
                format_currency(monto),
                fecha_aplicacion,
           
            ])
            totalCaja = parseFloat(monto) + totalCaja;
            
       });

       let [{idkey, fondo}] = await datosAsync("ultimo_corte");
       swal.close();
       //inputs ocultos para hacer la comparacion de cantidades posteriormente
       $('#efectivoFloat').val(totalCaja);
       $('#fondoFloat').val(fondo);
       ////////////////////////////////////////////

       $('#efectivoCaja').text(format_currency(totalCaja));
       $('#corte').text(idkey);
       $('#fondo').text(format_currency(fondo));


    }

    //funcion para cargar el datatable de Historial de corte

    const initHistorial = async () => {
        
        let datos;
        let tableHistorial = $('#table_historial').dataTable();
        let {usuario, nombre_usuario} = await datosAsync('cargar_usuario');
        
        if ( usuario === "2"){
            
            datos = await datosAsync('cargarHistorialCompleto');
             
        }else {
            datos = await datosAsync('cargarHistorial');
        }
 
        swal.close();
        datos.forEach( ({idkey, monto, fondo, fecha_cierre, fecha_inicio}) => {
         
            botones = '<a href="#" onclick="ModuloCorte.infoCorte('+idkey+')" class="btn radius-1 btn-md btn-brc-tp btn-outline-primary btn-h-outline-primary btn-a-outline-primary btn-text-primary" title="Ver info" target="_self"><i class="far fa-question-circle"></i></a>';

            tableHistorial.fnAddData([
                '<input type="checkbox" id="" autocomplete="off" value=""/>',
                idkey,
                format_currency(monto),
                format_currency(fondo),
                fecha_inicio,
                fecha_cierre,
                botones,
            ])
        })
    }

    const infoCorte = async ( idkey ) => {
        $('#modalHistorial').modal("show");
        $('#headerHistorial').text(`Historial - Corte No.: ${idkey}`);

        let table =  $('#tableHistorial').dataTable();
        table.fnDestroy();
    
        table = $('#tableHistorial').dataTable({ 
            "bPaginate": false,
            "ordering": true,
            "searching": false,
            "bFilter": false,
            "bInfo": false,
            'sDom': 't',
           
         });

        const datos = await datosAsync( 'cargarPagosCorte', idkey );
        
        datos.forEach(({monto, fecha_aplicacion, idkey_pago}) => {
            table.fnAddData([
                format_currency(monto), fecha_aplicacion, idkey_pago
            ]);
            
        });
        swal.close();
        
    }

    //confirmar cerrar corte 
    const confirmCerrar = () => {
        Swal.fire({
            title: '¿Está seguro de cerrar el corte actual?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Cerrar',
            cancelButtonText: 'Cancelar'
            }).then( (result) =>{
              if (result.value) 
                modalCerrarCorte();
              else
                Swal.fire('Operación cancelada', '', 'error');
            });
    }

    //funcion para limpiar campos
    const clean = () => {
        efectivoIngresar.value = '';
        fondoIngresar.value = 0;
    }
    
    //modal para cerrar corte 
    const modalCerrarCorte = () => {
        clean();
        $('#modalCorte').modal("show");
        let btnCerrar = document.querySelector('#btnCerrarCorte');
        let fecha = new Date().toLocaleString("MXN");
        let form = $('#form_corte');
        let fechayHora = cargarFecha(fecha);

        let corte = $('#corte').text();
        let efectivoActual  = $('#efectivoCaja').text();
        let fondoActual = $('#fondo').text();
        let totalCaja = 0;

        //variables ocultas para hacer el calculo
        efectivoFloat = $('#efectivoFloat').val();
        fondoFloat = $('#fondoFloat').val();
       
      
        totalCaja =parseFloat( fondoFloat ) + parseFloat( efectivoFloat );

        totalCaja = format_currency( totalCaja )

        fechaCorte.value = fechayHora.fecha_cambiada;
        numeroCorte.value = corte;
        horaCorte.value = fechayHora.hora;

        efectivoCorte.value = efectivoActual; 
        fondoCorte.value = fondoActual;
        total_corte.value = totalCaja;
        total_corte.value = totalCaja;
        fondoIngresar.value = 0;

        fondoIngresar.addEventListener('blur', () => {
            if(parseFloat(fondoIngresar.value) > parseFloat( fondoFloat )){
                Swal.fire({
                    title: 'El fondo ingresado es mayor al fondo en caja',
                    text: "",
                    icon: 'warning',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: '¡Entendido!'
                  }).then((result) => {
                      if (result.value) {
                        fondoIngresar.value = '';
                      }
                      
                  })
            }
         
        }, true);

        //evento click del boton cerrar corte
        btnCerrar.addEventListener("click", () => {
            form.validate({errorClass: 'text-error'});        
            if(form.valid()){
                let valorEfectivo = efectivoIngresar.value;

          
                if(parseFloat(valorEfectivo) === parseFloat( efectivoFloat )){
                    let title = 'Cerrar corte\nEfectivo en caja: '+ format_currency(efectivoFloat)+ '\nEfectivo a retirar: ' + format_currency(valorEfectivo)  + '\nFondo a retirar: ' + format_currency( parseFloat(fondoIngresar.value) );

                  mensajeSweet( title )
                    .then( (result) =>{
                        if (result.value) return guardar_corte();
                        Swal.fire('Operación cancelada', '', 'error');
                    });
                    
                }else if(valorEfectivo >  parseFloat( fondoFloat )){
                    let title = '¡El monto ingresado es mayor al efectivo actual en caja!, ¿Desea continuar?';

                    mensajeSweet( title )
                        .then( (result) =>{
                            if (result.value) {
                                let title = '¿Desea cerrar corte?\nEfectivo en caja: '+ format_currency(efectivoFloat)+ '\nEfectivo a retirar: ' + format_currency(valorEfectivo) + '\nFondo a retirar: ' + format_currency( parseFloat(fondoIngresar.value) );

                                mensajeSweet( title )
                                    .then( (result) => {
                                        if (result.value) return guardar_corte();
                                        Swal.fire('Operación cancelada', '', 'error');
                                    } )
                            }     
                        });

                }else if(valorEfectivo < parseFloat( efectivoFloat )){

                    let title = 'El dinero ingresado es menor al efectivo en caja',
                        text = "Revisar el dinero en caja antes de continuar",
                        confirmButtonText = '¡Entendido!';
                  
                        confirmSweet( title, text, confirmButtonText)
                            .then((result) => {
                                if (result.value) {               
                                    let title = '¿Desea cerrar corte?\nEfectivo en caja: '+ format_currency(efectivoFloat)+ '\nEfectivo a retirar: ' + format_currency(valorEfectivo) + '\nFondo a retirar: ' + format_currency( parseFloat(fondoIngresar.value) );

                                    mensajeSweet( title )
                                        .then( (result) =>{
                                            if (result.value) return guardar_corte();
                                            Swal.fire('Operación cancelada', '', 'error');
                                        });
                                }

                            })
                }
            }
        });
    }

    //funcion para guardar corte
    const guardar_corte = async () => {
        let monto = parseFloat( efectivoIngresar.value ),
            fondo = fondoIngresar.value,
            fondoCaja = $('#fondoFloat').val();

            
        console.log(fondoCaja);
        let fondoActual = parseFloat( fondoCaja ) - parseFloat(fondo);
        let total = parseFloat(monto) + parseFloat(fondoActual);
        let datos = [monto, fondoActual, total];
        console.log(datos);

        // autorizacion de supervisoro admin
        autorizacion(datos);
    }

    const autorizacion =  ( datos = []) => {
        document.querySelector('#user').value = '',
        document.querySelector('#pass').value = '';
      
        $('#modalConfirm').modal("show");
        $('#modalCorte').modal("toggle");

        let formConfirm = $('#form_confirm');
        let btnConfirm = $('#btnConfirm');
        let idCorte = num_corte.value;
        
        btnConfirm.click(async () => {
            formConfirm.validate({errorClass: 'text-error'});        
            if(formConfirm.valid()){
                let pass = document.querySelector('#pass').value;
                const flag = await evaluar(pass);

                if ( flag ) {

                    alertify.success('Usuario y Contraseña correctos');
                    
                    const mensaje = await guardar_corteAsync(datos, idCorte);

                    if( mensaje === 1 ){

                        alertSweet( 'Datos Guardados Correctamente' )
                            .then( (result) =>{
                                if( result.value){
                                    
                                    window.location = "../corte/corte_caja.php";
                                    swal.close();
                                }
                                
                            });
                        
                    }
                     
                }else{
                    alertify.error('Usuario y Contraseña incorrectos');
                    swal.close();
                }

            }
        })
       
    }

    const evaluar = async (password) => {
        try {

            const valores = await Promise.all( [datosAsync("cargarTiposUsuario"), datosAsync("encriptar", password),] );
            let usuario = document.querySelector('#user').value;
            let flag = false;
            const { ids, pass } =  separarArray(valores);

            ids.forEach( ({ usuario_contra, usuario_nombre }) => {
                if ( usuario === usuario_nombre && pass === usuario_contra )  flag = true;
                
            });

            return flag;

        }catch(e) {
            throw new Error('Error al cargar los usuarios o la contraseña');
        }
    }

    const separarArray =  (valores) => {
        let ids = valores[0];
        let pass = valores[ valores.length - 1];

        return { ids, pass};
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////// funciones de sweet alert /////////////////////////////////////////////////

    //funcion para mostrar un alert con la libreria sweet
    const mensajeSweet = ( title = '' ) => Swal.fire({ title, icon: 'warning', showCancelButton: true, confirmButtonColor: '#3085d6', cancelButtonColor: '#d33',confirmButtonText: 'Continuar', cancelButtonText: 'Cancelar'});

    //funcion para mostrar un confirm alert con la libreria sweet
    const confirmSweet = (title = '', text = '', confirmButtonText = '') => Swal.fire({ title, text, icon: 'warning', showCancelButton: true, confirmButtonColor: '#3085d6', cancelButtonColor: '#d33', confirmButtonText, });
    
    //funcion para mostrar un alert con sweetr
    const alertSweet = ( title = '' ) => Swal.fire({
            title,
            text: "",
            confirmButtonColor: '#3085d6',
            icon: 'success',
            confirmButtonText: '¡Entendido!'
          });
    

    ////////////////////////////////////////////////////////////////////////////////////////////////////
 

  

    
    ////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////                  PROMESAS       ///////////////////////////////////////////

    //guardar datos de corte para cierre

    const guardar_corteAsync = async ( datos = [], idCorte = '' ) => {
        try {
            const val = await guardar('guardarCorte', datos);
            const update = await datosAsync( "updateTraficoCorte", idCorte );

            return val;

        }catch( err ) {
            throw new Error('Ocurrió un error al guardar los datos')
        }   

    }

    //datatable de corte de cajas 
    const tableCorte = async () => {  
        try{
            const datosTable = await datatableAsync();
            
            return datosTable;
            
        }catch(err){
            console.log(err);
        }
    }


    const cargar_datos = (funcion = '' , datos = '') => {
        return new Promise((resolve, reject) => {
            $.ajax({
                url, dataType: 'json', type: 'POST', async: true, 
                data: {
                    funcion,
                    datos,
                }, beforeSend: () => {
                    Swal.fire({
                        title: '¡Espere un momento!',
                        html: 'Cargando...',
                        allowOutsideClick: false,
                        onBeforeOpen: () => {
                            Swal.showLoading()
                        },
                    });
                }, success: (response) => { 
                    swal.close();
                    (Object.keys(response).length === 0)
                        ?reject("No se han Encontrado Datos con la busqueda")
                        :resolve(response);
                        
                }, error: (data) => {
                    console.log(data);
                    swal.close();
                    reject("Ocurrió un error al conectar con el servidor");
                },
                
            });

        })
    }

    //promesa para guardar datos enviando los datos y la funcion
    const guardar_datos = (funcion = '', datos = '') => {

        return new Promise((resolve, reject) => {
            $.ajax({
                url, dataType: 'json', type: 'POST', async: true,
                data: {
                    funcion, datos,
                }, beforeSend: ()=>{
                    Swal.fire({
                        title: '¡Espere un momento!',
                        html: 'Cargando...',
                        allowOutsideClick: false,
                        onBeforeOpen: () => {
                            Swal.showLoading()
                        },
                    });
                }, success: ({error}) => {
                    swal.close();
                    (error === 1)
                        ?resolve("¡Datos Guardados Correctamente!")
                        :reject("¡Ocurrió un error al abrir corte, intentelo más tarde!");
                    

                }, error: (data) => {
                    console.log(data);
                    swal.close();
                    reject("Ocurrió un error al conectar con el servidor");
                },
            });
        });
    }


    // ajax async para obtener los datos y cargar el datatable
    const datatableAsync = async () => $.ajax({url , type: 'POST',async: true, dataType: 'json', data: {funcion: 'cargarTableCorte',}, beforeSend: () => { 
          Swal.fire({ title: '¡Espere un momento!', html: 'Cargando...', allowOutsideClick: false, onBeforeOpen: () => { Swal.showLoading() } }); } });

    // promesa para cargar datos enviando como referencia el nombre de la funcion y el idkey del pago
    const datosAsync = async (funcion, idkey ='') => $.ajax({url , type: 'POST',async: true, dataType: 'json', data: {funcion, idkey}, beforeSend: () => { 
        Swal.fire({ title: '¡Espere un momento!', html: 'Cargando...', allowOutsideClick: false, onBeforeOpen: () => { Swal.showLoading() } }); } });

    // promesa para cargar datos enviando como referencia el nombre de la funcion y los datos
    const guardar = async (funcion, datos ='') => $.ajax({url , type: 'POST',async: true, dataType: 'json', data: {funcion, datos}, beforeSend: () => { 
        Swal.fire({ title: '¡Espere un momento!', html: 'Cargando...', allowOutsideClick: false, onBeforeOpen: () => { Swal.showLoading() } }); } });

        
    ////////////////////////////////////////////////////////////////////////////////////////////////////

    
    return {
        abrir_caja,
        abrir_corte,
        init_corte,
        confirmCerrar,
        initHistorial,
        infoCorte,
    }

})();


