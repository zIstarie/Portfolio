<?php

namespace Portfolio\Infra\Entities;

use DateInterval;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;
use Portfolio\Infra\Types\NivelEscolar;

#[Entity]
#[Table(name: 'carreiras_academicas')]
class CarreiraAcademica
{
    #[Id]
    #[Column(type: Types::BIGINT)]
    #[GeneratedValue]
    private int $id;

    #[Column(type: Types::STRING, length: 180)]
    private string $instituicao;

    #[Column(type: Types::DATEINTERVAL, nullable: true)]
    private ?DateInterval $anoConclusao = null;

    #[Column(type: Types::BOOLEAN, options: ['default' => false])]
    private bool $cursando = false;

    #[Column(type: Types::STRING)]
    private NivelEscolar $nivel;

    #[Column(type: Types::TEXT)]
    private string $apresentacao;

    #[Column(name: 'empregados_token')]
    #[ManyToOne(targetEntity: Empregado::class, inversedBy: 'carreirasAcademicas')]
    #[JoinColumn(name: 'empregados_token', referencedColumnName: 'token')]
    private Empregado $empregadosToken;
}

?>