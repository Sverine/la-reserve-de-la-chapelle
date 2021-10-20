<?php

namespace App\Controller;

use App\Entity\BookLoan;
use App\Form\BookLoanType;
use App\Repository\BookLoanRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/dashboard/emprunts")
 */
class BookLoanController extends AbstractController
{
    /**
     * @Route("/", name="loan_index", methods={"GET"})
     */
    public function index(BookLoanRepository $bookLoanRepository, EntityManagerInterface $entityManager): Response
    {
        $loans = $bookLoanRepository->findByStatus('Réservé', 'Emprunté');
        $loansInLate = 0;

        foreach($loans as $loan){
            if ($loan->getDateLoan()){
                $diff = $loan->getDateLoan()->diff(new \DateTime('now'));
                if($diff->days >= 21){
                    $loan->setIsLate(1);
                    $loansInLate += 1;

                    $entityManager->persist($loan);
                    $entityManager->flush();
                }
            }
        }

        return $this->render('loan/index.html.twig', [
            'loans' => $loans,
            'loansInLate' => $loansInLate
        ]);
    }

    /**
     * @Route("/new", name="loan_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $bookLoan = new BookLoan();
        $form = $this->createForm(BookLoanType::class, $bookLoan);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($bookLoan);
            $entityManager->flush();

            return $this->redirectToRoute('loan_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('loan/new.html.twig', [
            'loan' => $bookLoan,
            'form' => $form,
        ]);
    }


    /**
     * @Route("/{id}/modifier", name="loan_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, BookLoan $bookLoan, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BookLoanType::class, $bookLoan);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();


            switch($bookLoan->getStatus()){
                case 'Emprunté':
                    $bookLoan->setDateLoan(new \DateTime('now'));
                    $entityManager->flush();
                    break;
                case 'Rendu':
                    $bookLoan->setDateReturn(new \DateTime('now'));

                    $bookToUpdate = $bookLoan->getBook();
                    $bookToUpdate->setIsReserved(false);
                    $entityManager->persist($bookToUpdate);

                    $entityManager->flush();
                    break;
            }

            return $this->redirectToRoute('loan_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('loan/edit.html.twig', [
            'loan' => $bookLoan,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="loan_delete", methods={"POST"})
     */
    public function delete(Request $request, BookLoan $bookLoan): Response
    {
        if ($this->isCsrfTokenValid('delete'.$bookLoan->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($bookLoan);
            $entityManager->flush();
        }

        return $this->redirectToRoute('loan_index', [], Response::HTTP_SEE_OTHER);
    }

}
