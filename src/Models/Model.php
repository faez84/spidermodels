<?php
/**
 * Created by PhpStorm.
 * User: Benutzer
 * Date: 12/21/2018
 * Time: 12:18 AM
 */

namespace Spider\Models;


class Model extends AbstractModel
{
    public function __construct(string $modelName)
    {
        $this->modelName = $modelName;
    }
}