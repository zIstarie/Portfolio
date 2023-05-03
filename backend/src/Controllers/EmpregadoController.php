<?php

namespace Portfolio\Src\Controllers;

use Doctrine\ORM\EntityManager;
use Portfolio\Config\Cloudinary;
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
    
            return $this->response($empregados);
        } catch (Exception $e) {
            $this->registerLogFile('Erro ao tentar recuperar dados da entidade "Empregado" no banco de dados', $e);
            return $this->send('Failed to retrieve database registers related to "Empregado" entity', 500);
        }
    }

    public function store(array|object $data, array $files): string
    {
        try {
            if (!$this->validate((array) $data)) return $this->send('Incoming data format cannot be processed by the server', 400);
            
            $data = (object) $data;
            $data->token = $this->hashString($this->randomString());

            $cloudinary = new Cloudinary();
            $data->urlImagem = $cloudinary->uploadFile($files['url-imagem']);

            if (gettype($data->urlImagem) === 'boolean') return $this->send('Image not suitable for supporting types', 415);
    
            $empregado = new Empregado($data->nome);
            $empregado->create($data);
            $this->entityManager->persist($empregado);
            $this->entityManager->flush();
    
            $lastEmployee = $this->entityManager
                ->find(Empregado::class, $empregado->getToken());

            return $this->response($lastEmployee, 201);
        } catch (Exception $e) {
            $this->registerLogFile('Erro ao inserir dados de novo Empregado no banco', $e);
            return $this->send('Error trying to persist Entity in the database', 500);
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

    public function update(int|string $token, array $data): string
    {
        try {
            if (empty($data)) return $this->send('Incoming data values are empty', 400);

            $empregado = $this->entityManager->find(Empregado::class, (string) $token);
            $empregado->update($data);

            $empregado->flush();

            return $this->response($empregado);
        } catch (Exception $e) {
            $this->registerLogFile("Erro ao atualizar entidade 'Empregado' de token: '$token' no banco de dados", $e);
            return $this->send('Failed to update the entity registers on the database', 500);
        }
    }

    public function destroy(int|string $token): string
    {
        try {
            $empregado = $this->entityManager->find(Empregado::class, $token);
            if ($empregado) {
                $this->entityManager->remove($empregado);
                $this->entityManager->flush();
            } else {
                return $this->send('No entity "Empregado" found with token: ' . $token, 404);
            }

            return $this->send('Entity ' . $token . ' successfully removed from the database', 200);
        } catch (Exception $e) {
            $this->registerLogFile("Erro ao persistir remoção de entidade 'Empregado' com token: '$token' na base de dados", $e);
            return $this->send('Failed to remove entity from the database', 500);
        }
    }
}

?>
