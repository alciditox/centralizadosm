<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>404</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet">
    <link href="<?php echo base_url('assets/') ?>dist-assets/css/themes/lite-purple.min.css" rel="stylesheet">
    <link href="<?php echo base_url('assets/') ?>dist-assets/css/plugins/fontawesome-free/css/all.min.css" rel="stylesheet" />
    <link rel="icon" type="image/png" href="<?php echo base_url('assets/'); ?>dist-assets/images/bootstrap-logo.png">
</head>
<style>
    .parent {
        height: 200px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .child {
        width: 30%;
        /* height: 100px; */
        /* margin-top: 1em; */
        /* margin-bottom: 3em; */
        padding-bottom: 3em;
    }
</style>
<div class="not-found-wrap text-center">



    <div class="parent">
        <div class="child">
            <img src="<?php echo base_url('assets/') ?>dist-assets/images/local/logo-login.png" alt="">
        </div>
    </div>


    <h1 class="text-60">404</h1>
    <p class="text-36 subheading mb-3">Error!</p>
    <p class="mb-5 text-muted text-18">¡Lo siento! La p&aacute;gina que estabas buscando no existe.</p>
    <a href="<?php echo base_url('/dashboard') ?>">
        <button class="btn btn-xl btn-outline-dark m-1" type="button"> <i class="fal fa-house-return"></i> Regresar </button>
    </a>

</div>