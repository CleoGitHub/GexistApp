<?php


namespace App\Tests\Fixtures;


use App\Entity\Feature;
use App\Entity\FeatureValue;
use App\Entity\Subcategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class FeatureValueFixtures  extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $features = [
            "Subcategory" => [
                "Feature" => ["FeatureValue"],
            ],
        ];
        foreach ($features as $subcatName => $featureValues) {
            $subcat = $manager->getRepository(Subcategory::class)->findOneByName($subcatName);
            foreach ($featureValues as $featureName => $featureValueNames) {
                $feature = $manager->getRepository(Feature::class)->findOneBy([
                    "name" => $featureName,
                    "subcategory" => $subcat
                ]);
                foreach ($featureValueNames as $ord => $featureValueName) {
                    $feature->addFeatureValue(
                        (new FeatureValue())
                            ->setPosition($ord)
                            ->setValue($featureValueName)
                    );
                }
                $manager->persist($feature);
            }
        }
        $manager->flush();
    }
}