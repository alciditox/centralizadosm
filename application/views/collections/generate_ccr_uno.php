<?php require(APPPATH . "views/collections/modals/funciones.php"); ?>

<link rel="stylesheet" href="<?php echo base_url('assets/') ?>dist-assets/css/plugins/toastr.css" />
<!-- Select2 -->
<link rel="stylesheet" href="<?php echo base_url('assets/') ?>dist-assets/select2/css/select2.min.css">
<link rel="stylesheet" href="<?php echo base_url('assets/') ?>dist-assets/select2/css/select2-bootstrap4.min.css">

<link rel="stylesheet" href="<?php echo base_url('assets/') ?>dist-assets/datetablet/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?php echo base_url('assets/') ?>dist-assets/datetablet/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="<?php echo base_url('assets/') ?>dist-assets/datetablet/datatables-buttons/css/buttons.bootstrap4.min.css">
<link href="<?php echo base_url('assets/') ?>dist-assets/loadingModal/css/jquery.loadingModal.min.css" rel="stylesheet">

<div class="contentpanel">

    <div class="row">
        <div class="col-sm-6">

            <div class="panel panel-primary">
                <div class="panel-heading">

                    <h3 class="panel-title">Llenar y generar</h3>
                </div>

                <form id="basicForm" method="POST" action="<?php echo base_url(); ?>Collections_ccr_uno/subeDataClient" accept-charset="UTF-8" enctype="multipart/form-data" novalidate="novalidate">
                    <div class="panel-body">

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="file"><strong>Archivo Credicard</strong></label>
                                    <input name="userfile[]" id="firstName1" type="file" class="btn-secondary valid nuevaImagenDos" onchange="checkExt(this);" aria-required="true" aria-invalid="false" required>
                                </div><!-- form-group -->
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="file"><strong>Reporte de Ventas</strong></label>
                                    <input name="userfile[]" id="firstName2" type="file" class="btn-secondary valid nuevaImagenUno" onchange="checkExt(this);" aria-required="true" aria-invalid="false" required>
                                </div><!-- form-group -->
                            </div>
                        </div>

                    </div>
                    <div class="panel-footer">
                        <p>1. Subir archivo <strong>Credicard(Xlxs,CSV)</strong> y <strong>Reporte de Ventas(Xlxs,CSV)</strong> en ese orden<br>
                            2. Verificar con el <strong>Botón</strong> los erróneos.<br>
                            3. Descargar el archivo Excel finalizado.<br>
                            4. Limpiar para volver a generar otro archivo
                        <p>

                            <?php if ($conteo == 0) { ?>
                                <button type="submit" class="btn btn-success btn-xs btn-metro">Subir Archivos</button>
                            <?php } ?>
                    </div><!-- panel-footer -->
                </form>
            </div><!-- panel -->

        </div><!-- col-sm-6 -->


    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-primary mb30 letra">
                    <thead>
                        <tr>
                            <th>Conteo</th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($conteo > 0) { ?>
                            <tr>
                                <td><?= $conteo; ?></td>
                                <td class="table-action">

                                </td>
                                <td>
                                    <button class="btn btn-success btn-xs" onclick=" showModal(); window.location.href='<?php echo base_url('Collections_ccr_uno/verificar/'); ?>'">Verificar</button>
                                    <?php if ($errores > 0) { ?>
                                        <button class=" btn btn-success btn-xs" onclick="window.location.href='<?php echo base_url('Collections_ccr_uno/excel_cobranza/'); ?>'">Descargar Excell</button>
                                    <?php } ?>
                                </td>
                                <td>
                                    <button class="btn btn-danger btn-xs btn-bordered tooltips" data-toggle="modal" data-toggle="tooltip" data-placement="top" data-target="#myModalGenerateEliminar" data-title="Eliminar registro">
                                        <span class="glyphicon glyphicon-trash"></span> Limpiar
                                    </button>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div><!-- table-responsive -->
        </div><!-- col-md-12 -->
    </div>
    <!--row -->
    <?php $this->load->view('collections/modals/modal_ccr_uno'); ?>

    <!-- ============ Search UI End ============= -->
    <script src="<?php echo base_url('assets/') ?>dist-assets/js/plugins/jquery-3.3.1.min.js"></script>
    <script src="<?php echo base_url('assets/') ?>dist-assets/js/plugins/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url('assets/') ?>dist-assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="<?php echo base_url('assets/') ?>dist-assets/js/scripts/tooltip.script.min.js"></script>
    <script src="<?php echo base_url('assets/') ?>dist-assets/js/scripts/script.min.js"></script>
    <script src="<?php echo base_url('assets/') ?>dist-assets/js/scripts/script_2.min.js"></script>
    <script src="<?php echo base_url('assets/') ?>dist-assets/js/scripts/sidebar.large.script.min.js"></script>
    <script src="<?php echo base_url('assets/') ?>dist-assets/js/plugins/feather.min.js"></script>
    <script src="<?php echo base_url('assets/') ?>dist-assets/js/plugins/metisMenu.min.js"></script>
    <script src="<?php echo base_url('assets/') ?>dist-assets/js/scripts/layout-sidebar-vertical.min.js"></script>
    <script src="<?php echo base_url('assets/') ?>dist-assets/js/plugins/datatables.min.js"></script>
    <script src="<?php echo base_url('assets/') ?>dist-assets/js/scripts/datatables.script.min.js"></script>
    <script src="<?php echo base_url('assets/') ?>dist-assets/js/scripts/customizer.script.min.js"></script>

    <!-- mask plugin  -->
    <script src="<?php echo base_url('assets/') ?>dist-assets/mask/jquery.mask.min.js"></script>
    <!-- ============ Mrtricas ============= -->
    <script src="<?php echo base_url('assets/') ?>dist-assets/js/metricas.js"></script>

    <!-- DataTables  & Plugins -->
    <script src="<?php echo base_url('assets/') ?>dist-assets/datetablet/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url('assets/') ?>dist-assets/datetablet/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?php echo base_url('assets/') ?>dist-assets/datetablet/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?php echo base_url('assets/') ?>dist-assets/datetablet/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="<?php echo base_url('assets/') ?>dist-assets/datetablet/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="<?php echo base_url('assets/') ?>dist-assets/datetablet/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="<?php echo base_url('assets/') ?>dist-assets/datetablet/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="<?php echo base_url('assets/') ?>dist-assets/datetablet/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="<?php echo base_url('assets/') ?>dist-assets/datetablet/datatables-buttons/js/buttons.colVis.min.js"></script>

    <!-- ============ Search UI End ============= -->
    <script src="<?php echo base_url('assets/') ?>dist-assets/js/scripts/form.validation.script.min.js"></script>

    <!-- Select2 -->
    <script src="<?php echo base_url('assets/') ?>dist-assets/select2/js/select2.full.min.js"></script>

    <!-- Toastr -->
    <script src="<?php echo base_url('assets/') ?>dist-assets/js/plugins/toastr.min.js"></script>

    <script src="<?php echo base_url('assets/') ?>dist-assets/loadingModal/js/jquery.loadingModal.min.js"></script>
    <script src="<?php echo base_url('assets/') ?>dist-assets/js/subeimagen.js"></script>

    <script>
        $(document).ready(function() {
            $('#basicForm').submit(function() {
                if (!$('#firstName1').val() || !$('#firstName2').val()) {

                } else {
                    $('body').loadingModal({
                        text: 'Estamos procesando su informaci&oacute;n<br> En breve estar&aacute; listo<br> Por favor no recargar la pagina'
                    });
                    var delay = function(ms) {
                        return new Promise(function(r) {
                            setTimeout(r, ms)
                        })
                    };
                    var time = 2000;
                    delay(time)
                        .then(function() {
                            $('body').loadingModal('animation', 'threeBounce');
                        });
                }
            });
        })
    </script>

    <script>
        function showModal() {
            $('body').loadingModal({
                text: 'Verificando Informaci&oacute;n<br> Por favor no recargar la pagina'
            });
            var delay = function(ms) {
                return new Promise(function(r) {
                    setTimeout(r, ms)
                })
            };
            var time = 2000;
            delay(time)
                .then(function() {
                    $('body').loadingModal('animation', 'threeBounce');
                });
        }
    </script>

    <script>
        <?php if ($this->session->flashdata('message')) { ?>
            $('#myModalMsn').modal('show');
            <?php unset($_SESSION['message']); ?>
        <?php } ?>
    </script>

    <script>
        $('#myModalGenerateEliminar').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget) // Botón que activó el modal
            $('.alert').hide(); //Oculto alert
        });
    </script>

    <script>
        jQuery(document).ready(function() {

            // Basic Form
            jQuery("#basicForm").validate({
                highlight: function(element) {
                    jQuery(element).closest('.form-group').removeClass('has-success').addClass('has-error');
                },
                success: function(element) {
                    jQuery(element).closest('.form-group').removeClass('has-error');
                }
            });

            // Select2
            jQuery("#cuenta_contable").select2();
        });
    </script>

    <script>
        $(".nuevaImagenDos").change(function() {
            var imagen = this.files[0];

            console.log(imagen["type"]);
            console.log(imagen["size"]);

            if (imagen["type"] != "application/pdf" && imagen["type"] != "text/csv") {
                $(".nuevaImagenDos").val("");
                toastr.error("¡El archivo debe estar en formato CSV", "Danger", {
                    progressBar: 100,
                    showMethod: "slideDown",
                    hideMethod: "slideUp",
                    timeOut: 4500
                });

            }
        });
    </script>

    <script>
        $(".nuevaImagenUno").change(function() {
            var imagen = this.files[0];

            console.log(imagen["type"]);
            console.log(imagen["size"]);

            if (imagen["type"] != "application/pdf" && imagen["type"] != "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet") {
                $(".nuevaImagenUno").val("");
                toastr.error("¡El archivo debe estar en formato EXCEL", "Danger", {
                    progressBar: 100,
                    showMethod: "slideDown",
                    hideMethod: "slideUp",
                    timeOut: 4500
                });

            }
        });
    </script>