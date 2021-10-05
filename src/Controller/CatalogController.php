<?php

namespace App\Controller;

use App\Entity\Type;
use App\Repository\TypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CatalogController extends AbstractController
{
    /**
     * @Route("/catalogue", name="catalog")
     */
    public function index(TypeRepository $repository, EntityManagerInterface $entityManager): Response
    {
        $types = $entityManager->getRepository(Type::class)->findAll();

        return $this->render('catalog/index.html.twig', [
            'types'=>$types
        ]);
    }
}
