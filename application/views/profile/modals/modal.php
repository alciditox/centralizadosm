<!--  Large Modal -->

<form class="needs-validation" novalidate="novalidate" method="POST" action="<?php echo base_url('profile/edit/password'); ?>" accept-charset="UTF-8" enctype="multipart/form-data">
    <div class="modal fade bd-example-modal-lg password" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle"> <i class="fas fa-edit"></i> Editar Clave </h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label for="firstName1">Contraseña Actual</label>
                            <div class="input-right-icon">
                                <input class="form-control password" id="password" name="password" type="password" autocomplete="off" minlength="8" maxlength="16" required>
                                <div class="invalid-feedback">
                                    Dato Obligatorio<br>
                                    Debe contener al menos 8 digitos
                                </div>

                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label for="firstName1">Contraseña Nueva</label>
                            <div class="input-right-icon">
                                <input class="form-control password" id="password" name="newpassword" type="password" autocomplete="off" minlength="8" maxlength="16" required>
                                <div class="invalid-feedback">
                                    Dato Obligatorio<br>
                                    Debe contener al menos 8 digitos
                                </div>

                            </div>
                        </div>

                        <div class="col-md-4 form-group">
                            <label for="firstName1">Repetir Contraseña</label>
                            <div class="input-right-icon">
                                <input class="form-control password" id="password" name="repeat" type="password" autocomplete="off" minlength="8" maxlength="16" required>
                                <div class="invalid-feedback">
                                    Dato Obligatorio<br>
                                    Debe contener al menos 8 digitos
                                </div>

                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row">

                        <div class="col-md-4 form-group">
                            <label class="switch pr-5 switch-success mr-3"><span>Mostrar Contraseñas</span>
                                <input type="checkbox" id="mostrar_contrasena"><span class="slider"></span>
                            </label>
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

<!--  Large Modal -->

<form class="needs-validation" novalidate="novalidate" method="POST" action="<?php echo base_url('profile/edit/mobile'); ?>" accept-charset="UTF-8" enctype="multipart/form-data">
    <div class="modal fade bd-example-modal-lg mobile" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle"> <i class="fas fa-edit"></i> Editar Movil </h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
                </div>
                <div class="modal-body">

                    <div class="row">

                        <div class="col-md-4 form-group">
                            <label for="firstName1">Movil Actual (No se modifica)</label>
                            <div class="input-right-icon">
                                <input class="form-control" id="" name="" type="text" value="<?= $info->movil; ?>" required readonly>
                                <div class="invalid-feedback">
                                    Dato Obligatorio<br>
                                </div>
                            </div>
                            <p><span class="t-font-boldest text-danger">No se modifica</span></p>
                        </div>

                        <div class="col-md-4 form-group">
                            <label for="firstName1">Movil Nuevo (Colocar numero real)</label>
                            <div class="input-right-icon">
                                <input class="form-control phone" id="movil" name="movil" type="text" minlength="12" autocomplete="off" required="required">
                                <div class="invalid-feedback">
                                    Dato Obligatorio
                                </div>
                            </div>
                            <p><span class="t-font-boldest text-danger">Colocar numero real, 0414, 0412, 0416, 0424, 0426</span></p>
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