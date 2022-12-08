<?php

namespace App\DataFixtures;

use App\Entity\Actor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker\Factory;

class ActorFixtures extends Fixture implements DependentFixtureInterface
{

    public const ACTORSLIST = [
        [
            "Name" => 'Jacques', 'Marcelin', 'Marcel', 'Jacques', 'Frédéric', 'Cunéguonde', 'Super-Man',
            'Patricia', 'Diam\'s', 'Passe-Partout', 'Mère Michel', '2Pac', 'Ma Soeur', 'Jacque II', 'Coques RhinoShield'
        ],
    ];
    public function load(ObjectManager $manager): void
    {
        //Puis ici nous demandons à la Factory de nous fournir un Faker
        $faker = Factory::create();

        /**
         * L'objet $faker que tu récupère est l'outil qui va te permettre 
         * de te générer toutes les données que tu souhaites
         */
        for ($j = 0; $j < ProgramFixtures::$numProgram; $j++) {
            for ($i = 0; $i < 3; $i++) {
                $actor = new Actor();
                $actor->setName($faker->name());
                $actor->addProgram($this->getReference('program_' .  $j));
                $manager->persist($actor);
                // $this->addReference('actor_' . $i, $actor);
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ProgramFixtures::class,
        ];
    }
}
