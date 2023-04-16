<?php

namespace Portfolio\Infra\Entities;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Id;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table(name: 'colaboradores')]
class Colaborador
{
    #[Id]
    #[Column(type: Types::TEXT)]
    private string $token;

    #[Column(type: Types::STRING, length: 100)]
    private string $usuario;

    #[Column(type: Types::TEXT)]
    private string $urlPerfil;

    #[Column(type: Types::TEXT)]
    private string $urlGithub;

    #[Column(name: 'projetos_id')]
    #[ManyToOne(targetEntity: Projeto::class, inversedBy: 'colaboradores')]
    #[JoinColumn(name: 'projetos_id', referencedColumnName: 'id')]
    private Projeto $projetosId;
}

?>