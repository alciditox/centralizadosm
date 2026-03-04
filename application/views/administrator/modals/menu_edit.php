                <!--  Large Modal -->

                <form class="needs-validation" novalidate="novalidate" method="POST" action="<?= base_url('administrator/menuConfigure/edit'); ?>" accept-charset="UTF-8" enctype="multipart/form-data">
                    <div class="modal fade bd-example-modal-lg menu_edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalCenterTitle">Editar <i class="fad fa-layer-plus"></i> </h5>
                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fas fa-times"></i></span></button>
                                </div>
                                <div class="modal-body">



                                    <div class="row">

                                        <input id="id" name="id" type="hidden" required />

                                        <div class="col-md-6 form-group">
                                            <label for="firstName1">Nombre</label>
                                            <input class="form-control" id="nombre" name="nombre" type="text" autocomplete="off" placeholder="..." required />
                                            <div class="invalid-feedback">
                                                Dato Obligatorio
                                            </div>
                                        </div>

                                        <div class="col-md-6 form-group">
                                            <label for="firstName1">URL</label>
                                            <input class="form-control" id="url" name="url" type="text" autocomplete="off" placeholder="..." required />
                                            <div class="invalid-feedback">
                                                Dato Obligatorio
                                            </div>
                                        </div>


                                    </div>

                                    <div class="row">

                                        <input id="id" name="id" type="hidden" required />

                                        <div class="col-md-4 form-group">
                                            <label for="firstName1">Parent</label>
                                            <input class="form-control" id="parent" name="parent" type="text" autocomplete="off" placeholder="..." />
                                            <div class="invalid-feedback">
                                                Dato Obligatorio
                                            </div>
                                        </div>

                                        <div class="col-md-4 form-group">
                                            <label for="firstName1">Icon</label>
                                            <input class="form-control" id="fabicon" name="fabicon" type="text" autocomplete="off" placeholder="..." />
                                            <div class="invalid-feedback">
                                                Dato Obligatorio
                                            </div>
                                        </div>

                                        <div class="col-md-4 form-group">
                                            <label for="firstName1">Estatus</label>
                                            <select class="form-control" name="status" required>
                                                <option value="Activo">Activo</option>
                                                <option value="Inactivo">Inactivo</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Dato Obligatorio
                                            </div>
                                        </div>


                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-outline-success" type="submit">Guardar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <!--  Small Modal -->