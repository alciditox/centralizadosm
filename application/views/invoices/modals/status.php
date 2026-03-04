<?php
//'Pendiente','Por Conciliar','Conciliado','Anulado'

switch ($k->status) {
    case 'Pendiente':
        echo  "<span class=\"text-primary\"><strong>" . $k->status . "</strong></span>";
        break;

    case 'Por Conciliar':
        echo  "<span class=\"text-warning\"><strong>" . $k->status . "</strong></span>";
        break;

    case 'Conciliado':
        echo  "<span class=\"text-success\"><strong>" . $k->status . "</strong></span>";
        break;

    case 'Anulado':
        echo  "<span class=\"text-danger\"><strong>" . $k->status . "</strong></span>";
        break;

    case 'Aprobado':
        echo  "<span class=\"text-success\"><strong>" . $k->status . "</strong></span>";
        break;

    case 'Manual':
        echo  "<span class=\"text-success\"><strong>" . $k->status . "</strong></span>";
        break;

    case 'Rechazado':
        echo  "<span class=\"text-danger\"><strong>" . $k->status . "</strong></span>";
        break;

    default:
        # code...
        break;
}
