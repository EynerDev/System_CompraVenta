
let user_id = $('#USER_IDx').val()

$(document).on("click", "#guardar", function(){
let password = $("#password").val()
let pass_confirm = $("#pass_confirm").val()

    if (password.length == 0 || pass_confirm.length == 0){
        Swal.fire({
            title: 'Error',
            text: "Campos vacios",
            icon: "error"
        });
    }else{
        if(password != pass_confirm){
            Swal.fire({
                title: 'Error',
                text: "Las contraseñas no coinciden",
                icon: "error"
            });
        }else{
            $.post("../../Controller/UsuarioController.php?op=password",{user_id:user_id,user_password:password}, function(data){
                Swal.fire({
                    title: 'Contraseña ',
                    text: "Contraseña Actualizada",
                    icon: "success"
                });
            })
        
            $("#lblTitle").html("Editar Registro")
            $("#ModalProducto").modal("show");

        }
}

})