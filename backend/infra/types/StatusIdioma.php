<?php

namespace Portfolio\Infra\Types;

enum StatusIdioma: string
{
    case INICIANTE = 'iniciante';
    case INTERMEDIARIO = 'intermediário';
    case AVANCADO = 'avançado';
    case FLUENTE = 'fluente';
}

?>