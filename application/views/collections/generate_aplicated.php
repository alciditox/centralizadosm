<?php require(APPPATH . "views/collections/modals/funciones.php"); ?>


<link rel="stylesheet" href="<?php echo base_url('assets/') ?>dist-assets/css/plugins/toastr.css" />
<!-- Select2 -->
<link rel="stylesheet" href="<?php echo base_url('assets/') ?>dist-assets/select2/css/select2.min.css">
<link rel="stylesheet" href="<?php echo base_url('assets/') ?>dist-assets/select2/css/select2-bootstrap4.min.css">

<link rel="stylesheet" href="<?php echo base_url('assets/') ?>dist-assets/datetablet/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?php echo base_url('assets/') ?>dist-assets/datetablet/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="<?php echo base_url('assets/') ?>dist-assets/datetablet/datatables-buttons/css/buttons.bootstrap4.min.css">
<link href="<?php echo base_url('assets/') ?>dist-assets/loadingModal/css/jquery.loadingModal.min.css" rel="stylesheet">

<style>
    .card-body-alt {
        flex: 1 1 auto;
        padding: 0rem;
    }
</style>

<div class="breadcrumb">
    <ul>
        <li><a href="#">CCR Aplicados : </a></li>
        <li></li>
    </ul>
</div>
<div class="separator-breadcrumb border-top"></div>

<div class="row">
    <div class="col-lg-12 col-md-12">

        <div class="row">

            <!-- Jobs Activos Alert -->
            <?php if (!empty($active_jobs)): ?>
                <div class="col-md-12">
                    <div class="alert alert-info" role="alert">
                        <h4 class="alert-heading"><i class="fa fa-sync fa-spin"></i> Procesando archivos en segundo plano...</h4>
                        <hr>
                        <?php foreach ($active_jobs as $job): ?>
                            <p class="mb-1">
                                <strong>Job #<?= $job->id ?></strong>:
                                <span class="badge badge-warning"><?= $job->status ?></span>
                                Progr.: <?= $job->progress ?>% - <?= $job->message ?>
                            </p>
                        <?php endforeach; ?>
                        <div class="mt-2">
                            <a href="<?= base_url('collections_aplicated/generate') ?>" class="btn btn-sm btn-light">
                                <i class="fa fa-sync"></i> Actualizar estado
                            </a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Sección Búsqueda por RIF -->
            <div class="col-md-12">
                <div class="card mb-4">
                    <form id="basicForm" class="needs-validation" novalidate="novalidate" method="POST" action="<?= base_url('Collections_aplicated/subeDataClient'); ?>" accept-charset="UTF-8" enctype="multipart/form-data">
                        <div class="card-body">

                            <div class="row">

                                <div class="col-md-4 form-group">
                                    <label for="rif">Archivo Credicard</label>
                                    <input class="form-control nuevaImagenDos" name="userfile[]" id="firstName1" type="file" onchange="checkExt(this);" required />
                                    <div class="invalid-feedback">
                                        Dato Obligatorio
                                    </div>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="rif">Reporte de Cobranza</label>
                                    <input class="form-control nuevaImagenUno" name="userfile[]" id="firstName2" type="file" onchange="checkExt(this);" required />
                                    <div class="invalid-feedback">
                                        Dato Obligatorio
                                    </div>
                                </div>

                                <div class="col-md-4 form-group">
                                    <label for="firstName1">Banco</label>
                                    <select class="form-control select2" id="cuenta_contable" name="cuenta_contable" required>
                                        <option value="">Seleccione</option>
                                        <?php foreach ($bancos as $banco) { ?>
                                            <option value="<?= $banco->codigo ?>"><?= $banco->codigo ?> - <?= $banco->nombre ?></option>
                                        <?php } ?>
                                    </select>
                                    <div class="invalid-feedback">
                                        Dato Obligatorio
                                    </div>
                                </div>

                            </div>

                            <div class="panel-footer">
                                <p>1. Subir archivo <strong>Credicard(CSV)</strong> y <strong>Reporte de Ventas(Xlxs)</strong> en ese orden<br>
                                    2. Descargar los archivos Excel finalizados.<br>
                                    3. Limpiar para volver a generar otro banco
                                <p>

                                    <?php if ($conteo == 0) { ?>
                                        <button type="submit" class="btn btn-success btn-xs btn-metro">Subir Archivos</button>
                                    <?php } ?>
                            </div><!-- panel-footer -->
                    </form>
                </div>

            </div>
        </div>

    </div>

    <div class="row">

        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">

                    <div class="row">

                        <div class="col-md-12">

                            <div class="table-responsive">
                                <table id="example1" class="table table-bordered table-striped">
                                    <!--<h4 bg-success text-white>Listado de procesos</h4>-->
                                    <p></p>
                                    <thead>
                                        <tr>
                                            <th>Datos</th>
                                            <th>Descargas</th>
                                            <th>Descargas</th>
                                            <th>Limpiar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach (($conteo_total ?: []) as $k) { ?>
                                            <tr>
                                                <td>
                                                    <span class="t-font-boldest text-info">Credicard:</span> <?= $k->conteo_credicard; ?> <br />
                                                    <span class="t-font-boldest text-success">Reporte:</span> <?= $k->conteo_reporte; ?> <br />
                                                    <span class="t-font-boldest text-primary">Total:</span> <?= $k->conteo_total; ?> <br />
                                                    <hr>
                                                    <span class="t-font-boldest text-success">Banco:</span> <?= $k->banco; ?><br />
                                                    <span class="t-font-boldest text-success">Nombre:</span> <?= $k->nombre; ?>
                                                </td>
                                                <td>
                                                    <?php

                                                    if ($k->create_user == $this->session->userdata['logged_in']['id']) {
                                                    ?>

                                                        <button class="btn btn-success ripple m-1" type="button" onclick="window.location.href='<?php echo base_url('Collections_aplicated/excel_cobranza/aprobados'); ?>'">Aprobados</button>

                                                        <button class="btn btn-success ripple m-1" type="button" onclick="window.location.href='<?php echo base_url('Collections_aplicated/excel_cobranza/rechazados'); ?>'">Rechazados</button>

                                                        <button class="btn btn-success ripple m-1" type="button" onclick="window.location.href='<?php echo base_url('Collections_aplicated/excel_cobranza/errados'); ?>'">Montos Errados</button>

                                                        <button class="btn btn-success ripple m-1" type="button" onclick="window.location.href='<?php echo base_url('Collections_aplicated/excel_cobranza/duplicados'); ?>'">Duplicados</button>

                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <?php

                                                    if ($k->create_user == $this->session->userdata['logged_in']['id']) {
                                                    ?>

                                                        <button class="btn btn-primary ripple m-1" type="button" onclick="window.location.href='<?php echo base_url('Collections_aplicated/excel_cobranza_csv/aprobados'); ?>'">Aprobados CSV</button>

                                                        <button class="btn btn-primary ripple m-1" type="button" onclick="window.location.href='<?php echo base_url('Collections_aplicated/excel_cobranza_csv/rechazados'); ?>'">Rechazados CSV</button>

                                                        <button class="btn btn-primary ripple m-1" type="button" onclick="window.location.href='<?php echo base_url('Collections_aplicated/excel_cobranza_csv/errados'); ?>'">Monto Errado CSV</button>

                                                        <button class="btn btn-primary ripple m-1" type="button" onclick="window.location.href='<?php echo base_url('Collections_aplicated/excel_cobranza_csv/duplicados'); ?>'">Duplicados CSV</button>

                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <?php if ($k->create_user == $this->session->userdata['logged_in']['id']) { ?>
                                                        <button class="btn btn-danger btn-xs btn-bordered tooltips btn-limpiar"
                                                            data-toggle="modal"
                                                            data-target="#myModalGenerateEliminar"
                                                            data-cuenta_contable="<?= $k->codigo_banco; ?>"
                                                            data-create_user="<?= $k->create_user; ?>"
                                                            data-title="Eliminar registro">
                                                            <span class="glyphicon glyphicon-trash"></span> Limpiar
                                                        </button>

                                                    <?php } ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>
</div>
<!-- end of col-->






<?php $this->load->view('collections/modals/modal_aplicated'); ?>

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
            if (!$('#firstName1').val() || !$('#firstName2').val() || !$('#cuenta_contable').val()) {

            } else {
                // Iniciar contador de tiempo transcurrido
                var startTime = Date.now();
                var timerInterval = setInterval(function() {
                    var elapsed = Math.floor((Date.now() - startTime) / 1000);
                    var mins = String(Math.floor(elapsed / 60)).padStart(2, '0');
                    var secs = String(elapsed % 60).padStart(2, '0');
                    var timeText = mins + ':' + secs;
                    // Actualizar el texto del modal con el tiempo transcurrido
                    $('.loading-modal .loading-modal-text, .jquery-loading-modal__text').html(
                        'Estamos procesando su informaci&oacute;n<br>' +
                        'Por favor no recargar la pagina<br><br>' +
                        'Tiempo transcurrido: <strong>' + timeText + '</strong><br>'
                    );
                }, 1000);

                $('body').loadingModal({
                    text: 'Estamos procesando su informaci&oacute;n<br> Tiempo transcurrido: <strong>00:00</strong><br> Por favor no recargar la pagina'
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

    $('#basicFormEliminar').submit(function() {
        $('body').loadingModal({
            text: 'Eliminando registros...<br>Por favor espere.'
        });
        $('body').loadingModal('animation', 'threeBounce');
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

<script>
    // JS para pasar datos al modal de eliminación
    $(document).on('click', '.btn-limpiar', function() {
        var cuenta_contable = $(this).data('cuenta_contable');
        var create_user = $(this).data('create_user');

        console.log('Cuenta Contable:', cuenta_contable);
        console.log('Create User:', create_user);

        $('#delete_cuenta_contable').val(cuenta_contable);
        $('#delete_create_user').val(create_user);
    });
</script>