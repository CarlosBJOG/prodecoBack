moduloGseguros = ( () => {

    const url = '../php/json_func_garantias.php';

    const initSeguro = () => {
        tablaSeguros();
        
        const tablaInd= $('#divTablaInd'),
            tablaGrupal = $("#divTablaGrup"),
            btnGrupal = $('#tablaGrupal'),
            tablaImprimir = $('#divTablaImprimir'),
            btnReimprimir = $('#reimpresion'),
            btnTabInd = $('#tablaIndividual');

        tablaInd.show();
        tablaGrupal.hide();
        tablaImprimir.hide();

        btnGrupal.on('click', () => {
             
            tablaInd.hide();
            tablaSegurosGrupal();
            tablaGrupal.show();
            tablaImprimir.hide();
            
        });
        
        btnTabInd.on('click', () => {
            tablaInd.show();
            tablaGrupal.hide();
            tablaImprimir.hide();
        });

        btnReimprimir.on('click', () => {
            tablaInd.hide();
            tablaGrupal.hide();
            tablaImprimir.show();
            tablaImpresion();
        })
    }

    const initRetiroSeguro = () => {
        tablaRetiros();
    }

    const initGarantias = () => {
        tablaGarantias();
        tablaGarantiasRetiro();
    }

    const tablaGarantias = async () => {
        try {

            const garantias = await peticionAjax('cargarGarantias');
            swal.close();

            let table = $('#tablaGarantias').DataTable(); 
            table.clear().draw();
           
            table = $('#tablaGarantias').DataTable({ "destroy":true, dom: 'Bfrtip',buttons: ['csv', 'excel'], bFilter: true, });
            
            garantias.forEach(({idkey, monto, fecha_registros, fecha_desembolso, nombre, tipo_credito}) => {
                let boton = '<a href="../pdf/ticket_garantia.php?idkey='+idkey+' " class="btn radius-1 btn-md btn-brc-tp btn-outline-primary btn-h-outline-primary btn-a-outline-primary btn-text-primary" title="Imprimir" target="_blank"><i class="fas fa-print text-primary"></i></a>'; 

            
                table.row.add([
                    idkey, monto, fecha_registros, fecha_desembolso, nombre, tipo_credito, boton
                ]).draw(false);
            
            })

        }catch(e) {
            swal.close();
            throw new Error('Error al cargar creditos')
        }
        
    }

    const retirarGarantia =async (idkey) => {
        const info = await modalGarantia(idkey);

        let formRetiro = $('#formGarantia');
        let btnRetiro = $('#btnRetirar');

        btnRetiro.on('click', () => {
            formRetiro.validate({errorClass: 'text-error'});

            if(formRetiro.valid()){
                let     operacion = $('#operacion').val(),
                        maxMonto  = $('#retiro').val(),
                    observaciones = $('#observaciones').val(),
                         banco    = $('#banco').val(),
                         folio    = $('#comprobante').val(),
                  selectOperacion = $('#operacion').val();
                if( parseFloat(maxMonto) > parseFloat(info.monto)){
                    return alertSweet('El monto ingresado es mayor al de la garantía', 'warning')
                }
           

                if(selectOperacion === '...'){
                    alertSweet('Debes seleccionar la operacion', 'error');
                }else if (selectOperacion === '1' || selectOperacion === '2') {
                    const datos = [maxMonto, banco, folio,  info.idkey_cliente, info.tipo_credito, info.idkey_credito,  info.nombre, info.idkey, observaciones];

                    confirmSweet('¿Esta seguro de retirar la garantía?', '', 'Retirar')
                        .then( result => {
                            if(result.value){

                                guardarRetiroGarantia(datos);
                            }
                        })
                  
                }
                
            }
        })       
    }

    const guardarRetiroGarantia = async (datos) => {

        try{
            const {error} = await peticionAjax('guardarGarantiaRetiro', datos);
            await peticionAjax('updateGarantiaRetiro', datos[7]);
            swal.close();
            console.log(datos);
            if(error === 0 || error === '0'){
                alertSweet('Retiro Satisfactorio, ya puedes imprimir el ticket')
                    .then((result) =>{
                        if (result.value){
                            let idoperacion = $('#operacion').val();
                            let path = `../pdf/ticket_garantia_retiro.php?idkey=${datos[3]}&&idoperacion=${idoperacion}`;

                            let btnImprimir = $('#btnImprimirRetiro');
                            $('#btnRetirar').prop('disabled', true);

                            btnImprimir.show();
               
                               
                            btnImprimir.attr('href', path);
                            
                        }
                    })
            }
            console.log(datos)

        }catch(e){
            swal.close();
            throw new Error('Error al guardar los datos');
        }

    }

    const modalGarantia = async (idkeyGarantia) => {
        try {
            $('#modalGarantia').modal('show');
            $('#divDatosBanco').hide();
            $('#btnImprimirRetiro').hide();
            $('#comprobante').val('');
            $('#retiro').val('');
            $('#observaciones').val('');
            $('#btnRetirar').prop('disabled', false);

            let selectOperacion = $('#operacion');

            btnImprimir = $('#btnImprimirCobranza');
            btnImprimir.hide();

            selectOperacion.val(selectOperacion.children('option:first').val());
            selectOperacion.on('change', (value) => {
                const valorOperacion = value.target.value;
    
                if(valorOperacion === '2'){
                    $('#divDatosBanco').show();
                    $('#observaciones').val('');
                    $('#comprobante').show();
                    $('#comprobante').val('');
                    $('#banco').val('');
                    $('#retiro').val('');
                }else{
                    $('#divDatosBanco').hide();
                    
                    $('#observaciones').val('');
                    $('#retiro').val('');
                }
            });

            const [{estatus, fecha_desembolso, fecha_registros, idkey, idkey_cliente, idkey_credito, nombre, tipo_credito, monto}] = await peticionAjax('cargarGarantiaCliente', idkeyGarantia);
            swal.close();
            
            $('#montoTotal').val(format_currency(monto));
            return {estatus, fecha_desembolso, fecha_registros, idkey, idkey_cliente, idkey_credito, nombre, tipo_credito, monto}

        }catch(e) {
            swal.close();
            throw new Error('Error al cargar modal')
        }
    }

    const tablaGarantiasRetiro = async () => {
        try {

            const garantiasRetiro = await peticionAjax('cargarGarantias');
            swal.close();

            let table = $('#tablaGarantiasRetiro').DataTable(); 
            table.clear().draw();
           
            table = $('#tablaGarantiasRetiro').DataTable({ "destroy":true, dom: 'Bfrtip',buttons: ['csv', 'excel'], bFilter: true, });
            
            garantiasRetiro.forEach(({idkey, monto, fecha_registros, fecha_desembolso, nombre, tipo_credito, estatus}) => {
                let boton = '<a href="../pdf/ticket_garantia.php?idkey='+idkey+' " class="btn radius-1 btn-md btn-brc-tp btn-outline-primary btn-h-outline-primary btn-a-outline-primary btn-text-primary" title="Imprimir" target="_blank"><i class="fas fa-print text-primary"></i></a>'; 
                if(estatus === 0 || estatus ==='0'){
                    boton += '<a onclick="moduloGseguros.retirarGarantia('+idkey+')" class="btn radius-1 btn-md btn-brc-tp btn-outline-primary btn-h-outline-primary btn-a-outline-primary btn-text-primary" title="Retirar Garantía"target="_blank"><i class="far fa-check-square text-success"></i></a>';
                }
            
                table.row.add([
                    idkey, monto, fecha_registros, fecha_desembolso, nombre, tipo_credito, boton
                ]).draw(false);
            
            })

        }catch(e) {
            swal.close();
            throw new Error('Error al cargar creditos')
        }
        
    }


    const tablaRetiros = async () => {
        try {

            const seguros = await peticionAjax('cargarSeguros');
            swal.close();

            let table = $('#tablaRetiro').DataTable(); 
            table.clear().draw();
           
            table = $('#tablaRetiro').DataTable({ "destroy":true, dom: 'Bfrtip',buttons: ['csv', 'excel'], bFilter: true, });

            seguros.forEach(({idkey, idkey_cliente, nombre, nombre_producto, idkey_credito, fecha_registro, monto, folio_operacion, banco, estatus}) => {
                let boton = '<a onclick="moduloGseguros.retirarSeguro('+idkey_credito+', '+idkey_cliente+', '+idkey+')" class="btn radius-1 btn-md btn-brc-tp btn-outline-primary btn-h-outline-primary btn-a-outline-primary btn-text-primary" title="Aplicar Seguro"target="_blank"><i class="far fa-check-square text-success"></i></a>'; 
                if(estatus === 1 || estatus ==='1'){
                    boton = '<a href="../pdf/ticket_retiro.php?idkeyCliente='+idkey_cliente+'&&credito='+idkey_credito+' " class="btn radius-1 btn-md btn-brc-tp btn-outline-primary btn-h-outline-primary btn-a-outline-primary btn-text-primary" title="Imprimir" target="_blank"><i class="fas fa-print text-warning"></i></a>'; 

                }

                table.row.add([
                    'ID: '+idkey, nombre, nombre_producto, format_currency(monto), fecha_registro, folio_operacion, banco, boton
                ]).draw(false);
            })

        }catch(e) {
            swal.close();
            throw new Error('Error al cargar creditos')
        }
    }

    const tablaSeguros = async () => { 
        try {

            const creditos = await peticionAjax('cargarCreditos');
            swal.close();
            let table = $('#tablaSeguros').DataTable(); 
            table.clear().draw();

            table = $('#tablaSeguros').DataTable({ "destroy":true, dom: 'Bfrtip',buttons: ['csv', 'excel'], bFilter: true, });

            creditos.forEach(({idkey_credito, idkey_clientes, nombre, nombre_producto, monto, fecha_desembolso, primer_pago, estatus_pagos}) => {
                let boton = '<a onclick="moduloGseguros.aplicarSeguro('+idkey_credito+')" class="btn radius-1 btn-md btn-brc-tp btn-outline-primary btn-h-outline-primary btn-a-outline-primary btn-text-primary" title="Aplicar Seguro"target="_blank"><i class="far fa-check-square text-success"></i></a>';
            
                table.row.add([
                    'ID: '+idkey_credito, nombre_producto, nombre, fecha_desembolso, primer_pago, format_currency(monto), boton
                ]).draw(false);
            })

        }catch(e) {
            swal.close();
            throw new Error('Error al cargar creditos')
        }
    }

    const tablaSegurosGrupal = async () => {
        try {

            const creditos = await peticionAjax('cargarCreditosGrupales');
            swal.close();
            let table = $('#tablaSegurosGrupal').DataTable(); 
            table.clear().draw();
           
            table = $('#tablaSegurosGrupal').DataTable({ "destroy":true, dom: 'Bfrtip',buttons: ['csv', 'excel'], bFilter: true, });

            creditos.forEach(({idkey_credito, idkey_cliente, nombre_grupo, nombre, fecha_creacion, primer_pago, monto}) => {
                let boton = '<a onClick="moduloGseguros.aplicarSeguroGrupal('+idkey_credito+', '+idkey_cliente+')" class="btn radius-1 btn-md btn-brc-tp btn-outline-primary btn-h-outline-primary btn-a-outline-primary btn-text-primary" title="Aplicar Seguro"target="_blank"><i class="far fa-check-square text-success"></i></a>';
            
                table.row.add([
                    'ID: '+idkey_credito, nombre_grupo, nombre, fecha_creacion, primer_pago, format_currency(monto), boton
                ]).draw(false);
            })

        }catch(e) {
            swal.close();
            throw new Error('Error al cargar creditos')
        }
    }

    const tablaImpresion = async () => {
        try {

            const seguros = await peticionAjax('cargarSeguros');
    
            swal.close();
            let table = $('#tablasImprimir').DataTable(); 
            table.clear().draw();
           
            table = $('#tablasImprimir').DataTable({ "destroy":true, dom: 'Bfrtip',buttons: ['csv', 'excel'], bFilter: true, });

            seguros.forEach(({idkey, idkey_cliente, nombre, nombre_producto, idkey_credito, fecha_registro, monto, folio_operacion, banco}) => {
                 let boton ;
                if(folio_operacion === '' && banco === ''){
                    folio_operacion = 'Sin Folio';
                    banco = 'Sin Banco';
                    boton = '<a href="../pdf/ticket_seguro.php?idkey='+idkey+'&&folio='+0+' " class="btn radius-1 btn-md btn-brc-tp btn-outline-primary btn-h-outline-primary btn-a-outline-primary btn-text-primary" title="Imprimir" target="_blank"><i class="fas fa-print text-warning"></i></a>';
                }else{
                    
                    boton = '<a href="../pdf/ticket_seguro.php?idkey='+idkey+'&&folio='+1+' " class="btn radius-1 btn-md btn-brc-tp btn-outline-primary btn-h-outline-primary btn-a-outline-primary btn-text-primary" title="Imprimir" target="_blank"><i class="fas fa-print text-warning"></i></a>';
                }             

                table.row.add([
                    'ID: '+idkey, nombre, nombre_producto, format_currency(monto), fecha_registro, folio_operacion, banco, boton
                ]).draw(false);
            })

        }catch(e) {
            swal.close();
            throw new Error('Error al cargar creditos')
        }
    }
    
    const aplicarSeguro =async (idkeyCredito) => {
        $('#modalSeguros').modal('show');
        $('#divFolio').hide();
        $('#divOperacion').hide();
        $('#comprobantePago').val('');
        $('#banco').val('');
        $('#observaciones').val('');
        $('#monto').val('');

        let selectOperacion = $('#operacion'),
                formSeguros = $('#formSeguros'),
                botonSeguro = $('#btnaplicarSeguro');

        btnImprimir = $('#btnImprimirCobranza');
        btnImprimir.hide();

        selectOperacion.val(selectOperacion.children('option:first').val());

        await cargarModal(idkeyCredito);

        selectOperacion.on('change', (value) => {
            const valorOperacion = value.target.value;

            if(valorOperacion === '2'){
                $('#divFolio').show();
                $('#divOperacion').show();
                $('#monto').val('');
            }else{
                $('#divFolio').hide();
                $('#divOperacion').hide();
                $('#monto').val('');
            }
        });

        botonSeguro.on('click', () => {
            formSeguros.validate({errorClass: 'text-error'});

            if(formSeguros.valid()){
                let valueOperacion = $('#operacion').val();

                if(valueOperacion === '...'){
                    alertSweet('Debes seleccionar la operacion', 'error');
                }else if (valueOperacion === '1' || valueOperacion === '2') {
                    guardarSeguro(idkeyCredito);
                }

            }
        })
    }

    const aplicarSeguroGrupal = async (idkeyCliente, idkeyCredito) => {
 
        $('#modalSeguros').modal('show');
        $('#divFolio').hide();
        $('#divOperacion').hide();
        $('#comprobantePago').val('');
        $('#banco').val('');
        $('#observaciones').val('');
        $('#monto').val('');
        let selectOperacion = $('#operacion'),
                formSeguros = $('#formSeguros'),
                botonSeguro = $('#btnaplicarSeguro');

        btnImprimir = $('#btnImprimirCobranza');
        btnImprimir.hide();

        selectOperacion.val(selectOperacion.children('option:first').val());

        await cargarModal(idkeyCliente, 2, idkeyCredito);

        selectOperacion.on('change', (value) => {
            const valorOperacion = value.target.value;

            if(valorOperacion === '2'){
                $('#divFolio').show();
                $('#divOperacion').show();
                $('#monto').val('');
            }else{
                $('#divFolio').hide();
                $('#divOperacion').hide();
                $('#monto').val('');
            }
        });

        botonSeguro.on('click', () => {
            formSeguros.validate({errorClass: 'text-error'});

            if(formSeguros.valid()){
                let valueOperacion = $('#operacion').val();

                if(valueOperacion === '...'){
                    alertSweet('Debes seleccionar la operacion', 'error');
                }else if (valueOperacion === '1' || valueOperacion === '2') {
                   
                    guardarSeguro(idkeyCliente);
                }

            }
        })
    }

    const guardarSeguro = async (idkeyCredito) => {
        const comprobantePago = $('#comprobantePago').val(),
            banco = $('#banco').val(),
            monto = $('#monto').val(),
            idCliente = $('#idcliente').val(),
            idOperacion = $('#operacion').val(),
            observaciones = $('#observaciones').val();
        
        const datos = [idCliente, idkeyCredito, monto, comprobantePago, banco];
        console.log(datos);
        try{
   
            confirmSweet('¿Desea guardar los cambios?', 'Seguro Depósito', 'Aplicar')
                .then( async (result) => {
                    if(result.value){
                          const {error} = await peticionAjax('guardarSeguro', datos);
                          if(error === "0" || error === 0){
                            alertSweet('Datos Guardados Correctamente')
                            .then(result => {
                                if(result.value){
                                    movimientoContable(datos, idOperacion, observaciones);
                                }
                            });
                          }
                    }
                })
                
        }catch(e) {
            swal.close();
            throw new Error('Error al guardar seguro')
        }
    }

    const retirarSeguro = async (idkeyCredito, idkeyCliente, idkey) => {
        $('#modalRetiro').modal('show');
        $('#retiro').val(''),
        $('#observaciones').val(''),
        $('#comprobante').val(''),
        $('#banco').val('');
        $('#btnRetirarSeguro').prop('disabled', false);;
        let     maxMonto = $('#montoTotal'),
         selectOperacion = $('#operacion'),
             btnImprimir = $('#btnImprimirRetiro'),
                divBanco = $('#divDatosBanco'),
              btnRetirar = $('#btnRetirarSeguro'),
              formRetiro = $('#formRetiro');

        divBanco.hide();
        btnImprimir.hide();

        selectOperacion.val(selectOperacion.children('option:first').val());
            
        const infoSeguros = [idkeyCliente, idkeyCredito];

        const datosRetiro = await Promise.all([peticionAjax('cargarSeguroActual', infoSeguros)]);

        const [{monto, idkey_cliente, idkey_credito}] = datosRetiro[0];
        swal.close();
        maxMonto.val(format_currency(monto));

        selectOperacion.on('change', (value) => {
            const valorOperacion = value.target.value;
            if(valorOperacion === '2'){
                divBanco.show();
                $('#retiro').val('');
                $('#observaciones').val('');
                $('#comprobante').val('');
                $('#banco').val('');
            }else{
                divBanco.hide();
                $('#retiro').val('');
                $('#observaciones').val('');
                $('#banco').val('');
            }
        });

        btnRetirar.on('click', () => {
            formRetiro.validate({errorClass: 'text-error'});

            if(formRetiro.valid()){
                            
                let valueOperacion = $('#operacion').val();
                    retiro         = $('#retiro').val();
                if(parseFloat(retiro) > parseFloat(monto)){
                    alertSweet('El monto es mayor del seguro de vida', 'error');
                }else{
                    if(valueOperacion === '...'){
                        alertSweet('Debes seleccionar la operacion', 'error');
                    }else if (valueOperacion === '1' || valueOperacion === '2') {
                        guardarRetiro(idkey_cliente, idkey_credito, idkey);
                    }
                    
                }
              
            }
        })
        
    }

    const guardarRetiro = async (idkeyCliente, idkeyCredito, idkey) => {
        try{

            let idOperacion   = $('#operacion').val(),
                monto         = $('#retiro').val(),
                observaciones = $('#observaciones').val(),
                comprobante   = $('#comprobante').val(),
                banco         = $('#banco').val();
         
            const infoRetiro = [monto, observaciones, banco, comprobante,  idkeyCredito, idkeyCliente, idkey];
            let path = `../pdf/ticket_retiro.php?idkeyCliente=${idkeyCliente}&&credito=${idkeyCredito}`;
       
            confirmSweet('¿Desea retirar el seguro?', '', 'Retirar')
                .then(async (result) => {
                    if (result.value){
                        
                        const {error} = await peticionAjax('guardarRetiro', infoRetiro);
                        await peticionAjax('updateSeguros', idkey);
                        swal.close();
                        if(error === 0 || error === '0'){
                            alertSweet('Datos Guardados correctamente')
                                .then(async (result) => {
                                    if (result.value){
                                        $('#btnImprimirRetiro').show();
                                        $('#btnRetirarSeguro').prop('disabled', true);

                                        let btnImprimir = $('#btnImprimirRetiro');
                               
                                        btnImprimir.attr('href', path);
                                    }
                                })
                        }
                    }
                })
            

        }catch(e){
            swal.close();
            throw new Error('Error al guardar los datos');
        }
    }
    
    const cargarModal = async (idkeyCredito, operacion = 1, idkey = 0) => {
        try{

            if(operacion === 1){
                const titulo = $('#titulo'),
                    nombreCliente = $('#cliente'),
                    nombreCredito = $('#credito'),
                    btnImprimir = $('#btnImprimirCobranza'),
                    idCliente = $('#idcliente');
                btnImprimir.hide();
                const [{nombre, nombre_producto, idkey_clientes}] = await peticionAjax('cargarCredito', idkeyCredito);

                nombreCliente.val(nombre);
                nombreCredito.val(nombre_producto);
                idCliente.val(idkey_clientes);

                swal.close();
                return 0;
            }else{
                const nombreCliente = $('#cliente'),
                      nombreCredito = $('#credito'),
                        btnImprimir = $('#btnImprimirCobranza'),
                          idCliente = $('#idcliente');
                btnImprimir.hide();
                let datos = [idkeyCredito, idkey];
                const [{desc_tipo, idkey_cliente, nombre}] = await peticionAjax('cargarCreditoGrupal', datos);
             
                nombreCliente.val(nombre);
                nombreCredito.val(desc_tipo);
                idCliente.val(idkey_cliente);

                swal.close();
                return 0;
            }
        
        }catch(e){
            swal.close();
            alertSweet('Ocurrio un error', 'warning')
                .then((result) => {
                    if(result.value){
                        window.location.reload();
                    }
                });
            throw new Error('Error al cargar los datos de credito')
        }
    }

    const movimientoContable = async (datos, idOperacion, observaciones) => {
        let monto = datos[2],
        idCredito = datos[1],
        idCliente = datos[0];
        if (idOperacion === '1') {

            const info = [monto, idCredito, idCliente, observaciones];

            await Promise.all ([peticionAjax('movEfectivo', info) ,peticionAjax('movEfectivoHaber', info)]); 

            swal.close();
        }else {

            const info = [monto, idCredito, idCliente, observaciones];

            await Promise.all ([peticionAjax('movBanco', info) ,peticionAjax('movBancoHaber', info)]); 

            swal.close();
        }
    }

    //funcion para formatear a moneda mxn
    const format_currency = (cantidad) => new Intl.NumberFormat('MXN', {style: 'currency',currency: 'MXN', minimumFractionDigits: 2}).format(cantidad);

    //funcion para mostrar un confirm alert con la libreria sweet
    const confirmSweet = (title = '', text = '', confirmButtonText = '') => Swal.fire({ title, text, icon: 'warning', showCancelButton: true, confirmButtonColor: '#3085d6', cancelButtonColor: '#d33', confirmButtonText, });

    //funcion para mostrar un alert con sweetr
    const alertSweet = ( title = '', icon = 'success') => Swal.fire({
        title,
        text: "",
        confirmButtonColor: '#3085d6',
        icon,
        confirmButtonText: '¡Entendido!'
    });

    //promesas
    const peticionAjax = async (funcion, datos ='') => $.ajax({url , type: 'POST',async: true, dataType: 'json', data: {funcion, datos}, beforeSend: () => { 
        Swal.fire({ title: '¡Espere un momento!', html: 'Cargando...', allowOutsideClick: false, onBeforeOpen: () => { Swal.showLoading() } }); } });

    return {

        initSeguro,
        aplicarSeguro,
        aplicarSeguroGrupal,
        initRetiroSeguro,
        retirarSeguro,
        initGarantias,
        retirarGarantia,

    }
})();