<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\Type;
use App\Form\BookType;
use App\Helper\YouMayAlsoLikeManager;
use App\Repository\BookRepository;
use App\Repository\TypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\Void_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/catalogue")
 */
class CatalogController extends AbstractController
{
    /**
     * @Route("/", name="catalog")
     */
    public function index(TypeRepository $repository, EntityManagerInterface $entityManager): Response
    {
        $types = $entityManager->getRepository(Type::class)->findAll();

        return $this->render('catalog/index.html.twig', [
            'types'=>$types
        ]);
    }

    /**
     * @Route ("/livre/{id}", name="catalog_show", methods={"GET","POST"})
     */
    public function show(Book $book, Request $request, EntityManagerInterface $entityManager, YouMayAlsoLikeManager $youMayAlsoLikeManager): Response
    {

        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->renderForm('catalog/book.html.twig', [
                'form' => $form,
            ]);
        }

        $types = $entityManager->getRepository(Type::class)->findAll();

        $booksFromTypes =$youMayAlsoLikeManager->displayBooksFromType($book, $types);

        return $this->render('catalog/book.html.twig',[
            'book'=>$book,
            'booksFromTypes'=>$booksFromTypes
        ]);
    }

    /** Permet de réserver un livre
     *
     * @Route ("/livre/{id}/reserved", name="catalog_show_reserved", methods={"GET","POST"})
     * @param Book $book
     * @param EntityManagerInterface $entityManager
     * @param BookRepository $repository
     * @return Response
     */
    public function reserve(Book $book, EntityManagerInterface $entityManager, BookRepository $repository): Response
    {
        if(!$book->getIsReserved()){
            $book->setIsReserved(true);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($book);
            $entityManager->flush();

            return $this->redirectToRoute('catalog_show',[
                'id'=>$book->getId(),
            ]);
        }
        return $this->redirectToRoute('catalog_show',[
            'id'=>$book->getId(),
        ]);
    }
}
