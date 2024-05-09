// $(document).ready(function(){
//     $.post("/Controller/EmpresaController.php?op=combo",{com_id:1},function(data){
//         $("#empresa").html(data);
//     });
// });
$(document).ready(function(){
    $.post("/Controller/EmpresaController.php?op=combo",{com_id:1})
    .done(function(data){
        $("#emp_id").html(data);
    })
    .fail(function(xhr, status, error) {
        console.error("Error en la solicitud:", error);
    });
});
