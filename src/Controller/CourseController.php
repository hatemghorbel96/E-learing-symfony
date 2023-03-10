<?php

namespace App\Controller;

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Entity\User;
use App\Entity\Video;
use App\classe\Search;

use App\Entity\Course;
use App\Entity\Comment;
use App\Entity\Progress;
use App\Form\SearchType;
use App\Form\CommentType;
use App\Entity\EtatCourse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CourseController extends AbstractController
{

    #[Route('/course', name: 'all_courses')]
    public function all(Request $request): Response
    {
         $courses = $this->getDoctrine()->getRepository(Course::class)->findAll(); 
         $search = new Search();
         $form = $this->createForm(SearchType::class,$search);
 
         $form->handleRequest($request);
         if ($form->isSubmitted() && $form->isValid()){
             
             $courses = $this->getDoctrine()->getRepository(Course::class)->findWithSearch($search);
          
         }
         else
         {
            $courses = $this->getDoctrine()->getRepository(Course::class)->findAll(); 
         }
        return $this->render('course/all.html.twig', [
            'courses' => $courses,'form' => $form->createView()
        ]);
    }
    
    #[Route('/course/{id}', name: 'courses')]
    public function index($id,Request $request): Response
    {
        
        $search = new Search();
        $form = $this->createForm(SearchType::class,$search);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            
            $courses = $this->getDoctrine()->getRepository(Course::class)->findWithSearch($search);
         
        }
        else
        {
        $courses = $this->getDoctrine()->getRepository(Course::class)->findBy(['category'=>$id]);
        }
        return $this->render('course/index.html.twig', [
            'courses' => $courses,
            'form'=> $form->createView()
        ]);
    }


    #[Route('/course/show/{id}', name: 'show_course')]
    public function show($id,Request $request): Response
    {
        
       
        $course = $this->getDoctrine()->getRepository(Course::class)->findOneById($id);
        $v=$course->getViews();
        $v+=1;
        $course->setViews($v);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($course);
        $entityManager->flush();
        $comment = new Comment();
        $form =$this->createForm(CommentType::class,$comment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()  ) {
          
            $comment->setCourse($course);
            $comment->setUser($this->getUser());
            $comment->setCreatedAt(new \DateTimeImmutable('now'));
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($comment);
        $entityManager->flush();
        $this->addFlash(
           'success',
           "Thanks for rating");
           return $this->redirectToRoute('show_course', ['id' => $course->getId()]);
           
        }
        
        return $this->render('course/show.html.twig', [
            'course' => $course,
            'form'=>$form->createView()
            
        ]);
    }


     
    #[Route('/course/show/imprimer/{id}', name: 'imprime_test')]
    public function imprimer($id): Response
    {
        $progress=$this->getDoctrine()->getRepository(Progress::class)->findOneById($id);
        $options = new Options();
        $options->set('defaultFont', 'Courier');
        $options->set('isRemoteEnabled', TRUE);
        $options->set('debugKeepTemp', TRUE);
        $options->set('isHtml5ParserEnabled', true);
        $options->setIsRemoteEnabled(true);
        $dompdf = new Dompdf($options);   
        $html = $this->renderView('course/certif.html.twig', [
            'enable_remote' => false,
            'p' => $progress,
           
            
        ]);
        $c=$progress->getCourse()->getNom();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream("$c.pdf", [
            "Attachment" => true
        ]);

        return new Response('', 200, [
            'Content-Type' => 'application/pdf',
            'enable_remote' => false,
        ]);
    }


#[Route('/course/favorit/{id}', name: 'add_fav')]
public function Ajoutfavorit(Course $course):Response {
   

    $course->addFavorit($this->getUser());
    $em = $this->getDoctrine()->getManager();
    $em->persist($course);
    $em->flush();
    return $this->redirectToRoute('show_course', ['id' => $course->getId()]);
     }


#[Route('/course/Annulefavorit/{id}', name: 'annule_fav')]
public function annulefavorit(Course $course):Response {
   

    $course->removeFavorit($this->getUser());
    $em = $this->getDoctrine()->getManager();
    $em->persist($course);
    $em->flush();
    return $this->redirectToRoute('show_course', ['id' => $course->getId()]);
     }


     #[Route('/course/follow/{id}', name: 'follow')]
public function follow(Course $course):Response {
   

    $course->addFollow($this->getUser());
    $em = $this->getDoctrine()->getManager();
    $em->persist($course);
    $em->flush();
    return $this->redirectToRoute('show_course', ['id' => $course->getId()]);
     }


#[Route('/course/unfollow/{id}', name: 'unfollow')]
public function unfollow(Course $course):Response {
   

    $course->removeFollow($this->getUser());
    $em = $this->getDoctrine()->getManager();
    $em->persist($course);
    $em->flush();
    return $this->redirectToRoute('show_course', ['id' => $course->getId()]);
     }




   
    public function comment($id,Request $request): Response
    {
        
       
        $course = $this->getDoctrine()->getRepository(Course::class)->findOneById($id);
        $comment = new Comment();
        $form =$this->createForm(CommentType::class,$comment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()  ) {
          
            $comment->setCourse($course);
            $comment->setUser($this->getUser());
            $comment->setCreatedAt(new \DateTimeImmutable('now'));
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($comment);
        $entityManager->flush();
        $this->addFlash(
           'success',
           "Thanks for rating");
           return $this->redirectToRoute('show_course', ['id' => $course->getId()]);
           
        }
        
        return $this->render('course/comment.html.twig', [
            'course' => $course,
            'form'=>$form->createView()
            
        ]);
    }


    public function commentvideo($id,Request $request): Response
    {
        
       
        $course = $this->getDoctrine()->getRepository(Course::class)->findOneById($id);
        $video = $this->getDoctrine()->getRepository(Video::class)->findOneById($id);
        $comment = new Comment();
        $form =$this->createForm(CommentType::class,$comment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()  ) {
          
            $comment->setCourse($course);
            $comment->setUser($this->getUser());
            $comment->setCreatedAt(new \DateTimeImmutable('now'));
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($comment);
        $entityManager->flush();
        $this->addFlash(
           'success',
           "Thanks for rating");
           return $this->redirectToRoute('show_video', ['id' => $video->getId()]);
           
        }
        
        return $this->render('course/commentvideo.html.twig', [
            'course' => $course,
            'form'=>$form->createView()
            
        ]);
    }


   
    public function lista($id): Response
    {
        
      
        
        $course = $this->getDoctrine()->getRepository(Course::class)->findOneById($id);
        $etatcourse =$this->getDoctrine()->getRepository(EtatCourse::class)->findAll();
        $video = $this->getDoctrine()->getRepository(Video::class)->findOneById($id);
        $user = $this->getDoctrine()->getRepository(User::class)->findOneById($this->getUser());
        $etat =  $this->getDoctrine()->getRepository(EtatCourse::class)->findBy(['course'=> $id]);
        $cas =  $this->getDoctrine()->getRepository(EtatCourse::class)->findBy(['course'=> $id , 'etat' => 0]);
        $countu = $this->getDoctrine()->getRepository(Progress::class)->counte($user,$course);
       
        return $this->render('course/lista.html.twig', [
            'course' => $course,'pro'=> $countu,'etat'=>$etat,'cas'=> $cas,'etatcourse'=>$etatcourse
            
        ]);
    }


    public function etat($id): Response
    {
        
      
        $etatcourse = new EtatCourse();

        $course = $this->getDoctrine()->getRepository(Course::class)->findOneById($id);

       
        $user = $this->getDoctrine()->getRepository(User::class)->findOneById($this->getUser());
        
        $etatcourse->setUser($user);
        $etatcourse->setCourse($course);
        $etatcourse->setEtat(1);
        $entitymanager = $this->getDoctrine()->getManager();
        $entitymanager->persist($etatcourse);
        $entitymanager->flush();

        
        return $this->render('home/reder.html.twig');
    }


    public function inetat($id): Response
    {
        
      
        $etatcourse = new EtatCourse();

        $course = $this->getDoctrine()->getRepository(Course::class)->findOneById($id);

       
        $user = $this->getDoctrine()->getRepository(User::class)->findOneById($this->getUser());
        
        $etatcourse->setUser($user);
        $etatcourse->setCourse($course);
        $etatcourse->setEtat(0);
        $entitymanager = $this->getDoctrine()->getManager();
        $entitymanager->persist($etatcourse);
        $entitymanager->flush();

        
        return $this->render('home/reder2.html.twig');
    }


    public function cas($id): Response
    {
        
       
       
        $etatcourse = $this->getDoctrine()->getRepository(EtatCourse::class)->findOneBy(['id'=>$id]);   
        
        
        $etatcourse->setEtat(1);
        $entitymanager = $this->getDoctrine()->getManager();
        $entitymanager->persist($etatcourse);
        $entitymanager->flush();

        
        return $this->render('home/reder.html.twig');
    }


    #[Route('/course/show/video/{id}', name: 'show_video')]
    public function video($id): Response
    {
        
     
        $video = $this->getDoctrine()->getRepository(Video::class)->findOneById($id);
        
        return $this->render('course/video.html.twig', [
            'video' => $video,
           
            
        ]);
    }

 
}
