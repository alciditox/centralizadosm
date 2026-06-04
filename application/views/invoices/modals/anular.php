                <!--  Large Modal -->

                <form class="needs-validation" novalidate="novalidate" method="POST" action="<?= base_url('invoices/anular'); ?>" accept-charset="UTF-8" enctype="multipart/form-data">
                    <div class="modal fade modal-anular" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalCenterTitle">Anular cobros </h5>
                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                </div>
                                <div class="modal-body">


                                    <div class="row">

                                        <input id="id" name="id" value="" type="hidden" required />
                                        <input id="banco" name="banco" value="" type="hidden" required />
                                        <input id="fecha_generado" name="fecha_generado" value="" type="hidden" required />

                                        <div class="col-md-4 form-group">
                                            <label for="firstName1">Banco</label>
                                            <p id="banconame"></p>
                                        </div>

                                        <div class="col-md-4 form-group">
                                            <label for="firstName1">Fecha a Conciliar</label>
                                            <p id="fecha_generado_text"></p>

                                        </div>

                                    </div>
                                    <div class="row">

                                        <div class="col-md-8 form-group">
                                            <label for="firstName1">Motivo De Anulaci&oacute;n</label>
                                            <textarea class="form-control" id="observacion" name="observacion" rows="5" cols="5" minlength="20" required></textarea>
                                            <div class="invalid-feedback">
                                                Dato Obligatorio
                                            </div>
                                        </div>

                                    </div>



                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-outline-danger" type="button" data-dismiss="modal">Cerrar</button>
                                    <button class="btn btn-outline-success" type="submit">Subir</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <!--  Small Modal -->