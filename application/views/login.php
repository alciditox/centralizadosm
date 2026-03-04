<?php

// Obtener la sesión completa de forma segura
$session = $this->session->userdata('logged_in');

// Si no existe la sesión, redirigir
if ($session || !empty($session['nombre'])) {
    redirect('dashboard');
    exit; // buena práctica
}

// Acceder a los datos
//$loggin_nombre = $session['nombre'];
?>

<?php
$ci = &get_instance();
$ci->load->model("parameters"); // Cargar el modelo
$wcon = $ci->parameters->webConfigurations();
?>

<!DOCTYPE html>

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
    <style>
        .auth-logo img {
            width: 80%;
            /*width: 220px;*/
            /*height: 50px;*/
        }

        .auth-right {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100%;
        }
    </style>
</head>

<form class="needs-validation" novalidate="novalidate" method="POST" action="<?php echo base_url('login/user_login_process') ?>">
    <div class="auth-layout-wrap" style="background-image: url(<?php echo base_url('assets/') ?>dist-assets/images/local/photo-wide-4.png)">
        <div class="auth-content">
            <div class="card o-hidden">
                <div class="row">
                    <div class="col-md-6">
                        <div class="p-4">
                            <div class="auth-logo text-center mb-4"><img src="<?php echo base_url('assets/') ?>dist-assets/images/local/logo-login.png" alt=""></div>
                            <!-- <h1 class="mb-3 text-18">Inicio</h1> -->
                            <h1 class="mb-3 text-18">Iniciar Sesi&oacute;n</h1>

                            <form>
                                <div class="form-group">
                                    <label for="email">Usuario <span class="t-font-boldest text-danger">(Correo)</span></label>
                                    <input class="form-control form-control-rounded " id="email" type="email" name="email" required="required">
                                    <div class="invalid-tooltip">
                                        Correo incorrecto.
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="password">Contraseña</label>
                                    <input class="form-control form-control-rounded " id="password" type="password" name="password" minlength="8" required>
                                    <div class="invalid-tooltip">
                                        Clave incorrecto.
                                    </div>
                                </div>

                                <div class="form-group ">
                                    <div class="">
                                        <div class=" form-check">

                                            <label class="form-check-label" for="remember">

                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <button class="btn btn-rounded btn-info btn-block mt-2" type="submit">Iniciar Sesi&oacute;n</button>

                                <div class="mt-3 text-center">
                                    <a class="text-muted" href="<?php echo base_url('login/signup') ?>">
                                        <u>Registrar</u>
                                    </a>
                                </div>

                            </form>

                        </div>
                    </div>
                    <div class="col-md-6 text-center" style="background-size: cover;background-image: url(<?php echo base_url('assets/') ?>dist-assets/images/local/photo-long-3.jpg)">
                        <div class="pr-3 auth-right">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</form>

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
<script src="<?php echo base_url('assets/') ?>dist-assets/js/scripts/form.validation.script.min.js"></script>

<?php require(APPPATH . "views/layout/message.php"); ?>