<?php

namespace App\Controller;

use App\Entity\Imagen;
use App\Entity\Asociado;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProyectoController extends AbstractController
{
    #[Route('/', name: 'sym_index')]
    public function index(ManagerRegistry $doctrine) : Response
    {
        // $publicaciones;

        return $this->render('index.view.html.twig', [
        ]);
    }

    #[Route('/about', name: 'sym_about')]
    public function about(){
        return $this->render('about.view.html.twig',[
        ]);
    }

    #[Route('/blog', name: 'sym_blog')]
    public function blog(){
        return $this->render('blog.view.html.twig');
    }

    #[Route('/contact', name: 'sym_contact')]
    public function contact(){
        return $this->render('contact.view.html.twig');
    }
}
