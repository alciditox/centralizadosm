<link rel="stylesheet" href="<?php echo base_url('assets/') ?>dist-assets/datetablet/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?php echo base_url('assets/') ?>dist-assets/datetablet/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="<?php echo base_url('assets/') ?>dist-assets/datetablet/datatables-buttons/css/buttons.bootstrap4.min.css">
<!-- Loading Model -->
<link rel="stylesheet" href="<?php echo base_url('assets/') ?>dist-assets/loadingModal/css/jquery.loadingModal.min.css">

<div class="breadcrumb">
    <ul>
        <li><a href="#">Domiciliación Bancaría</a></li>
        <li></li>
    </ul>
</div>
<div class="separator-breadcrumb border-top"></div>

<!-- end of row-->
<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card text-left">
            <div class="card-body">

                <div class="row">
                    <div class="col-sm-12">
                        <button class="btn btn-info btn-icon m-1" type="button" data-toggle="modal" data-target=".modal-cobro">
                            <span class="ul-btn__icon"><i class="fal fa-arrow-alt-circle-right"></i>
                            </span>
                            <span class="ul-btn__text">Generar Cobros</span>
                        </button>

                        <button class="btn btn-info btn-icon m-1" type="button" data-toggle="modal" data-target=".modal-generararchivo">
                            <span class="ul-btn__icon"><i class="fal fa-arrow-alt-circle-right"></i>
                            </span>
                            <span class="ul-btn__text">Generar Proceso Bancario</span>
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- end of col-->

    <div class="col-md-8 mb-8">
        <div class="card text-left">
            <div class="card-body">

                <div class="row">
                    <div class="col-sm-12">
                        <h5 class="heading text-secondary">Generados:</h5>
                    </div>
                    <div class="col-sm-12">
                        <?php //foreach (($totals ? $totals : array()) as $k) { 
                        ?>
                        <!-- <span class="t-font-boldest">
                            <a class="typo_link text-info" href=""><? //= $k->description; 
                                                                    ?>:</a> <? //= $k->cantidad; 
                                                                            ?> /
                        </span>-->
                        <?php //} 
                        ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- end of col-->
</div>
<div class="row">
    <!-- end of row-->
    <div class="col-md-12 mb-4">
        <div class="card text-left">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Banco</th>
                                <th>Total Bs</th>
                                <th>Total USD</th>
                                <th>Total Registros</th>
                                <th>Tasa</th>
                                <th>Estatus</th>
                                <th>Fecha Generado</th>
                                <!-- <th>Archivo</th> -->
                                <th>Respuesta</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($list as $k) { ?>
                                <tr>
                                    <td><?= $k->bancoName; ?></td>
                                    <td><?= $k->total_amount; ?></td>
                                    <td><?= $k->total_usd; ?></td>
                                    <td><?= $k->total_register; ?></td>
                                    <td><?= $k->tasa; ?></td>
                                    <td>
                                        <?php require(APPPATH . "views/invoices/modals/status.php"); ?>
                                    </td>
                                    <td><?= $k->fecha_generado; ?></td>
                                    <!-- <td>
                                        <a href="<?php //echo base_url('') . $k->route . $k->name; 
                                                    ?>" download>
                                            <button class="btn btn-dark ripple m-1" type="button">Descargar</button>
                                        </a>
                                    </td>-->
                                    <td>

                                        <?php if (!empty($k->numcobro)) { ?>
                                            <a href="<?= base_url('invoices/detail/' . $k->id); ?>">
                                                <button class="btn btn-info ripple m-1" type="button">Ver Detalle</button>
                                            </a>
                                        <?php } ?>

                                        <?php require(APPPATH . "views/invoices/modals/buttons.php"); ?>
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
<!-- end of col-->

<!-- ============ Modals ============= -->
<?php $this->load->view('invoices/modals/subir'); ?>
<?php $this->load->view('invoices/modals/cobro'); ?>
<?php $this->load->view('invoices/modals/generarArchivo'); ?>
<?php $this->load->view('invoices/modals/conciliar'); ?>
<?php $this->load->view('invoices/modals/anular'); ?>

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

<!-- ============ Search UI End ============= -->
<script src="<?php echo base_url('assets/') ?>dist-assets/js/scripts/form.validation.script.min.js"></script>
<!-- mask plugin  -->
<script src="<?php echo base_url('assets/') ?>dist-assets/mask/jquery.mask.min.js"></script>
<!-- ============ Mrtricas ============= -->
<script src="<?php echo base_url('assets/') ?>dist-assets/js/file_weight.js"></script>
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

<!-- Loading Modal -->
<script src="<?php echo base_url('assets/') ?>dist-assets/loadingModal/js/jquery.loadingModal.min.js"></script>

<script>
    $(function() {
        $("#example1").DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": false,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            //"buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
</script>


<script>
    $('.modal-subir').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget) // Botón que activó el modal

        var modal = $(this)
        //modal.find('.modal-body #id').text(button.data('id'))
        modal.find('.modal-body #id').val(button.data('id'))
        modal.find('.modal-body #banco').val(button.data('banco'))
        modal.find('.modal-body #banconame').text(button.data('banconame'))
        modal.find('.modal-body #fecha_generado').val(button.data('date'))
        modal.find('.modal-body #fecha_generado_text').text(button.data('date'))
        $('.alert').hide(); //Oculto alert
    });
</script>

<script>
    $('.modal-anular').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget) // Botón que activó el modal

        var modal = $(this)
        //modal.find('.modal-body #id').text(button.data('id'))
        modal.find('.modal-body #id').val(button.data('id'))
        modal.find('.modal-body #banco').val(button.data('banco'))
        modal.find('.modal-body #banconame').text(button.data('banconame'))
        modal.find('.modal-body #fecha_generado').val(button.data('date'))
        modal.find('.modal-body #fecha_generado_text').text(button.data('date'))
        $('.alert').hide(); //Oculto alert
    });
</script>

<script>
    $('.modal-conciliar').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget) // Botón que activó el modal

        var modal = $(this)
        //modal.find('.modal-body #id').text(button.data('id'))
        modal.find('.modal-body #id').val(button.data('id'))
        modal.find('.modal-body #banco').val(button.data('banco'))
        modal.find('.modal-body #banconame').text(button.data('banconame'))
        modal.find('.modal-body #fecha_generado').val(button.data('date'))
        modal.find('.modal-body #fecha_generado_text').text(button.data('date'))
        modal.find('.modal-body #registros').text(button.data('registros'))
        $('.alert').hide(); //Oculto alert
    });
</script>

<script>
    /****************************************************************************/
    $('#type_service').on('change', function(e) {
        var type_service = e.target.value;
        $(".field").attr("style", "display:none");

        $('.input').removeAttr('required');
        $('.input').attr('disabled', 'disabled');

        var cambio = document.getElementById("date_invoice");
        cambio.type = "month";

        document.getElementById("date_invoice").value = '';
        switch (type_service) {

            case '7':
                $(".months").attr("style", "display:block");
                $(".type_weekly").attr("style", "display:block");

                $('#type_weekly').removeAttr('disabled');
                $('#type_weekly').attr('required', true);

                $('.date_invoice').removeAttr('disabled');
                $('.date_invoice').attr('required', true);
                break;

            case '8':
                $(".months").attr("style", "display:block");
                $(".type_biweekly").attr("style", "display:block");

                $('#type_biweekly').removeAttr('disabled');
                $('#type_biweekly').attr('required', true);

                $('.date_invoice').removeAttr('disabled');
                $('.date_invoice').attr('required', true);
                break;

            case '9':
                $(".months").attr("style", "display:block");

                $('.date_invoice').removeAttr('disabled');
                $('.date_invoice').attr('required', true);

                break;

            case '10':
                $(".months").attr("style", "display:block");

                $('.date_invoice').removeAttr('disabled');
                $('.date_invoice').attr('required', true);

                break;
        }
    });
    /****************************************************************************/
</script>

<script>
    $(document).ready(function() {
        $('#basicForm').submit(function() {
            if (!$('#bank_id').val() || !$('#date_invoice').val()) {

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