<?php


namespace App\Tests\Entity;


use App\Entity\Category;
use App\Entity\Feature;
use App\Entity\FeatureValue;
use App\Entity\Subcategory;
use App\Tests\AssertErrors;
use App\Tests\FakerEntity;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class FeatureValueTest extends KernelTestCase
{
    use FixturesTrait, AssertErrors;

    public function getEntity() {
        return FakerEntity::featureValue();
    }

    public function testValideEntity() {
        $this->assertHasErrors($this->getEntity(), 0);
    }

    public function testInvalideDuplicateCombinationFeatureValue() {
        $cat = $this->loadFixtureFiles([
            dirname( __DIR__)."/Fixtures/featureValue.yaml"
        ]);
        $this->assertHasErrors($this->getEntity()->setFeature($cat["feature_subcat"]), 1);
    }

    public function testInvalideLongValue() {
        $this->assertHasErrors($this->getEntity()->setValue("ValideValideValideValideV"), 0);
        $this->assertHasErrors($this->getEntity()->setValue("ValideValideValideValideVa"), 1);
    }

    public function testInvalideBlankValue() {
        $this->assertHasErrors($this->getEntity()->setValue(""), 1);
    }

    public function testInvalideDuplicateOrder() {
        $cat = $this->loadFixtureFiles([
            dirname( __DIR__)."/Fixtures/featureValue.yaml"
        ]);
        $this->assertHasErrors(
            $this->getEntity()
                ->setOrd(1)
                ->setFeature($cat['feature_subcat'])
                ->setValue("Valide")
            , 1
        );
    }
}