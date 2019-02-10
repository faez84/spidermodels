<?php

namespace Spider\Models;

use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManager;
use Spider\Utils\ConnectDB;

abstract class AbstractModel
{
    /** @var  string */
    protected $modelName;
    /** @var  bool */
    protected $isDeleted;

    /** @var  \stdClass */
    protected $entity;

    /** @var  string */
    protected $aliasName = 'e';

    /** @var  string */
    protected $groupValidation;

    /** @var  string */
    protected $namespace;

    /** @var  EntityManager */
    protected $entityManager;

    /**
     * contains array of model's fields
     * name:
     *
     *
     * @var  array */
    protected $fields = [];

    public function setEntityManger(EntityManager $entityManager): bool
    {
        $this->entityManager = $entityManager;

        return true;
    }

    public function preInsert(): bool
    {
        return true;
    }

    /**
     * @return bool
     */
    public function postInsert(): bool
    {
        return true;
    }

    /**
     * @return bool
     */
    public function insert(): bool
    {
        return true;
    }

    /**
     * @return bool
     */
    public function preUpdate(): bool
    {
        return true;
    }

    /**
     * @return bool
     */
    public function postUpdate(): bool
    {
        return true;
    }

    /**
     * @return bool
     */
    public function update(): bool
    {
        return true;
    }

    /**
     * @return bool
     */
    public function delete(): bool
    {
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

    /**
     * @param int $id
     */
    public function find(int $id)
    {
        if (is_array($id)) {
            $this->entity = $this->entityManager->getRepository(get_class($this->entity))->findBy($id)[0];
        } elseif (is_int($id)) {
            $this->entity = $this->entityManager->getRepository(get_class($this->entity))->find($id);
        }
    }

    /**
     * @return mixed
     */
    public function listData()
    {
        return $this->entityManager->getRepository(get_class($this->entity))->createQueryBuilder($this->aliasName)
            ->select($this->getListFieldsAsString())
            ->getQuery()
            ->getResult();
    }

    /**
     * @return string
     */
    public function getListFieldsAsString(): string
    {
        return implode(',', array_filter(array_map(
            function ($fields) {
                if (isset($fields['list']) && $fields['list']&& $fields['type'] !== 'CollectionType') {
                    return $this->aliasName . '.' . $fields['name'];
                }
            },
            $this->fields
        ), 'strlen'));
    }

    /**
     * @return array
     */
    public function getListFields(): array
    {
        return
            array_map(function ($fields) {
                if (isset($fields['list']) && $fields['list']) {
                    return $fields;
                }
            }, $this->fields);
    }

    /**
     * @return array
     */
    public function getAddEditFields(): array
    {
        return
            array_filter(array_map(function ($fields) {
                if (isset($fields['addEdit']) && $fields['addEdit']) {
                    return $fields;
                }
            }, $this->fields));
    }

    /**
     * @return string
     */
    public function getModelName()
    {
        return $this->modelName;
    }

    /**
     * @return \stdClass
     */
    public function getEntity()
    {
        return $this->entity;
    }


    /**
     * @return string
     */
    public function getGroupValidation(): string
    {
        return $this->groupValidation;
    }

    /**
     * @param string $groupValidation
     * @return bool
     */
    public function setGroupValidation(string $groupValidation): bool
    {
        $this->groupValidation = $groupValidation;

        return true;
    }

    /**
     * @param string $callbackFunction
     * @param int $modelId
     * @return mixed
     */
    public function callBackFunction(string $callbackFunction, $modelId = null)
    {
        return $this->{$callbackFunction}($modelId);
    }
}
