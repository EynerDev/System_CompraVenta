$(document).ready(function(){

    var com_id = getUrlParameter('c');

    $('#emp_id').select2();
    $('#suc_id').select2();

    // Realiza una solicitud AJAX POST a EmpresaController.php cuando se carga la página o ocurre una cierta acción
    $.post("Controller/EmpresaController.php?op=combo", { com_id: com_id })
        .done(function(data) {
            console.log("Datos recibidos:", data);
            $("#emp_id").html(data);
        })
        .fail(function(error) {
            console.error("Error en la solicitud:", error);
        });

// Añade un listener de evento change al elemento #emp_id
$("#emp_id").change(function() {
    var emp_id = $(this).val();
    console.log("Empresa seleccionada:", emp_id);

    // Realiza una solicitud AJAX POST a SucursalController.php con el emp_id seleccionado
    $.post("Controller/SucursalController.php?op=combo", { emp_id: emp_id })
        .done(function(data) {
            console.log("Datos recibidos:", data);
            $("#suc_id").html(data);
        })
        .fail(function(error) {
            console.error("Error en la solicitud:", error);
        });
});
});
    
    


var getUrlParameter = function getUrlParameter(parameter) {
    const parametrosUrl = new URLSearchParams(window.location.search);
    return parametrosUrl.get(parameter);
}
