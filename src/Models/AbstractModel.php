<?php

namespace Spider\Models;


use phpDocumentor\Reflection\Types\Boolean;

Abstract class AbstractModel
{
    /** @var  string */
    protected $modelName;
    /** @var  bool */
    protected $isDeleted;

    public function preInsert()
    {
        return;
    }

    /**
     * @return bool
     */
    public function postInsert(): bool
    {
        return true;
    }
    public function insert(): bool
    {
        return true;
    }
    public function preUpdate(): bool
    {
        return bool;
    }
    public function postUpdate()
    {
        return;
    }
    public function update()
    {
        return;
    }
    public function delete()
    {
        return;
    }
}