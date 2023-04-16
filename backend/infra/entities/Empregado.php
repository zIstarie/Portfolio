<?php

namespace Portfolio\Infra\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table(name: 'empregados')]
class Empregado
{
    #[Id]
    #[Column(type: Types::TEXT)]
    private int $token;

    #[Column(type: Types::STRING, length: 120)]
    private string $nome;

    #[Column(type: Types::SMALLINT)]
    private int $idade;

    #[Column(type: Types::STRING, length: 75)]
    private string $area;

    #[Column(type: Types::SIMPLE_ARRAY, unique: true)]
    private array $links;

    #[Column(name: 'url_imagem', type: Types::TEXT)]
    private string $urlImagem;

    #[Column(
        type: Types::SIMPLE_ARRAY,
        nullable: true,
        unique: true
    )]
    private ?array $contatos = null;

    #[Column(type: Types::TEXT, nullable: true)]
    private ?string $descricao = null;

    #[OneToMany(targetEntity: Idioma::class, mappedBy: 'empregados_token')]
    private Collection|null $idiomas;
    
    #[OneToMany(targetEntity: ExperienciaProfissional::class, mappedBy: 'empregados_token', cascade: ['persist', 'remove'])]
    private Collection|null $experienciasProfissionais;

    #[OneToMany(targetEntity: CarreiraAcademica::class, mappedBy: 'empregados_token', cascade: ['persist', 'remove'])]
    private Collection|null $carreirasAcademicas;

    #[OneToMany(targetEntity: Tecnologia::class, mappedBy: 'empregados_token')]
    private Collection|null $tecnologias;

    #[OneToMany(targetEntity: Projeto::class, mappedBy: 'empregados_token', cascade: ['persist', 'remove'])]
    private Collection|null $projetos;

    public function __construct()
    {
        $this->idiomas = new ArrayCollection();
        $this->experienciasProfissionais = new ArrayCollection();
        $this->tecnologias = new ArrayCollection();
        $this->projetos = new ArrayCollection();
    }
}

?>
