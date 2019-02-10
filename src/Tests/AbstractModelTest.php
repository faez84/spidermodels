<?php

namespace Spider\Tests;

use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\DBAL\Configuration;
use Doctrine\ORM\Tools\Console\Command\GenerateRepositoriesCommand;
use PHPUnit\Framework\TestCase;
use Spider\Entity\GeneralEntity;
use Spider\Models\Model;
use Spider\Utils\ConnectDB;

class AbstractModelTest extends TestCase
{
    /** @var  Model */
    private $model;

    /** @var  ConnectDB $connectDB */
    private $connectDB ;
    public function setup()
    {
        $this->model = new Model('model');
        $this->connectDB = ConnectDB::getInstance();
        $this->model->setConnectDB($this->connectDB);
    }

    public function loadFixture()
    {
        $this->connectDB = ConnectDB::getInstance();
        $generalEntity = new GeneralEntity();
        $generalEntity->setName('entity1');
        $this->connectDB->getEntityManager()->persist($generalEntity);
        $this->connectDB->getEntityManager()->flush();
    }

    public function tearDown()
    {
        if ($this->connectDB->getConnection()->isTransactionActive()) {
            $this->connectDB->getConnection()->rollBack();
        }
        $this->connectDB->getConnection()->close();
    }

    public function testInsert()
    {
        $this->assertTrue($this->model->insert());
    }

    public function testGetListFields()
    {
        $fieldsName = $this->model->getListFields();
        $this->assertNotNull($fieldsName);
        $this->assertEquals('name', $fieldsName[0]['name']);
    }

    public function testDelete()
    {
        $this->model->find(['name' => 'entity1']);
        $this->assertTrue($this->model->delete());
    }

    public function testListData()
    {
        $result = $this->model->listData();
        $this->assertNotEmpty($result);
    }

    public function testFind()
    {
        $this->model->find(['name' => 'entity1']);
        $this->assertEquals('entity1', $this->model->getEntity()->getName());
    }

    public function testGetListFieldsAsString()
    {
        $this->assertContains('name', $this->model->getListFieldsAsString());
    }

    public function testGetAddEditFields()
    {
        $fieldsName = $this->model->getAddEditFields();
        $this->assertNotNull($fieldsName);
        $this->assertEquals('name', $fieldsName[0]['name']);
    }

    public function testGetModelName()
    {
        $this->assertEquals('model', $this->model->getModelName());
    }

    public function testGetEntity()
    {
        $this->assertEquals(GeneralEntity::class, get_class($this->model->getEntity()));
    }

    public function testSetGroupValidation()
    {
        $this->assertTrue($this->model->setGroupValidation('test_group_validation'));
    }

    public function testGetGroupValidation()
    {
        $this->model->setGroupValidation('test_group_validation');
        $this->assertEquals('test_group_validation', $this->model->getGroupValidation());
    }

    public function testCallBackFunction()
    {
        $this->assertTrue($this->model->callBackFunction('setGroupValidation', 'test_group_validation'));
        $this->assertEquals('test_group_validation', $this->model->callBackFunction('getGroupValidation'));
    }

    public function testSetEntityManger()
    {
        $this->assertTrue($this->model->setEntityManger($this->connectDB->getEntityManager()));
    }

    public function testPreInsert()
    {
        $this->assertTrue($this->model->preInsert());
    }

    public function testPostUpdate()
    {
        $this->assertTrue($this->model->postUpdate());
    }

    public function testPostInsert()
    {
        $this->assertTrue($this->model->postInsert());
    }

    public function testPreUpdate()
    {
        $this->assertTrue($this->model->preUpdate());
    }

    public function testUpdate()
    {
        $this->assertTrue($this->model->update());
    }
}
