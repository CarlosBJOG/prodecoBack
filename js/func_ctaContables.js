const url = "../php/json_func_ctaContables.php";

const cargar_tabla = ()=>{
    let table = $('#datatable').dataTable();
    cargar_datos("cargar_tabla")
        .then((value) =>{
            $.each(value, (i, value)=> {
                let botones;
                botones = '<a href="#" onclick="modal_cta('+value.no_cuenta+');" class="btn radius-1 btn-md btn-brc-tp btn-outline-warning btn-h-outline-warning btn-a-outline-warning btn-text-danger" title="Editar Cuenta" target="_self"><i class="fas fa-pen-square"></i></a>';

                // //Para alimentar el datatable
                table.fnAddData([
                    '<input type="checkbox" name="" id="" autocomplete="off" value="'+value.no_cuenta+'"/>',
                    value.no_cuenta,
                    value.cta_acumulable,
                    value.nombre,
                    value.rubro,
                    value.tipo,
                    value.naturaleza,
                    value.nivel,

                    '<div class="col text-center"><pre>'+botones+
                    '</pre></div>'
                ])
                        
            });
        })
        .catch(err => alertify.error(err));
}


const cargar_datos = (funcion, id = null) => {
    
    return new Promise ( (resolve, reject) => {
        $.ajax({
            url: url,
            data: {funcion, id},
            type: 'post',
            dataType: 'json',
            asycn: true,
            beforeSend:  () =>{
                Swal.fire({
                    title: '¡Espere un momento!',
                    html: 'Cargando...',
                    allowOutsideClick: false,
                    onBeforeOpen: () => {
                        Swal.showLoading()
                    },
                });
            },
            success:  (response) =>{
                swal.close();
                (Object.keys(response).length === 0)
                    ?reject("Ha ocurrido un error al cargar las cuentas")
                    :resolve(response);
        
            },
            error: (data) =>{
                reject("Ha ocurrido un error inesperado. Inténtelo más tarde!");
                console.log(data);
            }
        });
    })


}


const modal_cta = (idkey) => {

    let titulo = $('#titulo');
    titulo.empty();
    titulo.append('Editar Cuenta Contable');

    let boton = $('#btnGuardar');

    boton.attr('onclick', "guardar_cambios()")
    clean();

    $("#modal_cuentas").modal("show");
    $('#id_cta').val(idkey);

    cargar_datos("cargar_cuenta", idkey)
        .then(([{no_cuenta, cta_acumulable, nombre, rubro, tipo, naturaleza, nivel}]) => {
            
            $('#num_cuenta').val(parseFloat( no_cuenta ));
            $('#cta_acumulable').val(cta_acumulable);
            $('#nombre_cta').val(nombre);
            $('#rubro').val(rubro);
            $('#tipo').val(tipo);
            $('#naturaleza').val(naturaleza);
            $('#nivel').val(nivel);
            
        })
        .catch(error => alertify.error(error));
}

const guardar_cambios = () => {
    
    var form = $("#edit_cuentas");
    form.validate({errorClass: 'text-error'});
    if(form.valid()){

        let num_cuenta = $('#num_cuenta').val();
        let cta_acum = $('#cta_acumulable').val();
        let nombre_cuenta = $('#nombre_cta').val();
        let rub = $('#rubro').val();
        let tip = $('#tipo').val();
        let natu = $('#naturaleza').val();
        let niv = $('#nivel').val();
        datos = [num_cuenta, cta_acum, nombre_cuenta, rub, tip, natu, niv];
        Swal.fire({
            title: '¿Está seguro de actualizar los datos de la cuenta?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Guardar',
            cancelButtonText: 'Cancelar'
            }).then( (result) => {
                if (result.value) {
                    guardar('actualizar_cuenta', datos)
                        .then((value) => {
                           close_modal(value);
                        })
                        .catch(err => alertify.error(err));
                }
                else{
                    Swal.fire('Operación cancelada', '', 'error');
           
                }
            });       
      
        
    }
}

const close_modal = (value) => {
    Swal.fire({
        icon: 'success',
        title: 'Aviso',
        confirmButtonText: 'Aceptar',
        text: value + " Actualizados",
        footer: '',
        showCloseButton: true
        })
        .then(function (result) {
            $("#modal_cuentas").modal("toggle");
            $('.modal-backdrop').remove();
            window.location.reload(true);
        
    })
}

const guardar = (funcion, datos= null) => {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: url, dataType: 'json', type: 'POST', async: true, data: {
                funcion, array: datos
            }, beforeSend: () => {
                Swal.fire({
                    title: '¡Espere un momento!',
                    html: 'Cargando...',
                    allowOutsideClick: false,
                    onBeforeOpen: () => {
                        Swal.showLoading()
                    },
                });
            }, success: (response)=> {
                
                (response.error === 1)
                    ?resolve("Datos")
                    :reject('Ocurrió un error al guardar los datos')
                
                swal.close();

            },error: (data) => {
                console.log(data)
                reject("Ha ocurrido un errorr al guardar los cambios");
                swal.close();
            }
        })
    })
}

const agregar_cuenta = ()=> {
    //limpieza del form
    clean();
    //abrir modal
    $("#modal_cuentas").modal("show");
    //cambio de titulo para el formulario
    let titulo = $('#titulo');
    titulo.empty();
    titulo.append('Nueva Cuenta Contable');
    //cambio de funcion para agregar cuenta
    let boton = $('#btnGuardar');
    boton.attr('onclick', "boton()");

}

const clean = ()=> {
    $('#num_cuenta').val('');
    $('#cta_acumulable').val('');
    $('#nombre_cta').val('');
    $('#rubro').val('');
    $('#tipo').val('');
    $('#naturaleza').val('');
    $('#nivel').val('');
    return 0;
}

const boton = ()=>{
   
    var form = $("#edit_cuentas");
    validar();
    form.validate({errorClass: 'text-error'});
    
    if(form.valid()){

        let num_cuenta = $('#num_cuenta').val();
        let cta_acum = $('#cta_acumulable').val();
        let nombre_cuenta = $('#nombre_cta').val();
        let rub = $('#rubro').val();
        let tip = $('#tipo').val();
        let natu = $('#naturaleza').val();
        let niv = $('#nivel').val();
        datos = [num_cuenta, cta_acum, nombre_cuenta, rub, tip, natu, niv];
        Swal.fire({
            title: '¿Está seguro de actualizar los datos de la cuenta?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Guardar',
            cancelButtonText: 'Cancelar'
            }).then( (result) => {
                if (result.value) {
                    guardar('agregar_cuenta', datos)
                        .then((value) => {
                           close_modal(value);
                        })
                        .catch(err => alertify.error(err));
                }
                else{
                    Swal.fire('Operación cancelada', '', 'error');
           
                }
            });       
    }
}

//validar rfc
const validar= () =>{
    $.post(url,
        {funcion: "cargar_tabla"},
        function(data, status){
            data = JSON.parse(data);
            const cuenta = $('#num_cuenta').val();
            $.each(data, function(i, response){
                if(cuenta == response.no_cuenta){
                    Swal.fire('El número de cuenta ingresado ya existe');
                    $('#num_cuenta').val('');

                }
            });

    });
}