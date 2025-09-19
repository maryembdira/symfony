<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',

        ]);
    }
    
        #[Route('/hello',name:'hello')]
        public function hello (): Response {
           return new Response(content : "hello3a26") ;
     
        }

    #[Route('/contact/{tel}',name:'contact')]    
    public function contact($tel): Response {
        return $this->render('home/contact.html.twig',['telephone'=>$tel]);

    }

     #[Route('/bienvenue',name:'bienvenue')]
        public function show (): Response {
           return new Response(content : "bienvenue") ;
        }
    #[Route('/apropos',name:'apropos')]
    public function apropos(): Response
    {
        return $this->render('home/apropos.html.twig', [
            

        ]);
    }    

}

