<?php

$ci = &get_instance();
$ci->load->model("model_menu"); // Cargar el modelo

$permiso = $this->session->userdata['logged_in']['rol'];

?>

<div class="scroll-nav ps ps--active-y" data-perfect-scrollbar="data-perfect-scrollbar" data-suppress-scroll-x="true">
    <div class="side-nav">
        <div class="main-menu">
            <ul class="metismenu" id="menu">
                <li class="Ul_li--hover"><a href="<?= base_url('dashboard'); ?>"><i class="fal fa-tachometer-alt text-20 mr-2 text-muted"></i><span class="item-name text-15 text-muted">Dashboard</span></a></li>


                <?php
                $menus = $ci->model_menu->menuPrincipal($permiso); // Llamar el metodo del modelo

                foreach ($menus as $menu) {

                    $id = $menu->id;
                    $url = $menu->url;
                    $icon = $menu->icon;
                    $nombre = $menu->nombre;

                ?>

                    <li class="Ul_li--hover"><a class="has-arrow" href="#"><i class="<?= $icon ?> text-20 mr-2 text-muted"></i><span class="item-name text-15 text-muted"><?= $nombre ?></span></a>
                        <?php $menusSUB = $ci->model_menu->menuSubMenu($id, $permiso); ?>
                        <?php foreach ($menusSUB as $menuSUB) { ?>
                            <ul class="mm-collapse">
                                <li class="item-name"><a href="<?= base_url() . $menuSUB->url; ?>"><i class="fad fa-spinner mr-2 text-muted"></i><span class="text-muted"><?= $menuSUB->nombre; ?></span></a></li>
                            </ul>

                        <?php } ?>


                    </li>

                <?php } ?>

                <li class="Ul_li--hover"><a href="<?= base_url('profile/index/profile'); ?>"><i class="fal fa-address-card text-20 mr-2 text-muted"></i><span class="item-name text-15 text-muted">Perfil</span></a></li>

                <li class="Ul_li--hover"><a href="<?= base_url('login/logout'); ?>"><i class="fal fa-sign-out-alt text-20 mr-2 text-muted"></i><span class="item-name text-15 text-muted">Salir</span></a></li>

            </ul>
        </div>
    </div>
    <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
        <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
    </div>
    <div class="ps__rail-y" style="top: 0px; height: 404px; right: 0px;">
        <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 325px;"></div>
    </div>
    <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
        <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
    </div>
    <div class="ps__rail-y" style="top: 0px; height: 404px; right: 0px;">
        <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 325px;"></div>
    </div>
</div>