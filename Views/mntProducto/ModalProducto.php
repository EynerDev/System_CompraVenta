<!-- Grids in modals -->
<div class="modal fade" id="ModalProducto" tabindex="-1" aria-labelledby="exampleModalgridLabel" aria-modal="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" id="mantenimiento_form">
                    <div class="row g-3">
                                <div class="card-body p-4">
                                    <div class="text-center">
                                        <div class="profile-user position-relative d-inline-block mx-auto mb-4">
                                            <span id="prod_img_preview"></span>
                                            <div class="avatar-xs p-0 rounded-circle profile-photo-edit position-absolute bottom-0 end-0">
                                                <input id="prod_img" type="file" class="profile-img-file-input d-none">
                                                <label for="prod_img" class="profile-photo-edit avatar-xs m-1">
                                                    <span class="avatar-title rounded-circle bg-light text-body">
                                                        <i class="ri-camera-fill"></i>
                                                    </span>
                                                </label>
                                            </div>
                                            
                                            <div class="avatar-xs p-0 rounded-circle profile-photo-edit position-absolute bottom-0 start-0">
                                                <button id="remove-img-btn" class="profile-photo-edit rounded-circle avatar-xs m-1 btn btn-light">
                                                    <span class="avatar-title rounded-circle bg-light text-body">
                                                        <i class="ri-delete-bin-fill"></i>
                                                    </span>
                                                </button>
                                            </div>
                                        </div>
                                        <h5 class="fs-16 mb-1" id="lblTitle"></h5>
                                    </div>
                                </div>

                        <input type="hidden" name="prod_id" id="prod_id">
                        
                        <div class="col-xxl-6">
                            <h6 class="fw-semibold">Categoria</h6>
                            <select class="js-example-basic-single" id="cat_id" name="cat_id">                        
                            </select>
                        </div>
                        <div class="col-xxl-6">
                            <div>
                                <label for="nombre" class="form-label">Nombre:</label>
                                <input type="text" class="form-control" id="prod_name" name="prod_name" required placeholder="Nombre del producto">
                            </div>
                        </div><!--end col-->
                        <div class="col-xxl-6">
                            <div>
                                <label for="exampleFormControlTextarea5" class="form-label">Descripción</label>
                                <textarea class="form-control" id="prod_descrip" name="prod_descrip" rows="3"></textarea>
                            </div>
                        </div>
                    
                        <div class="col-xxl-6">
                            <h6 class="fw-semibold">Unidad:</h6>
                            <select class="js-example-basic-single" id="unid_id" name="unid_id">
                            </select>
                        </div>
                        <div class="col-xxl-6">
                            <h6 class="fw-semibold">Moneda:</h6>
                            <select class="js-example-basic-single" id="mon_id" name="mon_id">
                            </select>
                        </div>
                        <div class="col-xxl-6">
                            <div>
                                <label for="email" class="form-label">Precio Compra:</label>
                                <input type="text" class="form-control" id="prod_pcompra" name="prod_pcompra" required placeholder="Precio de Compra del producto">
                            </div>
                        </div><!--end col-->
                        <div class="col-xxl-6">
                            <div>
                                <label for="email" class="form-label">Precio Venta:</label>
                                <input type="text" class="form-control" id="prod_pventa" name="prod_pventa" required placeholder="Precio de Venta del producto">
                            </div>
                        </div><!--end col-->
                        <div class="col-xxl-6">
                            <div>
                                <label for="email" class="form-label">Stock:</label>
                                <input type="text" class="form-control" id="prod_stock" name="prod_stock" required placeholder="Stock del producto">
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
