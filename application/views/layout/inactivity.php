<link rel="stylesheet" href="<?= base_url('assets/dist-assets/jquery-confirm/jquery-confirm.min.css') ?>" />
<script src="<?= base_url('assets/dist-assets/jquery-confirm/jquery-confirm.min.js') ?>"></script>

<script>
    (function() {

        const logoutUrl = '<?= base_url("login/logout") ?>';
        const warningTime = 25 * 60 * 1000; // 25 minutos
        const autoLogoutTime = 30 * 1000; // 30 segundos para cerrar
        let timer = null;

        // Reinicia el temporizador
        const resetTimer = () => {
            clearTimeout(timer);
            timer = setTimeout(showWarning, warningTime);
        };

        // Muestra el modal de advertencia
        const showWarning = () => {
            $.confirm({
                title: 'Alerta de Inactividad',
                content: `La sesión expirará en ${autoLogoutTime / 1000} segundos.`,
                type: 'red',
                icon: 'fa fa-exclamation-triangle',
                autoClose: 'expirar|' + autoLogoutTime,
                buttons: {
                    expirar: {
                        text: 'Cerrar Sesión',
                        btnClass: 'btn-red',
                        action: logout
                    },
                    permanecer: {
                        text: 'Continuar',
                        btnClass: 'btn-green',
                        action: () => {
                            resetTimer();
                        }
                    }
                }
            });
        };

        // Cerrar sesión
        const logout = () => {
            window.location.href = logoutUrl;
        };

        // Escucha eventos de actividad
        ['mousemove', 'keydown', 'touchstart', 'click'].forEach(event => {
            document.addEventListener(event, resetTimer);
        });

        // Inicializa el temporizador
        resetTimer();

    })();
</script>