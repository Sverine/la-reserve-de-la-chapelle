<?php

namespace App\DataFixtures;

use App\Entity\Book;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class BookFixtures extends Fixture implements DependentFixtureInterface
{
        const BOOKS = ['Le mystère de la voix 8 deux tiers',
        'Hagrid et les sept nains',
        'Mon voisin Hedwige',
        'Les secrets de la Mandragore',
        'Les mystères du lac',
        'Sorbet citron : les meilleurs recettes!',
        'Wingardium Leviosa',
        'La folle histoire de Mme Chourave',
        'Touffu, une histoire vraie!',
        'Ou se restaurer au Chemin de l\'Endroit?'
        ];

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $types = TypeFixtures::TYPES;

        for($i =0; $i<count(self::BOOKS);$i++){
            $book = new Book();
            $book->setTitle(self::BOOKS[$i])
            ->setAuthor($faker->firstName.' '.$faker->lastName())
            ->setDescription($faker->paragraphs(4, true))
            ->setPublishedAt($faker->dateTimeThisCentury())
            ->setIsReserved(false)
            ->setIsFavorite($faker->boolean());

            $upOne = dirname(__DIR__, 2);
            $file = new UploadedFile(
                $upOne.'/public/images/covers/cover-'.$i.'.jpg',
                'cover-'.$i.'.jpg',
                'image/jpg',
                null,
                true
            );

            $book->setFolderImage($file);
            $book->setUpdatedAt(new \DateTime('now'));

            switch(self::BOOKS[$i]){
                case 'Le mystère de la voix 8 deux tiers' :
                case 'Les mystères du lac' :
                    $book->addType($this->getReference($types[1]));
                    $book->addType($this->getReference($types[2]));
                    break;

                case 'Hagrid et les sept nains' :
                case 'Wingardium Leviosa' :
                    $book->addType($this->getReference($types[4]));
                    break;

                case 'Mon voisin Hedwige' :
                case 'La folle histoire de Mme Chourave' :
                case 'Touffu, une histoire vraie!' :
                    $book->addType($this->getReference($types[0]));
                    break;

                case 'Les secrets de la Mandragore' :
                case 'Sorbet citron : les meilleurs recettes!' :
                case 'Ou se restaurer au Chemin de l\'Endroit?' :
                    $book->addType($this->getReference($types[3]));
                    break;
            }
            $manager->persist($book);
        }

        $manager->flush();
        //$this->setReference('bookReference', $book);
    }

    public function getDependencies(): array
    {
        return [
            TypeFixtures::class
        ];
    }
}
