<?php

namespace Portfolio\Src\Controllers;

use Doctrine\ORM\EntityManager;
use Exception;
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

        http_response_code(200);
        return json_encode([
            'data' => $empregados,
            'status' => http_response_code()
        ]);
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
        try {
            $empregado = $this->entityManager->find(Empregado::class, $id);
            if ($empregado) {
                $this->entityManager->remove($empregado);
                $this->entityManager->flush();
            }

            http_response_code(200);
            return json_encode([
                'message' => 'Entity ' . $id . ' successfully removed from the database',
                'status' => http_response_code()
            ]);
        } catch (Exception $e) {
            $logFile = fopen('../../logs/' . date('Y-m-d H:i:s') . '-log.txt', 'w');
            $content = "Erro ao persistir remoção de entidade 'Empregado' de id: '$id' na base de dados. Mensagem de erro: {$e->getMessage()}";
            fwrite($logFile, $content);
            fclose($logFile);

            http_response_code(500);
            return json_encode([
                'message' => 'Failed trying to remove entity from the database',
                'status' => http_response_code()
            ]);
        }
    }
}

?>
