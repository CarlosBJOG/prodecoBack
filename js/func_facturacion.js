const miModuloFacturacion = (()=>{
    const url = "../php/json_func_facturacion.php"

    const buscar = () => {
        $('#datatable').dataTable().fnClearTable();
        
        const form = $('#form_fact');
        let fecha_inicio = $('#fecha_inicio').val();
        let fecha_final = $('#fecha_fin').val();

        document.querySelector('#mensaje_busqueda').innerText = `Busqueda entre la fecha ${fecha_inicio} y ${fecha_final}`;
      
        form.validate({errorClass: 'text-error'});

        if(form.valid()){
            if(fecha_final == '' || fecha_final == null){
                alertify.error("INGRESA LA FECHA FINAL PARA CONTINUAR");
            }else{

                let fechas = separarFecha(fecha_inicio, fecha_final);
                buscar_datos(fechas, "buscar_datos")
                    .then(value => cargar_tabla(value))
                    .catch(error => alertify.error(error));
            } 
        }
    }

    const cargar_tabla = (value) => {
        let botones,
            table = $('#datatable').dataTable();
        value.forEach(({idkey_creditos, nombre_cliente, monto, nombre, no_pago, fecha_aprobacion, fecha_valor, rfc}) => {
            botones = '<a href="#" onclick="miModuloFacturacion.modal_fact('+idkey_creditos+');" class="btn radius-1 btn-md btn-brc-tp btn-outline-primary btn-h-outline-primary btn-a-outline-primary btn-text-primary" title="Ver info" target="_self"><i class="far fa-question-circle"></i></a>';
            // //Para alimentar el datatable
            table.fnAddData([
                '<input type="checkbox" name="" id="" autocomplete="off" value="'+idkey_creditos+'"/>',
                idkey_creditos,
                nombre_cliente,
                nombre,
                '$'+new Intl.NumberFormat().format(monto),
                no_pago,
                fecha_aprobacion,
                fecha_valor,
                rfc,
                botones,
            ])
       });
    }

    const modal_fact = (idkey) => {
        $("#modal_facturacion").modal("show");
        infoCompleta(idkey)
            .then((value) => {
               let info_cliente = value.info;
               let info_pagos = value.pagos;
             
                mostrar_info(info_cliente, info_pagos);

            })
            .catch(err => alertify.error(err) ); 
    }

    const limpiar = () => {
        $('#total_pago').text('');
        $('#total_interes').text('');
        $('#total_iva').text('');
        $('#total_monto').text('');
        $('#total_amort').text('');
        $('#nom_cliente').text('');
        $('#email').text('');
        $('#telefono').text('');
        $('#domicilio').text('');
        $('#rfc').text('');
        $('#tipo_id').text('');
        $('#nom_id').text('');
        $('#dom_fiscal').text('');
        $('#email_fact').text('');
        $('#nom_producto').text('');
        $('#monto').text('');
        // $('#mensaje_busqueda').text('');
        $('#table_pagos').dataTable().fnClearTable();
    }

    const mostrar_info = ([{nom_cliente, email, telefono, direccion_completa, rfc, nombre_identificacion, no_identificacion, nombre_producto, monto, correo_facturacion, domicilio_fiscal}],
        info_pagos )=> {

            limpiar();
            let iva_sumado = 0,
                interes_total = 0,
                monto_total = 0,
                pago_total = 0,
                amor_total = 0;
            document.querySelector('#nom_cliente').innerText = nom_cliente;
            document.querySelector('#email').innerText = email;
            document.querySelector('#telefono').innerText = telefono;
            document.querySelector('#domicilio').innerText = direccion_completa;
            document.querySelector('#rfc').innerText = rfc;
            document.querySelector('#tipo_id').innerText = nombre_identificacion;
            document.querySelector('#nom_id').innerText = no_identificacion;
            document.querySelector('#dom_fiscal').innerText = domicilio_fiscal;
            document.querySelector('#email_fact').innerText = correo_facturacion;
            document.querySelector('#nom_producto').innerText = nombre_producto;
            document.querySelector('#monto').innerText = format_currency(monto);
            console.log(info_pagos);
            $('#table_pagos').dataTable().fnDestroy();
            table = $('#table_pagos').dataTable({ "bPaginate": false,
            "ordering": true,
            "searching": false,
            "bFilter": false,
            "bInfo": false,
            'sDom': 't' });
            info_pagos.forEach(({no_pago,pago, fecha_valor, interes, iva, monto, amortizacion}) => {
                table.fnAddData([
                    no_pago,
                    format_currency(pago),
                    fecha_valor,
                    format_currency(interes),
                    format_currency(iva),
                    format_currency(monto),
                    format_currency(amortizacion),
                ]);

                iva = parseFloat(iva);
                interes = parseFloat(interes);
                monto = parseFloat(monto);
                pago = parseFloat(pago);
                amortizacion = parseFloat(amortizacion);
                
                iva_sumado = iva_sumado + iva;
                interes_total = interes_total + interes;
                monto_total = monto_total + monto;
                pago_total = pago_total + pago;
                amor_total = amor_total + amortizacion;
                
            });
            document.querySelector('#total_pago').innerText = format_currency(pago_total);
            document.querySelector('#total_interes').innerText = format_currency(interes_total);
            document.querySelector('#total_iva').innerText = format_currency(iva_sumado);
            document.querySelector('#total_monto').innerText = format_currency(monto);
            document.querySelector('#total_amort').innerText = format_currency(amor_total);
    }

    const infoCompleta = async (idkey) => {
        try {
            const info = await infoCreditoCliente(idkey);
            let fecha_inicio = $('#fecha_inicio').val();
            let fecha_final = $('#fecha_fin').val();
            let fechas = separarFecha(fecha_inicio, fecha_final);
            const pagos = await buscar_datos (fechas, "cargar_pago", idkey);
            return {info, pagos};

        }catch(err) {
            throw err;
        }
    }

    //funcion para formatear a moneda mxn
    const format_currency = (cantidad) => new Intl.NumberFormat('MXN', {style: 'currency',currency: 'MXN', minimumFractionDigits: 3}).format(cantidad);
    

    const separarFecha = (fecha_inicio, fecha_final)=> {

        let hora_inicial = "00:00:00",
            hora_final = "23:59:59";
        let temp,
            temp2;

        temp = fecha_inicio.split('/');
        fecha_inicio = `${temp[temp.length -1]}-${temp[1]}-${temp[0]}`;

        temp2 = fecha_final.split('/');
        fecha_final = `${temp[temp2.length -1]}-${temp2[1]}-${temp2[0]}`;
  
        fecha_inicio = `${fecha_inicio} ${hora_inicial}`;
        fecha_final = `${fecha_final} ${hora_final}`; 

        return { fecha_inicio, fecha_final };        
    }

    const buscar_datos = ({fecha_inicio = '', fecha_final =''}, funcion = '', idkey_credito = '') => {
        
        return new Promise((resolve, reject) =>{
            $.ajax({url, dataType: 'json', type: 'POST', async: true, data : {
                    funcion, fecha_inicio, fecha_final, idkey_credito
                },beforeSend: ()=> {
                    Swal.fire({
                        title: '¡Espere un momento!',
                        html: 'Cargando...',
                        allowOutsideClick: false,
                        onBeforeOpen: () => {
                            Swal.showLoading()
                        },
                    });
                },success: (response) => {
                    Swal.close();
                    (Object.keys(response).length === 0)
                        ?reject("No se han Encontrado Datos con la busqueda")
                        :resolve(response);
                   
                },error: (data) => {
                    console.log(data);
                    reject("Ocurrio un Error en la conexión con el servidor")
                    Swal.close();
                }
            });
        });
    }

    const infoCreditoCliente = (idkey_credito) => {
        return new Promise((resolve, reject) => {
            $.ajax({url, dataType: 'json', type: 'POST', async: true, data : {
                funcion: "cargarInfoCliente",
                idkey_credito,
                },beforeSend: ()=> {
                    Swal.fire({
                        title: '¡Espere un momento!',
                        html: 'Cargando...',
                        allowOutsideClick: false,
                        onBeforeOpen: () => {
                            Swal.showLoading()
                        },
                    });
                },success: (response) => {
                    Swal.close();
                    (Object.keys(response).length === 0)
                        ?reject("No se han Encontrado Datos con la busqueda")
                        :resolve(response);
                
                },error: (data) => {
                    console.log(data);
                    Swal.close();
                    reject("Ocurrio un Error al cargar la información del Cliente")
                }
            });
        })
    }
    
    const cerrar = () => {
        
        limpiar();
        $("#modal_facturacion").modal("toggle");
        $('.modal-backdrop').remove();
    }

    //retorno de acceso
    return {
        buscar,
        modal_fact,
        cerrar,
    }

})();