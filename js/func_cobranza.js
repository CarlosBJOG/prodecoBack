moduloCobranza = ( () => {

    const url = '../php/json_func_cobranza.php';
    const initPromotor = () => {
        tablaPromotor() 
        const tablaCobranza = $('#divTablaCobranza'),
               tablaTickets = $("#divTablaTicket"),
             btnReimpresion = $('#reimpresion'),
             btnTabCreditos = $('#tabCreditos');

        tablaCobranza.show();
        tablaTickets.hide();

        btnReimpresion.on('click', () => {
            tablaReimpresion();
            tablaCobranza.hide();
            tablaTickets.show();
        })

        btnTabCreditos.on('click', () => {
            tablaCobranza.show();
            tablaTickets.hide();
        })
    }
    
    const aplicarCobranza = async (idkeyCredito) => {
        $('#modalCobranza').modal('show');
        $('#divFolio').hide();
        $('#divOperacion').hide();
        $('#comprobantePago').val('');
        $('#banco').val('');
        let selectOperacion = $('#operacion'),
               formCobranza = $('#formCobranza'),
              botonCobranza = $('#btnCobranza');

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

        botonCobranza.on('click', () => {
           
            formCobranza.validate({errorClass: 'text-error'});

            if(formCobranza.valid()){
                let valueOperacion = $('#operacion').val();

                if(valueOperacion === '...'){
                    alertSweet('Debes seleccionar la operacion', 'error');
                }else if (valueOperacion === '1' || valueOperacion === '2') {
                    guardarCobranza(idkeyCredito);
                }

            }
        })
    }

    const guardarCobranza = async (idkey) => {
        const monto = $('#monto').val(),
              folio = $('#comprobantePago').val(),
              banco = $('#banco').val(),
     valueOperacion = $('#operacion').val();

        let estatusOperacion = '';
        let path;
        if(valueOperacion === '1'){
            estatusOperacion = 'Efectivo';
            path = `../pdf/ticket_gastos.php?idkey=0&&credito=${idkey} `;
            
        }else{
            estatusOperacion = 'Depósito o Transferencia';
            path = `../pdf/ticket_gastos_folio.php?idkey=0&&credito=${idkey}`;
        }
            
        try{
            const datos = [idkey, monto, folio, banco, valueOperacion, estatusOperacion]

            confirmSweet("¿Aplicar cobro por cobranza?", '', 'Aplicar cobro')
                .then(async (result) => {
                    if(result.value){
                        const {error} = await peticionAjax('guardarCobranza', datos)
                        if(error === 0){
                            alertSweet("Datos Guardados Correctamente, ya puedes imprimir el ticket")
                                .then((result) => {
                                    if(result.value) {
                                        let btnImprimir = $('#btnImprimirCobranza');
                                        $('#btnCobranza').prop('disabled', true);
                                        btnImprimir.attr('href', path);
                                        btnImprimir.show();

                                        //window.location.reload();
                                    }
                                })
                        }
                    }
                })

        }catch(e){
            swal.close();
            throw new Error('Error al guardar datos cobranza');

        }

    }

    const cargarModal = async (idkeyCredito) => {
        try{

            const titulo = $('#titulo'),
                    nombreCliente = $('#cliente'),
                    nombreCredito = $('#credito'),
                    btnImprimir = $('#btnImprimirCobranza');
            btnImprimir.hide();
            $('#btnCobranza').prop('disabled', false);
            const datosCredito = await peticionAjax('cargarCredito', idkeyCredito);

            if(datosCredito.length > 0){
                const [credito] = datosCredito;
                titulo.text(`- Credito: ${credito.nombre_producto}`)
                nombreCliente.val(credito.nombre);
                nombreCredito.val(credito.nombre_producto);
                
            }
            swal.close();
            return 0;
        
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

    const aplicarRegistro = async (idkey) => {
        confirmSweet("¿Desea aplicar el pago de gasto cobranza?",'','Aplicar')
            .then(async (result) => {
                if(result.value){

                    const {error} = await peticionAjax('updateCobranza', idkey);
                    if(error === 0){
                        alertSweet("Datos aplicados correctamente")
                            .then((result) => {
                                if(result.value){
                                    window.location.reload();
                                }
                            });
                    }

                }
            })
    }

    const tablaPromotor = async () => { 
        try{

            const datos = await peticionAjax('cargarCreditos');

            swal.close();

            let table = $('#tablaCobranza').DataTable(); 
            table.clear().draw();

            table = $('#tablaCobranza').DataTable({ "destroy":true, dom: 'Bfrtip',buttons: ['csv', 'excel'], bFilter: true, });
  
            datos.forEach( ({folio, nombre, nombre_producto, idkey_credito}) => {
                
                let boton = '<a onclick="moduloCobranza.aplicarCobranza('+idkey_credito+');" class="btn radius-1 btn-md btn-brc-tp btn-outline-primary btn-h-outline-primary btn-a-outline-primary btn-text-primary" title="Aplicar Gasto"target="_blank"><i class="far fa-question-circle"></i></a>';
        
                table.row.add([
                    folio, nombre, nombre_producto, boton
                ]).draw(false);
            })

        }catch(e){
            swal.close();
            throw new Error('Error al cargar datos de creditos')
        }
    }

    const tablaReimpresion = async () => {
        try{
            const datos = await peticionAjax('cargarCobranza');
            swal.close();
            console.log(datos);
            let table = $('#tablaComprobantes').DataTable(); 
            table.clear().draw();

            table = $('#tablaComprobantes').DataTable({ "destroy":true, dom: 'Bfrtip',buttons: ['csv', 'excel'], bFilter: true, });
            datos.forEach( ({idkey,idkey_credito, fecha_registro, monto, folio_operacion, banco, desc_operacion, id_operacion}) => {
                     
                let boton ;
                if(id_operacion ==='1'){
                    boton = '<a href="../pdf/ticket_gastos.php?idkey='+idkey+'&&credito='+0+' " class="btn radius-1 btn-md btn-brc-tp btn-outline-primary btn-h-outline-primary btn-a-outline-primary btn-text-primary" title="Imprimir" target="_blank"><i class="fas fa-print text-warning"></i></a>';
                }else{
                    boton = '<a href="../pdf/ticket_gastos_folio.php?idkey='+idkey+'&&credito='+0+' " class="btn radius-1 btn-md btn-brc-tp btn-outline-primary btn-h-outline-primary btn-a-outline-primary btn-text-primary" title="Imprimir" target="_blank"><i class="fas fa-print text-warning"></i></a>';
                }

                table.row.add([
                    `Id: ${idkey_credito}`, fecha_registro, format_currency(monto), folio_operacion, banco, desc_operacion, boton
                ]).draw(false);
            });


        }catch(e){
            swal.close();
            throw new Error('Error al cargar los datos de gastos cobranza')
        }
    }

    const tablaCajero = async () => {
        try{
            const datos = await peticionAjax('tablaCobranza');
            swal.close();
            let table = $('#tablagastosCajero').DataTable(); 
            table.clear().draw();

            table = $('#tablagastosCajero').DataTable({ "destroy":true, dom: 'Bfrtip',buttons: ['csv', 'excel'], bFilter: true, });
            datos.forEach( ({idkey, idkey_credito, nombre, nombre_producto, fecha_registro, fecha_valor, monto, estatus, desc_estatus, id_operacion}) => {
               
                let boton ;
                let idEstatus = `<span class="badge bgc-primary-l2 badge-xs text-600 text-blue-d2 pb-2 radius-round border-1 brc-primary-m2">${desc_estatus}</span>`;
                if(fecha_valor === null){
                    fecha_valor = 'Sin fecha'
                }

                if(id_operacion ==='1'){
                    
                    if(estatus === '0'){
                        boton = '<a href="../pdf/ticket_gastos.php?idkey='+idkey+'&&credito='+0+'"  class="btn radius-1 btn-sm btn-brc-tp btn-outline-primary btn-h-outline-primary btn-a-outline-primary btn-text-primary" title="Imprimir" target="_blank"><i class="fas fa-print text-primary"></i></a>' +
                        '<a onclick="moduloCobranza.aplicarRegistro('+idkey+');" class="btn radius-1 btn-sm btn-brc-tp btn-outline-success btn-h-outline-success btn-a-outline-success btn-text-success" title="Aprobar pago" target="_self"><i class="fas fa-check-circle text-success"></i></a>';
                        
                    }else{
                        boton = '<a href="../pdf/ticket_gastos.php?idkey='+idkey+'&&credito='+0+'"  class="btn radius-1 btn-sm btn-brc-tp btn-outline-primary btn-h-outline-primary btn-a-outline-primary btn-text-primary" title="Imprimir" target="_blank"><i class="fas fa-print text-primary"></i></a>';
                        idEstatus = `<span class="badge bgc-primary-l2 badge-xs text-600 text-success-d2 pb-2 radius-round border-1 brc-primary-m2">${desc_estatus}</span>`;
                    }
                }else{

                    if(estatus === '0'){
                        boton = '<a href="../pdf/ticket_gastos_folio.php?idkey='+idkey+'&&credito='+0+'"  class="btn radius-1 btn-sm btn-brc-tp btn-outline-primary btn-h-outline-primary btn-a-outline-primary btn-text-primary" title="Imprimir" target="_blank"><i class="fas fa-print text-primary"></i></a>' +
                        '<a onclick="moduloCobranza.aplicarRegistro('+idkey+');"  class="btn radius-1 btn-sm btn-brc-tp btn-outline-success btn-h-outline-success btn-a-outline-success btn-text-success" title="Aprobar pago" target="_self"><i class="fas fa-check-circle text-success"></i></a>';
                  
                    }else{
                        boton = '<a href="../pdf/ticket_gastos.php?idkey='+idkey+'&&credito='+0+'"  class="btn radius-1 btn-sm btn-brc-tp btn-outline-primary btn-h-outline-primary btn-a-outline-primary btn-text-primary" title="Imprimir" target="_blank"><i class="fas fa-print text-primary"></i></a>';
                        idEstatus = `<span class="badge bgc-success-l2 badge-xs text-600 text-success-d2 pb-2 radius-round border-1 brc-success-m2">${desc_estatus}</span>`;
                    }
                }

              

                table.row.add([
                    `Id: ${idkey_credito}`, nombre_producto, nombre, fecha_registro, fecha_valor, format_currency(monto), idEstatus, boton
                ]).draw(false);
            });


        }catch(e){
            swal.close();
            throw new Error('Error al cargar los datos de gastos cobranza')
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
        initPromotor,
        aplicarCobranza,
        tablaCajero, 
        aplicarRegistro
        
    }
})();