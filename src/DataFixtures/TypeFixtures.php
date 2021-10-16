<?php

namespace App\DataFixtures;

use App\Entity\Type;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TypeFixtures extends Fixture
{
    const TYPES = ['BD', 'Roman', 'Polar', 'Cuisine', 'Fantaisie'];

    public function load(ObjectManager $manager): void
    {
        foreach (self::TYPES as $typeTitle){
            $type = new Type();
            $type->setName($typeTitle);
            $this->addReference($typeTitle, $type);

            $manager->persist($type);
        }
        $manager->flush();
    }
}
