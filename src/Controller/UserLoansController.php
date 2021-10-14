<?php

namespace App\Controller;

use App\Entity\BookLoan;
use App\Entity\User;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;


/**
 * @Route("/mon-profil")
 */
class UserLoansController extends AbstractController
{
    /**
     * @Route("/mes-emprunts", name="my_loans")
     */
    public function index(Security $security, EntityManagerInterface $entityManager): Response
    {
        $userLoans = $entityManager->getRepository(BookLoan::class)->findBy(['user'=>$security->getUser()->getId()]);

        $userLoansInLate = $entityManager->getRepository(BookLoan::class)->findBy(['is_late'=>true]);
        $userLoansInLate = count($userLoansInLate);

        return $this->render('user_profile/my_loans.html.twig', [
            'loans' => $userLoans,
            'userLoansInLate'=>$userLoansInLate
        ]);
    }

    /**
     * @Route("/{id}/modifier" , name="my_profile", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user): Response
    {
        $form = $this->createForm(RegisterType::class, $user);
        $form->remove('roles');

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user_profile/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

}
