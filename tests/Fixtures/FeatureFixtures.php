<?php


namespace App\Tests\Fixtures;


use App\Entity\Feature;
use App\Entity\Subcategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class FeatureFixtures  extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $features = [
            "Subcategory" => [
                "Feature",
            ],
        ];

        foreach($features as $subcatName => $featureNames) {
            $subcat = $manager->getRepository(Subcategory::class)->findOneByName($subcatName);
            foreach ($featureNames as $featureName)
                $subcat->addFeature((new Feature())->setName($featureName));
            $manager->persist($subcat);
        }
        $manager->flush();
    }
}