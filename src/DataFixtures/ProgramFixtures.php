<?php

namespace App\DataFixtures;

use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{

    public const PROGRAMLIST = [
        [
            "Title" => "Murder",
            "Synopsis" => "Une avocate brillante se retrouve dans des situations plus que cocasse",
            "Category" => "category_Drame"
        ],
        [
            "Title" => "Bates Motel",
            "Synopsis" => "Le jeune Norman est un con psycoptahe et il fume tout le monde",
            "Category" => "category_Action"
        ],
        [
            "Title" => "Outer Banks",
            "Synopsis" => "Des jeunes font une chasse au trésor et ça fini en petit bain de sang",
            "Category" => "category_Aventure"
        ],
        [
            "Title" => "Baby Boss La Série",
            "Synopsis" => "Comme le film",
            "Category" => "category_Animation"
        ],
        [
            "Title" => "Jeff Dahmer",
            "Synopsis" => "Un type horrible qui mange des gens, exclusivement des mecs",
            "Category" => "category_Horreur"
        ],

    ];
    public function load(ObjectManager $manager): void
    {
        foreach (self::PROGRAMLIST as $ProgramInf) {
            $program = new Program();
            $program->setTitle($ProgramInf["Title"]);
            $program->setSynopsis($ProgramInf["Synopsis"]);
            $program->setCategory($this->getReference($ProgramInf["Category"]));
            $manager->persist($program);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        // Tu retournes ici toutes les classes de fixtures dont ProgramFixtures dépend
        return [
            CategoryFixtures::class,
        ];
    }
}
