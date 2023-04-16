<?php

namespace Portfolio\Infra\Entities;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Id;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;
use Portfolio\Infra\Types\StatusTecnologia;

#[Entity]
#[Table(name: 'tecnologias')]
class Tecnologia
{
    #[Id]
    #[Column(type: Types::BIGINT)]
    #[GeneratedValue]
    private int $id;

    #[Column(type: Types::STRING, length: 100)]
    private string $nome;

    #[Column(type: Types::STRING)]
    private StatusTecnologia $status;

    #[Column(type: Types::TEXT, nullable: true)]
    private ?string $descricao = null;

    #[Column(type: Types::TEXT)]
    private string $fotoLogoUrl;

    #[Column(name: 'empregados_token', nullable: true)]
    #[ManyToOne(targetEntity: Empregado::class, inversedBy: 'tecnologias')]
    #[JoinColumn(name: 'empregados_token', referencedColumnName: 'token')]
    private ?Empregado $empregadosToken = null;
}

?>