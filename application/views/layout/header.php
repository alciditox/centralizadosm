<header class="main-header bg-white d-flex justify-content-between p-2">
    <div class="header-toggle">
        <div class="menu-toggle mobile-menu-icon">
            <div></div>
            <div></div>
            <div></div>
        </div>

    </div>
    <div class="header-part-right">
        <!-- Grid menu Dropdown-->
        <?= $loggin_nombre; ?>
        <div class="dropdown dropleft"><i class="fal fa-user text-muted header-icon" id="dropdownMenuButton" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></i>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <div class="menu-icon-grid">
                    <a href="<?= base_url('dashboard') ?>"><i class="fal fa-home"></i> Home</a>
                    <a href="<?= base_url('profile/profile') ?>"><i class="fal fa-address-card"></i> Profile</a>
                    <a href="<?= base_url('login/logout') ?>"><i class="fal fa-portal-exit"></i> Salir</a>
                </div>
            </div>
        </div>
    </div>
</header>