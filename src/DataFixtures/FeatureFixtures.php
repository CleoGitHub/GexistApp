<?php


namespace App\DataFixtures;


use App\Entity\Feature;
use App\Entity\Subcategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class FeatureFixtures  extends Fixture implements FixtureGroupInterface, DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $features = [
            "T-Shirts" => [
                "Matière",
                "Col",
            ],
            "Chemises" => [
                "Matière",
                "Col",
                "Type"
            ],
            "Vestes" => [
                "Matière",
                "Type"
            ],
            "Pantalons" => [
                "Matière",
                "Type",
                "Coupe"
            ],
            "Joggings" => [
                "Matière",
            ],
            "Shorts" => [
                "Matière",
                "Type"
            ],
            "Boots" => [
                "Matière",
                "Fermeture"
            ],
            "Chaussures de ville" => [
                "Matière",
                "Forme"
            ],
            "Sneakers" => [
                "Matière",
            ],
            "Bracellets" => [
                "Matière",
            ],
            "Casquettes" => [
                "Matière",
                "Forme",
            ],
            "Montres" => [
                "Matière",
                "Type",
                "Bracelet"
            ]
        ];

        foreach($features as $subcatName => $featureNames) {
            $subcat = $manager->getRepository(Subcategory::class)->findOneByName($subcatName);
            foreach ($featureNames as $featureName)
                $subcat->addFeature((new Feature())->setName($featureName));
            $manager->persist($subcat);
        }
        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['item'];
    }

    public function getDependencies()
    {
        return [
            SubcategoryFixtures::class
        ];
    }
}