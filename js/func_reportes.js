const moduloReportes = ( () => {

    const initReportes = () => {
        const reporteGeneral = $('#reporteGeneral');
        const reporteAutorizados = $('#reportesAutorizados');
        const reporteAtrasados = $('#reportesAtrasados');
        const reportePagos = $('#reportesPagos');

        reporteGeneral.on('click', () => {
            tablaReportes();
        })

    }

    const tablaReportes = () => {
       $('#modalReportes').modal('show');
    }

    return {
        initReportes,
    }

})();