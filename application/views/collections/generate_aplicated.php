<?php require(APPPATH . "views/collections/modals/funciones.php"); ?>

<link rel="stylesheet" href="<?php echo base_url('assets/') ?>dist-assets/css/plugins/toastr.css" />
<link rel="stylesheet" href="<?php echo base_url('assets/') ?>dist-assets/select2/css/select2.min.css">
<link rel="stylesheet" href="<?php echo base_url('assets/') ?>dist-assets/select2/css/select2-bootstrap4.min.css">
<link rel="stylesheet" href="<?php echo base_url('assets/') ?>dist-assets/datetablet/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?php echo base_url('assets/') ?>dist-assets/datetablet/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="<?php echo base_url('assets/') ?>dist-assets/datetablet/datatables-buttons/css/buttons.bootstrap4.min.css">
<link href="<?php echo base_url('assets/') ?>dist-assets/loadingModal/css/jquery.loadingModal.min.css" rel="stylesheet">

<style>
    .ccr-card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, .06);
        transition: box-shadow .25s ease;
    }

    .ccr-card:hover {
        box-shadow: 0 6px 28px rgba(0, 0, 0, .10);
    }

    .ccr-card .card-header {
        background: linear-gradient(135deg, #4e73df 0%, #6f42c1 100%);
        color: #fff;
        border-radius: 10px 10px 0 0 !important;
        padding: .85rem 1.25rem;
        border-bottom: 0;
    }

    .ccr-card .card-header h5 {
        font-weight: 600;
        margin: 0;
        font-size: 1rem;
        display: flex;
        align-items: center;
        gap: .5rem;
    }

    .file-upload-zone {
        border: 2px dashed #d1d5db;
        border-radius: 8px;
        padding: 1.1rem;
        text-align: center;
        transition: all .2s ease;
        background: #fafbfc;
    }

    .file-upload-zone:hover {
        border-color: #6f42c1;
        background: #f3f0ff;
    }

    .file-upload-zone label {
        display: block;
        font-weight: 600;
        font-size: .85rem;
        color: #374151;
        margin-bottom: .6rem;
    }

    .file-upload-zone label i {
        color: #6f42c1;
        margin-right: .35rem;
    }

    .file-upload-zone input[type="file"] {
        font-size: .82rem;
    }

    .step-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .step-list li {
        display: flex;
        align-items: flex-start;
        gap: .65rem;
        padding: .45rem 0;
        font-size: .87rem;
        color: #444;
        line-height: 1.45;
    }

    .step-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 24px;
        height: 24px;
        min-width: 24px;
        border-radius: 50%;
        background: linear-gradient(135deg, #4e73df 0%, #6f42c1 100%);
        color: #fff;
        font-size: .72rem;
        font-weight: 700;
        flex-shrink: 0;
    }

    .btn-ccr {
        border-radius: 7px;
        font-weight: 600;
        font-size: .82rem;
        padding: .5rem 1.1rem;
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        transition: all .2s ease;
        border: none;
    }

    .btn-ccr:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, .15);
    }

    .btn-ccr-upload {
        background: linear-gradient(135deg, #4e73df 0%, #6f42c1 100%);
        color: #fff;
    }

    .btn-ccr-upload:hover {
        color: #fff;
    }

    /* Results table */
    .results-card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, .06);
        overflow: hidden;
    }

    .results-card .card-header {
        background: #f8f9fc;
        border-bottom: 1px solid #e3e6f0;
        padding: .85rem 1.25rem;
    }

    .results-card .card-header h5 {
        font-weight: 600;
        margin: 0;
        font-size: .95rem;
        color: #374151;
        display: flex;
        align-items: center;
        gap: .5rem;
    }

    .stat-pill {
        display: inline-flex;
        align-items: center;
        gap: .35rem;
        padding: .25rem .7rem;
        border-radius: 20px;
        font-size: .78rem;
        font-weight: 600;
    }

    .stat-pill-info {
        background: #e0f2fe;
        color: #0369a1;
    }

    .stat-pill-success {
        background: #dcfce7;
        color: #15803d;
    }

    .stat-pill-primary {
        background: #ede9fe;
        color: #6d28d9;
    }

    .stat-pill-warning {
        background: #fef3c7;
        color: #92400e;
    }

    .btn-download {
        border-radius: 6px;
        font-weight: 600;
        font-size: .78rem;
        padding: .4rem .85rem;
        display: inline-flex;
        align-items: center;
        gap: .35rem;
        transition: all .2s ease;
    }

    .btn-download:hover {
        transform: translateY(-1px);
        box-shadow: 0 3px 10px rgba(0, 0, 0, .12);
    }

    .empty-state {
        text-align: center;
        padding: 2.5rem 1rem;
        color: #94a3b8;
    }

    .empty-state i {
        font-size: 2.8rem;
        margin-bottom: .8rem;
        opacity: .5;
    }
</style>

<!-- Breadcrumb -->
<div class="breadcrumb">
    <ul>
        <li><a href="#">CCR Aplicados :</a></li>
        <li>Generar Reporte</li>
    </ul>
</div>
<div class="separator-breadcrumb border-top"></div>

<div class="row">
    <div class="col-lg-12 col-md-12">

        <!-- Jobs Activos Alert -->
        <?php if (!empty($active_jobs)): ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-info" role="alert" style="border-radius:10px; border-left:4px solid #0369a1;">
                        <h4 class="alert-heading"><i class="fa fa-sync fa-spin"></i> Procesando archivos en segundo plano...</h4>
                        <hr>
                        <?php foreach ($active_jobs as $job): ?>
                            <p class="mb-1">
                                <strong>Job #<?= $job->id ?></strong>:
                                <span class="badge badge-warning"><?= $job->estatus ?></span>
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
            </div>
        <?php endif; ?>

        <!-- Upload Card -->
        <div class="row">
            <div class="col-md-12">
                <div class="card ccr-card mb-4">
                    <div class="card-header">
                        <h5><i class="fas fa-cloud-upload-alt"></i> Subir Archivos — CCR Aplicados</h5>
                    </div>
                    <form id="basicForm" class="needs-validation" novalidate="novalidate" method="POST" action="<?= base_url('Collections_aplicated/subeDataClient'); ?>" accept-charset="UTF-8" enctype="multipart/form-data">
                        <div class="card-body p-4">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="file-upload-zone">
                                        <label for="firstName1"><i class="fas fa-credit-card"></i> Archivo Credicard</label>
                                        <input class="form-control-file nuevaImagenDos" name="userfile[]" id="firstName1" type="file" onchange="checkExt(this);" required />
                                        <small class="text-muted d-block mt-2">Formato: CSV</small>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="file-upload-zone">
                                        <label for="firstName2"><i class="fas fa-chart-bar"></i> Reporte de Cobranza</label>
                                        <input class="form-control-file nuevaImagenUno" name="userfile[]" id="firstName2" type="file" onchange="checkExt(this);" required />
                                        <small class="text-muted d-block mt-2">Formato: XLSX</small>
                                    </div>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="cuenta_contable"><i class="fas fa-university text-muted mr-1"></i> Banco</label>
                                    <select class="form-control select2" id="cuenta_contable" name="cuenta_contable" required>
                                        <option value="">Seleccione</option>
                                        <?php foreach ($bancos as $banco) { ?>
                                            <option value="<?= $banco->codigo ?>"><?= $banco->codigo ?> - <?= $banco->nombre ?></option>
                                        <?php } ?>
                                    </select>
                                    <div class="invalid-feedback">Dato Obligatorio</div>
                                </div>
                                <div class="col-md-2 d-flex align-items-end">
                                    <button type="submit" class="btn btn-ccr btn-ccr-upload btn-block mb-3">
                                        <i class="fas fa-upload"></i> Subir Archivos
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-light border-0 px-4 py-3">
                            <ul class="step-list">
                                <li><span class="step-badge">1</span> Subir archivo <strong>Credicard (CSV)</strong> y <strong>Reporte de Ventas (XLSX)</strong> en ese orden.</li>
                                <li><span class="step-badge">2</span> Descargar los archivos Excel finalizados.</li>
                                <li><span class="step-badge">3</span> Limpiar para volver a generar otro banco.</li>
                            </ul>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Results Table -->
        <div class="row">
            <div class="col-md-12">
                <?php if (!empty($conteo_total)) { ?>
                    <div class="card results-card mb-4">
                        <div class="card-header">
                            <h5><i class="fas fa-list-alt text-primary"></i> Resultados de Procesamiento</h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table id="example1" class="table table-hover mb-0">
                                    <thead style="background:#f1f5f9;">
                                        <tr>
                                            <th style="font-size:.82rem; font-weight:700; color:#475569; padding:.75rem 1rem; text-align:center;">Datos</th>
                                            <th style="font-size:.82rem; font-weight:700; color:#475569; padding:.75rem 1rem; text-align:center;">Descargas Excel</th>
                                            <th style="font-size:.82rem; font-weight:700; color:#475569; padding:.75rem 1rem; text-align:center;">Descargas CSV</th>
                                            <th style="font-size:.82rem; font-weight:700; color:#475569; padding:.75rem 1rem; text-align:center; width:100px;">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach (($conteo_total ?: []) as $k) { ?>
                                            <tr>
                                                <td style="padding:.85rem 1rem; vertical-align:middle;">
                                                    <div class="mb-2">
                                                        <span class="stat-pill stat-pill-info"><i class="fas fa-credit-card"></i> Credicard: <?= $k->conteo_credicard; ?></span>
                                                        <span class="stat-pill stat-pill-success ml-1"><i class="fas fa-file-alt"></i> Reporte: <?= $k->conteo_reporte; ?></span>
                                                        <span class="stat-pill stat-pill-primary ml-1"><i class="fas fa-layer-group"></i> Total: <?= $k->conteo_total; ?></span>
                                                    </div>
                                                    <div style="font-size:.82rem; color:#64748b;">
                                                        <span class="stat-pill stat-pill-warning"><i class="fas fa-university"></i> <?= $k->banco; ?> — <?= $k->nombre; ?></span>
                                                    </div>
                                                </td>
                                                <td style="padding:.85rem 1rem; vertical-align:middle;">
                                                    <?php if ($k->create_user === $this->session->userdata['logged_in']['id']) { ?>
                                                        <button class="btn btn-success btn-download ripple m-1" type="button" onclick="window.location.href='<?php echo base_url('Collections_aplicated/excel_cobranza/aprobados'); ?>'">
                                                            <i class="fas fa-check-circle"></i> Aprobados
                                                        </button>
                                                        <button class="btn btn-success btn-download ripple m-1" type="button" onclick="window.location.href='<?php echo base_url('Collections_aplicated/excel_cobranza/rechazados'); ?>'">
                                                            <i class="fas fa-times-circle"></i> Rechazados
                                                        </button>
                                                        <button class="btn btn-success btn-download ripple m-1" type="button" onclick="window.location.href='<?php echo base_url('Collections_aplicated/excel_cobranza/errados'); ?>'">
                                                            <i class="fas fa-exclamation-triangle"></i> Montos Errados
                                                        </button>
                                                        <button class="btn btn-success btn-download ripple m-1" type="button" onclick="window.location.href='<?php echo base_url('Collections_aplicated/excel_cobranza/duplicados'); ?>'">
                                                            <i class="fas fa-copy"></i> Duplicados
                                                        </button>
                                                    <?php } ?>
                                                </td>
                                                <td style="padding:.85rem 1rem; vertical-align:middle;">
                                                    <?php if ($k->create_user === $this->session->userdata['logged_in']['id']) { ?>
                                                        <button class="btn btn-primary btn-download ripple m-1" type="button" onclick="window.location.href='<?php echo base_url('Collections_aplicated/excel_cobranza_csv/aprobados'); ?>'">
                                                            <i class="fas fa-check-circle"></i> Aprobados CSV
                                                        </button>
                                                        <button class="btn btn-primary btn-download ripple m-1" type="button" onclick="window.location.href='<?php echo base_url('Collections_aplicated/excel_cobranza_csv/rechazados'); ?>'">
                                                            <i class="fas fa-times-circle"></i> Rechazados CSV
                                                        </button>
                                                        <button class="btn btn-primary btn-download ripple m-1" type="button" onclick="window.location.href='<?php echo base_url('Collections_aplicated/excel_cobranza_csv/errados'); ?>'">
                                                            <i class="fas fa-exclamation-triangle"></i> Monto Errado CSV
                                                        </button>
                                                        <button class="btn btn-primary btn-download ripple m-1" type="button" onclick="window.location.href='<?php echo base_url('Collections_aplicated/excel_cobranza_csv/duplicados'); ?>'">
                                                            <i class="fas fa-copy"></i> Duplicados CSV
                                                        </button>
                                                    <?php } ?>
                                                </td>
                                                <td style="padding:.85rem 1rem; vertical-align:middle; text-align:center;">
                                                    <?php if ($k->create_user === $this->session->userdata['logged_in']['id']) { ?>
                                                        <button class="btn btn-danger btn-download btn-limpiar"
                                                            data-toggle="modal"
                                                            data-target="#myModalGenerateEliminar"
                                                            data-cuenta_contable="<?= $k->codigo_banco; ?>"
                                                            data-create_user="<?= $k->create_user; ?>"
                                                            data-title="Eliminar registro">
                                                            <i class="fas fa-trash-alt"></i> Limpiar
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
                <?php } else { ?>
                    <div class="card ccr-card mb-4">
                        <div class="card-body">
                            <div class="empty-state">
                                <i class="fas fa-inbox d-block"></i>
                                <p><strong>Sin registros cargados</strong></p>
                                <p class="mt-1">Suba los archivos Credicard y Reporte de Cobranza para comenzar.</p>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>

    </div>
</div>

<?php $this->load->view('collections/modals/modal_aplicated'); ?>

<!-- Scripts -->
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
<script src="<?php echo base_url('assets/') ?>dist-assets/mask/jquery.mask.min.js"></script>
<script src="<?php echo base_url('assets/') ?>dist-assets/js/metricas.js"></script>
<script src="<?php echo base_url('assets/') ?>dist-assets/datetablet/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url('assets/') ?>dist-assets/datetablet/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url('assets/') ?>dist-assets/datetablet/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url('assets/') ?>dist-assets/datetablet/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?php echo base_url('assets/') ?>dist-assets/datetablet/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url('assets/') ?>dist-assets/datetablet/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?php echo base_url('assets/') ?>dist-assets/datetablet/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url('assets/') ?>dist-assets/datetablet/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?php echo base_url('assets/') ?>dist-assets/datetablet/datatables-buttons/js/buttons.colVis.min.js"></script>
<script src="<?php echo base_url('assets/') ?>dist-assets/js/scripts/form.validation.script.min.js"></script>
<script src="<?php echo base_url('assets/') ?>dist-assets/select2/js/select2.full.min.js"></script>
<script src="<?php echo base_url('assets/') ?>dist-assets/js/plugins/toastr.min.js"></script>
<script src="<?php echo base_url('assets/') ?>dist-assets/loadingModal/js/jquery.loadingModal.min.js"></script>
<script src="<?php echo base_url('assets/') ?>dist-assets/js/subeimagen.js"></script>

<script>
    $(document).ready(function() {
        $('#basicForm').submit(function() {
            if (!$('#firstName1').val() || !$('#firstName2').val() || !$('#cuenta_contable').val()) {
                toastr.warning("Debe completar todos los campos antes de continuar.", "Campos requeridos", {
                    progressBar: true,
                    showMethod: "fadeIn",
                    hideMethod: "fadeOut",
                    timeOut: 4000,
                    positionClass: "toast-top-right"
                });
                return false;
            } else {
                var startTime = Date.now();
                var timerInterval = setInterval(function() {
                    var elapsed = Math.floor((Date.now() - startTime) / 1000);
                    var mins = String(Math.floor(elapsed / 60)).padStart(2, '0');
                    var secs = String(elapsed % 60).padStart(2, '0');
                    var timeText = mins + ':' + secs;
                    $('.loading-modal .loading-modal-text, .jquery-loading-modal__text').html(
                        '<i class="fas fa-cog fa-spin" style="font-size:1.4rem;margin-bottom:.5rem"></i><br>' +
                        'Procesando archivos CCR Aplicados&hellip;<br>' +
                        '<small style="opacity:.7">Por favor no recargue la p&aacute;gina</small><br><br>' +
                        '<strong style="font-size:1.1rem">' + timeText + '</strong>'
                    );
                }, 1000);

                $('body').loadingModal({
                    text: '<i class="fas fa-cog fa-spin" style="font-size:1.4rem;margin-bottom:.5rem"></i><br>Procesando archivos CCR Aplicados&hellip;<br><small style="opacity:.7">Por favor no recargue la p&aacute;gina</small><br><br><strong>00:00</strong>'
                });
                setTimeout(function() {
                    $('body').loadingModal('animation', 'threeBounce');
                }, 2000);
            }
        });
    })
</script>

<script>
    function showModal() {
        $('body').loadingModal({
            text: '<i class="fas fa-search" style="font-size:1.4rem;margin-bottom:.5rem"></i><br>Verificando informaci&oacute;n&hellip;<br><small style="opacity:.7">Por favor no recargue la p&aacute;gina</small>'
        });
        setTimeout(function() {
            $('body').loadingModal('animation', 'threeBounce');
        }, 2000);
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
        var button = $(event.relatedTarget)
        $('.alert').hide();
    });

    $('#basicFormEliminar').submit(function() {
        $('body').loadingModal({
            text: '<i class="fas fa-trash-alt" style="font-size:1.4rem;margin-bottom:.5rem"></i><br>Eliminando registros&hellip;<br><small style="opacity:.7">Por favor espere</small>'
        });
        $('body').loadingModal('animation', 'threeBounce');
    });
</script>

<script>
    jQuery(document).ready(function() {
        jQuery("#basicForm").validate({
            highlight: function(element) {
                jQuery(element).closest('.form-group').removeClass('has-success').addClass('has-error');
            },
            success: function(element) {
                jQuery(element).closest('.form-group').removeClass('has-error');
            }
        });
        jQuery("#cuenta_contable").select2();
    });
</script>

<script>
    $(".nuevaImagenDos").change(function() {
        var imagen = this.files[0];
        if (imagen["type"] != "application/pdf" && imagen["type"] != "text/csv") {
            $(".nuevaImagenDos").val("");
            toastr.error("El archivo Credicard debe estar en formato <strong>CSV</strong>.", "Formato incorrecto", {
                progressBar: true,
                showMethod: "fadeIn",
                hideMethod: "fadeOut",
                timeOut: 5000,
                positionClass: "toast-top-right"
            });
        } else {
            toastr.success("Archivo Credicard cargado correctamente.", "Archivo listo", {
                progressBar: true,
                showMethod: "fadeIn",
                hideMethod: "fadeOut",
                timeOut: 3000,
                positionClass: "toast-top-right"
            });
        }
    });
</script>

<script>
    $(".nuevaImagenUno").change(function() {
        var imagen = this.files[0];
        if (imagen["type"] != "application/pdf" && imagen["type"] != "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet") {
            $(".nuevaImagenUno").val("");
            toastr.error("El Reporte de Cobranza debe estar en formato <strong>EXCEL (XLSX)</strong>.", "Formato incorrecto", {
                progressBar: true,
                showMethod: "fadeIn",
                hideMethod: "fadeOut",
                timeOut: 5000,
                positionClass: "toast-top-right"
            });
        } else {
            toastr.success("Reporte de Cobranza cargado correctamente.", "Archivo listo", {
                progressBar: true,
                showMethod: "fadeIn",
                hideMethod: "fadeOut",
                timeOut: 3000,
                positionClass: "toast-top-right"
            });
        }
    });
</script>

<script>
    $(document).on('click', '.btn-limpiar', function() {
        var cuenta_contable = $(this).data('cuenta_contable');
        var create_user = $(this).data('create_user');
        $('#delete_cuenta_contable').val(cuenta_contable);
        $('#delete_create_user').val(create_user);
    });
</script>