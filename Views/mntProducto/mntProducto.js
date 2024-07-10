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
        url: "../../Controller/ProductoController.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            try {
                // Intenta analizar la respuesta como JSON
                var data = JSON.parse(response);
                if (data.success) {
                    // La respuesta indica éxito
                    $('#table_datos').DataTable().ajax.reload();
                    $('#ModalProducto').modal('hide');
                    Swal.fire({
                        title: 'Producto',
                        text: data.message,
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
            } catch (e) {
                // Si hay un error al analizar la respuesta como JSON
                console.error("La respuesta no es JSON válido:", response);
                Swal.fire({
                    title: 'Error',
                    text: 'Hubo un problema al procesar la respuesta del servidor.',
                    icon: 'error'
                });
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            // Manejo de errores en la solicitud AJAX
            console.error("Error en la solicitud AJAX:", textStatus, errorThrown);
            Swal.fire({
                title: 'Error',
                text: 'Hubo un problema con la solicitud. Por favor, inténtalo de nuevo más tarde.',
                icon: 'error'
            });
        }
    });
}


$(document).ready(function() {
    $('#cat_id').select2();
    $.post("../../Controller/CategoriaController.php?op=combo",{suc_id:suc_id})
    .done(function(data) {
        $("#cat_id").html(data);
    })
    .fail(function(error) {
        console.error("Error en la solicitud:", error);
    });

    $('#unid_id').select2();
    $.post("../../Controller/UnidadController.php?op=combo",{suc_id:suc_id})
    .done(function(data) {
        $("#unid_id").html(data);
    })
    .fail(function(error) {
        console.error("Error en la solicitud:", error);
    });
    $('#mon_id').select2();
    $.post("../../Controller/MonedaController.php?op=combo",{suc_id:suc_id})
    .done(function(data) {
        $("#mon_id").html(data);
    })
    .fail(function(error) {
        console.error("Error en la solicitud:", error);
    });

table_init(suc_id)
});
function table_init(suc_id){

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
            url: "../../Controller/ProductoController.php?op=listar",
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

function editar(prod_id){
    $.post("../../Controller/ProductoController.php?op=mostrar",{prod_id:prod_id}, function(data){
        data=JSON.parse(data);
        console.log(data)
        $("#prod_id").val(data.PROD_ID)
        $("#prod_name").val(data.PROD_NAME)
        $("#prod_descrip").val(data.PROD_DESCRIP)
        $("#cat_id").val(data.CAT_ID).trigger('change');
        $("#unid_id").val(data.UNID_ID).trigger('change');
        $("#mon_id").val(data.MON_ID).trigger('change');
        $("#prod_pventa").val(data.PROD_PVENTA)
        $("#prod_pcompra").val(data.PROD_PCOMPRA)
        $("#prod_stock").val(data.PROD_STOCK)
        $('#prod_img_preview').html(data.PROD_IMG)

    })

    $("#lblTitle").html("Editar Registro")
    $("#ModalProducto").modal("show");


}
function eliminar(prod_id){
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
            $.post("../../Controller/ProductoController.php?op=eliminar",{prod_id:prod_id}, function(data){
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


$(document).on("click", "#btn_nuevo", function() {
    $('#prod_id').val('');
    $('#prod_name').val('');
    $('#prod_rut').val('');
    $('#prod_number').val('');
    $('#prod_dirc').val('');
    $('#prod_email').val('');
    $('#cat_id').val('').trigger('change');
    $('#und_id').val('').trigger('change');
    $('#mon_id').val('').trigger('change');
    $("#prod_img_preview").html(
        '<img src="../../assets/productos/error_404.jpeg" class="rounded-circle avatar-xl img-thumbnail user-profile-image" alt="user-profile-image"></img><input type="hidden" name="hidden_producto_imagen" value="" />');
    $('#lblTitle').html('Nuevo Registro');
    $("#mantenimiento_form")[0].reset();
    $('#ModalProducto').modal('show');
});

function filePreview(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#prod_img_preview').html(
                '<img src="' + e.target.result + '" class="rounded-circle avatar-xl img-thumbnail user-profile-image" alt="user-profile-image" />');
        }
        reader.readAsDataURL(input.files[0]);
    }
}

$(document).on('change', '#prod_img', function(){
    filePreview(this);
});


$(document).on("click","#btnremovephoto",function(){
    $('#prod_img').val('');
    $('#prod_img_preview').html(
        '<img src="../../assets/productos/error_404.jpeg" class="rounded-circle avatar-xl img-thumbnail user-profile-image" alt="user-profile-image"></img><input type="hidden" name="hidden_producto_imagen" value="" />');
});

init();