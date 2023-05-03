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
use InvalidArgumentException;

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

    public function __construct(string $nome)
    {
        $this->idiomas = new ArrayCollection();
        $this->experienciasProfissionais = new ArrayCollection();
        $this->tecnologias = new ArrayCollection();
        $this->projetos = new ArrayCollection();

        if (strlen($nome) > 120) throw new InvalidArgumentException('Nome informado atingiu o limite máximo de caracteres');
        $this->nome = $nome;
    }

    public function getToken(): int
    {
        return $this->token;
    }

    private function setIdade(int $idade): Empregado
    {
        if ($idade < 18) throw new InvalidArgumentException('Você não tem idade o suficiente para trabalhar');
        if (strlen((string) $idade) >= 4) throw new InvalidArgumentException('Idade informada maior do que o suportado');

        $this->idade = $idade;
        return $this;
    }

    private function setArea(string $area): Empregado
    {
        if (strlen($area) > 75) throw new InvalidArgumentException('Área informada excede o número máximo de caracteres');

        $this->area = $area;
        return $this;
    }

    private function setLinks(array $links)
    {
        !$this->validateUnique($links) && throw new InvalidArgumentException('Os links devem ser únicos');

        $this->links = $links;
        return $this;
    }

    public function validateUnique(array $data): bool
    {
        for ($i = 0; $i < count($data); $i++) { 
            if ($data[$i] === $data[$i + 1]) {
                return false;
            }
        }

        return true;
    }

    private function setUrlImage(string $urlImagem)
    {
        $this->urlImagem = $urlImagem;
        return $this;
    }

    private function setContatos(array $contacts)
    {
        !$this->validateUnique($contacts) && throw new InvalidArgumentException('Os contatos devem ser únicos');

        $this->contatos = $contacts;
        return $this;
    }

    private function setDescricao(string $descricao)
    {
        $this->descricao = $descricao;
        return $this;
    }

    public function create(object $data): void
    {
        $this->setIdade($data->idade)
            ->setArea($data->area)
            ->setLinks($data->links)
            ->setUrlImage($data->urlImagem);

        $data->contatos && $this->setContatos($data->contatos);
        $data->descricao && $this->setDescricao($data->descricao);
    }

    public function update(object $data): void
    {
        $this->setIdade($data->idade ?? $this->idade)
            ->setArea($data->area ?? $this->area)
            ->setLinks($data->links ?? $this->links)
            ->setUrlImage($data->urlImage ?? $this->urlImagem)
            ->setContatos($data->contatos ?? $this->contatos)
            ->setDescricao($data->descricao ?? $this->descricao);
    }

    public static function retrieveIndexes(): array
    {
        return [
            'nome',
            'idade',
            'area',
            'links',
            'urlImagem',
            'contatos' => null,
            'descricao' => null,
        ];
    }
}

?>
