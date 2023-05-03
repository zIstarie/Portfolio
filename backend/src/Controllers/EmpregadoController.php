<?php

namespace Portfolio\Src\Controllers;

use Doctrine\ORM\EntityManager;
use Portfolio\Config\EntityManager as ConfigEntityManager;
use Portfolio\Infra\Entities\Empregado;
use Portfolio\Src\Strategies\ApiController;
use Portfolio\Src\Traits\HTTPResponse;
use Portfolio\Src\Traits\LogRegister;
use Portfolio\Src\Traits\Encrypt;
use Exception;

class EmpregadoController implements ApiController
{
    use HTTPResponse;
    use LogRegister;
    use Encrypt;

    private EntityManager $entityManager;

    public function __construct()
    {
        $this->entityManager = ConfigEntityManager::getEntityManager();
    }

    public function retrieve(array $options = null)
    {
        try {
            $empregados = $this->entityManager
                ->getRepository(Empregado::class)
                ->findAll();
    
            $this->response($empregados);
        } catch (Exception $e) {
            $this->registerLogFile('Erro ao tentar recuperar dados da entidade "Empregado" no banco de dados', $e);
            $this->send('Failed to retrieve database registers related to "Empregado" entity', 500);
        }
    }

    public function store(array|object $data): void
    {
        try {
            if (!$this->validate((array) $data)) return;
            
            $data = (object) $data;
            $data->token = $this->hashString($this->randomString());
    
            $empregado = new Empregado($data->nome);
            $empregado->create($data);
            $this->entityManager->persist($empregado);
            $this->entityManager->flush();
    
            $lastEmployee = $this->entityManager
                ->find(Empregado::class, $empregado->getToken());

            $this->response($lastEmployee, 201);
        } catch (Exception $e) {
            $this->registerLogFile('Erro ao inserir dados de novo Empregado no banco', $e);
            $this->send('Error trying to persist Entity in the database', 500);
        }
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
            } else {
                $this->send('No entity "Empregado" found with id: ' . $id, 404);
            }

            $this->send('Entity ' . $id . ' successfully removed from the database', 200);
        } catch (Exception $e) {
            $this->registerLogFile("Erro ao persistir remoção de entidade 'Empregado' de id: '$id' na base de dados", $e);
            $this->send('Failed to remove entity from the database', 500);
        }
    }
}

?>
