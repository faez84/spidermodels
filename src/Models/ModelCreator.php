<?php

namespace Spider\Models;


class ModelCreator
{
    /**
     * @param string $signature
     * @return mixed
     */
    protected $nameSpace;

    public function getModel(string $signature, $params)
    {
        return new $signature($params);
    }

    public function setNameSpace(string $nameSpace): bool
    {
        $this->nameSpace = $nameSpace;

        return true;
    }
}