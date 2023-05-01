<?php

namespace Portfolio\Src\Controllers;

use Doctrine\ORM\EntityManager;
use Portfolio\Config\EntityManager as ConfigEntityManager;
use Portfolio\Infra\Entities\Empregado;
use Portfolio\Src\Strategies\ApiController;

class EmpregadoController implements ApiController
{
    private EntityManager $entityManager;

    public function __construct()
    {
        $this->entityManager = ConfigEntityManager::getEntityManager();
    }

    public function retrieve(array $options = null)
    {
        $empregados = $this->entityManager
            ->getRepository(Empregado::class)
            ->findAll();

        return $empregados;
    }

    public function store(array|object $data): void
    {
        if (!$this->validate((array) $data)) {
            return;
        }
        $data = (object) $data;

        $empregado = new Empregado($data->nome);
        $empregado->create($data);
        $this->entityManager->persist($empregado);
        $this->entityManager->flush();
    }

    private function validate(array $data): bool
    {
        $indexes = Empregado::retrieveIndexes();
        $keys = array_keys($data);

        foreach ($indexes as $index) {
            if (
                !array_key_exists($index, $keys) AND
                isset($indexes[$index])
            ) return false;
        }

        return true;
    }

    public function update(int $id, array $data)
    {
        
    }

    public function destroy(int $id)
    {

    }
}

?>
