$().ready(iniciarEventosMenu);

function iniciarEventosMenu(){
    

    $("#usuarioActivo").click(function (e) { 
        e.preventDefault();
        console.log("se clickeo");
    });

    $("#sltcampanas").change(function (e) { 
        e.preventDefault();
        $("#idCampanaActiva").val($("#sltcampanas").val());
        let idcampana=$("#idCampanaActiva").val();
        let campana=$("#sltcampanas option:selected").text()
        $.ajax({
            type: "GET",
            url: "includes/controlLogin.php",
            data: "idcampana="+idcampana+"&campana="+campana,
            dataType: "text",
            success: function (datos) {
                
            }
        });
        
    });

    $("#sltEmpresaActiva").change(function(e){
        e.preventDefault();
        $("#idEmpresaActiva").val($("#sltEmpresaActiva").val());
        let idempresaActiva=$("#sltEmpresaActiva").val();
        console.log(idempresaActiva);
        $("#idEmpresaActiva").val(idempresaActiva);
        let empresa=$("#sltEmpresaActiva option:selected").text()
        $.ajax({
            type: "GET",
            url: "includes/controlLogin.php",
            data: "MenuIdempresa="+idempresaActiva+"&MenuEmpresa="+empresa,
            dataType: "text",
            success: function (datos) {
                location.reload();
            }
        });
    });

}