<?php

namespace App\Controller;

use App\Entity\Book;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $favoriteBooks = $entityManager->getRepository(Book::class)->findBy(['is_favorite'=>true]);
        return $this->render('home/index.html.twig',[
            'favoriteBooks'=>$favoriteBooks
        ]);
    }
}
