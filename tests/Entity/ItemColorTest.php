<?php


namespace App\Tests\Entity;

use App\Entity\ItemColor;
use App\Tests\AssertErrors;
use App\Tests\FakerEntity;
use App\Tests\Traits\Printer;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ItemColorTest extends KernelTestCase
{
    use FixturesTrait, AssertErrors, Printer;

    public function getEntity(?string $nullElement = null): ItemColor
    {
        return FakerEntity::itemColor($nullElement);
    }

    public function testValidEntity()
    {
        $this->printTestInfo();
        $this->assertHasErrors($this->getEntity(), 0);
    }

    public function testInvalidNotAvailableColor() {
        $this->printTestInfo();
        $this->expectException(\Exception::class);
        $this->getEntity()->setColor("not available color");
    }

    public function testInvalidNullColor() {
        $this->printTestInfo();
        $this->assertHasErrors($this->getEntity("color"), 1);
    }

    public function testValidNullDescription() {
        $this->printTestInfo();
        $this->assertHasErrors($this->getEntity("description"), 0);
    }

    public function testValidBlankDescription() {
        $this->printTestInfo();
        $this->assertHasErrors($this->getEntity()->setDescription(""), 0);
    }

    public function testInvalidNullItem() {
        $this->printTestInfo();
        $this->assertHasErrors($this->getEntity("item"), 1);
    }
}