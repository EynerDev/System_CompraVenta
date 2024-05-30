function init(){
    $("#mantenimiento_form").on("submit",function(e){
        guardaryeditar(e);
    });
}

// function guardaryeditar(e){
//     e.preventDefault();
//     var formData = new FormData($("#mantenimiento_form")[0]);
//     formData.append('suc_id',$('#SUC_IDx').val());
//     $.ajax({
//         url:"../../Controller/MonedaController.php?op=guardaryeditar",
//         type:"POST",
//         data:formData,
//         contentType:false,
//         processData:false,
//         success:function(){
//             $('#table_datos').DataTable().ajax.reload();
//             $('#ModalMoneda').modal('hide');

//             // Usar swal.fire en lugar de swal
//             Swal.fire({
//                 title:'Moneda',
//                 text: 'Registro Exitoso',
//                 icon: 'success'
//             });
//         }
//     });
// }
function guardaryeditar(e) {
    e.preventDefault();
    var formData = new FormData($("#mantenimiento_form")[0]);
    formData.append('suc_id', $('#SUC_IDx').val());
    $.ajax({
        url: "../../Controller/MonedaController.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            // Intenta analizar la respuesta como JSON
                if (response) {
                    data=JSON.parse(response)
                    // La respuesta indica éxito
                    $('#table_datos').DataTable().ajax.reload();
                    $('#ModalMoneda').modal('hide');
                    Swal.fire({
                        title: 'Moneda',
                        text:data.message,
                        icon: 'success'
                    });
                } else {
                    // La respuesta indica un error
                    Swal.fire({
                        title: 'Error',
                        text: data.message,
                        icon: 'error'
                    });
                }
            }
        },
)}


$(document).ready(function() {

    $('#table_datos').DataTable({
        "aProcessing": true,
        "aServerSide": true,
        dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
        ],
        "ajax": {
            url: "../../controller/MonedaController.php?op=listar",
            type: "post",
            data: { suc_id : 1},
            dataSrc: function(json) {
                console.log("Response from server:", json); // Depurar la respuesta del servidor
                if (!json.aaData) {
                    console.error("Invalid JSON response:", json);
                    return [];
                }
                return json.aaData;
            }
        },
        "bDestroy": true,
        "responsive": true,
        "bInfo": true,
        "iDisplayLength": 10,
        "order": [[0, "desc"]],
        "language": {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla",
            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": "Buscar:",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        },
    });
});

function editar(mon_id){
    $.post("../../Controller/MonedaController.php?op=mostrar",{mon_id:mon_id}, function(data){
        data = JSON.parse(data)
        $("#mon_id").val(data.MON_ID)
        $("#mon_name").val(data.MON_NAME)
    })

    $("#lblTitle").html("Editar Registro")
    $("#ModalMoneda").modal("show");


}
function eliminar(mon_id){
    swal.fire({
        title: "Eliminar",
        text: "¿Estás seguro de eliminar este registro?",
        icon: "error",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result) {
            $.post("../../Controller/MonedaController.php?op=eliminar",{mon_id:mon_id}, function(data){
            })
           
            $("#table_datos").DataTable().ajax.reload();

            swal.fire({
                title : "Compra y Venta",
                text : "Registro Eliminado",
                icon : "success",
            });
        }
    });
}


$(document).on("click","#btn_nuevo",function(){
    $('#mon_id').val('');
    $('#mon_name').val('');
    $('#lblTitle').html('Nuevo Registro');
    $("#mantenimiento_form")[0].reset();
    $('#ModalMoneda').modal('show');
});

init();
