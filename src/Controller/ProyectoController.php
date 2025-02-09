<?php

namespace App\Controller;

use App\Repository\PublicacionesRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProyectoController extends AbstractController
{
    #[Route('/', name: 'sym_index')]
    public function index(PublicacionesRepository $publicacionesRepository) : Response
    {
        $publicaciones = $publicacionesRepository->findAll();

        shuffle($publicaciones);

        array_slice($publicaciones, 0, 4);

        return $this->render('index.view.html.twig', [
           'publicaciones' => $publicaciones
        ]);
    }
}
