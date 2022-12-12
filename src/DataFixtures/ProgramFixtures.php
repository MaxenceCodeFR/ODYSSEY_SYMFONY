<?php

namespace App\DataFixtures;

use App\Entity\Program;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\String\Slugger\SluggerInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

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

    public function __construct(private readonly SluggerInterface $slugger)
    {
    }

    public static int $numProgram = 0;
    public function load(ObjectManager $manager): void
    {
        foreach (self::PROGRAMLIST as $key => $programInf) {
            $program = new Program();
            $slug = $this->slugger->slug($programInf["Title"]);
            $program->setSlug($slug);
            $program->setTitle($programInf["Title"]);
            $program->setSynopsis($programInf["Synopsis"]);
            $program->setCategory($this->getReference($programInf["Category"]));
            $manager->persist($program);
            $this->addReference('program_' . $key, $program);
            self::$numProgram++;
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
