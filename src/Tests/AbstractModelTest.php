<?php
/**
 * Created by PhpStorm.
 * User: Benutzer
 * Date: 12/21/2018
 * Time: 12:15 AM
 */

namespace Spider\Tests;


use PHPUnit\Framework\TestCase;
use Spider\Models\Model;

class AbstractModelTest extends TestCase
{
    /** @var  Model */
    private $model;
    public function setup()
    {
        $this->model = new Model('model');
    }
    public function testInsert()
    {
        $this->assertTrue($this->model->insert());
    }
}