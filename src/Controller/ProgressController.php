<?php

namespace App\Controller;

use App\Entity\Video;
use App\Entity\Progress;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProgressController extends AbstractController
{
    #[Route('/progress/{id}', name: 'add_progress')]
    public function add(Request $request,EntityManagerInterface $entityManager,$id): Response
    { 
        
        $progress = new Progress();
        $video = $this->getDoctrine()->getRepository(Video::class)->findOneById($id);
        $course=$video->getCourse();
        $progress->setCourse($course);
        $progress->setUser($this->getUser());
        $progress->setEtat(true);
        $progress->setVideo($video);

        
      

            $entityManager->persist($progress);
            $entityManager->flush();
            
            // do anything else you need here, like send an email
            return $this->redirectToRoute('show_video',['id'=>$id]);
        
        return $this->render('course/video.html.twig');
    }
}
