function comparaFechasdmY(fecha1,fecha2) {
    // convierte las fechas a yyyymmdd
    tmp = fecha1.split('/');
    fini = tmp[2] + tmp[1] + tmp[0];
    tmp = fecha2.split('/');
    ffin = tmp[2] + tmp[1] + tmp[0];
    // la comparación
    if (fini > ffin) {
        return true;
    }else{
        return false
    }
}


