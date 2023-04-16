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
#[Table(name: 'experiencias_profissionais')]
class ExperienciaProfissional
{
    #[Id]
    #[Column(type: Types::BIGINT)]
    #[GeneratedValue()]
    private int $id;

    #[Column(type: Types::STRING, length: 180)]
    private string $local;

    #[Column(name: 'periodo_inicial', type: Types::DATEINTERVAL)]
    private DateInterval $periodoInicial;

    #[Column(name: 'periodo_final', type: Types::DATEINTERVAL, nullable: true)]
    private ?DateInterval $periodoFinal = null;

    #[Column(type: Types::BOOLEAN, options: ['default' => false])]
    private bool $atual = false;

    #[Column(type: Types::TEXT, nullable: true)]
    private ?string $descricao = null;

    #[Column(name: 'empregados_token')]
    #[ManyToOne(targetEntity: Empregado::class, inversedBy: 'experienciasProfissionais')]
    #[JoinColumn(name: 'empregados_token', referencedColumnName: 'token')]
    private Empregado $empregadosToken;

    #[OneToMany(targetEntity: Projeto::class, mappedBy: 'experiencias_profissionais_id')]
    private Collection $projetos;

    public function __construct()
    {
        $this->projetos = new ArrayCollection();
    }
}

?>
