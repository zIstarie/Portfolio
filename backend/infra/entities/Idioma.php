<?php

namespace Portfolio\Infra\Entities;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;
use Portfolio\Infra\Types\StatusIdioma;
use Portfolio\Infra\Entities\Empregado;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\GeneratedValue;

#[Entity]
#[Table(name: 'idiomas')]
class Idioma
{
    #[Id]
    #[Column(type: Types::BIGINT)]
    #[GeneratedValue()]
    private int $id;

    #[Column(type: Types::STRING, length: 70, unique: true)]
    private string $nome;

    #[Column(type: Types::STRING)]
    private StatusIdioma $status;

    #[Column(type: Types::TEXT, nullable: true)]
    #[ManyToOne(targetEntity: Empregado::class, inversedBy: 'idiomas')]
    #[JoinColumn(name: 'empregados_token', referencedColumnName: 'token')]
    private ?Empregado $empregadosToken = null;
}

?>
