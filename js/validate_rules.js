 function validarViernes(value){
        if (value !== '') {
            var fecha = new Date(value.split("/").reverse().join("/"));
            if(fecha.getDay() !=5)
                return false;
            else 
                return true;
        }
        else 
            return true;
    }
    
 $(document).ready(function() {


    jQuery.extend(jQuery.validator.messages, { 
        required: "Este campo es obligatorio.", 
        email: "Ingrese un correo válido.", 
        url: "Please enter a valid URL.", 
        date: "Ingrese una fecha válida.", 
        dateISO: "Please enter a valid date (ISO).", 
        number: "Please enter a valid number.", 
        digits: "Please enter only digits.", 
        creditcard: "Please enter a valid credit card number.", 
        equalTo: "Please enter the same value again.", 
        accept: "Please enter a value with a valid extension.", 
        maxlength: jQuery.validator.format("Please enter no more than {0} characters."), 
        minlength: jQuery.validator.format("Please enter at least {0} characters."), 
        rangelength: jQuery.validator.format("Please enter a value between {0} and {1} characters long."), 
        range: jQuery.validator.format("Please enter a value between {0} and {1}."), 
        max: jQuery.validator.format("Ingrese un valor igual o menor a {0}."), 
        min: jQuery.validator.format("Ingrese un valor mayor o igual a {0}.") 
    }); 

    /*Agregar funciones jquery validator*/

    $.validator.addMethod("RFC", function (value, element) {
        if (value !== '') {
            var patt = new RegExp("^[A-Z,Ñ,&]{3,4}[0-9]{2}[0-1][0-9][0-3][0-9][A-Z,0-9]?[A-Z,0-9]?[0-9,A-Z]?$");
            return patt.test(value);
        } else
            return true;
    }, "Ingrese un RFC válido");

    $.validator.addMethod("CURP", function (value, element) {
        if (value !== '') {
            var patt = new RegExp("^[A-Z][A,E,I,O,U,X][A-Z]{2}[0-9]{2}[0-1][0-9][0-3][0-9][M,H][A-Z]{2}[B,C,D,F,G,H,J,K,L,M,N,Ñ,P,Q,R,S,T,V,W,X,Y,Z]{3}[0-9,A-Z][0-9]$");
            return patt.test(value);
        } else 
            return true;
        
    }, "Ingrese una CURP válido");

    $.validator.addMethod("MayorEdad", function (value, element) {
        if (value !== '') {
            request_ajax="";
            ajax_processingdata("../php/check_general.php?module=cliente_check_birtday&nacimiento="+value,"","get");//////////////////////////////////
            if (request_ajax==0) 
                return false;
            else 
                return true;
        }
        else
            return true;
    }, "!La edad debe ser mayor de 18 años!");

    $.validator.addMethod("FechaAnterior", function (value, element) {
        if (value !== '') {
            var fecha = new Date(value.split("/").reverse().join("/"));
            var hoy = new Date();
            if(fecha>hoy)
                return false;
            else 
                return true;
        }
        else 
            return true;
    }, "!La fecha debe ser anterior!");

    $.validator.addMethod("FechaViernes", function (value, element) {
        return validarViernes(value);
    }, "¡La fecha debe ser Viernes!");

    $.validator.addMethod("FechaPosterior", function (value, element) {
        if (value !== '') {
            var fecha = new Date(value.split("/").reverse().join("/"));
            var hoy = new Date();
            if(fecha<hoy)
                return false;
            else 
                return true;
        }
        else 
            return true;
    }, "!La fecha debe ser posterior!");

    $.validator.addMethod("NombreGrupo", function (value, element) {
        if (value !== '') {
            request_ajax= "";
            ajax_processingdata("../php/json_func_cartera.php?funcion=checar_nombre_grupo&nombre="+value,"funcion=checar_nombre_grupo&nombre="+value,"post");
            if (request_ajax==0) 
                return true;
            else 
                return false;
        }
        else
            return true;
    }, "¡Este nombre  de Grupo ya está en uso!");


     $("#paso1form").validate({
        errorClass: 'text-error',  
        ignore: false,
        rules: {
            nombre: {required: true},
            apellido_p: {required: true},
            apellido_m: {required: false},
            nacimiento: {required: true, FechaAnterior:true, MayorEdad: true},
            sexo: {required: true},
            rfc: {required: true, RFC: false},
            curp: {required: true, CURP: true},
            identificacion: {required: true},
            num_id: {required: true},
            vigencia: {required: true, FechaPosterior:true},
            calle: {required: true},
            interior: {required: true},
            estados: {required: true},
            municipios: {required: true},
            localidad: {required: true},
            codigo_postal: {required: true},
            inicia_habitar: {required: true, FechaAnterior: true},
            entrecalles: {required: true},
            referencia: {required: true},
            observaciones: {required: true},
            tipo_direccion: {required: true}
        }
    });


     $("#paso2form").validate({
        errorClass: 'text-error',  
        ignore: false,
        rules: {
            estado_civil: {required: true},
            fecha_sat: {FechaAnterior: true},
            inicio_cargo : {FechaAnterior:true}
        }
    });

      $("#paso3form").validate({
        errorClass: 'text-error',  
        ignore: false,
        rules:{
            vivienda: {required: true}
        }
    });

 });