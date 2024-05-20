
$(document).ready(function(){

    var com_id = getUrlParameter('c')
    console.log(com_id)

    $('#emp_id').select2()
    $('#suc_id').select2()

    $.post("Controller/EmpresaController.php?op=combo",{com_id:com_id})
    .done(function(data){
        $("#emp_id").html(data);
    })
    .fail(function(error) {
        console.error("Error en la solicitud:", error)
    })

        $("#emp_id").change(function(){
            // Obtener el valor seleccionado de #emp_id
            var emp_id = $(this).val();
            console.log(emp_id);
    
            // Realizar una solicitud AJAX
            $.post("Controller/SucursalController.php?op=combo", { emp_id: emp_id })
            .done(function(data){
                console.log(data);
                // Actualizar el contenido de #suc_id con la respuesta de la solicitud AJAX
                $("#suc_id").html(data);
            })
            .fail(function(error){
                console.error("Error en la solicitud: ", error);
            });
        });
    });
    
    


var getUrlParameter = function getUrlParameter(parameter) {
    const parametrosUrl = new URLSearchParams(window.location.search);
    return parametrosUrl.get(parameter);
}
