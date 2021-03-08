<?php


namespace App\Tests\Entity;

use App\Entity\Parade;
use App\Tests\AssertErrors;
use App\Tests\FakerEntity;
use App\Tests\Traits\Printer;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ParadeTest extends KernelTestCase
{
    use FixturesTrait, AssertErrors, Printer;

    public function getEntity(?string $nullElement = null): Parade
    {
        return FakerEntity::parade($nullElement);
    }

    public function testValidEntity()
    {
        $this->assertHasErrors($this->getEntity(),0);
    }

    public function testInvalidNullTitle()
    {
        $this->assertHasErrors($this->getEntity("title"),1);
    }

    public function testInvalidBlankTitle()
    {
        $this->assertHasErrors($this->getEntity()->setTitle(""),1);
    }

    public function testInvalidNullVideo()
    {
        $this->assertHasErrors($this->getEntity("video"),1);
    }

    public function testInvalidBlankVideo()
    {
        $this->assertHasErrors($this->getEntity()->setVideo(""),1);
    }

    public function testAddItem()
    {
        $item = FakerEntity::item();
        $entity = $this->getEntity();
        $entity->addItem($item);
        $this->assertEquals($entity, $item->getParades()[0]);
        $this->assertEquals($item, $entity->getItems()[0]);
    }

    public function testRemoveItem()
    {
        $item = FakerEntity::item();
        $entity = $this->getEntity();
        $entity->addItem($item);
        $item->removeParade($entity);
        $this->assertEmpty($entity->getItems());
        $this->assertEmpty($item->getParades());
    }
}