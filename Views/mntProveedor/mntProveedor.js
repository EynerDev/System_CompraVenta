let emp_id = $('#EMP_IDx').val()
function init(){
    $("#mantenimiento_form").on("submit",function(e){
        guardaryeditar(e);

    }
)}


function guardaryeditar(e) {  
    e.preventDefault();
    var formData = new FormData($("#mantenimiento_form")[0]);
    formData.append('emp_id', emp_id);
    $.ajax({
        url: "../../Controller/ProveedorController.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            // Intenta analizar la respuesta como JSON
                if (response) {
                    data = JSON.parse(response)
                    console.log(data)
                    // La respuesta indica éxito
                    $('#table_datos').DataTable().ajax.reload();
                    $('#ModalProveedor').modal('hide');
                    Swal.fire({
                        title: 'Proveedor',
                        text:data.message,
                        icon: data.icon
                    });
                } else {
                    // La respuesta indica un error
                    Swal.fire({
                        title: 'Error',
                        text: data.message,
                        icon: data.icon
                    });
                }
            
        },
    });
}

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
            url: "../../Controller/ProveedorController.php?op=listar",
            type: "post",
            data: { emp_id : emp_id},
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

function editar(prov_id){
    $.post("../../Controller/ProveedorController.php?op=mostrar",{prov_id:prov_id}, function(data){
        data=JSON.parse(data);
        $("#prov_id").val(data.PROV_ID)
        $("#prov_name").val(data.PROV_NAME)
        $("#prov_rut").val(data.PROV_RUT)
        $("#prov_number").val(data.PROV_NUMBER)
        $("#prov_dirc").val(data.PROV_DIRC)
        $("#prov_email").val(data.PROV_EMAIL)
    })

    $("#lblTitle").html("Editar Registro")
    $("#ModalProveedor").modal("show");


}
function eliminar(prov_id){
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
            $.post("../../Controller/ProveedorController.php?op=eliminar",{prov_id:prov_id}, function(data){
              console.log(data)
            })
           
            $("#table_datos").DataTable().ajax.reload();

            swal.fire({
                title : "Compra y Venta",
                text : "Registro Eliminado",
                icon : "success",
                confirmButtonClass : "btn-success"


            })
        }

    }));
}


$(document).on("click","#btn_nuevo",function(){
    $('#prov_id').val('');
    $('#prov_name').val('');
    $('#prov_rut').val('');
    $('#prov_number').val('');
    $('#prov_dirc').val('');
    $('#prov_email').val('');
    $('#lblTitle').html('Nuevo Registro');
    $("#mantenimiento_form")[0].reset();
    $('#ModalProveedor').modal('show');
});

init();