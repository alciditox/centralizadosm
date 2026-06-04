                <!--  Large Modal -->

                <form class="needs-validation" novalidate="novalidate" method="POST" action="<?= base_url('administrator/webConfigure/edit'); ?>" accept-charset="UTF-8" enctype="multipart/form-data">
                    <div class="modal fade bd-example-modal-lg data_edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalCenterTitle">Editar <i class="fad fa-layer-plus"></i> </h5>
                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fas fa-times"></i></span></button>
                                </div>
                                <div class="modal-body">



                                    <div class="row">

                                        <input id="id" name="id" type="hidden" required />

                                        <div class="col-md-4 form-group">
                                            <label for="firstName1">Tittle</label>
                                            <input class="form-control" id="tittle" name="tittle" type="text" autocomplete="off" placeholder="..." required />
                                            <div class="invalid-feedback">
                                                Dato Obligatorio
                                            </div>
                                        </div>

                                        <div class="col-md-4 form-group">
                                            <label for="firstName1">Name</label>
                                            <input class="form-control" id="name" name="name" type="text" autocomplete="off" placeholder="..." required />
                                            <div class="invalid-feedback">
                                                Dato Obligatorio
                                            </div>
                                        </div>

                                        <div class="col-md-4 form-group">
                                            <label for="firstName1">Email</label>
                                            <input class="form-control" id="email" name="email" type="email" autocomplete="off" placeholder="..." required />
                                            <div class="invalid-feedback">
                                                Dato Obligatorio
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-md-6 form-group">
                                            <label for="firstName1">Web</label>
                                            <input class="form-control" id="web" name="web" type="text" autocomplete="off" placeholder="..." required />
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

                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-outline-success" type="submit">Guardar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <!--  Small Modal -->