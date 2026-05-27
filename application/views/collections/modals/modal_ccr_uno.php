<form id="basicFormEliminar" method="POST" action="<?= base_url('collections_ccr_uno/truncate'); ?>" accept-charset="UTF-8" enctype="multipart/form-data" novalidate="novalidate">
    <div class="modal fade" id="myModalGenerateEliminar" tabindex="-1" role="dialog" aria-labelledby="modalSolicitudLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title text-white" id="modalSolicitudLabel">Esta seguro de eliminar todos los registros CCR UNO?</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
</form>