<?php

namespace Portfolio\Infra\Types;

enum NivelEscolar: string
{
    case FUNDAMENTAL = 'fundamental';
    case MEDIO = 'médio';
    case TECNICO = 'técnico';
    case SUPERIOR = 'superior';
    case TECNOLOGO = 'tecnologo';
    case BACHARELADO = 'bacharelado';
    case POS_GRADUACAO = 'pós-graduação';
}

?>
