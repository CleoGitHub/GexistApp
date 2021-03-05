<?php


namespace App\Tests\Entity;

use App\Entity\Item;
use App\Entity\ItemCollection;
use App\Tests\AssertErrors;
use App\Tests\FakerEntity;
use App\Tests\Traits\Printer;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ItemCollectionTest extends KernelTestCase
{
    use FixturesTrait, AssertErrors, Printer;

    public function getEntity(?string $nullElement = null): ItemCollection
    {
        return FakerEntity::itemCollection($nullElement);
    }

    public function testValidEntity() {
        $this->printTestInfo();
        $this->assertHasErrors($this->getEntity(), 0);
    }

    public function testInvalidNullName()
    {
        $this->printTestInfo();
        $this->assertHasErrors($this->getEntity('name'), 1);
    }

    public function testInvalidLongName()
    {
        $this->printTestInfo();
        $entity = $this->getEntity();
        $this->assertHasErrors($entity->setName("VaaaaaaaaaaaaaaaaaaaaaaaaaaaaVaaaaaaaaaaaaaaaaaaaaaaaaaaaaVaaaaaaaaaaa"), 0);
        $this->assertHasErrors($entity->setName("VaaaaaaaaaaaaaaaaaaaaaaaaaaaaVaaaaaaaaaaaaaaaaaaaaaaaaaaaaVaaaaaaaaaaaa"), 1);
    }

    public function testInvalidNullSubtitle()
    {
        $this->printTestInfo();
        $this->assertHasErrors($this->getEntity('subtitle'), 1);
    }

    public function testInvalidLongSubtitle()
    {
        $this->printTestInfo();
        $entity = $this->getEntity();
        $this->assertHasErrors($entity->setSubtitle("VaaaaaaaaaaaaaaaaaaaaaaaaaaaaVaaaaaaaaaaaaaaaaaaaaaaaaaaaaVaaaaaaaaaaa"), 0);
        $this->assertHasErrors($entity->setSubtitle("VaaaaaaaaaaaaaaaaaaaaaaaaaaaaVaaaaaaaaaaaaaaaaaaaaaaaaaaaaVaaaaaaaaaaaa"), 1);
    }

    public function testValidNullDescription()
    {
        $this->printTestInfo();
        $this->assertHasErrors($this->getEntity('description'), 0);
    }

    public function testInvalidLongDescription()
    {
        $this->printTestInfo();
        $entity = $this->getEntity();
        $this->assertHasErrors($entity->setDescription("VaaaaaaaaaaaaaaaaaaaaaaaaaaaaVaaaaaaaaaaaaaaaaaaaaaaaaaaaaVaaaaaaaaaaa"), 0);
        $this->assertHasErrors($entity->setDescription("VaaaaaaaaaaaaaaaaaaaaaaaaaaaaVaaaaaaaaaaaaaaaaaaaaaaaaaaaaVaaaaaaaaaaaa"), 1);
    }

    public function testInvalidNullImage()
    {
        $this->printTestInfo();
        $this->assertHasErrors($this->getEntity('image'), 1);
    }

    public function testInvalidNullIsActive()
    {
        $this->printTestInfo();
        $this->assertHasErrors($this->getEntity('isActive'), 1);
    }

}