<?php

namespace App\Controller;

use App\Entity\Category;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryController extends AbstractController
{
    #[Route('/category', name: 'categories')]
    public function index(): Response
    {
        $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();
        return $this->render('category/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    //sous category
  /*   #[Route('/category/{id}', name: 'show_cat')]
    public function list($id): Response
    {
        $categories = $this->getDoctrine()->getRepository(Category::class)->findById($id);
        return $this->render('category/index.html.twig', [
            'categories' => $categories,
        ]);
    } */
}
