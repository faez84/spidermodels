<?php
/**
 * Created by PhpStorm.
 * User: Benutzer
 * Date: 12/21/2018
 * Time: 2:06 AM
 */

namespace Spider\Models;


class ModelCreator
{
    /**
     * @param string $signature
     * @return mixed
     */
    public function getModel(string $signature)
    {
        return new $signature();
    }
}