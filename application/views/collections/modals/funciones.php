<?php

//TIPO DE ESTATUS EN PROCESO DE PAGO
function tipoStatus($status)
{
    switch ($status) {
        case 'P':
            $status = "<p class=\"text-muted\">Pendiente</p>";
            break;
        case 'R':
            $status = "<p class=\"text-danger\">Rechazado</p>";
            break;
        case 'A':
            $status = "<p class=\"text-success\">Aprobado</p>";
            break;
        case 'M':
            $status = "<p class=\"text-warning\">Pago manual</p>";
            break;
        default:
            $status = "N/A";
            break;
    }

    return $status;
}

//TIPO DE METODO DE PAGO MENSUAL O DIARIO

function tipoMetodo($status)
{
    switch ($status) {
        case 'D':
            $status = "Pago Diario";
            break;
        case 'M':
            $status = "Pago Mensual";
            break;
        default:
            $status = "N/A";
            break;
    }

    return $status;
}
