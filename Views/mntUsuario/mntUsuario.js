let suc_id = $('#SUC_IDx').val()
function init(){
    $("#mantenimiento_form").on("submit",function(e){
        guardaryeditar(e);

    }
)}


function guardaryeditar(e) {  
    e.preventDefault();
    var formData = new FormData($("#mantenimiento_form")[0]);
    formData.append('suc_id', suc_id);
    $.ajax({
        url: "../../Controller/UsuarioController.php?op=guardaryeditar",
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
                    $('#ModalUsuario').modal('hide');
                    Swal.fire({
                        title: 'Usuario',
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
    $('#user_role_id').select2();
    $.post("../../Controller/RolController.php?op=combo",{suc_id:suc_id})
    .done(function(data) {
        $("#user_role_id").html(data);
    })
    .fail(function(error) {
        console.error("Error en la solicitud:", error);
    });

    $('#user_typedoc').select2();
    $.post("../../Controller/TipoDocController.php?op=combo")
    .done(function(data) {
        $("#user_typedoc").html(data);
    })
    .fail(function(error) {
        console.error("Error en la solicitud:", error);
    });
    init_table()
    
});

function editar(user_id){
    $.post("../../Controller/UsuarioController.php?op=mostrar",{user_id:user_id}, function(data){
        data=JSON.parse(data);
        $("#user_id").val(data.USER_ID)
        $("#user_name").val(data.USER_NAME)
        $("#user_ape").val(data.USER_APE)
        $("#user_role_id").val(data.USER_ROLE_ID).trigger('change');
        $("#user_typedoc").val(data.USER_TYPEDOC).trigger('change');
        $("#user_document").val(data.USER_DOCUMENT)
        $("#user_email").val(data.USER_EMAIL)
        $("#user_number").val(data.USER_NUMBER)
        $("#user_password").val(data.USER_PASSWORD)
    })

    $("#lblTitle").html("Editar Registro")
    $("#ModalUsuario").modal("show");


}
function eliminar(user_id){
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
            $.post("../../Controller/UsuarioController.php?op=eliminar",{user_id:user_id}, function(data){
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
function init_table(){
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
            url: "../../Controller/UsuarioController.php?op=listar",
            type: "post",
            data: { suc_id : suc_id},
            dataSrc: function(json) {
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

}


$(document).on("click","#btn_nuevo",function(){
    $('#user_id').val('');
    $('#user_name').val('');
    $('#user_ape').val('');
    $('#user_role_id').val('');
    $('#user_typedoc').val('');
    $('#user_document').val('');
    $('#user_email').val('');
    $('#user_number').val('');
    $('#user_password').val('');
    $('#lblTitle').html('Nuevo Registro');
    $("#mantenimiento_form")[0].reset();
    $('#ModalUsuario').modal('show');
});

init();