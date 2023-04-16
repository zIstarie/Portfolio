<?php

namespace Portfolio\Infra\Entities;

use DateInterval;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table(name: 'projetos')]
class Projeto
{
    #[Id]
    #[Column(type: Types::BIGINT)]
    #[GeneratedValue]
    private int $id;

    #[Column(type: Types::STRING, length: 120)]
    private string $titulo;

    #[Column(type: Types::TEXT, nullable: true)]
    private ?string $linkGithub = null;

    #[Column(type: Types::TEXT, nullable: true)]
    private ?string $descricao = null;

    #[Column(type: Types::BOOLEAN, options: ['default' => true])]
    private bool $publico = true;

    #[Column(type: Types::DATEINTERVAL)]
    private DateInterval $ano;

    #[ManyToOne(targetEntity: ExperienciaProfissional::class, inversedBy: 'projetos')]
    #[JoinColumn(name: 'experiencias_profissionais_id', referencedColumnName: 'id')]
    private ExperienciaProfissional $experienciasProfissionaisId;

    #[Column(name: 'empregados_token')]
    #[ManyToOne(targetEntity: Empregado::class, inversedBy: 'projetos')]
    #[JoinColumn(name: 'empregados_token', referencedColumnName: 'token')]
    private Empregado $empregadosToken;

    #[OneToMany(targetEntity: Colaborador::class, mappedBy: 'projetos_id')]
    private Collection $colaboradores;

    public function __construct()
    {
        $this->colaboradores = new ArrayCollection();
    }
}

?>