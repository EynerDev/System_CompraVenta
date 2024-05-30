function init(){
    $("#mantenimiento_form").on("submit",function(e){
        guardaryeditar(e);
    });
}

function guardaryeditar(e) {
    e.preventDefault();
    var formData = new FormData($("#mantenimiento_form")[0]);
    formData.append('emp_id', $('#EMP_IDx').val());
    $.ajax({
        url: "../../Controller/SucursalController.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            // Intenta analizar la respuesta como JSON
                if (response) {
                    data = JSON.parse(response)
                    // La respuesta indica éxito
                    $('#table_datos').DataTable().ajax.reload();
                    $('#ModalSucursal').modal('hide');
                    Swal.fire({
                        title: 'Sucursal',
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
            
        },
    });
}

$(document).ready(function() {
    // Puedes obtener este valor dinámicamente según tus necesidades

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
            url: "../../controller/SucursalController.php?op=listar",
            type: "post",
            data: { emp_id : 1},
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

function editar(suc_id){
    $.post("../../Controller/SucursalController.php?op=mostrar",{suc_id:suc_id}, function(data){
        data=JSON.parse(data);
        $("#suc_id").val(data.SUC_ID)
        $("#suc_name").val(data.SUC_NAME)
    })

    $("#lblTitle").html("Editar Registro")
    $("#ModalSucursal").modal("show");


}
function eliminar(suc_id){
    swal.fire({
        title: "Eliminar",
        text: "¿Estás seguro de eliminar este registro?",
        icon: "error",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "Cancelar"

    }).then((result => {
        if (result.value){
            $.post("../../Controller/SucursalController.php?op=eliminar",{suc_id:suc_id}, function(data){
            }).then(response =>{
            data= JSON.parse(response)
            $("#table_datos").DataTable().ajax.reload();

            swal.fire({
                title : "Compra y Venta",
                text : data.message,
                icon : data.icon,
                confirmButtonClass : "btn-success"


            })

            })


            
           
            
        }

    }));
}


$(document).on("click","#btn_nuevo",function(){
    $('#suc_id').val('');
    $('#suc_name').val('');
    $('#lblTitle').html('Nuevo Registro');
    $("#mantenimiento_form")[0].reset();
    $('#ModalSucursal').modal('show');
});

init();