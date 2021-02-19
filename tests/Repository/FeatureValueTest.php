<?php


namespace App\Tests\Repository;

use App\Tests\Fixtures\CategoryFixtures;
use App\Tests\Fixtures\FeatureFixtures;
use App\Tests\Fixtures\FeatureValueFixtures;
use App\Tests\Fixtures\SubcategoryFixtures;
use App\Repository\FeatureRepository;
use App\Repository\FeatureValueRepository;
use App\Repository\SubcategoryRepository;
use App\Tests\Traits\Printer;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class FeatureValueTest extends KernelTestCase {

    use FixturesTrait, Printer;

    public function testTestsFeatureValueInsertion() {
        $this->printTestInfo();
        self::bootKernel();
        $this->loadFixtures([
            CategoryFixtures::class,
            SubcategoryFixtures::class,
            FeatureFixtures::class,
            FeatureValueFixtures::class
        ]);
        $this->assertEquals(1, self::$container->get(FeatureValueRepository::class)->count([]));
        $this->assertCount(
            1,
            self::$container->get(FeatureRepository::class)->findOneBy([
                "name" => "Feature",
                "subcategory" => self::$container->get(SubcategoryRepository::class)->findOneByName("Subcategory")
            ])->getFeatureValues()
        );
        $this->assertNotNull(self::$container->get(FeatureValueRepository::class)->findOneByValue("FeatureValue"));
    }

    public function testTestsFeatureValueChangeOrder() {
        $this->printTestInfo();

        //launch the fixtures and get manager
        self::bootKernel();
        $manager = self::$container->get("doctrine")->getManager();
        $this->loadFixtures([
            CategoryFixtures::class,
            SubcategoryFixtures::class,
            FeatureFixtures::class,
            FeatureValueFixtures::class
        ]);

        //Get a features to test
        $feat = self::$container->get(FeatureRepository::class)->findOneByName("Feature");
        $featVals = $feat->getFeatureValues();

        //Save the featureValues in order to compare them later
        $featValsVerif = [];
        foreach ($featVals as $featVal)
            $featValsVerif[] = clone $featVal;

        //Change the order
        for ($i = 0; $i < count($featVals); $i++) {
            $featVals[$i]->setPosition($featVals[$i]->getPosition() + 1);
        }

        //Verification that we really changed the orders
        foreach ($featValsVerif as $featValVerif) {
            $i = 0;
            while($i < count($featVals) && $featVals->get($i)->getId() != $featValVerif->getId()) {
                $i++;
            }
            $featVal = $featVals[$i];
            $this->assertNotEquals($featVal->getPosition(), $featValVerif->getPosition());
        }
        $manager->persist($feat);
        $manager->flush();

        //Verification that the DB accepted the changes
        $featVerif = self::$container->get(FeatureRepository::class)->findOneByName("Feature");
        $featValsVerif = $featVerif->getFeatureValues();
        foreach ($featValsVerif as $featValVerif) {
            $i = 0;
            while($i < count($featVals) && $featVals->get($i)->getId() != $featValVerif->getId()) {
                $i++;
            }
            $featVal = $featVals[$i];
            $this->assertEquals($featVal->getPosition(), $featValVerif->getPosition());
        }
    }


}