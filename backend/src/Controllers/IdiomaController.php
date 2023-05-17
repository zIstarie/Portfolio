<?php

namespace Portfolio\Src\Controllers;

require __DIR__ . '/../lib/Validation.php';

use Doctrine\ORM\EntityManager;
use Portfolio\Infra\Entities\Idioma;
use Portfolio\Src\Strategies\ApiController;
use Portfolio\Config\EntityManager as ConfigEntityManager;
use Portfolio\Src\Traits\HTTPResponse;
use Portfolio\Src\Traits\LogRegister;
use Portfolio\Infra\Entities\Empregado;
use Exception;

class IdiomaController implements ApiController
{
    use HTTPResponse;
    use LogRegister;

    private EntityManager $entityManager;

    public function __construct()
    {
        $this->entityManager = ConfigEntityManager::getEntityManager();
    }

    public function retrieve(array $options = null)
    {
        try {
            $idiomas = $this->entityManager
                ->getRepository(Idioma::class)
                ->findAll();
            
            foreach ($idiomas as $key => $idioma) {
                $idiomas[$key] = $idioma->toString();
            }

            return $this->response($idiomas);
        } catch (Exception $e) {
            $this->registerLogFile('Erro ao recuperar dados do Repositório da Entidade "Idioma" no banco de dados', $e);
            return $this->send('Failed to retrieve data from "Idioma" Entity on the database', 500);
        }
    }

    public function store(array|object $data, mixed ...$options)
    {
        if (!validate((array) $data, Idioma::class)) return $this->send('Incoming data format cannot be processed by the server', 400);

        try {
            $data = (object) $data;

            $idioma = new Idioma($data->nome);
            $idioma->create($data);
            $this->entityManager->persist($idioma);
            $this->entityManager->flush();

            $lastInserted = $this->entityManager->find(Idioma::class, $idioma->getId());

            return $this->response($lastInserted->toString());
        } catch (Exception $e) {
            $this->registerLogFile('Falha ao inserir registros da Entidade "Idioma" no banco de dados', $e);
            $this->send('Failed to insert new record on database table related to Entity: "Idioma"', 500);
        }
    }

    public function update(int|string $id, array $data)
    {
        empty($data) && $this->send('Incoming data is empty', 422);

        try {
            $idioma = $this->entityManager->find(Idioma::class, (int) $id);
            if (!$idioma) return $this->send("No record find in the entity with id '$id'", 404);

            $idioma->update((object) $data);
            $this->entityManager->persist($idioma);
            $this->entityManager->flush();

            return $this->response($idioma->toString());
        } catch (Exception $e) {
            $this->registerLogFile("Erro ao tentar atualizar dados da Entidade 'Idoma' de id '$id' no banco de dados", $e);
            $this->send("Failed to update data related to Entity 'Idioma' with id '$id' in the database", 500);
        }
    }

    public function destroy(int|string $id)
    {
        try {
            $idioma = $this->entityManager->find(Idioma::class, $id);
            if (!$idioma) return $this->send("No record found in the Entity 'Idioma' with id '$id'", 404);

            $this->entityManager->remove($idioma);
            $this->entityManager->flush();

            return $this->send("Entity 'Idioma' with id '$id' successfully removed from the database", 200);
        } catch (Exception $e) {
            $this->registerLogFile("Erro ao deletar Entidade 'Idioma' de id '$id'", $e);
            $this->send('Failed to delete entity from the data records', 500);
        }
    }
}

?>
