<?php

namespace Portfolio\Infra\Entities;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;
use Portfolio\Infra\Entities\BaseEntity;
use Portfolio\Infra\Types\StatusIdioma;
use Portfolio\Infra\Entities\Empregado;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\GeneratedValue;
use Exception;
use stdClass;

#[Entity]
#[Table(name: 'idiomas')]
class Idioma extends BaseEntity
{
    #[Id]
    #[Column(type: Types::BIGINT)]
    #[GeneratedValue()]
    private int $id;

    #[Column(type: Types::STRING, length: 70, unique: true)]
    private string $nome;

    #[Column(type: Types::STRING)]
    private string $status;

    #[Column(name: 'empregados_token', type: Types::TEXT, nullable: true)]
    #[ManyToOne(targetEntity: Empregado::class, inversedBy: 'idiomas')]
    #[JoinColumn(name: 'empregados_token', referencedColumnName: 'token')]
    private ?string $empregadosToken = null;

    public function __construct(string $nome, Empregado $empregado = null)
    {
        if ($empregado) $this->empregadosToken = $empregado->getToken();

        if (strlen($nome) > 70) return;
        $this->nome = $nome;
    }

    public function getId(): int
    {
        return $this->id;
    }

    private function setNome(string $nome)
    {
        if (strlen($nome) > 70) return;

        $this->nome = $nome;
        return $this;
    }

    private function setStatus(string $status)
    {
        $confirmStatus = StatusIdioma::tryFrom($status);

        if ($confirmStatus) $this->status = $status;
        return $this;
    }

    private function setEmpregadosToken(string $token)
    {
        $this->empregadosToken = $token;
        return $this;
    }

    public function create(object $data): void
    {
        if (
            isset($data->empregado) AND
            !($data->empregado instanceof Empregado)
        ) return;

        $this->setStatus($data->status);

        isset($data->empregado) && $this->setEmpregadosToken($data->empregado);
    }

    public function update(object $data): void
    {
        $this->setNome($data->nome ?? $this->nome)
            ->setStatus($data->status ?? $this->status)
            ->setEmpregadosToken($data->empregadosToken ?? $this->empregadosToken);
    }

    public function toString()
    {
        $idioma = new stdClass();

        $idioma->id = $this->id;
        $idioma->nome = $this->nome;
        $idioma->status = $this->status;
        $idioma->empregadosToken = $this->empregadosToken;

        return $idioma;
    }

    public static function retrieveIndexes(): array
    {
        return ['nome', 'status'];
    }
}

?>
