<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InfoController extends AbstractController
{
    #[Route('/aboutus', name: 'aboutus')]
    public function index(): Response
    {
        return $this->render('info/index.html.twig');
    }


    #[Route('/contactus', name: 'contactus')]
    public function contactus(): Response
    {
        return $this->render('info/contactus.html.twig');
    }
}
