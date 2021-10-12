<?php

namespace App\Controller;

use App\Entity\BookLoan;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class UserLoansController extends AbstractController
{
    /**
     * @Route("/mes-emprunts", name="user_loans")
     */
    public function index(Security $security, EntityManagerInterface $entityManager): Response
    {
        $userLoans = $entityManager->getRepository(BookLoan::class)->findBy(['user'=>$security->getUser()->getId()]);

        $userLoansInLate = $entityManager->getRepository(BookLoan::class)->findBy(['is_late'=>true]);
        $userLoansInLate = count($userLoansInLate);

        return $this->render('user_loans/index.html.twig', [
            'loans' => $userLoans,
            'userLoansInLate'=>$userLoansInLate
        ]);
    }
}
