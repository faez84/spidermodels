<?php

namespace Spider\Models;


use Doctrine\ORM\EntityManager;
use Spider\Entity\Customer;
use Spider\Entity\GeneralEntity;
use Spider\Utils\ConnectDB;
use Doctrine\ORM\Tools\Setup;

class Model extends AbstractModel
{
    /** @var  ConnectDB */
    private $connectDB;

    protected $isDeleted = false;

    protected $fields = [
        ['name' => 'name', 'type' => 'string', 'list' => true, 'addEdit' => true],
    ];
    public function __construct(string $modelName)
    {
        $this->entity = new GeneralEntity();
        $this->modelName = $modelName;
    }

    public function setConnectDB(ConnectDB $connectDB)
    {
        $this->connectDB = $connectDB;
        $this->entityManager = $this->connectDB->getEntityManager();
    }

    /**
     * @return bool
     */
    public function delete(): bool
    {
        $this->connectDB->getConnection()->beginTransaction();
        if (is_null($this->entity)) {
            return false;
        }

        if ($this->isDeleted) {
            $this->entity->setDeleted = true;
            $this->entityManager->flush($this->entity);

            return true;
        }

        $this->entityManager->remove($this->entity);
        $this->entityManager->flush($this->entity);
        return true;

    }

}