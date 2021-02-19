<?php


namespace App\DataFixtures;


use App\Entity\Feature;
use App\Entity\FeatureValue;
use App\Entity\Subcategory;
use App\Repository\SubcategoryRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class FeatureValueFixtures  extends Fixture implements FixtureGroupInterface, DependentFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $features = [
            "T-Shirts" => [
                "Matière" => ["Coton", "Lin", "Synthétique", "Coton Bio"],
                "Col" => ["V", "Rond"],
            ],
            "Chemises" => [
                "Matière" => ["Coton", "Lin", "Synthétique", "Coton Bio"],
                "Col" => ["V", "Rond", "Montant"],
                "Type" => ["Casual", "Costume"],
            ],
            "Vestes" => [
                "Matière" => ["Jeans","Coton", "Cuir", "Synthétique", "Coton Bio"],
                "Type" => ["À capuche", "Sport"]
            ],
            "Pantalons" => [
                "Matière" => ["Jeans","Coton", "Lin", "Cuir", "Synthétique", "Coton Bio"],
                "Type" => ["Chino", "Costume", "Baggy", "Casual"],
                "Coupe" => ["Ultra Slim" ,"Slim", "Regular", "Large"]
            ],
            "Joggings" => [
                "Matière" => ["Coton", "Lin", "Synthétique", "Coton Bio"],
            ],
            "Shorts" => [
                "Matière" => ["Jeans","Coton", "Lin", "Synthétique", "Coton Bio"],
                "Type" => ["Bermuda", "Court"]
            ],
            "Boots" => [
                "Matière" => ["Cuir naturel", "Cuir Synthétique"],
                "Fermeture" => ["Eclair", "Lacet"]
            ],
            "Chaussures de ville" => [
                "Matière" => ["Cuir naturel", "Cuir Synthétique", "Daim", "Tissus"],
                "Forme" => ["Montante", "Pointu", "Arrondi"]
            ],
            "Sneakers" => [
                "Matière" => ["Cuir naturel", "Cuir Synthétique", "Tissus"],
            ],
            "Bracellets" => [
                "Matière" => ["Cuir naturel", "Cuir Synthétique", "Or", "Argent", "bronze"],
            ],
            "Casquettes" => [
                "Matière" => ["Cuir naturel", "Cuir Synthétique", "Coton", "Coton Bio"],
                "Forme" => ["Baseball", "Traditionnel"],
            ],
            "Montres" => [
                "Matière" => ["Or", "Argent", "Bronze", "Diament"],
                "Type" => ["Digital", "Aiguille"],
                "Bracelet" => ["Cuir naturel", "Cuir Synthétique", "Coton", "Coton Bio"],
            ]
        ];
        $count = 0;
        foreach ($features as $subcatName => $featureValues) {
            $subcat = $manager->getRepository(Subcategory::class)->findOneByName($subcatName);
            foreach ($featureValues as $featureName => $featureValueNames) {
                $feature = $manager->getRepository(Feature::class)->findOneBy([
                    "name" => $featureName,
                    "subcategory" => $subcat
                ]);
                foreach ($featureValueNames as $ord => $featureValueName) {
                    $count++;
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

    public static function getGroups(): array
    {
        return ['item'];
    }

    public function getDependencies()
    {
        return [
            FeatureFixtures::class
        ];
    }
}