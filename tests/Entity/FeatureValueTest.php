<?php


namespace App\Tests\Entity;

use App\Entity\FeatureValue;
use App\Tests\AssertErrors;
use App\Tests\FakerEntity;
use App\Tests\Traits\Printer;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class FeatureValueTest extends KernelTestCase
{
    use FixturesTrait, AssertErrors, Printer;

    public function getEntity(?string $nullElement = null): FeatureValue
    {
        return FakerEntity::featureValue($nullElement);
    }

    public function testValidEntity() {
        $this->printTestInfo();
        $this->assertHasErrors($this->getEntity(), 0);
    }

    public function testInvalidNullFeature() {
        $this->printTestInfo();
        $this->assertHasErrors($this->getEntity("feature"), 1);
    }

    public function testInvalidDuplicateCombinationFeatureValue() {
        $this->printTestInfo();
        $cat = $this->loadFixtureFiles([
            dirname( __DIR__)."/Fixtures/featureValue.yaml"
        ]);
        $this->assertHasErrors($this->getEntity()->setFeature($cat["feature_subcat"]), 1);
    }

    public function testInvalidLongValue() {
        $this->printTestInfo();
        $this->assertHasErrors($this->getEntity()->setValue("ValideValideValideValideV"), 0);
        $this->assertHasErrors($this->getEntity()->setValue("ValideValideValideValideVa"), 1);
    }

    public function testInvalidBlankValue() {
        $this->printTestInfo();
        $this->assertHasErrors($this->getEntity()->setValue(""), 1);
    }

    public function testInvalidNullValue() {
        $this->printTestInfo();
        $this->assertHasErrors($this->getEntity("value"), 1);
    }

    public function testInvalidDuplicatePosition() {
        $this->printTestInfo();
        $cat = $this->loadFixtureFiles([
            dirname( __DIR__)."/Fixtures/featureValue.yaml"
        ]);
        $this->assertHasErrors(
            $this->getEntity()
                ->setPosition(1)
                ->setFeature($cat['feature_subcat'])
                ->setValue("Valide")
            , 1
        );
    }

    public function testInvalidNullPosition() {
        $this->printTestInfo();
        $this->assertHasErrors($this->getEntity("position"), 1);
    }
}