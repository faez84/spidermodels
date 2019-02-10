<?php

namespace Spider\Tests;

use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\DBAL\Configuration;
use Doctrine\ORM\Tools\Console\Command\GenerateRepositoriesCommand;
use PHPUnit\Framework\TestCase;
use Spider\Entity\GeneralEntity;
use Spider\Models\AbstractModel;
use Spider\Models\Model;
use Spider\Models\ModelCreator;
use Spider\Utils\ConnectDB;

class ModelCreatorTest extends TestCase
{
    /** @var  ModelCreator */
    private $modelCreator;

    public function setup()
    {
        $this->modelCreator = new ModelCreator();
    }
}
