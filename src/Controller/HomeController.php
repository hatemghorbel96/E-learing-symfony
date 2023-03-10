<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Video;
use App\Entity\Course;
use App\Entity\Comment;
use App\Entity\Category;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        $courses = $this->getDoctrine()->getRepository(Course::class)->findAll(); 
        
        $toprating = $this->getDoctrine()->getRepository(Course::class)->toprating(); 
         $topcomment = $this->getDoctrine()->getRepository(Comment::class)->topcomments();  
       /*  $topcomment = $this->getDoctrine()->getRepository(Comment::class)->findby(['rating'=> '5' ],['rating' => 'DESC']);  */
       /*  $topfollowed = $this->getDoctrine()->getRepository(Course::class)->findTopFollows(); */ 
       $topviews = $this->getDoctrine()->getRepository(Course::class)->findby([],['views' => 'DESC']);
        $marketing = $this->getDoctrine()->getRepository(Course::class)->findBy(['category' =>'6']); 
        $web = $this->getDoctrine()->getRepository(Course::class)->findBy(['category' =>'3']); 
        $language = $this->getDoctrine()->getRepository(Course::class)->findBy(['category' =>'4']); 
        $design = $this->getDoctrine()->getRepository(Course::class)->findBy(['category' =>'5']); 
        $users = $this->getDoctrine()->getRepository(User::class)->findAll(); 
        $categories = $this->getDoctrine()->getRepository(Category::class)->findAll(); 
        $videos = $this->getDoctrine()->getRepository(Video::class)->findAll(); 
        $comments = $this->getDoctrine()->getRepository(Comment::class)->findAll(); 
        return $this->render('home/index.html.twig', [
            'courses' => $courses,'users'=>$users,'videos'=>$videos,'comments'=>$comments, 'marketing' =>$marketing,
            'web'=>$web,'language' =>$language,'design' =>$design,/* 'topfollowed'=>$topfollowed */
            'topviews'=> $topviews,'categories'=> $categories,'toprating'=>$toprating,'topcomment'=>$topcomment,
        
        ]);
    }
}
