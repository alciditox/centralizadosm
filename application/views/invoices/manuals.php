<link rel="stylesheet" href="<?php echo base_url('assets/') ?>dist-assets/css/plugins/toastr.css" />
<!-- Select2 -->
<link rel="stylesheet" href="<?php echo base_url('assets/') ?>dist-assets/select2/css/select2.min.css">
<link rel="stylesheet" href="<?php echo base_url('assets/') ?>dist-assets/select2/css/select2-bootstrap4.min.css">

<link rel="stylesheet" href="<?php echo base_url('assets/') ?>dist-assets/datetablet/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?php echo base_url('assets/') ?>dist-assets/datetablet/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="<?php echo base_url('assets/') ?>dist-assets/datetablet/datatables-buttons/css/buttons.bootstrap4.min.css">

<style>
    hr {
        margin-top: 0.2rem;
        margin-bottom: 1rem;
        border: 0;
        border-top: 1px solid rgba(0, 0, 0, 0.1);
        height: 0;
    }

    label {
        color: #003473 !important;
        font-weight: bold;
    }

    .form-group p {
        font-weight: bold;
    }
</style>

<div class="breadcrumb">
    <ul>
        <li><a href="#">Pagos Manuales</a></li>
        <li></li>
    </ul>
</div>
<div class="separator-breadcrumb border-top"></div>


<form class="needs-validation" novalidate="novalidate" method="POST" action="<?= base_url('invoices/manuals/search'); ?>" accept-charset="UTF-8" enctype="multipart/form-data">


    <div class="col-md-12">
        <div class="row">
            <div class="col-md-6">
                <div class="card mt-4 mt-4">
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-3 form-group">
                                <label for="firstName1">Rif Del Contratante</label>
                                <input class="form-control rif" id="rif" name="rif" type="text" autocomplete="off" />
                            </div>
                            <div class="col-md-1 form-group">
                                <label for="firstName1">&Oacute;</label>
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="firstName1">Contrato</label>
                                <input class="form-control only-number" id="contrato" name="contrato" type="text" maxlength="9" autocomplete="off" />
                            </div>

                            <div class="col-md-2 form-group">
                                <br>
                                <button class="btn btn-success" type="submit">Buscar</button>
                            </div>
                            <div class="col-md-2 form-group">
                                <br>
                                <a href="<?= base_url('invoices/manuals'); ?>">
                                    <button class="btn btn-info" type="button">Refrescar</button>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</form>


<?php if (!empty($row)) { ?>

    <div class="col-md-12">
        <div class="row">
            <div class="col-md-6">
                <div class="card mt-4 mt-4">
                    <div class="card-body">

                        <h3 class="card-title">datos del cliente</h3>

                        <div class="row">

                            <div class="col-md-3 form-group">
                                <label for="firstName1">Contrato</label>
                                <p><?= $row->id; ?></p>
                            </div>

                            <div class="col-md-3 form-group">
                                <label for="firstName1">Estatus</label>
                                <p><?= $row->status; ?></p>
                            </div>

                            <div class="col-md-3 form-group">
                                <label for="firstName1">Nombre</label>
                                <p><?= $row->nombre; ?></p>
                            </div>

                            <div class="col-md-3 form-group">
                                <label for="firstName1">Apellido</label>
                                <p><?= $row->apellido; ?></p>
                            </div>

                            <div class="col-md-3 form-group">
                                <label for="firstName1">Cedula</label>
                                <p><?= $row->cedula; ?></p>
                            </div>

                            <div class="col-md-3 form-group">
                                <label for="firstName1">Rif</label>
                                <p><?= $row->rif; ?></p>
                            </div>

                            <div class="col-md-3 form-group">
                                <label for="firstName1">Correo</label>
                                <p><?= $row->correo; ?></p>
                            </div>

                            <div class="col-md-3 form-group">
                                <label for="firstName1">Celular</label>
                                <p><?= $row->celular; ?></p>
                            </div>

                            <div class="col-md-3 form-group">
                                <label for="firstName1">Direccion</label>
                                <p><?= $row->address; ?></p>
                            </div>

                            <div class="col-md-3 form-group">
                                <label for="firstName1">Fecha Creacion</label>
                                <p><?= date('d-m-Y', strtotime($row->create_at)); ?></p>
                            </div>

                            <div class="col-md-3 form-group">
                                <label for="firstName1">Cantidad Afiliados</label>
                                <p><span class="text-danger"><?= $row->afiliados; ?></span></p>
                            </div>

                        </div>

                        <hr>

                        <div class="row">

                            <div class="col-md-3 form-group">
                                <label for="firstName1">Plan</label>
                                <p><?= $row->nplan; ?></p>
                            </div>

                            <div class="col-md-3 form-group">
                                <label for="firstName1">Nivel</label>
                                <p><?= $row->nnivel; ?></p>
                            </div>

                            <div class="col-md-3 form-group">
                                <label for="firstName1">Periodicidad</label>
                                <p><span class="text-danger"><?= $row->nperiodicidad; ?></span></p>
                            </div>

                            <div class="col-md-3 form-group">
                                <label for="firstName1">Tipo Pago</label>
                                <p><?= $row->pago; ?></p>
                            </div>

                            <div class="col-md-3 form-group">
                                <label for="firstName1">Monto Anual $</label>
                                <p>$ <?= $row->monto; ?></p>
                            </div>

                            <div class="col-md-3 form-group">
                                <label for="firstName1">Monto por cuota $</label>
                                <p>$ <?= $row->cobrar; ?>$</p>
                            </div>

                        </div>
                        <hr>
                        <div class="row">

                            <div class="col-md-4 form-group">
                                <label for="firstName1">Banco</label>
                                <p><?= $row->nbanco; ?></p>
                            </div>

                            <div class="col-md-4 form-group">
                                <label for="firstName1">Cuenta</label>
                                <p><?= $row->cuenta; ?></p>
                            </div>

                            <div class="col-md-4 form-group">
                                <label for="firstName1">Rif Pagador</label>
                                <p><?= $row->rifcuenta; ?></p>
                            </div>

                        </div>

                        <?php //if ($row->pago == "Domiciliacion") { 
                        ?>

                        <?php //} else { 
                        ?>
                        <!--<span class="text-danger"><strong>Cliente no Domiciliado.</strong></span>-->
                        <?php //} 
                        ?>

                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card mt-4 mt-4">
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-12">
                                <button class="btn btn-success" type="submit" data-toggle="modal" data-target=".modal-manual" data-contrato="<?= $row->id; ?>" data-cobrar="<?= $row->cobrar; ?>" data-cedula="<?= $row->cedula; ?>">
                                    Crear Cobro
                                </button>
                            </div>
                        </div>

                        <hr>

                        <div class="table-responsive">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>N Cobro</th>
                                        <th>Usd</th>
                                        <th>Bs</th>
                                        <th>Tasa</th>
                                        <!-- <th>Banco</th> -->
                                        <th>Generado</th>
                                        <th>Conciliado</th>
                                        <th>Estatus</th>
                                        <th>Referencia</th>
                                        <th>Fecha Creacion</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach (($list ? $list : array()) as $k) { ?>
                                        <tr>
                                            <td><?= $k->ncobro; ?></td>
                                            <td><?= $k->usd; ?></td>
                                            <td><?= $k->monto; ?></td>
                                            <td>
                                                <?php
                                                $tasa = ($k->monto / $k->usd);
                                                echo round($tasa, 2);
                                                ?>
                                            </td>
                                            <!-- <td><?= $k->nbanco; ?></td> -->
                                            <td><?= $k->fecha_mes_cobro; ?></td>
                                            <td><?= $k->fecha_conciliado; ?></td>
                                            <td>
                                                <?php require(APPPATH . "views/invoices/modals/status.php"); ?>
                                            </td>
                                            <td><?= $k->respuesta; ?></td>
                                            <td><?= $k->fecha_generado; ?></td>
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

<?php } ?>




<!-- ============ Modals ============= -->
<?php $this->load->view('invoices/modals/manual'); ?>

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
<script src="<?php echo base_url('assets/') ?>dist-assets/js/plugins/echarts.min.js"></script>
<script src="<?php echo base_url('assets/') ?>dist-assets/js/scripts/echart.options.min.js"></script>
<script src="<?php echo base_url('assets/') ?>dist-assets/js/scripts/dashboard.v1.script.min.js"></script>
<script src="<?php echo base_url('assets/') ?>dist-assets/js/scripts/customizer.script.min.js"></script>
<script src="<?php echo base_url('assets/') ?>dist-assets/js/plugins/toastr.min.js"></script>
<!-- ============ Search UI End ============= -->
<script src="<?php echo base_url('assets/') ?>dist-assets/js/scripts/form.validation.script.min.js"></script>
<!-- mask plugin  -->
<script src="<?php echo base_url('assets/') ?>dist-assets/mask/jquery.mask.min.js"></script>
<!-- ============ Mrtricas ============= -->
<script src="<?php echo base_url('assets/') ?>dist-assets/js/metricas.js"></script>
<script src="<?php echo base_url('assets/') ?>dist-assets/js/beneficiarios.js"></script>
<!-- Select2 -->
<script src="<?php echo base_url('assets/') ?>dist-assets/select2/js/select2.full.min.js"></script>

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
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
</script>

<script>
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2()
    })
</script>

<script>
    $('.modal-manual').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget) // Botón que activó el modal

        var modal = $(this)
        //modal.find('.modal-body #id').text(button.data('id'))
        modal.find('.modal-body #contrato').val(button.data('contrato'))
        modal.find('.modal-body #cobrar').val(button.data('cobrar'))
        modal.find('.modal-body #cedula').val(button.data('cedula'))
        $('.alert').hide(); //Oculto alert
    });
</script>

<script>
    //$("#cuotas").keyup(function() {
    $("#tasa").keyup(function() {
        var cobrar = parseFloat($("#cobrar").val());
        //var cuotas = parseFloat($("#cuotas").val());
        //var totalusd = parseFloat(cobrar * cuotas);
        var totalusd = parseFloat(cobrar * 1);
        $("#totalusd").val(totalusd.toFixed(2));

        var totalusd = parseFloat($("#totalusd").val());
        var tasa = parseFloat($("#tasa").val());
        var totalbs = parseFloat(totalusd * tasa);

        $("#totalbs").val(totalbs.toFixed(2));

    });

    $("#tasa").keyup(function() {
        var totalusd = parseFloat($("#totalusd").val());
        var tasa = parseFloat($("#tasa").val());

        var totalbs = parseFloat(totalusd * tasa);

        $("#totalbs").val(totalbs.toFixed(2));
    });
</script>