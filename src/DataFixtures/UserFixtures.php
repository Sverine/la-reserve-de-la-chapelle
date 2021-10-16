<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{

    /**
     * @var UserPasswordHasherInterface
     */
    private $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }



    public function load(ObjectManager $manager): void
    {
        /***** ADMIN *****/
        $userAdmin = new User();
        $userAdmin->setEmail('isabelle.garnier@la-reserve.com')
                ->setPassword($this->hasher->hashPassword($userAdmin, 'bonsoirlareserve'))
                ->setRoles(["ROLE_ADMIN"])
                ->setFirstname('Isabelle')
                ->setLastname('Garnier')
                ->setAddress('8 avenue Calypso
34000 Curreau-sur-Seine')
                ->setDateBirth(new \DateTime('1973-05-06'))
                ->setIsConfirmed(true)
                ->setDateInscription(new \DateTime('2021-05-12 13:31:53'));

        $manager->persist($userAdmin);

        /***** EMPLOYE *****/
        $userEmploye = new User();
        $userEmploye->setEmail('vincent.fermont@la-reserve.com')
            ->setPassword($this->hasher->hashPassword($userEmploye, 'bonjourlareserve'))
            ->setRoles(["ROLE_EMPLOYE"])
            ->setFirstname('Vincent')
            ->setLastname('Fermont')
            ->setAddress('8 avenue Calypso
34110 Curreau-sur-Seine')
            ->setDateBirth(new \DateTime('1993-05-06'))
            ->setIsConfirmed(true)
            ->setDateInscription(new \DateTime('2021-08-14 16:31:00'));

        $manager->persist($userEmploye);

        /***** CUSTOMERS (SUBSCRIBER AND NON CONFIRMED SUBSCRIBER) *****/
        $userSubscriber = new User();
        $userSubscriber->setEmail('charline.legal@mail.com')
            ->setPassword($this->hasher->hashPassword($userSubscriber, 'charlinelareserve'))
            ->setRoles(["ROLE_SUBSCRIBER"])
            ->setFirstname('Charline')
            ->setLastname('Legal')
            ->setAddress('13 rue du vieux Moulin
34110 Curreau-sur-Seine')
            ->setDateBirth(new \DateTime('1993-02-12'))
            ->setIsConfirmed(true)
            ->setDateInscription(new \DateTime('2021-09-02 15:21:00'));

        $manager->persist($userSubscriber);
        $this->addReference('Charline', $userSubscriber);

        $userNonSubscriber = new User();
        $userNonSubscriber->setEmail('yvan.frannet@mail.com')
            ->setPassword($this->hasher->hashPassword($userNonSubscriber, 'yvanlareserve'))
            ->setRoles(["ROLE_SUBSCRIBER"])
            ->setFirstname('Yvan')
            ->setLastname('Frannet')
            ->setAddress('45 impasse du jeu de Boule
34110 Curreau-sur-Seine')
            ->setDateBirth(new \DateTime('1953-12-06'))
            ->setIsConfirmed(false)
            ->setDateInscription(new \DateTime('now'));

        $manager->persist($userNonSubscriber);

        $manager->flush();
    }
}
