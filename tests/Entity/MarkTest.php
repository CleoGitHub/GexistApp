<?php


namespace App\Tests\Entity;

use App\Entity\Mark;
use App\Tests\AssertErrors;
use App\Tests\FakerEntity;
use App\Tests\Traits\Printer;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class MarkTest extends KernelTestCase
{
    use FixturesTrait, AssertErrors, Printer;

    public function getEntity(?string $nullElement = null): Mark
    {
        return FakerEntity::mark($nullElement);
    }

    public function testValidEntity()
    {
        $this->printTestInfo();
        $this->assertHasErrors($this->getEntity(), 0);
    }

    public function testInvalidRangeGrade()
    {
        $this->printTestInfo();
        $this->assertHasErrors($this->getEntity()->setGrade(-1), 1);
        $this->assertHasErrors($this->getEntity()->setGrade(6), 1);
    }

    public function testInvalidNullGrade()
    {
        $this->printTestInfo();
        $this->assertHasErrors($this->getEntity("grade"), 1);
    }

    public function testInvalidNullItem()
    {
        $this->printTestInfo();
        $this->assertHasErrors($this->getEntity("item"), 1);
    }
}