<link rel="stylesheet" href="<?php echo base_url('assets/') ?>dist-assets/css/plugins/toastr.css" />
<!-- Select2 -->
<link rel="stylesheet" href="<?php echo base_url('assets/') ?>dist-assets/select2/css/select2.min.css">
<link rel="stylesheet" href="<?php echo base_url('assets/') ?>dist-assets/select2/css/select2-bootstrap4.min.css">

<link rel="stylesheet" href="<?php echo base_url('assets/') ?>dist-assets/datetablet/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?php echo base_url('assets/') ?>dist-assets/datetablet/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="<?php echo base_url('assets/') ?>dist-assets/datetablet/datatables-buttons/css/buttons.bootstrap4.min.css">
<link href="<?php echo base_url('assets/') ?>dist-assets/loadingModal/css/jquery.loadingModal.min.css" rel="stylesheet">

<div class="breadcrumb">
    <ul>
        <li><a href="#">Consolidado De Pagos Procesados</a></li>
        <li></li>
    </ul>
</div>
<div class="separator-breadcrumb border-top"></div>

<div class="row">
    <div class="col-lg-12 col-md-12">

        <!-- ============ Formulario de Búsqueda ============= -->
        <div class="col-md-12 mb-4">
            <div class="card text-left">
                <div class="card-body">
                    <h5 class="card-title mb-3"><i class="fal fa-search mr-2"></i>Filtros de Búsqueda</h5>
                    <form id="formFiltros">
                        <div class="row">

                            <div class="col-md-3 form-group">
                                <label for="fecha_desde"><b>Fecha Desde</b></label>
                                <input type="date" class="form-control" id="fecha_desde" name="fecha_desde">
                            </div>

                            <div class="col-md-3 form-group">
                                <label for="fecha_hasta"><b>Fecha Hasta</b></label>
                                <input type="date" class="form-control" id="fecha_hasta" name="fecha_hasta">
                            </div>

                            <div class="col-md-3 form-group">
                                <label for="banco"><b>Banco</b></label>
                                <select class="form-control select2" id="banco" name="banco">
                                    <option value="">Todos</option>
                                    <?php foreach ($bancos as $b) { ?>
                                        <option value="<?= $b->id ?>"><?= $b->id ?> - <?= $b->description ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="col-md-3 form-group">
                                <label for="status"><b>Status</b></label>
                                <select class="form-control select2" id="status" name="status">
                                    <option value="">Todos</option>
                                    <option value="Pendiente">Pendiente</option>
                                    <option value="Rechazado">Rechazado</option>
                                    <option value="Aprobado">Aprobado</option>
                                    <option value="Manual">Manual</option>
                                    <option value="Anulado">Anulado</option>
                                </select>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-12 text-right">
                                <button type="button" id="btnBuscar" class="btn btn-primary btn-icon m-1">
                                    <span class="ul-btn__icon"><i class="fal fa-search"></i></span>
                                    <span class="ul-btn__text"> Buscar</span>
                                </button>
                                <button type="button" id="btnLimpiar" class="btn btn-outline-secondary btn-icon m-1">
                                    <span class="ul-btn__icon"><i class="fal fa-eraser"></i></span>
                                    <span class="ul-btn__text"> Limpiar</span>
                                </button>
                                <button type="button" id="btnExportar" class="btn btn-success btn-icon m-1">
                                    <span class="ul-btn__icon"><i class="fal fa-file-excel"></i></span>
                                    <span class="ul-btn__text"> Exportar Excel</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- ============ DataTable Resultados ============= -->
        <div class="col-md-12 mb-4">
            <div class="card text-left">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table_consolidado" class="table table-bordered table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Nro Cobro</th>
                                    <th>Contrato</th>
                                    <th>Banco</th>
                                    <th>Cuenta</th>
                                    <th>RIF</th>
                                    <th>Razón</th>
                                    <th>Afiliado</th>
                                    <th>Frecuencia</th>
                                    <th>Nro POS</th>
                                    <th>Status</th>
                                    <th>F. Generado</th>
                                    <th>F. Conciliado</th>
                                    <th>F. Procesado</th>
                                    <th>Tasa</th>
                                    <th>Monto</th>
                                    <th>USD</th>
                                    <th>Nro POS (Col)</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

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

<script src="<?php echo base_url('assets/') ?>dist-assets/js/scripts/form.validation.script.min.js"></script>
<script src="<?php echo base_url('assets/') ?>dist-assets/mask/jquery.mask.min.js"></script>

<!-- DataTables & Plugins -->
<script src="<?php echo base_url('assets/') ?>dist-assets/datetablet/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url('assets/') ?>dist-assets/datetablet/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url('assets/') ?>dist-assets/datetablet/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url('assets/') ?>dist-assets/datetablet/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?php echo base_url('assets/') ?>dist-assets/datetablet/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url('assets/') ?>dist-assets/datetablet/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?php echo base_url('assets/') ?>dist-assets/datetablet/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url('assets/') ?>dist-assets/datetablet/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?php echo base_url('assets/') ?>dist-assets/datetablet/datatables-buttons/js/buttons.colVis.min.js"></script>

<!-- Select2 -->
<script src="<?php echo base_url('assets/') ?>dist-assets/select2/js/select2.full.min.js"></script>
<!-- Toastr -->
<script src="<?php echo base_url('assets/') ?>dist-assets/js/plugins/toastr.min.js"></script>
<!-- Loading Modal -->
<script src="<?php echo base_url('assets/') ?>dist-assets/loadingModal/js/jquery.loadingModal.min.js"></script>

<script>
    var table = null;

    $(document).ready(function() {
        // Inicializar Select2
        $('#banco').select2();
        $('#status').select2();

        // Botón Buscar - inicializa o recarga el DataTable
        $('#btnBuscar').on('click', function() {
            if (!$('#fecha_desde').val() && !$('#fecha_hasta').val() && !$('#banco').val() && !$('#status').val()) {
                toastr["warning"]("Debe seleccionar al menos un filtro para buscar.", "Aviso", {
                    progressBar: 100,
                    showMethod: "slideDown",
                    hideMethod: "slideUp",
                    timeOut: 3500
                });
                return;
            }

            if (table !== null) {
                table.ajax.reload(null, true);
            } else {
                table = $('#table_consolidado').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "order": [],
                    "ajax": {
                        "url": "<?php echo site_url('collections/get_consolidado_procesado_ajax') ?>",
                        "type": "POST",
                        "data": function(d) {
                            d.fecha_desde = $('#fecha_desde').val();
                            d.fecha_hasta = $('#fecha_hasta').val();
                            d.banco       = $('#banco').val();
                            d.status      = $('#status').val();
                        }
                    },
                    "columnDefs": [
                        { "targets": [10, 11, 12], "orderable": true }
                    ],
                    "responsive": true,
                    "pageLength": 25,
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
                    }
                });
            }
        });

        // Botón Limpiar - destruye DataTable y vuelve a estado vacío
        $('#btnLimpiar').on('click', function() {
            $('#formFiltros')[0].reset();
            $('#banco').val('').trigger('change');
            $('#status').val('').trigger('change');
            if (table !== null) {
                table.destroy();
                $('#table_consolidado tbody').empty();
                table = null;
            }
        });

        // Botón Exportar Excel
        $('#btnExportar').on('click', function() {
            var params = $.param({
                fecha_desde: $('#fecha_desde').val(),
                fecha_hasta: $('#fecha_hasta').val(),
                banco:       $('#banco').val(),
                status:      $('#status').val()
            });

            if (!$('#fecha_desde').val() && !$('#fecha_hasta').val() && !$('#banco').val() && !$('#status').val()) {
                toastr["warning"]("Debe seleccionar al menos un filtro para exportar.", "Aviso", {
                    progressBar: 100,
                    showMethod: "slideDown",
                    hideMethod: "slideUp",
                    timeOut: 3500
                });
                return;
            }

            window.location.href = "<?php echo site_url('collections/export_consolidado_procesado') ?>?" + params;
        });
    });
</script>
