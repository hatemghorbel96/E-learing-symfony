<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Course;
use App\Entity\Progress;
use App\Entity\EtatCourse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    #[Route('/user', name: 'dash_pro')]
    public function index(): Response
    {
        $user = $this->getUser();
      
        // nb on progress kol
        $nbtotal =  $this->getDoctrine()->getRepository(EtatCourse::class)->findBy(['user'=> $user]);
        //nb course etat complete // w nraffichi biha courses kol
        $nbetat =  $this->getDoctrine()->getRepository(EtatCourse::class)->findBy(['user'=> $user , 'etat' => 1]);
        
        /* $test = $this->getDoctrine()->getRepository(EtatCourse::class)->test(['user'=> $user]); */
        // nb cource ili d5alt'hom total (en progress) w naffichihom
        $nbc = $this->getDoctrine()->getRepository(Progress::class)->nbcourseprog($user);
        //
        $courses = $this->getDoctrine()->getRepository(Course::class)->list_course_progress($user);
        // nb video in table progress
        $nbvideo = $this->getDoctrine()->getRepository(Progress::class)->videos($user);
       
        return $this->render('user/index.html.twig',['user' => $user ,'nbetat' => $nbetat,'nbc' => $nbc,'courses'=> $courses,'nbvideo' => $nbvideo,'nbtotal' => $nbtotal]);
    }

    #[Route('/favorit', name: 'favoritlist')]
    public function favoritlist(): Response
    {
        $user = $this->getUser();
       
        return $this->render('user/favorit.html.twig',['user' => $user]);
    }

    #[Route('/editprof', name: 'editprof')]
    public function editprof(): Response
    {
        $user = $this->getUser();
       
        return $this->render('user/editprof.html.twig',['user' => $user]);
    }

    #[Route('/editpass', name: 'editpass')]
    public function editpass(): Response
    {
        $user = $this->getUser();
       
        return $this->render('user/editpass.html.twig',['user' => $user]);
    }


    #[Route('/follow', name: 'follow_courses')]
    public function followcourses(): Response
    {
        $user = $this->getUser();
       
        return $this->render('user/follow.html.twig',['user' => $user]);
    }


    #[Route('/courses', name: 'courses_list')]
    public function courses(): Response
    {
       
       
        $user = $this->getUser();
        // nb on progress kol
        $nbtotal =  $this->getDoctrine()->getRepository(EtatCourse::class)->findBy(['user'=> $user]);
        //nb course etat complete // w nraffichi biha courses kol
        $nbetat =  $this->getDoctrine()->getRepository(EtatCourse::class)->findBy(['user'=> $user , 'etat' => 1]);
        
        /* $test = $this->getDoctrine()->getRepository(EtatCourse::class)->test(['user'=> $user]); */
        // nb cource ili d5alt'hom total (en progress) w naffichihom
        $nbc = $this->getDoctrine()->getRepository(Progress::class)->nbcourseprog($user);
        //
        $courses = $this->getDoctrine()->getRepository(Course::class)->list_course_progress($user);
        // nb video in table progress
        $nbvideo = $this->getDoctrine()->getRepository(Progress::class)->videos($user);
       
        return $this->render('user/courses.html.twig',['user' => $user ,'nbtotal' => $nbtotal,'nbc' => $nbc,'courses'=> $courses,'nbvideo' => $nbvideo,'nbetat' => $nbetat]);
    }

}
