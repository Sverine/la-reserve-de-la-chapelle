<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\BookLoan;
use App\Entity\Type;
use App\Entity\User;
use App\Form\BookType;
use App\Helper\YouMayAlsoLikeManager;
use App\Repository\BookRepository;
use App\Repository\TypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\Void_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

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
        $books = $entityManager->getRepository(Book::class)->findAll();
        $searchForm = $this->createForm(SearchType::class);
        $bookFound = [];

        return $this->render('catalog/index.html.twig', [
            'types'=>$types,
            'books'=>$books,
            'form'=>$searchForm->createView(),
            'bookFound' => $bookFound

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
     * @Route ("/livre/{id}/reserved", name="catalog_show_reserved", methods={"POST"})
     * @param Book $book
     * @param EntityManagerInterface $entityManager
     * @param BookRepository $repository
     * @return Response
     */
    public function reserve(Book $book, EntityManagerInterface $entityManager, BookRepository $repository, Security $security): Response
    {
        if(!$book->getIsReserved()){
            $book->setIsReserved(true);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($book);
            $entityManager->flush();


            $user = $security->getUser();
            $book_loan =  new BookLoan();
            $book_loan->setBook($book)
                ->setUser($user);
            $entityManager->persist($book_loan);
            $entityManager->flush();

            return $this->redirectToRoute('catalog_show',[
                'id'=>$book->getId(),
            ]);
        }
        return $this->redirectToRoute('catalog_show',[
            'id'=>$book->getId(),
        ]);
    }

    /**
     * @Route ("/search/{booktitle}/", name="catalog_search")
     * @param EntityManagerInterface $entityManager
     * @param $booktitle
     * @param SerializerInterface $serializer
     * @return Response
     */
    public function searchByTitle(EntityManagerInterface $entityManager, $booktitle, SerializerInterface $serializer)
    {

        $types = $entityManager->getRepository(Type::class)->findAll();
        $books = $entityManager->getRepository(Book::class)->findAll();
        $searchForm = $this->createForm(SearchType::class);

        $bookFound = $entityManager->getRepository(Book::class)->findByTitle($booktitle);

        $bookFound = $serializer->serialize($bookFound, 'json',[
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);

        $bookFound =json_decode($bookFound);

        return $this->json([
            'message'=>'ohé',
            'bookFound'=>$bookFound
        ],200);
    }
}
