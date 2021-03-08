<?php


namespace App\Tests\Entity;

use App\Entity\Item;
use App\Entity\Mark;
use App\Tests\AssertErrors;
use App\Tests\FakerEntity;
use App\Tests\Traits\Printer;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ItemTest extends KernelTestCase
{
    use FixturesTrait, AssertErrors, Printer;

    public function getEntity(?string $nullElement = null): Item
    {
        return FakerEntity::item($nullElement);
    }

    public function testValidEntity() {
        $this->printTestInfo();
        $this->assertHasErrors($this->getEntity(), 0);
    }

    public function testInvalidBlankName() {
        $this->printTestInfo();
        $this->assertHasErrors($this->getEntity()->setName(""), 1);
    }

    public function testInvalidNullName() {
        $this->printTestInfo();
        $this->assertHasErrors($this->getEntity("name"), 1);
    }

    public function testInvalidLongName() {
        $this->printTestInfo();
        $this->assertHasErrors($this->getEntity()->setName(
            "ValideValideValideValideValideValideValideValideValideValideValideValiValideValideValideValideValideValideValideValideValideValideValideValiValideValideValideValideValideValideValideValideValideValideValideValiValideValideValideValideValideValideValideVal"
        ), 0);
        $this->assertHasErrors($this->getEntity()->setName(
            "VValideValideValideValideValideValideValideValideValideValideValideValiValideValideValideValideValideValideValideValideValideValideValideValiValideValideValideValideValideValideValideValideValideValideValideValiValideValideValideValideValideValideValideVal"
        ), 1);
    }

    public function testInvalidBlankDescription() {
        $this->printTestInfo();
        $this->assertHasErrors($this->getEntity()->setDescription(""), 1);
    }

    public function testInvalidNullDescription() {
        $this->printTestInfo();
        $this->assertHasErrors($this->getEntity("description"), 1);
    }

    public function testInvalidMinPrice() {
        $this->printTestInfo();
        $entity = $this->getEntity();
        $this->assertHasErrors($entity->setPrice(0.45), 1);
    }

    public function testInvalidNullPrice() {
        $this->printTestInfo();
        $this->assertHasErrors($this->getEntity("price"), 1);
    }

    public function testValidZeroValueDiscount() {
        $this->printTestInfo();
        $entity = $this->getEntity();
        $this->assertHasErrors($entity->setDiscount(0), 0);
    }

    public function testInvalidMinDiscount() {
        $this->printTestInfo();
        $entity = $this->getEntity();
        $this->assertHasErrors($entity->setDiscount(-1), 1);
    }

    public function testInvalidMaxDiscount() {
        $this->printTestInfo();
        $entity = $this->getEntity();
        $this->assertHasErrors($entity->setDiscount(101), 1);
    }

    public function testValidNullDiscount() {
        $this->printTestInfo();
        $this->assertHasErrors($this->getEntity("discount"), 0);
    }

    public function testValidNullNew() {
        $this->printTestInfo();
        $this->assertHasErrors($this->getEntity("isNew"), 0);
    }

    public function testAverageMark() {
        $this->printTestInfo();
        $item = FakerEntity::item();
        for($i = 0; $i < 18; $i++){
            $mark = new Mark();
            $mark->setGrade($i%6);
            $item->addMark($mark);
        }
        $this->assertEquals(2.5,$item->getAverageMark());
    }
}