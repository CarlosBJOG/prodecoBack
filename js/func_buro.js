buroModulo = (() => {
    const url = "../php/json_func_buro.php";

    const init = () => {

        const maxConsultas = document.querySelector('#num_consultas'),
            maxPorConsulta = document.querySelector('#costo'),
            maxMonto = document.querySelector('#monto'),
            btnGuardar = document.querySelector('#btnGuardar'),
            observaciones = document.querySelector('#observaciones');
        
        maxConsultas.addEventListener('input', () =>{     
            maxMonto.value = (maxConsultas.value * maxPorConsulta.value);
        });

        maxPorConsulta.addEventListener('input', () =>{
            maxConsultas.value = 0;
            maxMonto.value = 0;
        })

        //validacion de formulario 
        btnGuardar.addEventListener('click', () =>{
            let formBuro = $('#formBuro');
            formBuro.validate({errorClass: 'text-error'});

            if(formBuro.valid()){
                let title = 'Costo por consulta: $'+ maxPorConsulta.value + ', Total: $'+ maxMonto.value;

                const datosConsulta = [maxPorConsulta.value, maxConsultas.value, maxMonto.value, observaciones.value];

                confirmSweet("¿Aplicar consultas?", title, 'Guardar Consultas' )
                    .then(( result ) =>{
                        if(result.value)  guardarBuro(datosConsulta);           
                    })
            }
        })
    }

    //CARGAR TABLA DE PROMOTORES
    const promotorTabla = async () => {
        try{
            const datosBuro = await datosAsync("cargar_tabla");   
            let table = $('#tablaPromotorBuro').DataTable();
 
            table.clear().draw();

            table = $('#tablaPromotorBuro').DataTable({
                "destroy":true,
                dom: 'Bfrtip',
                buttons: [
                    'csv', 'excel'
                ],
                bFilter: true,
            })
  
            datosBuro.forEach( (row) => {
                let estatus;
                let boton = '<a href="../pdf/ticket_buro.php?idkey='+row.idkey+' " class="btn radius-1 btn-md btn-brc-tp btn-outline-primary btn-h-outline-primary btn-a-outline-primary btn-text-primary" title="Imprimir"target="_blank"><i class="far fa-question-circle"></i></a>';
            
                if(row.estatus === "1"){
                    estatus = `<span class="badge bgc-primary-l2 badge-xs text-600 text-blue-d2 pb-2 radius-round border-1 brc-primary-m2">${row.desc_estatus}</span>`
                }else{
                    estatus = `<span class="badge bgc-warning-l2 badge-xs text-600 text-orange-d2 pb-2 radius-round border-1 brc-warning-m2">${row.desc_estatus}</span>`
                }

                table.row.add([
                    'ID: '+row.idkey,'Registro(s). '+row.num_registros, format_currency(row.monto), row.fecha_registro, row.observaciones, estatus, boton
                ]).draw(false);
            })
            swal.close();
        }catch(e){
            swal.close();
            throw new Error("Error al cargar la tabla de promotores");
        }
    }

    //tabla cajero de buro de credito
    const cajeroTablaBuro = async () => {

        try{
            const datos = await datosAsync("cargar_tabla");
            swal.close();

            let table = $("#datatable").dataTable(); 
    
            datos.forEach( response => {
                let color = '';
                let botones;
                if(response.estatus == 0){//pendiente
                    color = 'warning';
                    botones ='<a href="#" class="btn radius-1 btn-sm btn-brc-tp btn-outline-primary btn-h-outline-primary btn-a-outline-primary btn-text-primary" title="Aplicar pago" onclick="buroModulo.aplicar( '+response.idkey+') "><i class="fas fa-hand-holding-usd"></i></a>';
                    }
                    else if(response.estatus == 1){
                        //autorizado
                    color = 'success';
                    botones ='<a href="../pdf/ticket_buro.php?idkey='+response.idkey+' " class="btn radius-1 btn-sm btn-brc-tp btn-outline-default btn-h-outline-purple btn-a-outline-purple btn-text-purple" title="Imprimir Recibo" target="_blank"><i class="fas fa-receipt"></i></a>';
                    
                    }
                    estatus = "<span class='badge badge-sm bgc-"+color+"-l2 text-"+color+"-d2 border-1 brc-"+color+"-m3'>"+response.desc_estatus+"</span>";
                
                    //Para alimentar el datatable
                    table.fnAddData([
                        '<input type="checkbox" name="" id="" autocomplete="off" value="'+response.idkey+'"/>',
                        response.idkey,
                        `No. : ${response.num_registros}`,
                        format_currency(response.costo_unitario),
                        format_currency(response.monto),
                        response.fecha_registro,
                        response.fecha_alta,
                        response.observaciones,
                        estatus,
                        '<div class="col text-center"><pre>'+botones+
                        '</pre></div>'
                    ]);
            }) 

        }catch(e){
            swal.close();
            throw new Error("Error al cargar la tabla de cajeros");
        }
    }

    const aplicar = (idkey)=>{
        confirmSweet("¿Aplicar Registro de Buró de Crédito?", '', 'Aplicar')
            .then(async result => {
                if(result.value){
                    try{
                        const {error} = await datosAsync("aprobar", idkey);
                        swal.close();
                        if(error === 0){
                            alertSweet("Datos aplicados correctamente")
                                .then((result) => {
                                    if(result.value){ 
                                        location.reload();
                                    }
                                });
                        }
                    }catch(e){
                        swal.close();
                        throw new Error("error al guardar los datos de buro");
                    }                
                }
            })
    }

    //GUARDAR DATOS EN LA BD DE BURO
    const guardarBuro = async (datosConsulta) => {
        try{
            const {error} = await datosAsync('guardar', datosConsulta);
            swal.close();
            if(error === 0){
              
                alertSweet('Datos Guardados Correctamente')
                    .then((result) => {
                        if(result.value){ 
                            limpiar();
                            location.reload();
                        }
                        
                    });  
            } 
        }catch(e) {
            swal.close();
            alertSweet('Ocurrio un error al guardar los datos', 'warning');
            throw new Error('Ocurrio un error al guardar los datos');
        }
    }

    const limpiar = () => {
        
        const maxConsultas = document.querySelector('#num_consultas'),
            maxMonto = document.querySelector('#monto'),
            observaciones = document.querySelector('#observaciones');

        observaciones.value = '';
        maxConsultas.value = 0;
        maxMonto.value = 0;
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

    ////////////// promesas ///////////////////////////////////
      // funcion asyncrona para traer extraer datos 
    const datosAsync = async (funcion, datos ='') => $.ajax({url , type: 'POST',async: true, dataType: 'json', data: {funcion, datos}, beforeSend: () => { 
        Swal.fire({ title: '¡Espere un momento!', html: 'Cargando...', allowOutsideClick: false, onBeforeOpen: () => { Swal.showLoading() } }); } });

    //////////////////////////////////////////////////////////

    return{
        init,
        promotorTabla,
        cajeroTablaBuro,
        aplicar
    }

})();