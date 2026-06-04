                <!--  Large Modal -->

                <form id="formConciliar" class="needs-validation" novalidate="novalidate" method="POST" action="<?= base_url('collections/conciliar'); ?>" accept-charset="UTF-8" enctype="multipart/form-data">
                    <div class="modal fade modal-conciliar" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalCenterTitle">Conciliar banco </h5>
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
                                            <label for="firstName1">Fecha Generado</label>
                                            <p id="fecha_generado_text"></p>

                                        </div>

                                        <div class="col-md-4 form-group">
                                            <label for="firstName1">Cant. de Registros</label>
                                            <p id="registros"></p>

                                        </div>

                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-outline-danger" type="button" data-dismiss="modal">Cerrar</button>
                                    <button class="btn btn-outline-success" type="submit">Conciliar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                
<script>
    $(document).ready(function() {
        $('#formConciliar').submit(function(e) {
            var form = this;
            if (form.checkValidity() === false) {
                e.stopPropagation();
            } else {
                // Bloquear el botón para evitar más de un clic
                $(this).find('button[type="submit"]').prop('disabled', true).text('Conciliando...');
                
                // Mostrar ventana de carga
                $('body').loadingModal({
                    text: 'Estamos procesando su informaci&oacute;n<br> En breve estar&aacute; listo<br> Por favor no recargar la pagina'
                });
                var delay = function(ms) {
                    return new Promise(function(r) {
                        setTimeout(r, ms)
                    });
                };
                var time = 2000;
                delay(time).then(function() {
                    $('body').loadingModal('animation', 'threeBounce');
                });
            }
        });
    });
</script>
                <!--  Small Modal -->