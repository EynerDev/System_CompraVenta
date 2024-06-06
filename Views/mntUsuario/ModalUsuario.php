<!-- Grids in modals -->
<div class="modal fade" id="ModalUsuario" tabindex="-1" aria-labelledby="exampleModalgridLabel" aria-modal="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="lblTitle"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" id="mantenimiento_form">
                    <div class="row g-3">

                        <input type="hidden" name="user_id" id="user_id">
                        
        
                        <div class="col-xxl-6">
                            <div>
                                <label for="nombre" class="form-label">Nombre:</label>
                                <input type="text" class="form-control" id="user_name" name="user_name" required placeholder="Nombre delusuario">
                            </div>
                        </div><!--end col-->
                    
                        <div class="col-xxl-6">
                            <div>
                                <label for="nombre" class="form-label">Apellido:</label>
                                <input type="text" class="form-control" id="user_ape" name="user_ape" required placeholder="Apellido del usuario">
                            </div>
                        </div><!--end col-->

                        <div class="col-lg-4">
                            <h6 class="fw-semibold">Rol:</h6>
                            <select class="js-example-basic-single" id="user_role_id" name="user_role_id">
                            </select>
                        </div>
                        
                        <div class="col-lg-4">
                            <h6 class="fw-semibold">Tipo de Documento:</h6>
                            <select class="js-example-basic-single" id="user_typedoc" name="user_typedoc">
                            </select>
                        </div>
                        <div class="col-xxl-6">
                            <div>
                                <label for="nombre" class="form-label">N° Documento:</label>
                                <input type="text" class="form-control" id="user_document" name="user_document" required placeholder="Documento del usuario">
                            </div>
                        </div><!--end col-->
                        
                        <div class="col-xxl-6">
                            <div>
                                <label for="email" class="form-label">Correo:</label>
                                <input type="text" class="form-control" id="user_email" name="user_email" required placeholder="Correo del usuario">
                            </div>
                        </div><!--end col-->
                        <div class="col-xxl-6">
                            <div>
                                <label for="email" class="form-label">Numero:</label>
                                <input type="text" class="form-control" id="user_number" name="user_number" required placeholder="Numero del usuario">
                            </div>
                        </div><!--end col-->
                        <div class="col-xxl-6">
                            <div>
                                <label for="email" class="form-label">Contraseña:</label>
                                <input type="text" class="form-control" id="user_password" name="user_password" required placeholder="Contraseña del usuario">
                            </div>
                        </div><!--end col-->
                        <div class="col-lg-12">
                            <div class="hstack gap-2 justify-content-end">
                                <button type="reset" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
                                <button type="submit"  name="action" value="add" class="btn btn-primary">Agregar</button>
                            </div>
                        </div><!--end col-->
                    </div><!--end row-->
                </form>
            </div>
        </div>
    </div>
</div>
