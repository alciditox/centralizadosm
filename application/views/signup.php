<?php $this->session->sess_destroy(); ?>
<!-- Select2 -->
<link rel="stylesheet" href="<?php echo base_url('assets/') ?>dist-assets/select2/css/select2.min.css">
<link rel="stylesheet" href="<?php echo base_url('assets/') ?>dist-assets/select2/css/select2-bootstrap4.min.css">
<!DOCTYPE html>

<?php
$ci = &get_instance();
$ci->load->model("parameters"); // Cargar el modelo
$wcon = $ci->parameters->webConfigurations();
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $wcon->tittle; ?></title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet">

    <link href="<?php echo base_url('assets/') ?>dist-assets/css/themes/lite-purple.css" rel="stylesheet" />
    <link href="<?php echo base_url('assets/') ?>dist-assets/css/plugins/perfect-scrollbar.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo base_url('assets/') ?>dist-assets/css/plugins/fontawesome-5.css" />
    <link href="<?php echo base_url('assets/') ?>dist-assets/css/plugins/metisMenu.min.css" rel="stylesheet" />

    <link rel="icon" type="image/png" href="<?php echo base_url('assets/'); ?>dist-assets/images/local/favicon.png">
</head>

<style>
    .auth-logo img {
        width: 100%;
        height: 100px;
    }
</style>

<div class="auth-layout-wrap" style="background-image: url(<?php echo base_url('assets/') ?>dist-assets/images/local/photo-wide-4.png)">

    <div class="auth-content">
        <div class="card o-hidden">
            <div class="row">
                <div class="col-md-6 text-center" style="background-size: cover;background-image: url(../../dist-assets/images/local/photo-long-3.jpg)">
                    <div class="pl-3 auth-right">
                        <div class="auth-logo text-center mb-4"><img src="<?php echo base_url('assets/') ?>dist-assets/images/local/logo-login.png" alt=""></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-4">
                        <form class="needs-validation" novalidate="novalidate" method="POST" action="<?= base_url('login/add'); ?>" accept-charset="UTF-8" enctype="multipart/form-data">

                            <div class="form-group">
                                <label>Nombre</label>
                                <input class="form-control letters letter nocopy" id="nombre" name="nombre" type="text" maxlength="20" autocomplete="off" required="required">
                                <div class="invalid-feedback">
                                    Nombre incorrecto.
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Apellido</label>
                                <input class="form-control letters letter nocopy" id="apellido" name="apellido" type="text" maxlength="20" autocomplete="off" required="required">
                                <div class="invalid-feedback">
                                    Apellido incorrecto.
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Nombre Correo</label>
                                <input class="form-control notspace minusculas nocopy" id="correo" name="correo" type="text" maxlength="35" autocomplete="off" required="required">
                                <div class="invalid-feedback">
                                    Correo incorrecto.
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Dominio</label>
                                <select class="form-control" id="dominio" name="dominio" required>
                                    <option value="">Seleccione</option>
                                    <option value="@correo.com">@correo.COM</option>
                                </select>
                                <div class="invalid-feedback">
                                    Dato Obligatorio
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Movil</label>
                                <input class="form-control phone nocopy" id="movil" name="movil" type="text" minlength="12" autocomplete="off" required="required">
                                <div class="invalid-feedback">
                                    Movil incorrecto.
                                </div>
                            </div>

                            <button class="btn btn-info btn-block mt-3">Registrar</button>

                            <div class="mt-3 text-center">
                                <a class="text-muted" href="<?php echo base_url('') ?>">
                                    <u>Volver</u>
                                </a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


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
<!-- ============ Search UI End ============= -->
<script src="<?php echo base_url('assets/') ?>dist-assets/js/scripts/form.validation.script.min.js"></script>
<!-- mask plugin  -->
<script src="<?php echo base_url('assets/') ?>dist-assets/mask/jquery.mask.min.js"></script>
<!-- ============ Mrtricas ============= -->
<script src="<?php echo base_url('assets/') ?>dist-assets/js/metricas.js"></script>
<!-- Select2 -->
<script src="<?php echo base_url('assets/') ?>dist-assets/select2/js/select2.full.min.js"></script>

<script>
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2()
    })
</script>

<?php require(APPPATH . "views/layout/message.php"); ?>