<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        //$users = $entityManager->getRepository(User::class)->findAll();
        $users = $entityManager->getRepository(User::class)->findBy(['is_confirmed'=>false]);
        return $this->render('dashboard/index.html.twig',[
            'users'=>$users
            ]);
    }

    /**
     * @Route("/dashboard/utilisateur/{id}/confirmer", name="user_approve",  methods={"POST"})
     * @param User $user
     * @param EntityManagerInterface $entityManager
     * @param UserRepository $userRepository
     * @return Response
     */
    public function approveUser(User $user, EntityManagerInterface $entityManager) : Response
    {
        $userUpdate = $user->setRoles(["ROLE_SUBSCRIBER"])
            ->setIsConfirmed(true)
        ;

        $entityManager->persist($userUpdate);
        $entityManager->flush();

        return $this->json([
            'userId'=>$user->getId()
        ],200);
    }

}
