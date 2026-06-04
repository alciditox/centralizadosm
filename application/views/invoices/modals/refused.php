<?php
//'Pendiente','Por Conciliar','Conciliado','Anulado'

switch ($k->status) {
    case 'Rechazado':
?>

        <button class="btn btn-success" type="submit" data-toggle="modal" data-target=".modal-manual" data-idcoll="<?= $k->ncobro; ?>" data-contrato="<?= $row->id; ?>" data-cobrar="<?= $row->cobrar; ?>" data-cedula="<?= $row->cedula; ?>" data-banco="<?= $k->banco; ?>">
            Pagar
        </button>
        <br>
        <button class="btn btn-danger" type="submit" data-toggle="modal" data-target=".modal-anular" data-idcoll="<?= $k->ncobro; ?>" data-contrato="<?= $row->id; ?>" data-banco="<?= $k->banco; ?>">
            <i class="fas fa-trash-alt"></i>
        </button>

    <?php
        break;

    case 'Pendiente':
    ?>

        <!-- <button class="btn btn-success" type="submit" data-toggle="modal" data-target=".modal-manual" data-idcoll="<?= $k->id; ?>" data-contrato="<?= $row->id; ?>" data-cobrar="<?= $row->cobrar; ?>" data-cedula="<?= $row->cedula; ?>" data-banco="<?= $row->banco; ?>">
            Pagar
        </button> -->

        <button class="btn btn-success" type="submit" data-toggle="modal" data-target=".modal-manual" data-idcoll="<?= $k->ncobro; ?>" data-contrato="<?= $row->id; ?>" data-cobrar="<?= $row->cobrar; ?>" data-cedula="<?= $row->cedula; ?>" data-banco="<?= $k->banco; ?>">
            Pagar
        </button>
        <br>
        <button class="btn btn-danger" type="submit" data-toggle="modal" data-target=".modal-anular" data-idcoll="<?= $k->ncobro; ?>" data-contrato="<?= $row->id; ?>" data-banco="<?= $k->banco; ?>">
            <i class="fas fa-trash-alt"></i>
        </button>

<?php
        break;

    default:
        # code...
        break;
}
