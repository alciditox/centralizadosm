<form id="basicFormEliminar" method="POST" action="<?= base_url('collections_aplicated/eliminar_registro'); ?>" accept-charset="UTF-8" enctype="multipart/form-data" novalidate="novalidate">
    <div class="modal fade" id="myModalGenerateEliminar" tabindex="-1" role="dialog" aria-labelledby="modalSolicitudLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title text-white" id="modalSolicitudLabel">¿Está seguro de eliminar los registros seleccionados?</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="cuenta_contable" id="delete_cuenta_contable">
                    <input type="hidden" name="create_user" id="delete_create_user">
                    <p>Esta acción eliminará los registros cargados para este banco y usuario.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
</form>