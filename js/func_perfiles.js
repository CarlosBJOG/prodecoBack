perfilesModulo = (() => {

    const url = "../php/json_func_perfiles.php";

    const nombreUs = document.querySelector('#nombreCompleto');
    const edadUs = document.querySelector('#edad');
    const emailUs = document.querySelector('#email');
    const celularUs = document.querySelector('#celular');
    const telCasaUs = document.querySelector('#telCasa');
    const domicilioUs = document.querySelector('#domicilio');
    const fechaRegistroUs = document.querySelector('#fechaRegistro');
    const usuarioUs = document.querySelector('#nombreUsuario');
    const cpUs = document.querySelector('#cp');
    const puestoUs = document.querySelector('#puesto');
    const headerOverview = document.querySelector('#headerOverview');
    const headerActividad = document.querySelectorAll('.actividad');
    const titRegistros = document.querySelector('#tituloRegistros');
    const contenedorLista = document.querySelectorAll('.nombreCliente');
    const fechaCreacion = document.querySelectorAll('.fechaCreacion');
    


    const init = async () => {
        
        const [{nombre, celular, edad, tel_casa, direccion, usuario_nombre, email, fecha_registro, cp}] = await infoPersonal();
  
        nombreUs.innerText = nombre.toUpperCase();
        edadUs.innerText = `${edad} años`;
        emailUs.innerText = email;
        celularUs.innerText = celular;
        telCasaUs.innerText = tel_casa;
        domicilioUs.innerText = direccion.toUpperCase();
        fechaRegistroUs.innerText = fecha_registro;
        usuarioUs.innerText = usuario_nombre.toUpperCase();
        cpUs.innerText = cp;

        //funcion para cargar el tipo de usuario
        const idUsuario = await verificarUsuario();

        if( idUsuario === 2 || idUsuario === '2'){
            puestoUs.innerText = 'Promotor';
            infoPromotor();

        }else if(idUsuario === 1 || idUsuario === '1') {
            puestoUs.innerText = 'Administrador';

        }else if(idUsuario === 3 || idUsuario === '3') {
            puestoUs.innerText = 'Supervisor Promotor';

        } else if(idUsuario === 4 || idUsuario === '4') {
            puestoUs.innerText = 'Cajero';

        } else if(idUsuario === 5 || idUsuario === '5') {
            puestoUs.innerText = 'Contador';
            infoContador();

        }else if(idUsuario === 6 || idUsuario === '6') {
            puestoUs.innerText = 'Supervisor Cajero';
        } 

    } 

    //info promotor
    const infoPromotor = async () => {
        infoAdicionalOverviewPromotor("Clientes a Cargo",'Creditos a Cargo');
        const clientesCargoProm = document.querySelector('#clientes');
        const creditosCargoProm = document.querySelector('#creditos');
       
        try {
                //info adicional de promotor
            const datos =  await Promise.all([datosAsync("infoPromotorClientes"), datosAsync("infoPromotorCreditos")]);
            const datosClientesCreditos = await Promise.all([datosAsync("clientesPromotor")]);
            
            //info de los clientes y creditos
            const clientes = datosClientesCreditos[0].splice(0, 4);

            clientes.forEach(({fecha_creacion, nombre, idkey_cliente}, i) => {
                contenedorLista[i].innerText = nombre + ' - FECHA: ' + fecha_creacion + ' -- ID: ' + idkey_cliente;
                
            })
           

            const [numClientes] = datos[0];
            const [numCreditos] = datos[1];
            swal.close();

            //mostramos los datos en el front
            clientesCargoProm.innerText = numClientes[0];
            creditosCargoProm.innerText = numCreditos[0];
            headerActividad[0].innerText = 'Clientes';
            headerActividad[1].innerText = 'Clientes';
            titRegistros.innerText = "Ultimos Registros";

        }catch(e) {
            clientesCargoProm.innerText = 0;
            swal.close();
            throw new Error("Error al cargar");
          
        }
    }

    //info contador 

    const infoContador = async () => {
        infoAdicionalOverviewCajero("Polizas de Ingreso", 'Polizas de Egreso', "Polizas de Orden", 'Polizas de Diario');
        const polizaIngreso = document.querySelector('#pIngreso');
        const polizaEgreso = document.querySelector('#pEgreso');
        const polizaOrden = document.querySelector('#pOrden');
        const polizaDiario = document.querySelector('#pDiario');
        try{
            const polizas = await Promise.all([ datosAsync('polizaDiario'), datosAsync('polizaEgreso'), datosAsync('polizaIngreso'), datosAsync('polizaOrden') ]); 
            swal.close();

            const [{diario}] = polizas[0];
            const [{egreso}] = polizas[1];
            const [{ingreso}] = polizas[2];
            const [{orden}] = polizas[polizas.length - 1];
    
            polizaIngreso.innerText = ingreso;
            polizaDiario.innerText = diario;
            polizaEgreso.innerText = egreso;
            polizaOrden.innerText = orden;
        }catch(e){
            swal.close();
            polizaIngreso.innerText = 0;
            polizaDiario.innerText = 0;
            polizaEgreso.innerText = 0;
            polizaOrden.innerText = 0;
            throw new Error("Error al cargar datos de contador");

        }


        
    }

    

    //html 
    const infoAdicionalOverviewPromotor = ( titulo, titulo2 ) => {
        return headerOverview.innerHTML = `
        <div class="d-flex justify-content-center my-3 flex-wrap flex-equal">
        <div class="border-1 brc-grey-l1 px-3 py-2 rounded text-center mx-1 mb-1">
          <span class="text-170 text-blue" id="clientes"></span>
          <br />
          <span class="text-90 text-dark-tp2">${titulo}</span>
        </div>

        <div class="border-1 brc-grey-l1 py-2 rounded text-center text-success-m1  mx-1 mb-1">
          <span class="text-170" id="creditos"></span> 
          <br />
          <span class="text-90 text-dark-tp2">${titulo2}</span>
        </div>
      </div>
      `
    }

      
    const infoAdicionalOverviewCajero = ( titulo ='', titulo2='', titulo3='', titulo4='' ) => {
        return headerOverview.innerHTML = `
        <div class="d-flex justify-content-center my-3 flex-wrap flex-equal">
        <div class="border-1 brc-grey-l1 px-3 py-2 rounded text-center mx-1 mb-1">
          <span class="text-170 text-success-m1" id="pIngreso"></span>
          <br />
          <span class="text-90 text-dark-tp2">${titulo}</span>
        </div>

        <div class="border-1 brc-grey-l1 py-2 rounded text-center text-success-m1  mx-1 mb-1">
            <span class="text-170" id="pEgreso"></span> 
            <br />
            <span class="text-90 text-dark-tp2">${titulo2}</span>
        </div>
       
            <div class="border-1 brc-grey-l1 py-2 rounded text-center text-success-m1  mx-1 mb-1">
                <span class="text-170" id="pOrden"></span> 
                <br />
                <span class="text-90 text-dark-tp2">${titulo3}</span>
            </div>

            <div class="border-1 brc-grey-l1 py-2 rounded text-center text-success-m1  mx-1 mb-1">
                <span class="text-170" id="pDiario"></span> 
                <br />
                <span class="text-90 text-dark-tp2">${titulo4}</span>
            </div>
        </div>
      `
    }



    ////////////// promesas ///////////////////////////////////
      // funcion asyncrona para traer extraer datos 
    const datosAsync = async (funcion, datos ='') => $.ajax({url , type: 'POST',async: true, dataType: 'json', data: {funcion, datos}, beforeSend: () => { 
        Swal.fire({ title: '¡Espere un momento!', html: 'Cargando...', allowOutsideClick: false, onBeforeOpen: () => { Swal.showLoading() } }); } });

    const infoPersonal = async () => {    
        try {
            
            const infoPersonal = await datosAsync("infoPersonalUsuario");
            swal.close();
            return infoPersonal;

        } catch (err) {
            throw new Error("Error al cargar la informacion del usuario")
        }
    }

    const verificarUsuario = async () => {

        try{

            const idUsuario = await datosAsync("verificarUsuario");
            swal.close();
            return idUsuario;

        }catch (err) {
            swal.close();
            throw new Error("Error al cargar el id del usuario")
        }

    }

    //////////////////////////////////////////////////////////


    init();

    return{

       

    }

})();